<?php
//Siempre que se trabaja con sesiones hay que poner nombre y comenzarla
session_name("primer_login_22_33");
session_start();
define("MINUTOS", 10);
if (isset($_SESSION["usuario"])) {
    //Estoy logueado
    if (isset($_POST["btnSalir"])) {
        session_destroy();
        header("Location:index.php");
        exit;
    }
    require "src/seguridad.php";
    //Si voy por aqui es que tengo la seguridad pasada (baneo y tiempo):
    // 1.- Conexion BD abierta
    //2.- Ultima accion renovada
    //3.- Usuario logueado en $datos_usuario_log
    if ($datos_usuario_log["tipo"] == "normal")
        require "vistas/vista_normal.php";
    else
        require "vistas/Admin/vista_admin.php";

    $conexion = null;
} else if (isset($_POST["btnRegistro"]) || isset($_POST["btnEnviar"]) || isset($_POST["btnVolver"])) {
    //No estoy logueado
    require "vistas/vista_formulario_registro.php";
} else {
    require "vistas/vista_home.php";
}