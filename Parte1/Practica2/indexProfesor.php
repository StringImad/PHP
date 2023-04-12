<?php
//Siempre que se trabaja con sesiones hay que poner nombre y comenzarla
session_name("primer_login_22_33");
session_start();
define("MINUTOS", 10);
if (isset($_SESSION["usuario"])) {
    //Estoy logueado
    if(isset($_POST["btnSalir"])){
        session_destroy();
        header("Location:index.php");
        exit;
    }
    require "src/seguridadPDO.php";

    if ($datos_usuario_log["tipo"] == "normal")
        require "vistas/vista_normal.php";
    else
        require "vistas/Admin/vista_admin.php";

        $conexion = null;
} else if (isset($_POST["btnRegistro"]) || isset($_POST["btnContinuarRegistro"]) || isset($_POST["btnVolver"])) {
    //No estoy logueado
    require "vistas/vista_formulario_registro.php";
} else {
    require "vistas/vista_home.php";
}
