<?php
$url = DIR_SERV . "/logueado";

$respuesta = consumir_servicios_REST($url, "GET",$_SESSION["api_session"]);

$obj = json_decode($respuesta);

if (!$obj) {

    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);

    die(error_page("Error", "Error", "Error consumiendo el servicio" . $url));
}
if (isset($obj->error)) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);

    die(error_page("Error", "Error", "Error base de datos: " . $obj->error));
}



if (isset($obj->no_auth)) {
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesion ha expirado";
    header("Location:index.php");
    exit;
}

 if (isset($obj->mensaje)) {
     consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
     session_unset();
     header("Location:index.php");
     exit;
 }

 $datos_usu_log = $obj->usuario;

 if (time() - $_SESSION["ultima_accion"] > 60 * MINUTOS) {
     consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
     session_unset();
     $_SESSION["seguridad"] = "El tiempo de sesion ha expierado";

     header("Location:index.php");
     exit;
 }
 $_SESSION["ultima_accion"] = time();
?>