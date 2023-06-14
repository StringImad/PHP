<?php
require "src/funciones.php";

session_name("exam_pract");
session_start();
if (isset($_POST["btnSalir"])) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
    session_destroy();
    header("Location:index.php");
    exit;
}
if (isset($_SESSION["usuario"])) {
    //Realiza la seguridad
    require "src/seguridad.php";
    //LOGIN realizado con exito

    if ($_SESSION["tipo"] == "admin") {
        require "vistas/vista_admin.php";

    } else {
        require "vistas/vista_normal.php";
    }

} else {
    require "vistas/vista_login.php";
}
?>