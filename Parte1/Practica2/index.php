<?php
if (isset($_POST['btnEntrar'])) {
    $error_nombre = $_POST["nombre"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_form = $error_nombre || $error_clave;
}

if (isset($_POST['btnRegistro'])) {
    $error_usuario = $_POST['usuario']=="";
    $error_nombre = $_POST["nombre"] == "";
    $error_clave = $_POST["clave"] == "";
    

    $error_form = $error_nombre || $error_clave;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica Rec 2</title>
</head>

<body>
    <h1>Practica Rec 2</h1>

    <?php
    if (isset($_POST["btnEntrar"]) && !$error_form) {
        require "vistas/vista_info.php";
    } else if (isset($_POST["btnRegistro"])) {
        require "vistas/vista_formulario_registro.php";

    } else {
        require "vistas/vista_formulario_login.php";
    }

    ?>

</body>

</html>