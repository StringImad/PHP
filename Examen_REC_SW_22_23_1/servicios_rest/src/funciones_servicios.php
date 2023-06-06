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

function logueado2($datos) {
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "SELECT * FROM usuarios WHERE usuario=? and clave = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            if($sentencia->rowCount()>0){
                $respuesta["usuario"]  = $sentencia->fetch(PDO::FETCH_ASSOC); 
            }else
                $respuesta["mensaje"] = "Usuario no se encuentra regis. en la BD";
            
            $sentencia=null;
            $conexion=null;
        } catch (PDOException $e) {
            $respuesta["error"] = "Error de consulta en logueado";
        }
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
};

function logueado($datos)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            $consulta="select * from usuarios where usuario=? and clave=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);

            if($sentencia->rowCount()>0)
            {
                $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
                
            }
            else
                $respuesta["mensaje"]="Usuario no registrado en BD";

            $sentencia=null;
            $conexion=null;
        }
        catch(PDOException $e)
        {
            $respuesta["mensaje_error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["mensaje_error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}
function obtenerUsuario($datos) {
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "SELECT * FROM usuarios WHERE id_usuario=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            if($sentencia->rowCount()>0){
                $respuesta["usuario"]  = $sentencia->fetch(PDO::FETCH_ASSOC); 
            }else
                $respuesta["mensaje"] = "Usuario no se encuentra regis. en la BD";
            
            $sentencia=null;
            $conexion=null;
        } catch (PDOException $e) {
            $respuesta["error"] = "Error de consulta en obtener Usuario";
        }
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
};

function obtener_usuariosGuardia($datos){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "SELECT usuarios.*   FROM usuarios, horario_guardias  WHERE usuarios.id_usuario = horario_guardias.usuario and dia = ? and hora = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            if($sentencia->rowCount()>0){
                $respuesta["usuario"]  = $sentencia->fetchAll(PDO::FETCH_ASSOC); 
            }else
                $respuesta["mensaje"] = "Usuarios no se encuentran regis. en la BD";
            
            $sentencia=null;
            $conexion=null;
        } catch (PDOException $e) {
            $respuesta["error"] = "Error de consulta en obtener usuario de guardia";
        }
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function obtener_deGuardia($datos){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "SELECT usuarios.*   FROM usuarios, horario_guardias  WHERE usuarios.id_usuario = horario_guardias.usuario and dia = ? and hora = ? and id_usuario=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            if($sentencia->rowCount()>0){
                $respuesta["deGuardia"]  = true; 
            }else
                $respuesta["deGuardia"] = false;
            
            $sentencia=null;
            $conexion=null;
        } catch (PDOException $e) {
            $respuesta["error"] = "Error de consulta en obtener de guardia";
        }
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}
