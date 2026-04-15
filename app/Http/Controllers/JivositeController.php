<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Mail;

class JivositeController extends Controller
{
    public function send_to_zoho_first_msg(Request $request){
        $request_url = 'https://support.infraredsaunaparts.com/support/WebToCase';
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
        $zoho_data = array(
                'Description' => "Chat id <a href='https://app.jivosite.com/chat/my/{$_POST['chat_id']}'>#{$_POST['chat_id']}</a>",
                'Subject' => "New chat {$_SERVER['HTTP_HOST']} #{$_POST['chat_id']}",
                'Site' => $_SERVER['HTTP_HOST'],
                'xnQsjsdp' => 'zk8hI9vIUANthYo*kRl79w$$',
                'xmIwtLD' => '-pUXjU4*qUKUoJGCHzjBfHHp987L9qYB',
                'actionType' => 'Q2FzZXM=',
                'returnURL' => $protocol.$_SERVER['HTTP_HOST']
        );			
        $zoho_data['First Name'] = '';
        $zoho_data['Contact Name'] = 'blank';
        $zoho_data['Email'] = 'blank@mail.com';
        $zoho_data['Phone'] = '-';
        
        /*Mail::send(['html' => 'emails.jivosite_zoho_first_msg'], $zoho_data, function($message){
            $message->to(env('MAIL_ADMIN'))->subject("New chat {$_SERVER['HTTP_HOST']} #{$_POST['chat_id']}");//env('MAIL_ADMIN')
        });*/

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 	
        $request_parameters = $zoho_data;
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request_parameters));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch, CURLOPT_URL, $request_url);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $response_info = curl_getinfo($ch);
        curl_close($ch);
        die('Created');
    }
    
    public function send_to_zoho_contacts(Request $request){
        $request_url = 'https://support.infraredsaunaparts.com/support/WebToCase';
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
        $zoho_data = array(
                'Description' => "Chat id <a href='https://app.jivosite.com/chat/my/{$_POST['chat_id']}'>#{$_POST['chat_id']}</a>",
                'Subject' => "Update chat contacts {$_SERVER['HTTP_HOST']} #{$_POST['chat_id']}",
                'Site' => $_SERVER['HTTP_HOST'],
                'xnQsjsdp' => 'zk8hI9vIUANthYo*kRl79w$$',
                'xmIwtLD' => '-pUXjU4*qUKUoJGCHzjBfHHp987L9qYB',
                'actionType' => 'Q2FzZXM=',
                'returnURL' => $protocol.$_SERVER['HTTP_HOST']
        );			
        $zoho_data['First Name'] = '';
        $zoho_data['Contact Name'] = $_POST['client_name'];
        $zoho_data['Email'] = $_POST['email'];
        $zoho_data['Phone'] = $_POST['phone'];
        
        /*Mail::send(['html' => 'emails.jivosite_zoho_contacts'], ['name' => $zoho_data['Contact Name'], 'email' => $zoho_data['Email'], 'phone' => $zoho_data['Phone'], 'description' => $zoho_data['Description']], function($message){
            $message->to(env('MAIL_ADMIN'))->subject("Update chat contacts {$_SERVER['HTTP_HOST']} #{$_POST['chat_id']}");
        });*/


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 	
        $request_parameters = $zoho_data;
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request_parameters));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch, CURLOPT_URL, $request_url);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $response_info = curl_getinfo($ch);
        curl_close($ch);
        die('Created');
    }
    
    public function send_to_zoho_events(Request $request){
        $content = file_get_contents('php://input');
        if(!empty($content)){
            $content = json_decode($content, true);
            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/jivosite.log', print_r($content['event_name'], true), FILE_APPEND);
            if(isset($content['event_name'])){
                if($content['event_name'] == 'offline_message'){
					$host = @parse_url($content['page']['url'])['host'];
                    $request_url = 'https://support.infraredsaunaparts.com/support/WebToCase';
                    $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
                    $zoho_data = array(
                            'Description' => $content['message'],
                            'Subject' => "Chat offline message {$host}",
                            'Site' => $host,
                            'xnQsjsdp' => 'zk8hI9vIUANthYo*kRl79w$$',
                            'xmIwtLD' => '-pUXjU4*qUKUoJGCHzjBfHHp987L9qYB',
                            'actionType' => 'Q2FzZXM=',
                            'returnURL' => $protocol.$_SERVER['HTTP_HOST']
                    );			
                    $zoho_data['First Name'] = '';
                    $zoho_data['Contact Name'] = @$content['visitor']['name'];
                    $zoho_data['Email'] = @$content['visitor']['email'];
                    $zoho_data['Phone'] = @$content['visitor']['phone'];

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 	
                    $request_parameters = $zoho_data;
                    curl_setopt($ch, CURLOPT_POST, TRUE);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request_parameters));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
                    curl_setopt($ch, CURLOPT_URL, $request_url);
                    curl_setopt($ch, CURLOPT_HEADER, TRUE);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $response = curl_exec($ch);
                    $response_info = curl_getinfo($ch);
                    curl_close($ch);
                    die('Created');
                }
            }
        }
    }
}
