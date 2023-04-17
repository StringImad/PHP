<?php

if (isset($_POST["boton_editar"])) {


    try {
        $id_usuario = $_POST["boton_editar"];
        $consulta = "SELECT * FROM usuarios WHERE id_usuario = ?";

        $sentencia->execute([$id_usuario]);

        $sentencia = $conexion->prepare($consulta);

        if ($sentencia->rowCount() > 0) {
            $tupla = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            $nombre = $tupla["nombre"];
            $usuario = $tupla["usuario"];
            $dni = $tupla["dni"];
        } else {
            $error_usuario = true;
            $sentencia = null;
            $conexion = null;
        }
    } catch (PDOException $e) {
        session_destroy();
        $sentencia = null;
        $conexion = null;
        die(error_page("Práctica Rec 2", "Práctica Rec 2", "Imposible realizar la consulta. Error:" . $e->getMessage()));
    }
} else {

    $id_usuario = $_POST["boton_confirma_editar"];
    $nombre = $_POST["nombre"];
    $usuario = $_POST["usuario"];
    $dni = $_POST["dni"];
}

echo "<h2 class='centrar'>Editar Usuario " . $id_usuario . "</h2>";

if (isset($error_consistencia)) {

    echo "<div class='centrar'>";
    echo "<p>" . $error_consistencia . "</p>";
    echo "<form action='index.php' method='post'>";
    echo "<button type='submit'>Volver</button>";
    echo "</form>";
} else {

    ?>

    <form action="index.php" method="post" class="centrar">
        <p>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php echo $nombre ?>" />
            <?php if (isset($_POST["nombre"]) && $error_nombre)
                echo "<span class='error'>* Campo vacío * </span>"; ?>
        </p>

        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php echo $usuario ?>" />
            <?php if (isset($_POST["usuario"]) && $error_usuario) {

                if ($_POST["usuario"] == "")
                    echo "<span class='error'>* Campo vacío * </span>";
                else
                    echo "<span class='error'>* Usuario ya existente * </span>";
            }
            ?>
        </p>

        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave" maxlength="20" placeholder="Nueva contraseña">
        </p>

        <p>
            <label for="dni">DNI:</label><br />
            <input type="text" id="dni" name="dni" placeholder="DNI: 11223344Z"
                value="<?php if (isset($_POST["dni"]))
                    echo $_POST["dni"]; ?>" />
            <?php
            if (isset($_POST["btnContRegistro"]) && $error_dni)
                if ($_POST["dni"] == "")
                    echo "<span class='error'> Campo Vacío </span>";
                else if (!dni_bien_escrito($_POST["dni"]))
                    echo "<span class='error'> DNI no está bien escrito </span>";
                else if (!dni_valido($_POST["dni"]))
                    echo "<span class='error'> DNI no válido </span>";
                else
                    echo "<span class='error'> DNI repetido </span>";
            ?>
        </p>

        <p>
            <button type="submit" name="boton_volver">Volver</button>
            <button type="submit" value="<?php echo $id_usuario; ?>" name="boton_confirma_editar">Continuar</button>
        </p>
    </form>

    <?php


}