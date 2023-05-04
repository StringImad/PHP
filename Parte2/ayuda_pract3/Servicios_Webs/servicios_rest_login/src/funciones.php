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
            if ($sentencia->rowCount() > 0) {
                $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            } else {
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

function repetido($columna, $valor)
{



    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));


        try {
            $consulta = "select * from usuarios where " . $columna . "=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$valor]);

            $respuesta["repetido"] = $sentencia->rowCount() > 0;
            $sentencia = null;
        } catch (PDOException $e) {
            $sentencia = null;
            $respuesta["error"] = "Imposible realizar la consulta. Error:" . $e->getMessage();
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Error conectando a BD: " . $e->getMessage();
    }


    return $respuesta;
}


function insertar_usuario($datos)
{



    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));


        try {
            $consulta = "insert into usuarios(usuario, clave, nombre, dni,sexo, subscripcion) values(?,?,?,?,?,?)";
            $sentencia = $conexion->prepare($consulta);
           
            $sentencia->execute($datos);
            $respuesta["ultimo_id"]=$conexion->lastInsertId();
            $sentencia = null;
        } catch (PDOException $e) {
            $sentencia = null;
            $conexion = null;
            session_destroy();
            die(error_page("Práctica Rec 3", "Práctica Rec 3", "Imposible realizar la consulta. Error:" . $e->getMessage()));
        }

    
    } catch (PDOException $e) {
        $respuesta["error"] = "Error conectando a BD: " . $e->getMessage();
    }


    return $respuesta;
}

function cambiar_foto($id, $foto){

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        if ($_FILES["foto"]["name"] != "") {
            $ultm_id = $conexion->lastInsertId();
            $array_ext = explode(".", $_FILES["foto"]["name"]);
            $ext = "";
            if (count($array_ext) > 0)
                $ext = "." . end($array_ext);

            $nombre_nuevo_img = "img_" . $ultm_id . $ext;
            @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Img/" . $nombre_nuevo_img);
            if ($var) {
                try {
                    $consulta = "update usuarios set foto=? where id_usuario=?";
                    $sentencia = $conexion->prepare($consulta);
                    $sentencia->execute([$nombre_nuevo_img, $ultm_id]);
                } catch (PDOException $e) {
                    unlink("Img/" . $nombre_nuevo_img);
                    $mensaje = "El usuario ha sido registrado con éxito con la imagen por defecto, por un problema con la BD";
                }
                $sentencia = null;
            } else
                $mensaje = "El usuario ha sido registrado con la imagen por defecto por no poder mover imagen a carpeta destino en el servidor";
        }

        try {
            $consulta = "update usuarios set foto=? where id_usuario=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$foto, $id]);
        } catch (PDOException $e) {
            unlink("Img/" . $foto);
            $mensaje = "El usuario ha sido registrado con éxito con la imagen por defecto, por un problema con la BD";
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Error conectando a BD: " . $e->getMessage();
    }


    return $respuesta;
}
