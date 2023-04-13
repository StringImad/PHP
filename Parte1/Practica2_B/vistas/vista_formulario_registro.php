<?php //boton enviar el formulario del registro
require("src/funciones.php");
require("src/bd_config.php");
if (isset($_POST['btnEnviar'])) {
    $error_usuario = $_POST['usuario'] == "";
    $error_nombre = $_POST['nombre'] == "";
    $error_clave = $_POST["clave"] == "";
    $error_dni = $_POST["dni"] == "" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    $error_sexo = !isset($_POST["sexo"]);
    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1000);

    $sus = 0;
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        session_destroy();

        die("<p>Failed to connect" . $e->getMessage() . "</p></body></html>");
    }
    if (isset($_POST["suscrip"])) {
        $sus = 1;
    }
    //COmprobar si el usuario es repetido
    if (!$error_usuario) { //Si no hay error usuario
        $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"]);
        //Si error usuario es un string quitamos la conexion y matamos el usuario
        if (is_string($error_usuario)) {
            $conexion = null;
            die(error_page("Practica rec 2", "Practica rec 2", $error_usuario));
        }
    }
    //Comprobar si el DNI es repetido
    if (!$error_usuario) { //Si no hay error usuario
        $error_usuario = repetido($conexion, "usuarios", "dni", $_POST["dni"]);
        //Si error usuario es un string quitamos la conexion y matamos el usuario
        if (is_string($error_usuario)) {
            $conexion = null;
            die(error_page("Practica rec 2", "Practica rec 2", $error_usuario));
        }
    }
    //si no hay error en el registro meter nuevo usuario
    $error_formulario_registro = $error_usuario || $error_nombre || $error_clave || $error_dni || $error_sexo || $error_foto;

    if (!$error_formulario_registro) {
        //conexion


        try {
            $consulta = "INSERT INTO usuarios(usuario, clave, nombre, dni, sexo, subscripcion) VALUES (?, ?, ?, ?, ?,  ?)";

            $sentencia = $conexion->prepare($consulta);
            $datos[] = $_POST["usuario"];
            $datos[] = md5($_POST["clave"]);
            $datos[] = $_POST["nombre"];
            $datos[] = $_POST["dni"];
            $datos[] = $_POST["sexo"];
            $datos[] = $sus;

            $sentencia->execute($datos);
           
        } catch (PDOException $e) {

            session_destroy();
            $sentencia = null;
            $conexion = null;
            die("<p>Failed to connect" . $e->getMessage() . "</p></body></html>");
        }
    }
$mensaje ="usuario insertado con exito";
if($_FILES["foto"]["name"]!=""){
    //parte de la foto
    $ultimo_id = $conexion->lastInsertId();

    //Separa cada vez que hay un .
    $arr_nombre = explode(".", $_FILES["foto"]["name"]);
    $extension = "";
//Si es mayor que 0 significa que hay un delimitador '.' y la extension
//va a ser un punto concatenado con la ultima posicion del array
    if (count($arr_nombre) > 0)
        $extension = "." . end($arr_nombre);

    $nombre_nuevo = "img_" . $ultimo_id . $extension;

    @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Images/" . $nombre_nuevo);

    if ($var) { //Si se mueve el archivo



        try {
            $consulta = "UPDATE usuarios SET foto=? WHERE id_usuario =?";

            $sentencia = $conexion->prepare($consulta);
            $datos[] = $nombre_nuevo;
            $datos[] = $ultimo_id;
       
            $sentencia->execute($datos);
           
        } catch (PDOException $e) {
            if (is_file("img/" . $nombre_nuevo))
            unlink("img/" . $nombre_nuevo);
            session_destroy();
            $sentencia = null;
            $conexion = null;
            die("<p>Failed to connect" . $e->getMessage() . "</p></body></html>");
        }

    } else {
        $mensaje_registro = "Usuario registrado correctamente con la imagen por defecto, debido a un error en la subida";
    }
}
$_SESSION["usuario"] = $datos[0];
$_SESSION["clave"] = $datos[1];
$_SESSION["bienvenida"] = "Se ha registrado con exito";
$conexion = null;
header("Location:index.php");
exit();
    if (isset($conexion)) {
        $conexion = null;
    }
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post" action="index.php" enctype="multipart/form-data">
        <p>
            <label for="usuario">usuario: </label>
            <input type="text" name="usuario" value="<?php if (isset($_POST["usuario"]))
                                                            echo $_POST["usuario"]; ?>" id="usuario">
            <?php

            if (isset($_POST['btnEnviar']) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>* Debes rellenar el usuario *</span>";
                } else {
                    echo "<span class='error'>* Usuario repetido*</span>";
                }
            }

            ?>
        </p>
        <p>
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre" value="<?php if (isset($_POST["nombre"]))
                                                        echo $_POST["nombre"]; ?>" id="nombre">
            <?php

            if (isset($_POST["btnEnviar"]) && $error_nombre) {
                echo "<span class='error'>* Debes rellenar el nombre *</span>";
            }

            ?>
        </p>

        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave">
            <?php
            if (isset($_POST["btnEnviar"]) && $error_clave) {
                echo "<span class='error'>* Debes rellenar la clave *</span>";
            }
            ?>
        </p>
        <p><label for="dni">Dni: </label>
            <input type="text" placeholder="11223344Z" name="dni" id="dni" value="<?php if (isset($_POST['dni']))
                                                                                        echo $_POST['dni']; ?>">
            <?php
            if (isset($_POST['btnEnviar']) && $error_dni) {

                if ($_POST["dni"] == "") {
                    echo "<span class='error'>* Campo vacio *</span>";
                } else if (!dni_bien_escrito($_POST["dni"])) {

                    echo "<span class='error'>* Debes rellenar el DNI con 8 dígitos seguidos de una letra *</span>";
                } else if (!dni_valido($_POST["dni"])) {
                    echo "<span class='error'>* DNI no válido *</span>";
                } else {
                    echo "<span class='error'>* DNI repetido *</span>";
                }
            }

            ?>
        </p>
        <p id="campo-sexo">
            Sexo:</br>


            <input type="radio" value="hombre" id="hombre" name="sexo" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "hombre")
                                                                            echo "checked"; ?>>
            <label for="hombre">Hombre: </label>
            <input type="radio" value="mujer" id="mujer" name="sexo" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer")
                                                                            echo "checked"; ?>>

            <label for="mujer">Mujer: </label>
            <?php
            if (isset($_POST["btnEnviar"]) && $error_sexo) {
                echo "<span class='error'>* Debes seleccionar un sexo *</span>";
            } ?>
        </p>
        <p>
            <label for="foto">Incluir mi foto (Max. 500KB)</label>
            <input type="file" name="foto" id="foto" accept="image/*" />
            <?php
            if (isset($_POST["btnEnviar"]) && $error_foto) {

                if (isset($_FILES["foto"]["error"])) {

                    echo "<span class='error'>* error al subir la imagen en el servidor*</span>";
                } else if (!getimagesize($_FILES["foto"]["tmp_name"])) {
                    echo "<span class='error'>* Debes de seleccionar una imagen*</span>";
                } else {
                    echo "<span class='error'>*La imagen no es del tamaño indicado *</span>";
                }
            }
            ?>
        </p>
        <p>
            <input type="checkbox" name="suscrip" id="suscrip" <?php if (isset($_POST["suscrip"]))
                                                                    echo "checked"; ?>>

            <label for="suscrip">Suscribirme al boletín de novedades</label>

        </p>
        <p>
            <button type="submit" name="btnEnviar">Guardar Cambios</button>
            <button type="submit" name="btnBorrar">Borrar datos</button>
        </p>
    </form>
</body>

</html>