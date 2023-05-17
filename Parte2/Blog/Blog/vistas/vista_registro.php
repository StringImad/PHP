<?php
if(isset($_SESSION["btnBorrarNuevo"]))
unset($_SESSION["btnBorrarNuevo"]);
?>
<h2>Registro de un nuevo Usuario</h2>
<form action="index.php" method="post" enctype="multipart/form-data">
<p>
<label for="usuario">Usuario:</label><br/>
<input type="text" id="usuario" name="usuario" placeholder="Usuario..." value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>"/>
<?php
if(isset($_POST["btnContNuevo"])&&$error_usuario)
{
    if($_POST["usuario"]=="")
        echo "<span class='error'> Campo Vacío </span>";
    else
        echo "<span class='error'> Usuario repetido </span>";
}
?>
</p>

<p>
<label for="clave">Contraseña:</label><br/>
<input type="password" id="clave" name="clave" placeholder="Contraseña..." value=""/>
<?php
if(isset($_POST["btnContNuevo"])&&$error_clave)
{
    echo "<span class='error'> Campo Vacío </span>";
}
?>
</p>


<p>
<label for="foto">Incluir mi foto (Máx 500 KB):</label><input type="file" id="foto" name="foto" accept="image/*"/>
<?php
if(isset($_POST["btnContNuevo"])&&$error_foto)
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
<input type="checkbox" <?php if(isset($_POST["subcripcion"])) echo "checked";?>  name="subcripcion" id="sub"/> <label for="sub">Subcribirme al boletín de novedades</label>

</p>
<p>
<input type="submit" name="btnContNuevo" value="Guardar Cambios"/> 
<input type="submit" name="btnBorrarNuevo" value="Borrar los datos introducidos"/>
<input type="submit" name="btnVolver" value="Volver"/>
</p>
</form>