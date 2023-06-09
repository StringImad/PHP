<?php
session_name("pract3_sw_22_23");
session_start();

require "src/funciones.php";
define("DIR_SERV", "http://localhost/proyectos/rec/PHP/Parte2/Pract3_SW/Servicios_Webs/servicios_rest_login");
if (isset($_SESSION["usuario"])) {

    if (isset($_POST["btnSalir"])) {
        session_destroy();
        header("Location:index.php");
        exit;
    }

    require "src/seguridad.php";

    //muestro vista oportuna

    if ($datos_usu_log->tipo == "admin")
        require "vistas/vista_admin.php";
    else
        require "vistas/vista_normal.php";
} else {
    require "vistas/vista_home.php";
}
