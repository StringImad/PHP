<?php
require "config_bd.php";

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
            $respuesta["error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}

function obtener_usuario($id_usuario)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            $consulta="select * from usuarios where id_usuario=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$id_usuario]);

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
            $respuesta["error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["error"]="Imposible conectar a la BD. Error:".$e->getMessage();
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
                session_name("api_exam_rec_sw_22_23");
                session_start();
                $_SESSION["usuario"]=$respuesta["usuario"]["usuario"];
                $_SESSION["clave"]=$respuesta["usuario"]["clave"];
                $respuesta["api_session"]=session_id();
            }  
            else
                $respuesta["mensaje"]="Usuario no registrado en BD";

            $sentencia=null;
            $conexion=null;
        }
        catch(PDOException $e)
        {
            $respuesta["error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}


function usuarios_guardia($datos)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            $consulta="select usuarios.* from usuarios, horario_guardias where usuarios.id_usuario=horario_guardias.usuario and horario_guardias.dia=? and horario_guardias.hora=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);

           
            $respuesta["usuarios"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
                
          
            $sentencia=null;
            $conexion=null;
        }
        catch(PDOException $e)
        {
            $respuesta["error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}

function de_guardia($datos)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            $consulta="select usuario from horario_guardias where usuario=? and dia=? and hora=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);

           
            $respuesta["de_guardia"]=$sentencia->rowCount()>0;
                
          
            $sentencia=null;
            $conexion=null;
        }
        catch(PDOException $e)
        {
            $respuesta["error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}
?>
