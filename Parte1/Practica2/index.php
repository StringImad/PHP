<?php
require("src/funciones.php");
require("src/bd_config.php");
$error_form = true;
$error_formulario_registro = true;
//si le dan a boton borrar del registro
if (isset($_POST["btnBorrar"])) {
    unset($_POST);
}

//boton entrar del login
if (isset($_POST['btnEntrar'])) {
    $error_nombre = $_POST["nombre"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_nombre || $error_clave;

    //si  no hay error en al hacer login buscar el usuario

    if (!$error_form) {
        //conexion
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            $mensaje = "Imposible conectar con la BD. Error Nº " . mysqli_connect_errno() . " : " . mysqli_connect_error();
            session_destroy();
            die(error_page("Primer Login", "Primer Login", $mensaje));
        }

        //consulata con la BD
        try {
            $consulta = "select * from usuarios where usuario='" . $_POST["usuario"] . "' and clave='" . md5($_POST["clave"]) . "'";
            $resultado = mysqli_query($conexion, $consulta);
            $usuario_registrado = mysqli_num_rows($resultado) > 0;

            mysqli_free_result($resultado);
            mysqli_close($conexion);
            if ($usuario_registrado) {
                $_SESSION["usuario"] = $_POST["usuario"];
                $_SESSION["clave"] = md5($_POST["clave"]);
                $_SESSION["ultimo_acceso"] = time();
                header("Location:index.php");
                exit;
            } else {
                $error_usuario = true;
            }
        } catch (Exception $e) {
            $mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . " : " . mysqli_error($conexion);
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Primer Login", "Primer Login", $mensaje));
        }
    }
}
//boton enviar el formulario del registro
if (isset($_POST['btnEnviar'])) {
    $error_usuario = $_POST['usuario'] == "";
    $error_nombre = $_POST['nombre'] == "";
    $error_clave = $_POST["clave"] == "";
    $error_dni = $_POST["dni"] == "" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    $error_sexo = !isset($_POST["sexo"]);
    $error_suscrip = !isset($_POST["suscrip"]);
    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1000);

    $error_formulario_registro = $error_usuario || $error_nombre || $error_clave || $error_dni || $error_sexo || $error_foto || $error_suscrip;

    //si no hay error en el registro meter nuevo usuario

    if (!$error_formulario_registro) {
        //conexion
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die("Imposible conectar. Error Nº " . mysqli_connect_errno() . " : " . mysqli_connect_error());
        }

        $consulta = "insert into usuarios(nombre,usuario,clave,dni,sexo,foto,suscrip,tipo) values ('" . $_POST["nombre"] . "','" . $_POST["usuario"] . "','" . md5($_POST["clave"]) . "','" . $_POST["dni"] . "','" . $_POST["sexo"] . "','" . $_FILES["foto"]["name"] . "','" . $_POST["suscrip"] . "','admin')";

        try {

            mysqli_query($conexion, $consulta);

            $_SESSION["usuario"] = $_POST["usuario"];
            $_SESSION["clave"] = $_POST["clave"];

            mysqli_close($conexion);
            header("Location:index.php");
            exit();
        } catch (Exception $e) {

            $mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
            mysqli_close($conexion);
            die(error_page("Prácitca 1º CRUD", "Nuevo Usuario", $mensaje));
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica Rec 2</title>
</head>

<body>
    <h1>Practica Rec 2</h1>

    <?php


    // //si le da al boton de registro se reenvia al formulario de registro
    // if (isset($_POST["btnRegistro"])) {
    //     require "vistas/vista_formulario_registro.php";
    // }
    // //Si ha enviado el formulario y hay error en el formulario de registro se vuelve a mostrar el formulario
    // if (isset($_POST["btnEnviar"]) && $error_formulario_registro) {
    //     require "vistas/vista_formulario_registro.php";
    
    // }
    
    // if ((isset($_POST["btnEntrar"]) && !$error_form) || (isset($_POST["btnEnviar"]) && !$error_formulario_registro)) {
    //     require "vistas/vista_info.php";
    // } else {
    //     require "vistas/vista_formulario_login.php";
    
    // }
    define("MINUTOS", 10);

    session_name("primer_login_22_33");
    session_start();
    //Estas 3 variables existen cuando me he logeado, si no, no cumples ninguna
    if (isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && (isset($_SESSION["ultimo_acceso"]))) {

        require "src/seguridad.php";

        $_SESSION["ultimo_acceso"] = time();

        if ($datos_usuario_log["tipo"] == "normal")
            require "vistas/vista_normal.php";
        else
            require "vistas/vista_admin.php";

        mysqli_close($conexion);
    } elseif (isset($_POST["btnRegistro"]) || isset($_POST["btnEnviar"])) {

        require "vistas/vista_formulario_registro.php";
    } else {

        require "vistas/vista_formulario_login.php";
    }

    ?>

</body>

</html>