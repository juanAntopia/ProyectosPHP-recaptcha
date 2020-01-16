<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

require_once 'init.php';
$response = $recaptcha->verify($_POST['g-recaptcha-response']);

if($response->isSuccess()){
    //revisar si existe el botón
    if(isset($_POST['enviar'])){
        //recoger los datos
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);

        //error en array
        $errores = array();
        //expresiones regulares
        $exp_string = "/^[a-záéóóúàèìòùäëïöüñ\s]+$/i";
        $exp_int = "/^[0-9]/";

        $expr1_test = preg_match($exp_string, $name);
        $expr2_test = preg_match($exp_int, $phone);

        //validación de todos los campos
        if(empty($name) || empty($email) || empty($phone)){
            header("Location: ../index.php?faltan_valores=Los campos no pueden estar vacíos");
        }
        
        //validación del campo nombre
        elseif($expr1_test == false){
            header("Location: ../index.php?error=Nombre no válido");
        } 
        
        elseif(strlen($name) > 100){
            header("Location: ../index.php?error=Máximo 100 caracteres");
        }
        
        //validación campo email 
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header("Location: ../index.php?error= Email no valido");
        }

        //validación campo teléfono
        elseif($expr2_test == false){
            header("Location: ../index.php?error= Solo números en este campo");
        }

        elseif(strlen($phone) > 15){
            header("Location: ../index.php?error= Máximo 15 dígitos");
        }

        else {
            $mail = new PHPMailer();
            $mail->CharSet = 'UTF-8';
            try{
                //server settings
                $mail->SMTPDebug = false;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com; smtp.live.com';
                $mail->SMTPAuth = true;
                $mail->Username = "businessprocessexpertsbpxs@gmail.com";
                $mail->Password = "Admin12345678";
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                //recipioents
                $mail->setFrom($email, $name);
                $mail->addAddress('juan_27angel@hotmail.com', 'juan');

                //content
                $mail->isHTML(true);
                $mail->Subject = 'Mensaje enviado';
                $mail->Body ='
                    <p>
						<h1>Mensaje de la página web</h1>
						
						
					</p>
					
					<p style="font-size:20px;">
						Puedes ponerte en contacto con <strong>'.$name.'</strong> al correo: <strong>'.$email.' </strong>
						o al teléfono: <strong>'.$phone. '</strong>
					</p>
                ';

                $mail->SMTPOptions = array('ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                if($mail->send()){
                    header("Location: gracias.php");
                }else{
                    header("Location:../index.php?error=*Error al enviarlo, Inténtelo de nuevo en unos momentos");
                }
                
            }catch(Exception $e){
                echo $e;
            }
        }

    }
}else{
   header('Location: ../index.php?error=Captcha Inválida');
}
