<?php
session_name("Examen_Rec_SW_22_23");
session_start();

require "src/funciones_ctes.php";

if(isset($_POST["btnSalir"]))
{
    consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
    session_destroy();
    header("Location:index.php");
    exit;
}


if(isset($_SESSION["usuario"]))
{
    //Ya estoy logueado
    require "src/seguridad.php";

    require "vistas/vista_examen.php";

}
else
{
    require "vistas/vista_login.php";

}

?>
