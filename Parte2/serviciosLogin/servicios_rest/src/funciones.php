<?php
require "bd_config.php";

function login($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "select * from usuarios where id_usuario = ? and clave = ?";
            $sentencia=$conexion->prepare($consulta);
            echo "nombre: ".$datos[0]." clave: ".$datos[1];
            $sentencia->execute($datos);
            if ($sentencia->rowCount() > 0) {
                echo "sentencia: ".$sentencia;

                $respuesta["usuario"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            } else {
                $respuesta["mensaje_error"] = "Usuario y/o constraseña no válido/s";
            }

        } catch (PDOException $e) {

            $respuesta["mensaje_error"] = "Imposible realizar la consulta. Error:" . $e->getMessage();
        }

        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error:" . $e->getMessage();
    }


    return $respuesta;
}

function repetido_reg($conexion,$columna, $valor)
{
    try
    {
        $consulta="select * from usuarios where ".$columna."=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$valor]);
        $respuesta=$sentencia->rowCount()>0;
        $sentencia=null;
      
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $respuesta="Imposible realizar la consulta. Error:".$e->getMessage();
    }
  
 
    return $respuesta;
}

function error_page($title,$cabecera,$mensaje)
{
    return '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>'.$title.'</title>
    </head>
    <body>
        <h1>'.$cabecera.'</h1><p>'.$mensaje.'</p>
    </body>
    </html>';
}
?>