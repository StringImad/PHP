<?php
session_name("exam_pract");
session_start();
require "src/funciones.php";
if (isset($_SESSION["usuario"])) {
    //Realiza la seguridad
    // require "src/seguridad.php";
    //LOGIN realizado con exito
    if ($_SESSION["tipo"] == "Admin") {
        require "vistas/vista_admin.php";
    } else {
        require "vistas/vista_normal.php";
    }
} else {
    require "vistas/vista_login.php";
}
?>