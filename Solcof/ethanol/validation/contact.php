<?php
require_once 'init.php';

$response = $captcha->verify($_POST['g-recaptcha-response']);

if ($response->isSuccess()) {

    if (isset($_POST['submit'])) {
        //recoger los datos
        $nombre = trim($_POST['nombre']);
        $mail = trim($_POST['mail']);
        $telefono = trim($_POST['telefono']);
        $mensaje = trim($_POST['mensaje']);

        //expresiones regulares
        $exp_string = "/^[a-záéóóúàèìòùäëïöüñ\s]+$/i";

        $expr1_test = preg_match($exp_string, $nombre);
        //validación de todos los campos
        if (empty($nombre) || empty($mail) || empty($mensaje) || empty($telefono)) {
            header("Location: ../index.html?faltan_valores=Los campos no pueden estar vacíos");
        }

        //validación del campo nombre
        elseif ($expr1_test == false) {
            header("Location: ../index.html?error=Nombre no válido");
        } elseif (strlen($nombre) > 100) {
            header("Location: ../index.html?error=Máximo 100 caracteres");
        }

        //validación del campo teléfono
        elseif (!is_numeric($telefono)) {
            header("Location: ../index.html?error=Teléfono inválido - solo números");
        }

        //validación campo email 
        elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../index.html?error= Email no valido");
        } 
        
        //validación campo mensaje
        elseif (strlen($mensaje) > 500) {
            header("Location: ../index.html?error=Máximo 500 caracteres");
        } 
        
        //sino envía el email
        else {
            //asunto
            $asunto = "Mensaje desde la página web";

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
                <p>
                    Mensaje: ' . $mensaje . '
                </p>
					
				<p style="font-size:20px;">
                    Puedes ponerte en contacto con <strong>' . $nombre . '</strong> al correo: <strong>' . $mail . ' </strong>
                    o al teléfono <strong>'. $telefono .'</strong>
					
				</p>
		';

            //enviar correo
            $envio = mail($destino, $asunto, $contenido, $headers);

            if ($envio) {
                header("Location:gracias.php");
                //Enviando autorespuesta
                $pwf_header = "juan_27angel@hotmail.com\n"
                    .  "Reply-to: juan_27angel@hotmail.com \n";
                $pwf_asunto = "Solcof Confirmación";
                $pwf_dirigido_a = "$mail";
                $pwf_mensaje = "$nombre Gracias por dejarnos su mensaje desde nuestro sitio web \n"
                    . "Su mensaje ha sido recibido satisfactoriamente \n"
                    . "Nos pondremos en contacto lo antes posible a su e-mail: $mail \n"
                    . "\n"
                    . "\n"
                    . "-----------------------------------------------------------------"
                    . "Favor de NO responder este e-mail ya que es generado Automaticamente.\n"
                    . "Atte: Solcof - Soluciones Contables y Fiscales. \n";
                @mail($pwf_dirigido_a, $pwf_asunto, $pwf_mensaje, $pwf_header);
            } else {
                header("Location:../index.html?error=Inténtelo de nuevo en unos momentos");
            }
        }
    }
} else {
    header('Location: ../index.html?error=Captcha Inválida');
}