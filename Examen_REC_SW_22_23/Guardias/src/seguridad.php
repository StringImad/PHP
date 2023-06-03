<?php
$url = DIR_SERV . "/Logueado";
$datos_env["api_session"] = $_SESSION["api_session"];
$respuesta = consumir_servicios_REST($url, "GET", $datos_env);
$obj = json_decode($respuesta);
//Error al consumir el objeto

if (!$obj) {
    consumir_servicios_REST(DIR_SERV . "/Salir", "POST", $_SESSION["api_session"]);
    session_destroy();
    die(error_page("Recup exam", "error", "error consumiendo el servicio: " . $url . $respuesta));
}


//error de consulta o de bd
if (isset($obj->error)) {
    consumir_servicios_REST(DIR_SERV . "/Salir", "POST", $_SESSION["api_session"]);
    session_destroy();
    die(error_page("Recup exam", "error en la bd", $obj->error));
}


// no funciona esta parte del codigo
// if(isset($obj->no_auth)){
//     session_unset();
//     $_SESSION["seguridad"] = "El tiempo de sesión de la api ha terminado";
//     header("Location: index.php"  );
//     exit;
// }

//usuario no encontrado
// if (isset($obj->mensaje)) {
//     echo "---------------------------------4-------------------------------";

//     consumir_servicios_REST(DIR_SERV . "/Salir", "POST", $_SESSION["api_session"]);
//     session_unset();
//     $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
//     header("Location: index.php"  );
//     exit;
// }

//almacenamos los datos del usuario
// if (isset($obj->usuario)) {
//     $datos_usu_log = $obj->usuario;
// }
// if(time() - $_SESSION["ultima_accion"]>MINUTOS*60){
//     session_unset();
//     $_SESSION["seguridad"] = "El tiempo de sesión de la api ha terminado";
//     header("Location: index.php"  );
//     exit;
// }
// $_SESSION["ultima_accion"]=time();
?>