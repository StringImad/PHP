<?php //boton enviar el formulario del registro
if (isset($_POST['btnEnviar'])) {
    $error_usuario = $_POST['usuario'] == "";
    $error_nombre = $_POST['nombre'] == "";
    $error_clave = $_POST["clave"] == "";
    $error_dni = $_POST["dni"] == "" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    $error_sexo = !isset($_POST["sexo"]);
    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1000);

    $error_formulario_registro = $error_usuario || $error_nombre || $error_clave || $error_dni || $error_sexo || $error_foto;
    $sus = 0;

    if (isset($_POST["suscrip"])) {
        $sus = 1;
    }
    //COmprobar si el usuario es repetido
    if (!$error_usuario) { //Si no hay error usuario
        $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"]);

        if (is_string($error_usuario)) { //Si ha saltado el catch en repetido()
            $conexion = null;
            die(error_page("Blog Personal", "Blog Personal", $error_usuario));
        }
    }
    //Comprobar si el DNI es repetido

    //si no hay error en el registro meter nuevo usuario

    if (!$error_formulario_registro) {
        //conexion
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die("Imposible conectar. Error Nº " . mysqli_connect_errno() . " : " . mysqli_connect_error());
        }

        try {
            $consulta = "INSERT INTO usuarios(usuario, clave, nombre, dni, sexo, foto, subscripcion, tipo) VALUES (?, ?, ?, ?, ?, ?, ?, 'normal')";

            $sentencia = $conexion->prepare($consulta);
            $datos[]= $_POST["usuario"];
            $datos[]=md5($_POST["clave"]);
            $datos[]= $_POST["nombre"];
            $datos[]= $_POST["dni"];
            $datos[]= $_POST["sexo"];
            $datos[]= $_FILES["foto"]["name"];
            $datos[]= $sus;

            $sentencia->execute($datos);
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
    if (!$error_formulario_registro) {
        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

            try {
                $consulta = "select * from usuarios where usuario = ? and clave = ?";
                $sentencia = $conexion->prepare($consulta);
                $datos[] = $_POST["usuario"];
                $datos[] = md5($_POST["clave"]);
                $sentencia->execute($datos);
                if ($sentencia->rowCount() > 0) {

                    $_SESSION["usuario"] = $datos[0];
                    $_SESSION["clave"] = $datos[1];
                    $_SESSION["ultimo_acceso"] = time();
                    $sentencia = null;
                    $conexion = null;
                    //Y lo mandamos a la pagina principal
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
            session_destroy();

            die("<p>Failed to connect" . $e->getMessage() . "</p></body></html>");
        }
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
                echo "<span class='error'>* Debes rellenar el usuario *</span>";
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
                } else {
                    echo "<span class='error'>* DNI no válido *</span>";
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