<?php
$url = DIR_SERV . "/logueado";
$respuesta = consumir_servicios_REST($url, "POST", $_SESSION["api_session"]);
$obj = json_decode($respuesta);

if (!$obj) {
    consumir_servicios_REST("/salir", "POST", $_SESSION["api_session"]);
    session_destroy();
    die(error_page("Error", "error conusmiendo servicio" . $url));
}
if (isset($obj->error)) {
    consumir_servicios_REST("/salir", "POST", $_SESSION["api_session"]);
    session_destroy();
    die(error_page("Error", "error en la BD: " . $obj->error));
}

if (isset($obj->no_auth)) {
    session_unset();
    $_SESSION["seguridad"] = "sesion expirada";
    header("Location:index.php");
    exit;
}
if (isset($obj->mensaje)) {
    session_unset();
    $_SESSION["seguridad"] = "usuario no se encuntra en la BD";
    header("Location:index.php");
    exit;
}

$datos_usu_log = $obj->usuario;

if (time() - $_SESSION["ultima_accion"] > 60 * MINUTOS) {

    session_unset();
    $_SESSION["seguridad"] = "Tiempo de sesion expierado";
    header("Location:index.php");
    exit;
}
$_SESSION["ultima_accion"] = time();

?>