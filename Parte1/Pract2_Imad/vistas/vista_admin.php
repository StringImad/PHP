<?php

//codigo para la paginacion
if (!isset($_SESSION["registros"])) {
    $_SESSION["registros"] = 3;
}
if (isset($POST["pag"])) {
    $_SESSION["pag"] = 2;
}
if (!isset($POST["pag"])) {
    $_SESSION["pag"] = 1;
}



if (isset($_POST["btnBorrarNuevo"])) {
    unset($_POST);
    $_SESSION["btnBorrarNuevo"]=true;
    //header("Location:index.php");
    //exit;
}

if (isset($_POST["btnContNuevo"])) {
    //comprobar errores formulario
    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {
      
        $error_usuario = repetido_reg($conexion, "usuario", $_POST["usuario"]);
        if (is_string($error_usuario)) {
            session_destroy();
            $conexion = null;
            die(error_page("Práctica Rec 2", "Práctica Rec 2", $error_usuario));
        }
    }
    $error_nombre = $_POST["nombre"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_dni = $_POST["dni"] == "" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    if (!$error_dni) {
        if (!isset($conexion)) {
            try {
                $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            } catch (PDOException $e) {
                session_destroy();
                die(error_page("Práctica Rec 2", "Práctica Rec 2", "Imposible realizar la conexión. Error:" . $e->getMessage()));
            }
        }

        $error_dni = repetido_reg($conexion, "dni", strtoupper($_POST["dni"]));
        if (is_string($error_dni)) {
            session_destroy();
            $conexion = null;
            die(error_page("Práctica Rec 2", "Práctica Rec 2", $error_dni));
        }
    }
    $error_sexo = !isset($_POST["sexo"]);
    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1024);
    $error_form = $error_usuario || $error_nombre || $error_clave || $error_dni || $error_sexo || $error_foto;

    if (!$error_form) {
        try
        {
            $consulta="insert into usuarios(usuario, clave, nombre, dni,sexo, subscripcion) values(?,?,?,?,?,?)";
            $sentencia=$conexion->prepare($consulta);
            $subs=0;
            if(isset($_POST["subcripcion"]))
                $subs=1;
         
            $datos[]=$_POST["usuario"];
            $datos[]=md5($_POST["clave"]);
            $datos[]=$_POST["nombre"];
            $datos[]=strtoupper($_POST["dni"]);
            $datos[]=$_POST["sexo"];
            $datos[]=$subs;
            $sentencia->execute($datos);
            $sentencia=null;
        }
        catch(PDOException $e)
        {
            $sentencia=null;
            $conexion=null;
            session_destroy();
            die(error_page("Práctica Rec 2","Práctica Rec 2","Imposible realizar la consulta. Error:".$e->getMessage()));
        }

        $mensaje="El usuario ha sido registrado con éxito";
        if($_FILES["foto"]["name"]!="")
        {
            $ultm_id=$conexion->lastInsertId();
            $array_ext=explode(".", $_FILES["foto"]["name"]);
            $ext="";
            if(count($array_ext)>0)
                $ext=".".end($array_ext);

            $nombre_nuevo_img="img_".$ultm_id.$ext;
            @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"Img/".$nombre_nuevo_img);
            if($var)
            {
                try
                {
                    $consulta="update usuarios set foto=? where id_usuario=?";
                    $sentencia=$conexion->prepare($consulta);
                    $sentencia->execute([$nombre_nuevo_img,$ultm_id]);
                }
                catch(PDOException $e)
                {
                    unlink("Img/".$nombre_nuevo_img);
                    $mensaje="El usuario ha registrado con éxito con la imagen por defecto, por un problema con la BD";
                }
                $sentencia=null;
            }
            else
                $mensaje="El usuario ha sido registrado con la imagen por defecto por no poder mover imagen a carpeta destino en el servidor";
        }

       
        $_SESSION["mensaje_accion"]=$mensaje;
        $conexion=null;
        header("Location: index.php");
        exit;
    }
}

if (isset($_POST["boton_confirmar_borrar"])) {

    try {

        $consulta = "DELETE FROM usuarios WHERE id_usuario = ?";
        $id_usuario = $_POST["boton_confirmar_borrar"];

        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
        if ($_POST["foto"] != "no_imagen.jpg") {
            unlink("Img/" . $_POST["foto"]);
        }
        $_SESSION["mensaje_accion"] = "Usuario borrado con éxito";
        $sentencia = null;
        header("Location:index.php");
        exit;
    } catch (PDOException $e) {
        session_destroy();
        $sentencia = null;
        $conexion = null;
        die(error_page("Práctica Rec 2", "Práctica Rec 2", "Imposible borrar el usuario. Error:" . $e->getMessage()));
    }
}
if (isset($_POST["btnContBorrarFoto"])) {

    try {

        $consulta = "UPDATE usuarios set foto ='no_imagen.jpg' WHERE id_usuario = ?";
        $id_usuario = $_POST["btnContBorrarFoto"];

        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
     
            unlink("Img/" . $_POST["foto_bd"]);
        
        $_SESSION["borrar_foto"] = $id_usuario ;
        $sentencia = null;
        header("Location:index.php");
        exit;
    } catch (PDOException $e) {
        session_destroy();
        $sentencia = null;
        $conexion = null;
        die(error_page("Práctica Rec 2", "Práctica Rec 2", "Imposible borrar el usuario. Error:" . $e->getMessage()));
    }
}

if (isset($_POST["boton_listar"])) {
    try {
        $consulta = "select * from usuarios where id_usuario = ?";
        $id_usuario = $_POST["boton_borrar"];
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);

        // $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        echo "<div class='centrar'>";
        if ($sentencia->rowCount() > 0) { //Si el usuario sigue existiendo

            $tupla = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            echo "<h3>Datos del usuario " . $_POST["boton_listar"] . "</h3>";
            echo "<p><strong>Nombre: </strong>" . $tupla["nombre"] . "</p>";
            echo "<p><strong>Usuario: </strong>" . $tupla["usuario"] . "</p>";
            echo "<form action='index.php' method='post'><button type='submit'>Atrás</button></form>";
        } else { //Si el usuario se borra durante

            echo "<p class ='error'>Error de consistencia. El usuario seleccionado ya no existe</p>";
            echo "<form action='index.php' method='post'><button type='submit'>Atrás</button></form>";
        }

        echo "</div>";
    } catch (PDOException $e) {
        session_destroy();
        $sentencia = null;
        $conexion = null;
        die(("<p>Imposible realizar la consulta. Error:" . $e->getMessage()) . "</p></body></html>");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Rec 2</title>
    <style>
        table {
            border-collapse: collapse;
            text-align: center;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        img {
            height: 100px;
            width: auto;
        }

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        .enlinea {
            display: inline
        }

        .centrar {
            width: 80%;
            margin: 1rem auto;
        }

        .centrar-texto {
            text-align: center;
        }

        .flexible {
            display: flex;
            justify-content: space-between;
        }

        #bot_pag {
            display: flex;
            justify-content: center;
            margin-top: 1em;
        }
    </style>
</head>

<body>
    <h1>Práctica Rec 2</h1>
    <div>Bienvenido <strong>
            <?php echo $datos_usuario_log["usuario"]; ?>
        </strong> - <form method="post" action="index.php" class="en_linea"><button class="enlace" name="btnSalir">Salir</button></form>
    </div>
    <?php


    if (isset($_POST["btnUsuarioNuevo"]) || isset($_POST["btnContNuevo"])|| isset($_SESSION["btnBorrarNuevo"])) {
        if (isset($_SESSION["btnBorrarNuevo"])) {
            unset($_POST);
            $_SESSION["btnBorrarNuevo"]=false;
            //header("Location:index.php");
            //exit;
        }
        require "Admin/vista_usuario_nuevo.php";
    }
    if (isset($_POST["btnBorrar"])) {

        require "Admin/vista_borrar.php";
    }
    if (isset($_POST["btnListarUsuario"])) {

        require "Admin/vista_listar_usuario.php";
    }
    if (isset($_POST["btnEditar"])) {

        require "Admin/vista_editar.php";
    }

    require "Admin/vista_listar.php";

    if (isset($_SESSION["mensaje_accion"])) {
        $mensaje_accion = $_SESSION["mensaje_accion"];
    }
    ?>
</body>

</html>