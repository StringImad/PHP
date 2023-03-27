<h1>Segundo Formulario</h1>

<form method="post" action="Practica2.php" enctype="multipart/form-data">
    <p><label for="nombre">Nombre: </label>
        <input type="text" id="nombre" value="<?php if (isset($_POST['nombre']))
                                                    echo $_POST['nombre']; ?>" name="nombre">
        <?php

        if (isset($_POST['nombre']) && $error_nombre) {
            echo "<span class='error'>* Debes rellenar el nombre *</span>";
        }

        ?>
    </p>
    <p><label for="pais">Nacido en: </label>
        <select id="pais" name="nacido">
            <option <?php if (isset($_POST["nacido"]) && $_POST["nacido"] == "Malaga")
                        echo "selected"; ?>>Malaga</option>
            <option <?php if (isset($_POST["nacido"]) && $_POST["nacido"] == "Barcelona")
                        echo "selected"; ?>>Barcelona</option>
            <option <?php if (isset($_POST["nacido"]) && $_POST["nacido"] == "Madrid")
                        echo "selected"; ?>>Madrid</option>
        </select>
        <?php
        if (isset($_POST['pais']) && $error_pais) {
            echo "<span class='error'>*Campo Vacio*</span>";
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
        Aficiones: <label for="deportes">Deportes</label>
        <input id="deportes" type="checkbox" name="aficiones[]" value="Deportes" <?php if (isset($_POST["aficiones"]) && in_array("Deportes", $_POST["aficiones"])) echo "checked"; ?> />
        <label for="lectura">Lectura</label>
        <input id="lectura" type="checkbox" name="aficiones[]" value="Lectura" <?php if (isset($_POST["aficiones"]) && in_array("Lectura", $_POST["aficiones"])) echo "checked"; ?> />
        <label for="otros">Otros</label>
        <input id="otros" type="checkbox" name="aficiones[]" value="Otros" <?php if (isset($_POST["aficiones"]) && in_array("Otros", $_POST["aficiones"])) echo "checked"; ?> />
    </p>
    <p>
        <label for="coment">Comentarios: </label>
        <textarea id="coment" name="coment">
        <?php if (isset($_POST["btnEnviar"])) echo $_POST["coment"]; ?>
    </textarea>
        <?php
        if (isset($_POST['btnEnviar']) && $_POST["coment"] == "") {
            echo "<span class='error'>*Debes escribir un comentario*</span>";
        }
        ?>
    </p>
    <p>
        <label for="foto">Incluir mi foto (Archivo de tipo imagen Máx. 500KB): </label>
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
    <span id="nombre_archivo">
    </span>
    <br /><br />
    <input type="submit" value="Enviar" name="btnEnviar" />&nbsp;
    <input type="submit" value="Borrar Campos" name="btnBorrar" />
</form>