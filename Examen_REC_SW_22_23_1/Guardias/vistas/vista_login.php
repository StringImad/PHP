
<h1>Gestion de usuarios</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">
                Usuario:
            </label>
            <input type="text" id="usuario" name="usuario" value="<?php if (isset($_POST['usuario'])) echo $_POST['usuario']; ?>" />
            <?php
            if (isset($_POST["btnLogin"]) && $error_usuario) {
                echo '<span>*Campo Vacio*</span>';
            }
            ?>
        </p>
        <p>
            <label for="clave">
                Clave:
            </label>
            <input type="password" id="clave" name="clave" value="" />
            <?php
            if (isset($_POST["btnLogin"]) && $error_clave) {
                echo '<span>*Campo Vacio*</span>';
            }
            ?>
        </p>
        <p>
            <input type="submit" name="btnLogin" value="Entrar" />
        </p>
    </form>
