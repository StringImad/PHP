<?php
session_name("exam_blog_22_23");
session_start();

require "src/funciones_ctes.php";


if(isset($_SESSION["usuario"]))
{
    header("Location:principal.php");
    exit();
}
else
{
    // if(isset($_POST["btnRegistro"])){
    //     require "vistas/vista_registro.php";
    // }
    require "vistas/vista_login.php";
}

?>