<?php
require "bd_config.php";

function login($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "select * from usuarios where usuario=? and clave=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if ($sentencia->rowCount() > 0)
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            else
                $respuesta["mensaje"] = "Usuario no registrado en BD";

            $sentencia = null;
            $conexion = null;
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible realizar la consulta. Error:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
    }

    return $respuesta;
}
//funcion para imprimir todos los ususarios de la base de datos
function usuarios()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT * FROM usuarios";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute();
            $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $respuesta["error"] = "Error de consulta: " . $e->getMessage();
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Error conectando a BD: " . $e->getMessage();
    }
    return $respuesta;
}
function obtenerUsuario($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "Select * FROM usuarios where id_usuario = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            if($sentencia->rowCount()>0){
                $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            }else{
                $respuesta["usuarios"] = "Usuario no registradi en la bd";

            }
        } catch (PDOException $e) {
            $respuesta["error"] = "Error de consulta: " . $e->getMessage();
        }

        
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Error conectando a BD: " . $e->getMessage();
    }


    
    return $respuesta;
}
function borrarUsuario($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "Delete FROM usuarios where id_usuario = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            $respuesta["usuarios"] = "usuario borrado con exito";
        } catch (PDOException $e) {
            $respuesta["error"] = "Error de consulta: " . $e->getMessage();
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Error conectando a BD: " . $e->getMessage();
    }
    return $respuesta;
}
