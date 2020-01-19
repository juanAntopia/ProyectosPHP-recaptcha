<?php

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
            //asunto
            $asunto = "Mensaje de la página web sección - Contacto";

            //destinatario
            $destino = "juan_27angel@hotmail.com";

            //cabeceras para validar el formato HTML
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";

            //contenido del mensaje
            $contenido =  '
		<p>
						<h1>Mensaje de la página web</h1>
						<span></span>
						
					</p>
					
					<p style="font-size:20px;">
						Puedes ponerte en contacto con <strong>' . $name . '</strong> al correo: <strong>' . $email . ' </strong>
						o al teléfono: <strong>' . $phone . '</strong>
					</p>
		';

            //enviar correo
            $envio = mail($destino, $asunto, $contenido, $headers);

            if ($envio) {
                header("Location:gracias.php");
                //Enviando autorespuesta
                $pwf_header = "juan_27angel@hotmail.com\n"
                    .  "Reply-to: juan_27angel@hotmail.com \n";
                $pwf_asunto = "BP-XS Confirmación";
                $pwf_dirigido_a = "$email";
                $pwf_mensaje = "$name Gracias por dejarnos su mensaje desde nuestro sitio web \n"
                    . "Su mensaje ha sido recibido satisfactoriamente \n"
                    . "Nos pondremos en contacto lo antes posible a su e-mail: $email o su telefono $telefono \n"
                    . "\n"
                    . "\n"
                    . "-----------------------------------------------------------------"
                    . "Favor de NO responder este e-mail ya que es generado Automaticamente.\n"
                    . "Atte: DREFSA Mtto. de Drenaje Industrial \n";
                @mail($pwf_dirigido_a, $pwf_asunto, $pwf_mensaje, $pwf_header);
            } else {
                header("Location:../index.php?error=Inténtelo de nuevo en unos momentos");
            }
        }

    }
}else{
   header('Location: ../index.php?error=Captcha Inválida');
}
