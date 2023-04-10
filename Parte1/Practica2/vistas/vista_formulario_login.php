<form method="post" action="index.php">
        <p>
            <label for="usuario_log">Usuario: </label>
            <input type="text" name="usuario_log" value="<?php if (isset($_POST["usuario"]))
                echo $_POST["usuario"]; ?>" id="usuario_log">
         
              <?php
            if (isset($_POST["btnEntrar"]) && $error_usuario)
                if ($_POST["usuario_log"] == "")
                echo "<span class='error'>* Debes rellenar el usuario *</span>";
                else
                    echo "<span class='error'>* Usuario no se encuentra registrado en BD *</span>";
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