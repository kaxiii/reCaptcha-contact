<?php

// CAPTCHA CHECK //////////////////////////////////////////////////
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
    
    $validate = json_decode($result);
}
///////////////////////////////////////////////////////////////////

if ($validate->success) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $subject = "Message from " . $name . " - " . $email;

    // Set content-type header for sending HTML email 
    $headers = "MIME-Version: 1.0" . "\r\n"; 
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: '.$name.'<'.$email.'>' . "\r\n"; 
    $headers .= 'Cc: ccmail@myweb.com' . "\r\n";

    // Your HTML here
    $m = "
        <style type='text/css'>
            p {
                color: firebrick;
            }
        </style>
        <p>". $message ."</p>";
    

    if(mail('contact@myweb.com', $subject, $m, $headers)) {
        echo '<b style="color: firebrick;"> Mail Sended </b>';
    }

    else {
        echo "Invalid Captcha";
    }

}

?>