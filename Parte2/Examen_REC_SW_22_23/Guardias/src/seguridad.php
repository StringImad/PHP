<?php
$url=DIR_SERV."/logueado";
$respuesta=consumir_servicios_REST($url,"GET",$_SESSION["api_session"]);
$obj=json_decode($respuesta);
if(!$obj)
{
    consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
    session_destroy();
    die(error_page("Gestión de Guardias","Gestión de Guardias","Error consumiendo el servicio: ".$url));
}
if(isset($obj->error))
{
    consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
    session_destroy();
    die(error_page("Gestión de Guardias","Gestión de Guardias",$obj->error));
}

if(isset($obj->no_auth))
{
    session_unset();
    $_SESSION["seguridad"]="El tiempo de sesión de la API ha expirado";
    header("Location:index.php");
    exit;
}

if(isset($obj->mensaje))
{
    
    consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
    session_unset();
    $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}


$datos_usu_log=$obj->usuario;

if(time()-$_SESSION["ultima_accion"]>MINUTOS*60)
{
    consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
    session_unset();
    $_SESSION["seguridad"]="Su tiempo de sesión ha expirado";
    header("Location:index.php");
    exit;
}
$_SESSION["ultima_accion"]=time();


?>