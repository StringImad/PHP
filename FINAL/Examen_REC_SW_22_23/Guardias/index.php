<?php
require "src/funciones.php";

session_name("exam_recup");
session_start();
if(isset($_POST["btnSalir"])){
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
}
if(isset($_SESSION["usuario"])){
    //usuario logueado 
    require "src/seguridad.php";
    require "vistas/vista_tabla.php";
}else{
    //vista login
    require "vistas/vista_login.php";
}

?>
