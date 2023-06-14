<?php
$url = DIR_SERV."/logueado";
$respuesta = consumir_servicios_REST($url,"GET",$_SESSION["api_session"]);

$obj = json_decode($respuesta);

if(!$obj){
    consumir_servicios_REST("/salir","POST",$_SESSION["api_session"]);
    session_destroy();
    die(error_page("error", "error consumiendo servicio: ", $url));
}

if (isset($obj->error)) {
    consumir_servicios_REST("/salir","POST",$_SESSION["api_session"]);

    session_destroy();
    die(error_page("error", "error en la BD: ", $obj->error));
}

if (isset($obj->mensaje)) {
    session_unset();
    $_SESSION["seguridad"] = $obj->mensaje;
    header("Location: index.php");
    exit();

}

$datos_usu_log= $obj->usuario;

if(time()-$_SESSION["ultima_accion"]>60*MINUTOS){
    session_unset();
    $_SESSION["seguridad"] =" El tiempo ha expirado";
    header("Location: index.php");
    exit();
}
$_SESSION["ultima_accion"] = time();
?>