<?php

if ($_POST['g-recaptcha-response'] == '') {
    echo "Invalid Captcha";
    } 
    
else {
    $obj = new stdClass();
    $obj->secret = "your-recaptcha-secret";
    $obj->response = $_POST['g-recaptcha-response'];
    $obj->remoteip = $_SERVER['REMOTE_ADDR'];
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    
    $options = array(
    'http' => array(
    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
    'method' => 'POST',
    'content' => http_build_query($obj)
    )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    $validar = json_decode($result);
}

if ($validar->success) {
    //echo "Mail";
    $name = $_POST['name'];
    $email = $_POST['email'];
    $header = "Message from " . $name . " - " . $email;
    $message = $_POST['message'];
    

    if(mail('atencioncliente@hidalgosgroup.com', $header, $message)){
        echo "Mail sended";
    }

    else {
        echo "Invalid Captcha";
    }

}

?>