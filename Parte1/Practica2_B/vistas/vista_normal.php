<?php
if (isset($_POST["btnSalir"])) {
    session_destroy();
    mysqli_close($conexion);
    header("Location:index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="centrar">
        Bienvenid@ <strong><?php echo $datos_usuario_log["usuario"]; ?></strong> 
        <form class="enlinea" action="index.php" method="post">
            <button class='enlace' name='btnSalir'>Salir</button>
        </form>
    </div>
    <?php
if(isset($_SESSION["bienvenida"])){
    echo "<p>".$_SESSION["bienvenida"]."</p>";
    unset($_SESSION["bienvenida"]);

}

?>
</body>
</html>