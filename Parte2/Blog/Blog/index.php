<?php
session_name("exam_blog_22_23");
session_start();

require "src/funciones_ctes.php";


if(isset($_SESSION["usuario"]))
{
    header("Location:principal.php");
    exit();
}
elseif(isset($_POST["btnRegistro"]) || isset($_POST["btnContRegistro"])){
    echo "ha pulsado en btnRegistro o btnContRegistro ";
        require "vistas/vista_registro.php";

}else{
    // if(isset($_POST["btnRegistro"])){
    //     require "vistas/vista_registro.php";
    // }
    require "vistas/vista_login.php";
}

?>