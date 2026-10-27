<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\CustomForm;
use App\FormField;
use Validator;
use App\Brand;

class FormController extends Controller {

    public function send_form(Request $request) {
        try {
            return $this->sendFormUnchecked($request);
        } catch (\Throwable $e) {
            \Log::error('send_form failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return response()->json(['error' => 'Could not send the form. Please try again.']);
        }
    }

    private function sendFormUnchecked(Request $request) {
        $data = $request->except(['_token']);
        $referer = $request->headers->get('referer');
        if (!$referer && isset($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
        }
        $host = strtolower($this->get_host($referer ?: ''));
        // SQLite compares domain case-sensitively; stored values are uppercase.
        // Also accept admin aliases (token without TLD), same as Landing middleware.
        $brand = Brand::where('active', 1)->where(function ($query) use ($host) {
            $query->whereRaw('LOWER(domain) = ?', [$host]);

            preg_match("/(www\.(.*?)s\.)|((.*?)s\.)|(www\.(.*?)\.)|((.*?)\.)/i", $host, $d_result);
            $d_result = array_values(array_diff($d_result, array('', null, false)));
            if (!isset($d_result[2])) {
                return;
            }
            $extra = strtolower($d_result[2]);
            $query->orWhere(function ($query) use ($extra) {
                $query->whereRaw('LOWER(additional_domains) = ?', [$extra]);
                $query->orWhereRaw('LOWER(additional_domains) LIKE ?', [$extra . '|%']);
                $query->orWhereRaw('LOWER(additional_domains) LIKE ?', ['%|' . $extra . '|%']);
                $query->orWhereRaw('LOWER(additional_domains) LIKE ?', ['%|' . $extra]);
            });
        })->first();
        $response = [];

        if ($this->check_black_list($request->get('form')) && $brand && count($data) && empty($request->subject_msg_4)) {
            $form_id = key($data['form']);
            $form = CustomForm::where(['id' => $form_id, 'active' => 1])->first();
            if ($form) {
                $rules = [];
                $values = [];
                $rule_field_names = [];
                $single_images = [];
                $zoho_fields = [];
                foreach ($form->form_fields as $field) {
                    if ($field->type != 'custom_text') {
                        //Если передали каким то оброзом не все поля которые есть в форме например мультиселек или чекбокс или радио
                        if (!isset($data['form'][$form_id][$field->id])) {
                            $data['form'][$form_id][$field->id] = '';
                        }
                        $value = $data['form'][$form_id][$field->id];
                        if (is_array($value)) {//Для значений которые массив - мульти селекс
                            $value = join(", ", $value);
                        }

                        if ($field->required && $field->type == 'email') {
                            $rules["form.{$form_id}.{$field->id}"] = 'required|email';
                        } elseif ($field->required && $field->type == 'phone') {
                            $rules["form.{$form_id}.{$field->id}"] = 'required|regex:/^\+1-\d{3}-\d{3}-\d{4}$/';
                        } elseif ($field->required) {
                            $rules["form.{$form_id}.{$field->id}"] = 'required';
                        } elseif ($field->type == 'email') {
                            $rules["form.{$form_id}.{$field->id}"] = 'email';
                        } elseif ($field->type == 'phone') {
                            $rules["form.{$form_id}.{$field->id}"] = 'regex:/^\+1-\d{3}-\d{3}-\d{4}$/';
                        }

                        //Для картинки
                        if ($field->type == 'image') {
                            if (isset($rules["form.{$form_id}.{$field->id}"])) {
                                $rules["form.{$form_id}.{$field->id}"] .= '|image';
                            } else {
                                $rules["form.{$form_id}.{$field->id}"] = 'image';
                            }

                            // Empty file inputs arrive as null or "". count() on those
                            // throws on PHP 7.2+ and Laravel turns it into a 500.
                            $upload = $data['form'][$form_id][$field->id];
                            if ($upload instanceof \Illuminate\Http\UploadedFile && $upload->isValid()) {
                                $image_name = time() . '.' . $upload->getClientOriginalExtension();
                                $single_images[] = [
                                    'name' => $image_name,
                                    'image' => $upload,
                                    'src_path' => "/storage/forms/{$form_id}/$image_name"
                                ];
                                $value = "/storage/forms/{$form_id}/$image_name";
                            } else {
                                $value = '';
                                if (!$field->required) {
                                    unset($rules["form.{$form_id}.{$field->id}"]);
                                }
                            }
                        }
                        $values[$field->id] = [
                            'name' => $field->name,
                            'value' => $value,
                            'type' => $field->type
                        ];
                        $rule_field_names["form.{$form_id}.{$field->id}"] = [
                            'name' => $field->name,
                            'field_id' => $field->id
                        ];

                        if (!empty($field->zoho_field_type)) {
                            $zoho_fields[$field->zoho_field_type] = $value;
                        }elseif($field->type != 'image'){
                            if(!isset($zoho_fields['description'])) $zoho_fields['description'] = "";
                            $zoho_fields['description'] .= $field->name.": ".$value."\n";
                        }
                    }
                }
                $validator = Validator::make($data, $rules);

                if ($form->use_captcha) {
                    $validator->after(function ($validator) use ($request) {
                        if (!$this->recaptcha_check($request->get('g-recaptcha-response'))) {
                            $validator->getMessageBag()->add('recapthca_error', 'Please ensure that you are a human!');
                        }
                    });
                }

                if (!$validator->fails()) {
                    //Загрузка картинок                    
                    $curl_attachments = [];
                    $formDir = public_path("storage/forms/{$form_id}");
                    if (count($single_images) && !is_dir($formDir)) {
                        mkdir($formDir, 0755, true);
                    }
                    foreach ($single_images as $key => $image) {
                        $image['image']->move($formDir, $image['name']);
                        if($key < 5){
                            $curl_attachments["attachment_".($key+1)] = curl_file_create(public_path("storage/forms/{$form_id}/{$image['name']}"), mime_content_type(public_path("storage/forms/{$form_id}/{$image['name']}")), $image['name']);
                        }
                    }
                    //Сохранение данных
                    $form_result = $form->form_results()->create([
                        'form_name' => $form->name,
                        'data' => json_encode($values)
                    ]);
                    $response['msg'] = $form->success_text;

                    //Сообщение в зохо/почту
                    $msg = '';
                    $email_msg = '';
                    $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
                    foreach ($values as $value) {
                        if (!empty($value['value'])) {
                            if ($value['type'] == 'image'){
                                $email_msg .= "{$value['name']}: {$protocol}{$_SERVER['HTTP_HOST']}{$value['value']}<br/>";
                            }else{
                                $msg .= "{$value['name']}: {$value['value']}<br/>";
                                $email_msg .= "{$value['name']}: {$value['value']}<br/>";
                            }
                        }
                    }
                    
                    $this->sendFormMail($email_msg, 'LandingPages(' . $form->name . ') ' . $_SERVER['HTTP_HOST']);

                    if (count($zoho_fields) >= 3) {
                        /*$request_url = 'https://support.infraredsaunaparts.com/support/WebToCase';
                        $zoho_data = array(
                            'Description' => $msg,
                            'Site' => 'Landing Pages',
                            'Subject' => 'LandingPages(' . $form->name . ') ' . $_SERVER['HTTP_HOST'],
                            'xnQsjsdp' => 'zk8hI9vIUANthYo*kRl79w$$',
                            'xmIwtLD' => '-pUXjU4*qUKUoJGCHzjBfHHp987L9qYB',
                            'actionType' => 'Q2FzZXM=',
                            'returnURL' => $protocol . $_SERVER['HTTP_HOST']
                        );
                        $zoho_data['First Name'] = '';
                        $zoho_data['Contact Name'] = $zoho_fields['name'];
                        $zoho_data['Email'] = $zoho_fields['email'];
                        $zoho_data['Phone'] = $zoho_fields['phone'];

                        $breaks = array("<br />", "<br>", "<br/>");
                        $zoho_data['Description'] = strip_tags(str_ireplace($breaks, "\r\n", $zoho_data['Description']));

                        if(count($curl_attachments)){
                            $zoho_data = array_merge($curl_attachments, $zoho_data);
                        }
                        
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                        curl_setopt($ch, CURLOPT_POST, TRUE);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $zoho_data);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type:multipart/form-data'));
                        curl_setopt($ch, CURLOPT_URL, $request_url);
                        curl_setopt($ch, CURLOPT_HEADER, false);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        $zoho_response = curl_exec($ch);
                        curl_close($ch);*/
                        
                        $zoho_data = [
                            "zf_referrer_name" => "",
                            "zf_redirect_url" => "",
                            "zc_gad" => "",
                            "SingleLine1" => 'LandingPages(' . $form->name . ') ' . $_SERVER['HTTP_HOST'],//"Contact us for a price",
                            "Name_First" => isset($zoho_fields['name']) ? $zoho_fields['name'] : '',
                            "Email" => isset($zoho_fields['email']) ? $zoho_fields['email'] : '',
                            "SingleLine8" => isset($zoho_fields['phone']) ? $zoho_fields['phone'] : '',
                            "MultiLine" => isset($zoho_fields['description']) ? $zoho_fields['description'] : '',
                            'SingleLine14' => 'Infrared Sauna Parts'
                        ];
                        
                        if(count($curl_attachments)){
                            $index = 0;
                            foreach($curl_attachments as $curl_attachment){
                                $zoho_data['ImageUpload'.($index > 0 ? $index : "")] = $curl_attachment;
                                $index++;
                            }
                        }
                        
                        $this->postMultipart(
                            "https://forms.zohopublic.com/zohopeople267/form/InfraredSaunaPartsForm/formperma/vXecmwVeDKV9IWNPI9ZORxSzoGRe4TWgIujPS9rF42g/htmlRecords/submit",
                            $zoho_data
                        );
                    }
                } else {
                    $response['errors'] = [];
                    foreach ($validator->errors()->getMessages() as $key => $message) {
                        if ($key == 'recapthca_error') {
                            $response['errors'][$key] = join("<br/>", $message);
                        } else {
                            $message = join("<br/>", $message);
                            $message = str_replace($key, $rule_field_names[$key]['name'], $message);
                            $response['errors'][$rule_field_names[$key]['field_id']] = $message;
                        }
                    }
                }
            } else {
                $response['error'] = 'Form not found';
            }
        } else {
            $response['error'] = 'Request error';
        }

        return response()->json($response);
    }
    
    public function send_pay_form(Request $request){
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'address' => 'required',
        ]);
        $validator->after(function ($validator) use ($request) {
            if (!$this->recaptcha_check($request->get('g-recaptcha-response'))) {
                $validator->getMessageBag()->add('recapthca_error', 'Please ensure that you are a human!');
            }
        });
        
        if (!$validator->fails()) {
            
            $msg = "
                First name: {$request->first_name}<br/>
                Last name: {$request->last_name}<br/>
                Email: {$request->email}<br/>
                Phone: {$request->phone}<br/>
                Country: {$request->country}<br/>
                State: {$request->state}<br/>
                City: {$request->city}<br/>
                Zip/postal code: {$request->zip}<br/>
                Address: {$request->address}
            ";
            
            $this->sendFormMail($msg, 'Haloone Order ' . $_SERVER['HTTP_HOST']);

            $this->postMultipart(
                "https://forms.zohopublic.com/zohopeople267/form/InfraredsaunapartsHaloOne/formperma/D1mC-AKUzriIdVBU9rTj8G7O6qWwvHYcooIq3tKOEjw/htmlRecords/submit",
                [
                    "zf_referrer_name" => "",
                    "zf_redirect_url" => "",
                    "zc_gad" => "",
                    "SingleLine" => $request->first_name,
                    "SingleLine1" => $request->last_name,
                    "SingleLine2" => $request->email,
                    "SingleLine3" => $request->phone,
                    "SingleLine4" => $request->country,
                    "SingleLine5" => $request->state,
                    "SingleLine6" => $request->city,
                    "SingleLine7" => $request->zip,
                    "SingleLine8" => $request->address,
                ]
            );
            
            $response['msg'] = '<i class="fas fa-spinner fa-spin"></i> Thank you for being our valued customer. We hope our product will meet your expectations. Let us know if you have any questions.';
        }else{
            $response['errors'] = [];
            foreach ($validator->errors()->getMessages() as $key => $message) {
                if ($key == 'recapthca_error') {
                    $response['errors'][$key] = join("<br/>", $message);
                } else {
                    $response['errors'][$key] = $message;
                }
            }
        }
        
        return response()->json($response);
    }

    private function recaptcha_check($captcha) {
        if (!$captcha) {
            return false;
        }
        $privatekey = "6LcgS1gUAAAAAB7o3BROVaLfH9iqjgUXJQQb5ivY";
        $remote = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        $response = $this->file_get_contents_curl("https://www.google.com/recaptcha/api/siteverify?secret=" . $privatekey . "&response=" . $captcha . "&remoteip=" . $remote);
        $responseKeys = json_decode($response, true);
        return is_array($responseKeys) && !empty($responseKeys['success']);
    }

    private function get_host($url) {
        $parseUrl = parse_url(trim((string) $url));
        if (!is_array($parseUrl)) {
            return '';
        }
        if (!empty($parseUrl['host'])) {
            return trim($parseUrl['host']);
        }
        $path = isset($parseUrl['path']) ? $parseUrl['path'] : '';
        $parts = explode('/', $path, 2);
        return trim($parts[0]);
    }

    private function check_black_list($form) {
        if (!is_array($form)) {
            return false;
        }
        $black_list = array('freetexthost.com', 'canadian-pharmacyn', 'cialis', 'porn');
        foreach ($form as $fields) {
            if (!is_array($fields)) {
                continue;
            }
            foreach ($fields as $field) {
                if (is_array($field)) {
                    $field = join(' ', $field);
                }
                if (!is_string($field) || $field === '') {
                    continue;
                }
                foreach ($black_list as $w) {
                    if (preg_match("/$w/iu", $field)) {
                        return false;
                    }
                }
                if (preg_match('/<[^<]+>/ius', $field)) {
                    return false;
                }
                if (preg_match('/http|ftp|mailto/ius', $field)) {
                    return false;
                }
                if(preg_match("/[а-яё]/iu", $field)){
                    return false;
                }
            }
        }
        return true;
    }

    private function sendFormMail($html, $subject) {
        try {
            $swift = Mail::getSwiftMailer();
            if ($swift && method_exists($swift->getTransport(), 'setTimeout')) {
                $swift->getTransport()->setTimeout(5);
            }
            Mail::send('emails.form', [
                'msg' => $html
            ], function ($m) use ($subject) {
                $m->to("info@infraredsaunaparts.com")->subject($subject);
            });
        } catch (\Exception $e) {
            \Log::error('Form mail failed: ' . $e->getMessage());
        }
    }

    private function postMultipart($url, array $fields) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    private function file_get_contents_curl($url) {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

}
