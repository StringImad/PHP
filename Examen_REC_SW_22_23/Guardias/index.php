<?php
session_name("recup_exam");
session_start();
require "src/funciones.php";
if (isset($_POST['btnLogin'])) {
    $error_usuario = $_POST['usuario'] == "";
    $error_clave = $_POST['clave'] == "";

    $error_form =  $error_usuario || $error_clave;

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

            $_SESSION["api_session"]["api_session"]=$obj->api_session;
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
    <title>Document</title>
</head>

<body>

    <?php
    if (isset($_POST["btnLogin"]) && !$error_form) {
        echo "<h1>Gestion de guardias</h1>";
        echo "<p>Bienvenido <strong>" . $_SESSION["usuario"] . "</strong></p>";
    } else {
        require "vistas/vista_login.php";
    }

    ?>
</body>

</html>