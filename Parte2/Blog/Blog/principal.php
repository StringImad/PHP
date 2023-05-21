<?php
session_name("exam_blog_22_23");
session_start();

require "src/funciones_ctes.php";

if(isset($_POST["btnSalir"]))
{
    session_destroy();
    header("Location:index.php");
    exit;

}

if(isset($_SESSION["usuario"]))
{
    $salto="index.php";

    require "src/seguridad.php";

    if($datos_usu_log->tipo=="admin")
    {
        header("Location:admin/gest_comentarios.php");
        exit;
    }
    else
        require "vistas/vista_normal.php";

}
else
{
    header("Location:index.php");
    exit;
}

?>