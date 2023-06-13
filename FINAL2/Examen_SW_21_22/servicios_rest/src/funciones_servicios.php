<?php
require "config_bd.php";


function login($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            if ($sentencia->rowCount() > 0) {
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
                session_name("api_exam");
                session_start();

                $_SESSION["usuario"] = $respuesta["usuario"]["usuario"];
                $_SESSION["clave"] = $respuesta["usuario"]["clave"];
                $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];

                $respuesta["api_session"] = session_id();

            } else {
                $respuesta["mensaje"] = "Usuario no encontrado en la BD";

            }
            $sentencia = null;
            $conexion = null;
        } catch (PDOException $e) {
            $respuesta["error"] = "error al  conectar:" . $e->getMessage();

        }

    } catch (PDOException $e) {

        $respuesta["error"] = "error al  conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function logueado($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            if ($sentencia->rowCount() > 0) {
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);


            } else {
                $respuesta["depuracion"] = array($datos);
                $respuesta["mensaje"] = "Usuario no encontrado en la BD";

            }
            $sentencia = null;
            $conexion = null;
        } catch (PDOException $e) {
            $respuesta["error"] = "error al  conectar:" . $e->getMessage();

        }

    } catch (PDOException $e) {

        $respuesta["error"] = "error al  conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function obtenerHorarioUsuario($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "SELECT hl.dia, hl.hora, hl.grupo FROM horario_lectivo as hl, usuarios as u WHERE hl.usuario = u.id_usuario AND u.id_usuario=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            $respuesta["horario"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);


            $sentencia = null;
            $conexion = null;
        } catch (PDOException $e) {
            $respuesta["error"] = "error al  conectar:" . $e->getMessage();

        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "error al  conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function obtenerUsuariosNoAdmin()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "SELECT * FROM usuarios WHERE tipo <> 'Admin'";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute();
            $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);


            $sentencia = null;
            $conexion = null;
        } catch (PDOException $e) {
            $respuesta["error"] = "error al  conectar:" . $e->getMessage();

        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "error al  conectar:" . $e->getMessage();
    }
    return $respuesta;
}
?>