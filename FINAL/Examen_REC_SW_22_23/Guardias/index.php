<?php
session_name("recup");
session_start();
if(isset($_SESSION["usuario"])){
  echo "session iniciada";
    header("Location:principal.php");
     exit;
}else{
    require "vistas/vista_login.php";

}


?>