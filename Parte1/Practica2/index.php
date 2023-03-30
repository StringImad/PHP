<?php
require("src/funciones.php");
require("src/bd_config.php");
$error_form = true;
$error_formulario_registro = true;
//si le dan a boton borrar del registro
if (isset($_POST["btnBorrar"])) {
    unset($_POST);
}

//boton entrar del login
if (isset($_POST['btnEntrar'])) {
    $error_nombre = $_POST["nombre"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_nombre || $error_clave;

    //si  no hay error en al hacer login buscar el usuario

    if (!$error_form) {
        //conexion
    }
}

//boton enviar el formulario del registro
if (isset($_POST['btnEnviar'])) {
    $error_usuario = $_POST['usuario'] == "";
    $error_nombre = $_POST['nombre'] == "";
    $error_clave = $_POST["clave"] == "";
    $error_dni = $_POST["dni"] == "" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    $error_sexo = !isset($_POST["sexo"]);
    $error_suscrip = !isset($_POST["suscrip"]);
    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1000);

    $error_formulario_registro = $error_usuario || $error_nombre || $error_clave || $error_dni || $error_sexo || $error_foto || $error_suscrip;

    //si no hay error en el registro meter nuevo usuario

    if (!$error_formulario_registro) {
        //conexion
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die("Imposible conectar. Error Nº " . mysqli_connect_errno() . " : " . mysqli_connect_error());
        }
    }
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

    if ((isset($_POST["btnEntrar"]) && !$error_form) || (isset($_POST["btnEnviar"]) && !$error_formulario_registro)) {
        require "vistas/vista_info.php";
    } else if (isset($_POST["btnRegistro"])) {
        require "vistas/vista_formulario_registro.php";
    } else if (isset($_POST["btnEnviar"]) && $error_formulario_registro) {
        require "vistas/vista_formulario_registro.php";

    } else {
        require "vistas/vista_formulario_login.php";
    }

    ?>

</body>

</html>