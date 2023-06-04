<?php
session_name("recup_exam");
session_start();
require "src/funciones.php";
if (isset($_POST['btnLogin'])) {
    $error_usuario = $_POST['usuario'] == "";
    $error_clave = $_POST['clave'] == "";

    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {
        //Si no hay erreres llamamos al servicio
        $url = DIR_SERV . "/Login";
        $datos_env["usuario"] = $_POST["usuario"];
        $datos_env["clave"] = md5($_POST["clave"]);
        $respuesta = consumir_servicios_REST($url, "POST", $datos_env);
        $obj = json_decode($respuesta);

        if (!$obj) {
            die(error_page("Recup exam", "error", "error consumiendo el servicio: " . $url . $respuesta));
        }

        if (isset($obj->error)) {
            die(error_page("Recup exam", "error", "error en la bd", $obj->$error));
        }

        if (isset($obj->mensaje)) {
            $error_form = true;
        } else {
            $_SESSION['usuario'] = $datos_env["usuario"];
            $_SESSION["clave"] = $datos_env["clave"];

            $_SESSION["ultima_accion"] = time();

            $_SESSION["api_session"]["api_session"] = $obj->api_session;
        }
    }
}
if (isset($_POST["btnSalir"])) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
    session_destroy();
    header("Location:index.php");
    exit;

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .enlinea{
           display: inline;
        }
        .enlace{
            background-color: none;
            border: none;
            text-decoration: underline;
            cursor: pointer;
        }
        .tabla{
            width: 90%;

            border-collapse: collapse;
            border: 1px solid black;
        }
        .tabla td, th{
            border: 1px solid black;

        }
        .tabla th{
            background-color: #ccc;
        }

    </style>
</head>

<body>

    <?php
    if (isset($_SESSION['usuario'])) {
        require "src/seguridad.php";

        echo "<h1>Gestion de guardias</h1>";
        ?>
        Bienvenido <strong>
            <?php echo $_SESSION['usuario']; ?>
        </strong> -
        <form class="enlinea" action="index.php" method="post">
            <button name="btnSalir" class="enlace">Salir</button>
        </form>

        <?php

        require "vistas/vista_tabla.php";
    } else {
        require "vistas/vista_login.php";
    }

    ?>
</body>

</html>