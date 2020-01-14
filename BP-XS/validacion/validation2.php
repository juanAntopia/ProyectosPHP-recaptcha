<?php
//revisar si existe el botón
if (isset($_POST['enviar2'])) {
    //recoger los datos
    $name = trim($_POST['name2']);
    $email = trim($_POST['email2']);
    $phone = trim($_POST['phone2']);

    //expresiones regulares
    $exp_string = "/^[a-záéóóúàèìòùäëïöüñ\s]+$/i";
    $exp_int = "/^[0-9]/";

    $expr1_test = preg_match($exp_string, $name);
    $expr2_test = preg_match($exp_int, $phone);

    //validación de todos los campos
    if (empty($name) || empty($email) || empty($phone)) {
        header("Location: ../index.html?faltan_valores=Los campos no pueden estar vacíos");
    }

    //validación del campo nombre
    elseif ($expr1_test == false) {
        header("Location: ../index.html?error=Nombre no válido");
    } elseif (strlen($name) > 100) {
        header("Location: ../index.html?error=Máximo 100 caracteres");
    }

    //validación campo email 
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../index.html?error= Email no valido");
    }

    //validación campo teléfono
    elseif ($expr2_test == false) {
        header("Location: ../index.html?error= Solo números en este campo");
    } 
    
    elseif (strlen($phone) > 15) {
        header("Location: ../index.html?error= Máximo 15 dígitos");
    } 
    
    else {
        echo $name;
        echo $email;
        echo $phone;
    }
}
