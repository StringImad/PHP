<?php
function LetraNIF($dni)
{
    return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1);
}

function dni_bien_escrito($texto)
{
    $dni = strtoupper($texto);
    return strlen($dni) == 9 && is_numeric(substr($dni, 0, 8)) && substr($dni, 8, 1) >= "A" && substr($dni, 8, 1) <= "Z";
}
function dni_valido($dni)
{
    return LetraNIF(substr($dni, 0, 8)) == strtoupper(substr($dni, -1));
}

if (isset($_POST["btnBorrar"])) {
    unset($_POST);
    //header("Location:index.php");
    //exit;
}

if (isset($_POST["btnEnviar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_nombre = $_POST["nombre"] == "";
    $error_dni = $_POST["dni"] == "" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    $error_clave = $_POST["clave"] == "";
    $error_sexo = !isset($_POST["sexo"]);
    $error_suscrip = !isset($_POST["suscrip"]);
    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"])) || $_FILES["foto"]["size"] > 500000;
    $error_form = $error_usuario || $error_nombre || $error_dni || $error_clave || $error_suscrip || $error_foto;
}




?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario CV</title>
    <style>
        /* body {
            background-color: black;
        }


        h1 {
            color: wheat;
        }

        #content {

            background-color: grey;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 50%;
            margin: auto;
        }

        p {
            color: white;
            display: flex;
            flex-direction: column;
            width: 20em;
            text-align: center;
            align-items: center;
        }

        #campo-sexo {
            display: flex;
            flex-direction: row;
            justify-content: center;
        }

        .error {
            color: red;
        } */
    </style>
</head>

<body>
    <div id="content">
        <?php
        if (isset($_POST["btnEnviar"]) && !$error_form) {
        ?>
            <h1>Datos Enviados</h1>
            <p>Usuario:
                <?php echo $_POST["usuario"]; ?>
            </p>
            <p>
                Nombre:
                <?php echo $_POST["nombre"]; ?>
            </p>
            <p>
                Contraseña:
                <?php echo $_POST["clave"]; ?>
            </p>
            <p>
                sexo:
                <?php echo $_POST["sexo"]; ?>
            </p>
            <p>
                suscripcion: SI
            </p>
            <p>DNI:
                <?php echo $_POST["dni"]; ?>
                </br> -------------------------------------------------------
            </p>
            <p>Foto:
                <?php if ($_FILES["foto"]["name"] != "") {

                    $uniq = md5(uniqid(uniqid(), true));
                    $arr_nombre = explode(".", $_FILES["foto"]["name"]);
                    $ext = "";
                    if (count($arr_nombre) > 1) {
                        $ext = "." . end($arr_nombre);
                    }
                    $nuevo_nombre = "img_" . $uniq . $ext;
                } //Con el arroba se avisa del control del warning
                @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "img/" . $nuevo_nombre);
                ?>
            </p>
            <p>
                <?php
                ?>
            <p>
                Nombre:
                <?php echo $_FILES["foto"]["name"] ?><br>
                Tipo:
                <?php echo $_FILES["foto"]["type"] ?><br>
                Tamaño:
                <?php echo $_FILES["foto"]["size"] ?>
                Error:
                <?php echo $_FILES["foto"]["error"] ?>
            </p>
        <?php
         if ($var) {
                    echo "La imagen se ha movido a la carpeta destino con éxito";
                    echo "<img src='img/" . $nuevo_nombre . "'>";
                } else {
                    echo "<p>La imagen no ha podido ser movida por falta de permisos</p>";
                    //sudo chmod 777 -R '/opt/lampp/htdocs/PHP

                }
        ?>
        </p>
    <?php

        } else { ?>
        <h1>Rellena tu CV</h1>

        <form method="post" action="Practica1.php" enctype="multipart/form-data">

            <p> <label for="usuario">
                    Usuario:
                </label>
                <input type="text" id="usuario" value="<?php if (isset($_POST['usuario']))
                                                            echo $_POST['usuario']; ?>" name="usuario">
                <?php


                if (isset($_POST['usuario']) && $error_usuario) {
                    echo "<span class='error'>*Debes rellenar el usuario*</span>";
                }

                ?>
            </p>
            <p><label for="nombre">Nombre: </label>
                <input type="text" id="nombre" value="<?php if (isset($_POST['nombre']))
                                                            echo $_POST['nombre']; ?>" name="nombre">
                <?php
                if (isset($_POST['nombre']) && $error_nombre) {
                    echo "<span class='error'>* Debes rellenar el nombre *</span>";
                }

                ?>
            </p>
            <p>
                <label for="clave">Contraseña: </label>
                <input type="password" id="clave" name="clave">
                <?php
                if (isset($_POST['clave']) && $error_clave) {
                    echo "<span class='error'>* Debes rellenar la contraseña *</span>";
                }

                ?>
            </p>
            <p><label for="dni">Dni: </label>
                <input type="text" placeholder="11223344Z" name="dni" id="dni" value="<?php if (isset($_POST['dni']))
                                                                                            echo $_POST['dni']; ?>">
                <?php
                if (isset($_POST['dni']) && $error_dni) {

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
                <?php
                if (isset($_POST['btnEnviar']) && $error_suscrip) {
                    echo "<span class='error'>*Debes marcar la suscripción*</span>";
                }
                ?>
            </p>
            <p>
                <button type="submit" name="btnEnviar">Guardar Cambios</button>
                <button type="submit" name="btnBorrar">Borrar datos</button>
            </p>


        </form>
    <?php
        }
    ?>
    </div>
</body>

</html>