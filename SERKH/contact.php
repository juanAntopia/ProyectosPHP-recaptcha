<?php

if(isset($_POST['submit'])){
    //recoger los datos
    $nombre = trim($_POST['nombre']);
    $asunto = trim($_POST['asunto']);
    $mail = trim($_POST['mail']);
    $mensaje = trim($_POST['mensaje']);

    //expresiones regulares
    $exp_string = "/^[a-záéóóúàèìòùäëïöüñ\s]+$/i";

    $expr1_test = preg_match($exp_string, $nombre);
    //validación de todos los campos
    if (empty($nombre) || empty($mail) || empty($mensaje) || empty($asunto)) {
        header("Location: index.php?faltan_valores=Los campos no pueden estar vacíos");
    }

    //validación del campo nombre
    elseif ($expr1_test == false) {
        header("Location: index.php?error=Nombre no válido");
    } 
    
    elseif (strlen($nombre) > 100) {
        header("Location: index.php?error=Máximo 100 caracteres");
    }

    //validación del campo asunto
    elseif (strlen($asunto)>50) {
        header("Location: index.php?error=Máximo 50 caracteres");
    } 
    
    //validación campo email 
    elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.php?error= Email no valido");
    }

    elseif (strlen($mensaje) > 500) {
        header("Location: index.php?error=Máximo 500 caracteres");
    }

    else{
        echo $nombre;
        echo $asunto;
        echo $mail;
        echo $mensaje;
    }
}