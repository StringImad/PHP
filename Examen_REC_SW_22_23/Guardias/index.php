<?php
session_name("exam_viej");
session_start();
require "src/funciones.php";
if(isset($_POST["btnSalir"])){
    session_destroy();
    consumir_servicios_REST($url,"GET",$_SESSION["api_session"]);
    header("Location:index.php");
    exit();
}
if (isset($_SESSION["usuario"])) {
    //seguridad
    require "src/seguridad.php";
    require "vistas/vista_principal.php";
} else {
    require "vistas/vista_login.php";
}
?>