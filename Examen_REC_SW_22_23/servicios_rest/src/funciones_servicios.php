<?php
require "config_bd.php";

function conexion_pdo()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $respuesta["mensaje"] = "Conexi&oacute;n a la BD realizada con &eacute;xito";

        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}



function login_usuario($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            if($sentencia->rowCount()>0){
                $respuesta["usuario"]  = $sentencia->fetch(PDO::FETCH_ASSOC); 
                session_name("api_exam_recup");
                session_start();
                $_SESSION["usuario"]=$respuesta["usuario"]["usuario"];
                $_SESSION["clave"]=$respuesta["usuario"]["clave"];
                $respuesta["api_session"]=session_id();



            }else
                $respuesta["mensaje"] = "Usuario no se encuentra regis. en la BD";
            
            $sentencia=null;
            $conexion=null;
        } catch (PDOException $e) {
            $respuesta["error"] = "Error de consulta";
        }
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}
