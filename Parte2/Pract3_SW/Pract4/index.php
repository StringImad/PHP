<?php
session_name("pract4_sw_22_23");
session_start();

define("DIR_SERV","http://localhost/PHP/Parte2/Pract_3/Servicios_Webs/servicios_rest_login");
//si exsite la sesion es que esta logueado o se ha registrado
if(isset($_SESSION["usuario"]))
{

    if(isset($_POST["btnSalir"]))
    {
        session_destroy();
        header("Location:index.php");
        exit;
    }
    

    //muestro vista oportuna
    
    if($datos_usu_log->tipo=="admin")
        require "vistas/vista_admin.php";
    else
        require "vistas/vista_normal.php";

}
else
    require "vistas/vista_home.php";
?>