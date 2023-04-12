<?php
try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "select * from usuarios where usuario = ? and clave = ?";
            $sentencia = $conexion->prepare($consulta);
            $datos[] = $_SESSION["usuario"];
            $datos[] =  $_SESSION["clave"];
            $sentencia->execute($datos);
            //!!!!!!!!!!SI ES MENOR O IGUAL A 0!!!!!!!!!!!!!!!
            if ($sentencia->rowCount() <= 0) {
                //si me han baneado creo un mensaje de error y salto al index


                $sentencia = null;
                $conexion = null;
                session_unset();
                $_SESSION["baneo"] = "Usted ya no se encuentra registrado en la BD";
                header("Location:indexProfesor.php");
                exit();
            } else {
                $error_usuario = true;
                $sentencia = null;
                $conexion = null;
            }
        } catch (PDOException $e) {
            session_destroy();
            $sentencia = null;
            $conexion = null;
            die("<p>Failed to connect" . $e->getMessage() . "</p></body></html>");
        }
    } catch (PDOException $e) {
        //No cerramos la conexion por si nos hace falta despues
        session_destroy();
        die("<p>Failed to connect" . $e->getMessage() . "</p></body></html>");
    }
    $tiempo_transc = time() - $_SESSION["ultimo_acceso"];

    if ($tiempo_transc > MINUTOS * 60) {
        session_unset();
        $_SESSION["tiempo"] = "Su tiempo de sesión ha expirado";
        header("Location:index.php");
        exit;
    }
    $_SESSION["ultimo_acceso"] = time();
    ?>