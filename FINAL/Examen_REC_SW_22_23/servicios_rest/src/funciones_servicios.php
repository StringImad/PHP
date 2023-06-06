<?php
require "config_bd.php";

function login($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));




        try {

            $consulta = "select * from usuarios where usuario = ? and clave = ?";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            if ($sentencia->rowCount() > 0) {
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
                session_name("api_exam_recup");
                session_start();
                $_SESSION["usuario"]=$respuesta["usuario"]["usuario"];
                $_SESSION["clave"]=$respuesta["usuario"]["clave"];
                $respuesta["api_session"]= session_id();
            } else {
                $respuesta["mensaje"] = "Usuario no se encuentra regis. en
                la BD";
            }

            $conexion = null;
            $sentencia = null;

        } catch (PDOException $e) {
            $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();

        }


    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function logueado($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $consulta = "select * from usuarios where usuario = ? and clave = ?";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            if ($sentencia->rowCount() > 0) {
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            } else {
                $respuesta["mensaje"] = "Usuario no se encuentra regis. en
                la BD";
            }

            $conexion = null;
            $sentencia = null;

        } catch (PDOException $e) {
            $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();

        }


    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}
function obtener_usuario($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $consulta = "select * from usuarios where id_usuario = ?";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            if ($sentencia->rowCount() > 0) {
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            } else {
                $respuesta["mensaje"] = "Usuario con ID: ".$datos[0]." no se encuentra regis. en
                la BD";
            }

            $conexion = null;
            $sentencia = null;

        } catch (PDOException $e) {
            $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();

        }


    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}
function obtener_guardia($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $consulta = "select * from usuarios, horario_guardias where usuarios.id_usuario = horario_guardias.usuario and dia = ? and hora=?";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            if ($sentencia->rowCount() > 0) {
                $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $respuesta["mensaje"] = "Usuario no se encuentra regis. en
                la BD";
            }

            $conexion = null;
            $sentencia = null;

        } catch (PDOException $e) {
            $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();

        }


    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function obtener_deGuardia($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $consulta = "select * from usuarios, horario_guardias where usuarios.id_usuario = horario_guardias.usuario and dia = ? and hora=? and id_usuario =?";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            if ($sentencia->rowCount() > 0) {
                $respuesta["deGuardia"] = true;
            } else {
                $respuesta["deGuardia"] = false;
            }

            $conexion = null;
            $sentencia = null;

        } catch (PDOException $e) {
            $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();

        }


    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}
?>