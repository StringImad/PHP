<?php
require "bd_config.php";


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


function login($datos)
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
                session_name("api_blog_exam_22_23");
                session_start();
                $_SESSION["usuario"]=$respuesta["usuario"]["usuario"];
                $_SESSION["clave"]=$respuesta["usuario"]["clave"];
                $_SESSION["tipo"]=$respuesta["usuario"]["tipo"];
                $respuesta["api_session"]=session_id();
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

function obtener_comentarios(){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "SELECT c.*, u.usuario, n.titulo
            FROM comentarios c
            JOIN usuarios u ON c.idUsuario = u.idusuario
            JOIN noticias n ON c.idNoticia = n.idNoticia order by idComentario;";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute();

            $respuesta["comentarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);


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
 function borrar_comentario($id)
 {
     try {
         $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
         try {
             $consulta = "delete from comentarios where idComentario=?";
             $sentencia = $conexion->prepare($consulta);
             $sentencia->execute([$id]);

             $respuesta["mensaje"] = "comentario borrado de la BD";

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

function insertar_usuario($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "insert into usuarios(usuario, clave, nombre) values(?,?,?)";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $respuesta["mensaje"] ="usuario insertado con exito";


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

function obtener_comentarios2(){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "SELECT *
            FROM comentarios";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute();

            $respuesta["comentarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);


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

function obtener_usuarios($columna, $valor)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
                //falla por las comillas si no lo ponemos así
                $consulta = "select * from usuarios where " . $columna . "=?";
              

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($valor);

            if($sentencia->rowCount()>0){
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            }else{
                $respuesta["mensaje"] = "No se encontró el usuario.";
            }


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

function obtener_comentario($id)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
                //falla por las comillas si no lo ponemos así
                $consulta = "select * from comentarios where idNoticia =?";
              

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($id);

            if($sentencia->rowCount()>0){
                $respuesta["comentario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            }else{
                $respuesta["mensaje"] = "No se encontró el usuario.";
            }


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
function obtener_usuario($id)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
                //falla por las comillas si no lo ponemos así
                $consulta = "select * from usuarios where idusuario =?";
              

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($id);

            if($sentencia->rowCount()>0){
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            }else{
                $respuesta["mensaje"] = "No se encontró el usuario.";
            }


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

function obtener_noticia($id)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
                //falla por las comillas si no lo ponemos así
                $consulta = "select * from noticias where idNoticia =?";
              

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$id]);

            if($sentencia->rowCount()>0){
                $respuesta["noticia"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            }else{
                $respuesta["mensaje"] = "No se encontró la noticia.";
            }


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

function obtener_categoria($id)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
                //falla por las comillas si no lo ponemos así
                $consulta = "select * from categorias where idCategoria =?";
              

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($id);

            if($sentencia->rowCount()>0){
                $respuesta["categoria"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            }else{
                $respuesta["mensaje"] = "No se encontró la categoria.";
            }


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

function actualizar_comentario($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
                //falla por las comillas si no lo ponemos así
                $consulta = "update comentarios set estado =? idComentario =?";
              

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if($sentencia->rowCount()>0){
                $respuesta["comentario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            }else{
                $respuesta["mensaje"] = "No se encontró la comentario.";
            }


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

function borrar_comentario2($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
                //falla por las comillas si no lo ponemos así
                $consulta = "delete from comentarios where idComentario =?";
              

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if($sentencia->rowCount()>0){
                $respuesta["comentario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            }else{
                $respuesta["mensaje"] = "No se encontró la comentario.";
            }


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