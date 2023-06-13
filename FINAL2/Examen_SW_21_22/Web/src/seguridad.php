<?php
$url = DIR_SERV . "/logueado";

$respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);

$obj = json_decode($respuesta);
if (!$obj) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
    session_destroy();
    die(error_page("ERROR", "Error consumiendo el servicio: " . $url));
}

if (isset($obj->error)) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);

    session_destroy();
    die(error_page("ERROR", "Error en la BD" . $obj->error));

}
if (isset($obj->no_auth)) {

    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesion ha expirado";
    header("Location:index.php");
    exit();
}
if (isset($obj->mensaje)) {
    echo "-----------------";
    session_unset();
    $_SESSION["seguridad"] = $obj->mensaje;
    header("Location:index.php");
    exit();

}

$datos_usu_log = $obj->usuario;

if (time() - $_SESSION["ultima_accion"] > 60 * MINUTOS) {
    session_unset();
    $_SESSION["seguridad"] = "Ha expirado el tiempo de la api";
    header("Location:index.php");
    exit();
}
$_SESSION["ultima_accion"] = time();