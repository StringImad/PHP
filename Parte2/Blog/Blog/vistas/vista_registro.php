<?php
if(isset($_POST["btnConRegistro"])){
    $error_usuario = $_POST["usuario"]=="";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Usuarios nuevos</title>
</head>
<body>
<h2>Registro de un nuevo Usuario</h2>
<form action="index.php" method="post" enctype="multipart/form-data">
<p>
<label for="usuario">Usuario:</label><br/>
<input type="text" id="usuario" name="usuario" placeholder="Usuario..." value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>"/>
<?php
if(isset($_POST["btnContRegistro"])&&$error_usuario)
{
    if($_POST["usuario"]=="")
        echo "<span class='error'> Campo Vacío </span>";
    else
        echo "<span class='error'> Usuario repetido </span>";
}
?>
</p>

<p>
<label for="nombre">Nombre:</label><br/>
<input type="text" id="nombre" name="nombre" placeholder="Nombre..." value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>"/>
<?php
if(isset($_POST["btnContRegistro"])&&$error_nombre)
{
    echo "<span class='error'> Campo Vacío </span>";
}
?>
</p>
<p>
<label for="clave">Contraseña:</label><br/>
<input type="password" id="clave" name="clave" placeholder="Contraseña..." value=""/>
<?php
if(isset($_POST["btnContRegistro"])&&$error_clave)
{
    echo "<span class='error'> Campo Vacío </span>";
}
?>
</p>
<p>
<input type="submit" name="btnContRegistro" value="Guardar Cambios"/> 
<input type="submit" name="btnVolver" value="Volver"/>
</p>
</form>
</body>
</html>