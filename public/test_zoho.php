<?php
$files = [
    $_SERVER['DOCUMENT_ROOT']."/images/parts_main/infrarednewlogo1.jpg",
    $_SERVER['DOCUMENT_ROOT']."/images/parts_main/infrarednewlogo1.png"
];

print_r($files);
$data = [
    "zf_referrer_name" => "",
    "zf_redirect_url" => "",
    "zc_gad" => "",
    "SingleLine1" => 'LandingPages(test) ' . $_SERVER['HTTP_HOST'],//"Contact us for a price",
    "Name_First" => 'test',
    "Email" => 'test@test.com',
    "SingleLine8" => '111111111111111',
    "MultiLine" => 'description'
];
foreach ($files as $index => $file) {
    if($index <= 4){
        $data['ImageUpload'.($index > 0 ? $index : "")] = curl_file_create(
            realpath($file),
            mime_content_type($file),
            basename($file)
        );
    }
    /*$data["ImageUpload[{$index}]"] = '@' . realpath(
        realpath($file),
        mime_content_type($file),
        basename($file)
    );*/
    //$data["ImageUpload[{$index}]"] = "@{$file}";
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
curl_setopt($ch, CURLOPT_URL, "https://forms.zohopublic.com/zohopeople267/form/InfraredSaunaPartsForm/formperma/vXecmwVeDKV9IWNPI9ZORxSzoGRe4TWgIujPS9rF42g/htmlRecords/submit");
curl_setopt($ch, CURLOPT_HEADER, false); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$zoho_response = curl_exec($ch); 

if ($zoho_response === false) {
    echo(curl_error($zoho_response));
}
echo $zoho_response;
curl_close($ch);