<form method="post" action="index.php">
        <p>
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre" value="<?php if (isset($_POST["nombre"]))
                echo $_POST["nombre"]; ?>" id="nombre">
            <?php

            if (isset($_POST['nombre']) && $error_nombre) {
                echo "<span class='error'>* Debes rellenar el nombre *</span>";
            }

            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave">
            <?php
    if(isset($_POST["btnEntrar"]) && $error_clave){
        echo "<span class='error'>* Debes rellenar la clave *</span>";

    }
            ?>
        </p>
        <p>
            <input type="submit" name="btnEntrar" id="btnEntrar" value="Entrar">
            <input type="submit" name="btnRegistro" id="btnRegistro" value="Registrarse">

        </p>
    </form>