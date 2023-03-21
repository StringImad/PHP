<?php
function comprueba_dni($texto)
{
    $dni = strtoupper($texto);
    return strlen($dni) == 9 && is_numeric(substr($dni, 0, 8)) && substr($dni, 8, 1) >= "A" && substr($dni, 8, 1) <= "Z";
}

if (isset($_POST["btnBorrar"])) {
    unset($_POST);
    //header("Location:index.php");
    //exit;
}

if (isset($_POST["btnEnviar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_nombre = $_POST["nombre"] == "";
    $error_dni = $_POST["dni"] == "" || !comprueba_dni($_POST["dni"]);
    $error_clave = $_POST["clave"] == "";
    $error_sexo = !isset($_POST["sexo"]);
    $error_suscrip = !isset($_POST["suscrip"]);
    $error_foto = $_FILES["foto"]["name"] != "" &&( $_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"])) || $_FILES["foto"]["size"] > 500000;
    $error_form = $error_usuario || $error_nombre || $error_dni || $error_clave || $error_suscrip || $error_foto;
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario CV</title>
    <style>

    </style>
</head>

<body>
    <?php
    if (isset($_POST["btnEnviar"]) && !$error_form) {
        ?>
        <h1>Datos Enviados</h1>
        <p>Usuario:
            <?php echo $_POST["usuario"]; ?>
        </p>
        <p>DNI:
            <?php echo $_POST["dni"]; ?>
            -------------------------------------------------------
        </p>
        <p>Foto:
            <?php if($_FILES["foto"]["name"]!=""){
                $uniq = md5(uniqid(uniqid(),true));
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
                Nombre:
                <?php echo $_FILES["foto"]["name"] ?><br>
                Tipo:
                <?php echo $_FILES["foto"]["type"] ?><br>
                Tamaño:
                <?php echo $_FILES["foto"]["size"] ?>
            </p>
            <p>
                <?php if ($var) {
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
                <input type="text" name="dni" id="dni" value="<?php if (isset($_POST['dni']))
                    echo $_POST['dni']; ?>">
                <?php
                if (isset($_POST['dni']) && $error_dni) {

                    if($_POST["dni"]==""){
                        echo "<span class='error'>* Campo vacio *</span>";
                    } else if (!comprueba_dni($_POST["dni"])){
                        
                        echo "<span class='error'>* Debes rellenar el DNI con 8 dígitos seguidos de una letra *</span>";
                    }else {
                        echo "<span class='error'>* DNI no válido *</span>";
                        
                    }                }

                ?>
            </p>
            <p>
                Sexo:</br>


                <input type="radio" value="hombre" id="hombre" name="sexo" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "hombre")
                    echo "checked"; ?>>
                <label for="hombre">Hombre: </label>
                <input type="radio" value="mujer" id="mujer" name="sexo" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer")
                    echo "checked"; ?>>

                <label for="mujer">Mujer: </label>

            </p>
            <p>
                <label for="foto">Incluir mi foto (Max. 500KB)</label>
                <input type="file" name="foto" id="foto" accept="image/*" />

            </p>
            <p>
                <input type="checkbox" name="suscrip" id="suscrip">

                <label for="suscrip">Suscribirme al boletín de novedades</label>
                <?php
                if (isset($_POST['btnEnviar']) && $error_suscrip) {
                    echo "<span class='error'>*Debes marcar la suscripción*</span>";
                }
                ?>
            </p>
            <button type="submit" name="btnEnviar">Guardar Cambios</button>
            <button type="submit" name="btnBorrar">Borrar datos</button>

        </form>
        <?php
    }
    ?>
</body>

</html>