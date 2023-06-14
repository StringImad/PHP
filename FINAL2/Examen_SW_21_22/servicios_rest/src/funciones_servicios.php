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
            $consulta = "SELECT  hl.dia, hl.hora, g.nombre FROM horario_lectivo as hl, usuarios as u, grupos as g WHERE hl.usuario = u.id_usuario AND hl.grupo = g.id_grupo AND u.id_usuario=?";
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


function obtenerTieneGrupo($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "SELECT * from horario_lectivo where usuario = ? and dia= ? and hora = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            if ($sentencia->rowCount() > 0) {
                $respuesta["tieneGrupo"] = true;

            } else {
                $respuesta["tieneGrupo"] = false;

            }


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

function obtenerGrupoDiaHoraUsuario($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "SELECT grupos.id_grupo ,grupos.nombre from grupos,horario_lectivo where horario_lectivo.grupo = grupos.id_grupo and  horario_lectivo.usuario = ? and horario_lectivo.dia= ? and horario_lectivo.hora = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            $respuesta["grupos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);



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

function obtenerNoGrupoDiaHoraUsuario($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "SELECT grupos.id_grupo ,grupos.nombre from grupos,horario_lectivo where horario_lectivo.grupo = grupos.id_grupo and  horario_lectivo.usuario <> ? and horario_lectivo.dia= ? and horario_lectivo.hora = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            $respuesta["grupos_libres"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);



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

// function borrarUsuarioDeGuardia($datos)
// {
//     try {
//         $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
//         try {
//             $consulta = "DELETE  horario_lectivo.usuario from grupos,horario_lectivo where horario_lectivo.grupo = grupos.id_grupo and  horario_lectivo.grupo = ? and horario_lectivo.dia= ? and horario_lectivo.hora = ?";
//             $sentencia = $conexion->prepare($consulta);
//             $sentencia->execute($datos);
//             $respuesta["mensaje"] = "grupo borrado con exito";



//             $sentencia = null;
//             $conexion = null;
//         } catch (PDOException $e) {
//             $respuesta["error"] = "error al  conectar:" . $e->getMessage();

//         }
//         $sentencia = null;
//         $conexion = null;
//     } catch (PDOException $e) {

//         $respuesta["error"] = "error al  conectar:" . $e->getMessage();
//     }
//     return $respuesta;
// }

function insertarUsuario($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
        $consulta = "INSERT INTO horario_lectivo (dia, hora, usuario, grupo) VALUES (?,?,?,?)";
        
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);

        $respuesta["mensaje"] = "Grupo insertado con exito";
        } catch (PDOException $e) {

            $respuesta["error"] = "error al  conectar:" . $e->getMessage();
        }
    } catch (PDOException $e) {

        $respuesta["error"] = "error al  conectar:" . $e->getMessage();
    }
    return $respuesta;
}
?>