<?php
if (isset($_POST["btnBorrar"])) {
    //unset($_POST);
    //header("Location:index.php");
    //exit;
}

if (isset($_POST["btnEnviar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_nombre = $_POST["nombre"] == "";
    $error_dni = $_POST["dni"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_sexo = $_POST["sexo"] == "";
    $error_suscrip = $_POST["suscrip"] == "";

    $error_form = $error_usuario || $error_nombre  || $error_dni   ||  $error_clave || $error_sexo || $error_suscrip;
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

    <?php

    } else { ?>
        <h1>Rellena tu CV</h1>

        <form method="post" action="Practica1.php" enctype="multipart/form-data">

            <p> <label for="usuario">
                    Usuario:
                </label>
                <input type="text" id="usuario" value="<?php if (isset($_POST['usuario'])) echo $_POST['usuario']; ?>" name="usuario">
                <?php


                if (isset($_POST['usuario']) && $error_usuario) {
                    echo "<span class='error'>*Debes rellenar el usuario*</span>";
                }

                ?>
            </p>
            <p><label for="nombre">Nombre: </label>
                <input type="text" id="nombre" value="<?php if (isset($_POST['nombre'])) echo $_POST['nombre']; ?>" name="nombre">
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
                <input type="text" name="dni" id="dni" value="<?php if (isset($_POST['dni'])) echo $_POST['dni']; ?>">
                <?php
                if (isset($_POST['dni']) && $error_dni) {
                    echo "<span class='error'>* Debes rellenar el DNI*</span>";
                }

                ?>
            </p>
            <p>
                Sexo:</br>


                <input type="radio" value="hombre" id="hombre" name="sexo">
                <label for="hombre">Hombre: </label>
                <input type="radio" value="mujer" id="mujer" name="sexo">
                <label for="mujer">Mujer: </label>
                <?php
                if (isset($_POST['sexo']) && $error_sexo) {
                    echo "<span class='error'>* Campo vacío *</span>";
                }

                ?>
            </p>
            <p>
                <label for="foto">Incluir mi foto (Max. 500KB)</label>
                <input type="file" name="foto" id="foto" accept="image/*" />

            </p>
            <p>
                <input type="checkbox" name="suscrip" id="suscrip">

                <label for="suscrip">Suscribirme al boletín de novedades</label>
                <?php
                if (isset($_POST['suscrip']) && $error_suscrip) {
                    echo "<span class='error'>*Campo Vacio*</span>";
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