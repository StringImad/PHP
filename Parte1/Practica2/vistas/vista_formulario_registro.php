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