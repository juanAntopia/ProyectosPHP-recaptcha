<?php

require_once 'init.php';
$response = $recaptcha->verify($_POST['g-recaptcha-response']);

if ($response->isSuccess()) {
    //revisar si existe el botón
    if (isset($_POST['enviar2'])) {
        //recoger los datos
        $name = trim($_POST['name2']);
        $email = trim($_POST['email2']);
        $phone = trim($_POST['phone2']);
        $file = $_FILES['adjunto'];

        //expresiones regulares
        $exp_string = "/^[a-záéóóúàèìòùäëïöüñ\s]+$/i";
        $exp_int = "/^[0-9]/";

        $expr1_test = preg_match($exp_string, $name);
        $expr2_test = preg_match($exp_int, $phone);

        //validación de todos los campos
        if (empty($name) || empty($email) || empty($phone)) {
            header("Location: ../index.php?faltan_valores=Los campos no pueden estar vacíos");
        }

        //validación del campo nombre
        elseif ($expr1_test == false) {
            header("Location: ../index.php?error=Nombre no válido");
        } elseif (strlen($name) > 100) {
            header("Location: ../index.php?error=Máximo 100 caracteres");
        }

        //validación campo email 
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../index.php?error= Email no valido");
        }

        //validación campo teléfono
        elseif ($expr2_test == false) {
            header("Location: ../index.php?error= Solo números en este campo");
        } elseif (strlen($phone) > 15) {
            header("Location: ../index.php?error= Máximo 15 dígitos");
        } else {
            $nameFile = $_FILES['adjunto']['name'];
            $sizeFile = $_FILES['adjunto']['size'];
            $typeFile = $_FILES['adjunto']['type'];
            $tempFile = $_FILES["adjunto"]["tmp_name"];
            $fecha = time();
            $fechaFormato = date("j/n/Y", $fecha);

            $correoDestino = "juan_27angel@hotmail.com";
            //, contacto@7mas1.com
            //asunto del correo
            $asunto = "Enviado por " . $name . "  sección - Únete a nuestro equipo";


            // -> mensaje en formato Multipart MIME
            $cabecera = "MIME-VERSION: 1.0\r\n";
            $cabecera .= "Content-type: multipart/mixed;";
            //$cabecera .="boundary='=P=A=L=A=B=R=A=Q=U=E=G=U=S=T=E=N='"
            $cabecera .= "boundary=\"=C=T=E=C=\"\r\n";
            $cabecera .= "From: {$email}";

            //Primera parte del cuerpo del mensaje
            $cuerpo = "--=C=T=E=C=\r\n";
            $cuerpo .= "Content-type:text/plain; charset=iso-8859-1\r\n";
            $cuerpo .= "charset=utf-8\r\n";
            $cuerpo .= "Content-Transfer-Encoding: 7bit\r\n";
            $cuerpo .= "\r\n"; // línea vacía
            $cuerpo .= "Correo enviado por: " . $name;
            $cuerpo .= " con fecha: " . $fechaFormato . "\r\n";
            $cuerpo .= "Email: " . $email . "\r\n";
            $cuerpo .= "\r\n"; // línea vacía

            // -> segunda parte del mensaje (archivo adjunto)
            //    -> encabezado de la parte
            $cuerpo .= "--=C=T=E=C=\r\n";
            $cuerpo .= "Content-Type: application/octet-stream; ";
            $cuerpo .= "name=" . $nameFile . "\r\n";
            $cuerpo .= "Content-Transfer-Encoding: base64\r\n";
            $cuerpo .= "Content-Disposition: attachment; ";
            $cuerpo .= "filename=" . $nameFile . "\r\n";
            $cuerpo .= "\r\n"; // línea vacía

            $fp = fopen($tempFile, "rb");
            $file = fread($fp, $sizeFile);
            $file = chunk_split(base64_encode($file));

            $cuerpo .= "$file\r\n";
            $cuerpo .= "\r\n"; // línea vacía
            // Delimitador de final del mensaje.
            $cuerpo .= "--=C=T=E=C=--\r\n";

            //Enviar el correo
            if (mail($correoDestino, $asunto, $cuerpo, $cabecera)) {
                header("Location:gracias.php");
            } else {
                header("Location:../index.php?error=Inténtelo de nuevo en unos momentos");
            }
        }
    }
} else {
    header('Location: ../index.php?error2=Captcha Inválida');
}