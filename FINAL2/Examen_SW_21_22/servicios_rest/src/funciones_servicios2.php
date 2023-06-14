<?php
require "config_bd.php";




function login($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        try{
            $consulta="select * from usuarios where usuario=? and clave=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);
            if($sentencia->rowCount()>0)
            {
                $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
                
                session_name("Exam_API_SW_21_22");
                session_start();
                $_SESSION["usuario"]=$datos[0];
                $_SESSION["clave"]=$datos[1];
                $_SESSION["tipo"]=$respuesta["usuario"]["tipo"];
                $respuesta["api_session"]=session_id();
                
            }
            else
            {
                $respuesta["mensaje"]="El usuario no se encuentra registrado en la BD";
            }
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        }
        $sentencia=null;
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function logueado($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        try{
            $consulta="select * from usuarios where usuario=? and clave=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);
            if($sentencia->rowCount()>0)
            {
                $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
                
            }
            else
            {
                $respuesta["mensaje"]="El usuario no se encuentra registrado en la BD";
            }
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        }
        $sentencia=null;
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function obtener_horario($id_usuario)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        try{
            $consulta="select horario_lectivo.dia, horario_lectivo.hora, grupos.nombre from horario_lectivo, grupos where horario_lectivo.grupo=grupos.id_grupo and horario_lectivo.usuario=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$id_usuario]);
            $respuesta["horario"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        }
        $sentencia=null;
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}


function obtener_usuarios()
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        try{
            $consulta="select * from usuarios where tipo<>'admin'";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute();
            $respuesta["usuarios"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        }
        $sentencia=null;
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function obtener_grupos($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        try{
            $consulta="select grupos.id_grupo, grupos.nombre from horario_lectivo, grupos where horario_lectivo.grupo=grupos.id_grupo and horario_lectivo.dia=? and horario_lectivo.hora=? and horario_lectivo.usuario=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);
            $respuesta["grupos"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        }
        $sentencia=null;
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}


function obtener_tiene_grupos($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        try{
            $consulta="select grupo from horario_lectivo where dia=? and hora=? and usuario=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);
            $respuesta["tiene_grupos"]=($sentencia->rowCount()>0);
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        }
        $sentencia=null;
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function obtener_grupos_libres($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        try{
            $consulta="select * from grupos where id_grupo not in(select grupo from horario_lectivo where dia=? and hora=? and usuario=?)";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);
            $respuesta["grupos_libres"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        }
        $sentencia=null;
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function insertar_grupo($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        try{
            $consulta="insert into horario_lectivo (usuario, dia, hora, grupo, aula) values (?,?,?,?,'aula_inventada')";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);
            $respuesta["mensaje"]="Grupo insertado con éxito";
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        }
        $sentencia=null;
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function borrar_grupo($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        try{
            $consulta="delete from horario_lectivo where dia=? and hora=? and usuario=? and grupo=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);
            $respuesta["mensaje"]="Grupo borrado con éxito";
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        }
        $sentencia=null;
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}
?>
