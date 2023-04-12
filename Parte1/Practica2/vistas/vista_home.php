<?php
if (isset($_POST['btnEntrar'])) {
    $error_usuario = $_POST["usuario_log"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_usuario || $error_clave;
    if (!$error_form) {
        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

            try {
                $consulta = "select * from usuarios where usuario = ? and clave = ?";
                $sentencia = $conexion->prepare($consulta);
                $datos[] = $_POST["usuario"];
                $datos[] = md5($_POST["clave"]);
                $sentencia->execute($datos);
                if ($sentencia->rowCount() > 0) {

                    $_SESSION["usuario"] = $datos[0];
                    $_SESSION["clave"] = $datos[1];
                    $_SESSION["ultimo_acceso"] = time();
                    $sentencia = null;
                    $conexion = null;
                    header("Location:indexProfesor.php");
                    exit();
                } else {
                    $error_usuario = true;
                    $sentencia = null;
                    $conexion = null;
                }
            } catch (PDOException $e) {
                session_destroy();
                $sentencia = null;
                $conexion = null;
                die("<p>Failed to connect" . $e->getMessage() . "</p></body></html>");
            }
        } catch (PDOException $e) {
            session_destroy();

            die("<p>Failed to connect" . $e->getMessage() . "</p></body></html>");
        }
    }
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
            <input type="password" name="clave_log" id="clave">
            <?php
            if (isset($_POST["btnEntrar"]) && $error_clave) {
                echo "<span class='error'>* Debes rellenar la clave *</span>";
            }
            ?>
        </p>
        <p>
            <input type="submit" name="btnEntrar" id="btnEntrar" value="Entrar">
            <input type="submit" name="btnRegistro" id="btnRegistro" value="Registrarse">

        </p>
    </form>
</body>

</html>
<?php
if(isset($_SESSION["baneo"])){
    echo "<p>".$_SESSION["baneo"]."</p>";
    session_destroy();
}

?>