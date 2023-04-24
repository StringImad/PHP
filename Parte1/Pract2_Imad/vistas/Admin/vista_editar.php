<?php
if(isset($_POST["btnEditar"]) || isset($_POST["borrar_foto"])){

}
if (isset($_POST["btnEditar"])) {


    try {
        $id_usuario = $_POST["btnEditar"];
        $consulta = "SELECT * FROM usuarios WHERE id_usuario = ?";
        $sentencia = $conexion->prepare($consulta);

        $sentencia->execute([$id_usuario]);


        if ($sentencia->rowCount() > 0) {
            $tupla = $sentencia->fetch(PDO::FETCH_ASSOC);
            $subs=0;
            if(isset($_POST["subcripcion"]))
                $subs=1;
            $nombre = $tupla["nombre"];
            $usuario = $tupla["usuario"];
            $dni = $tupla["dni"];
            $foto = $tupla["foto"];
            $subs = $subs;
            $sexo = $tupla["sexo"];
        } else {
            $error_consistencia = true;
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

    $id_usuario = $_POST["id_usuario"];
    $nombre = $_POST["nombre"];
    $usuario = $_POST["usuario"];
    $dni = $_POST["dni"];
    $subs = 0;
    if (isset($_POST["subcripcion"]))
        $subs = 1;

    $sexo = $_POST["sexo"];
    $foto_ant = $_POST["foto_bd"];
}



echo "<h2 class='centrar'>Editar Usuario " . $id_usuario . "</h2>";

if (isset($error_consistencia)) {

    echo "<div class='centrar'>";
    echo "<p>El usuario no se encuentra registrado</p>";
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
            <input type="text" id="dni" name="dni" placeholder="DNI: 11223344Z" value="<?php if (isset($_POST["dni"]))
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
        <label>Sexo:</label>
        <?php
        if(isset($_POST["btnContRegistro"])&&$error_sexo)
            echo "<span class='error'> Debes seleccionar un sexo </span>";
        ?>
        <br/>
        <input type="radio" <?php if(isset($_POST["sexo"])&& $_POST["sexo"]=="hombre") echo "checked";?> name="sexo" id="hombre" value="hombre"/> <label for="hombre">Hombre</label><br/>
        <input type="radio" <?php if(isset($_POST["sexo"])&& $_POST["sexo"]=="mujer") echo "checked";?> name="sexo" id="mujer" value="mujer"/> <label for="mujer">Mujer</label>

    </p>
    <p>
        <label for="foto">Incluir mi foto (Máx 500 KB):</label><input type="file" id="foto" name="foto" accept="image/*"/>
        <?php
        if(isset($_POST["btnContRegistro"])&&$error_foto)
        {
            if($_FILES["foto"]["error"])
            {
                echo "<span class='error'> Error en la subida del fichero al servidor </span>";
            }
            elseif(!getimagesize($_FILES["foto"]["tmp_name"]))
            {
                echo "<span class='error'> Error, no has seleccionado un archivo imagen </span>";
            }
            else
                echo "<span class='error'> Error, el tamaño del fichero seleccionado supera los 500KB </span>";
        }
        ?>
    </p>
    <p>
        <input type="checkbox" <?php if($subs==1) echo "checked";?>  name="subcripcion" id="sub"/> <label for="sub">Subcribirme al boletín de novedades</label>
       
    </p>

        <p>
            <input type="hidden" value="<?php echo $foto_bd;?>" name="foto_bd">
            <input type="hidden" value="<?php echo $id_usuario;?>" name="id_usuario">
            <input type="hidden" value="<?php echo $foto_bd;?>" name="foto_bd">

            <button type="submit" name="boton_volver">Volver</button>
            <button type="submit" value="<?php echo $id_usuario; ?>" name="boton_confirma_editar">Continuar</button>
        </p>
        <div>
        <img src="">
    </div>
    <div class='centrado'>
        <img src="Img/<?php echo $foto_bd;?>" alt="Foto perfil">
        if($foto_bd!="no_imagen.jpg"){

        }
    </div>
    </form>
    

<?php


}
