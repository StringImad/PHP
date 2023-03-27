<?php

if (isset($_POST["btnBorrar"])) {
    unset($_POST);
}
if (isset($_POST["btnEnviar"])) {
    $error_nombre = $_POST["nombre"] == "";
    $error_sexo = !isset($_POST["sexo"]);
    $error_coment = $_POST["coment"]== "";
    echo "valor de coment". $_POST["coment"];
    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"])) || $_FILES["foto"]["size"] > 500000;
    $error_form = $error_coment || $error_nombre || $error_sexo || $error_foto;
}

?>
<html lang="es">

<head>
    <title>Segundo Formulario</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .oculta {
            display: none;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_POST["btnEnviar"]) && !$error_form) {
        require "vistas/vista_info.php";
    } else {
        require "vistas/vista_formulario.php";
    }
    ?>
</body>

</html>