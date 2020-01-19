<?php
 

if($_POST) {
    $nombre = "";
    $asunto = "";
    $mail = "";
    $mensaje = "";

     
    if(isset($_POST['nombre'])) {
      $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
      $email_to = "x_petex@hotmail.com";

    }
     
    if(isset($_POST['mail'])) {
        $mail = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['mail']);
        $mail = filter_var($mail, FILTER_VALIDATE_EMAIL);
    }
     
    if(isset($_POST['asunto'])) {
        $asunto = filter_var($_POST['asunto'], FILTER_SANITIZE_STRING);
    }

    if(isset($_POST['mensaje'])) {
        $mensaje = htmlspecialchars($_POST['mensaje']);
    }

     
    $headers  = 'MIME-Version: 1.0' . "\r\n"
    .'Content-type: text/html; charset=utf-8' . "\r\n"
    .'From: ' . $mail. "\r\n";
    $email_subject = "Contacto desde el sitio web";
 
?>