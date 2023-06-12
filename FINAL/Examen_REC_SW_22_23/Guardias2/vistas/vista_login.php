<?php
if (isset($_POST["btnLogin"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {
        $url = DIR_SERV . "/login";
        $datos_env["usuario"] = $_POST["usuario"];
        $datos_env["clave"] = md5($_POST["clave"]);
        $respuesta = consumir_servicios_REST($url, "POST", $datos_env);

        $obj = json_decode($respuesta);

        if (!$obj) {
            session_destroy();
            die(error_page("Error", "Error", "Error consumiendo el servicio" . $url));
        }
        if (isset($obj->error)) {
            session_destroy();
            die(error_page("Error", "Error", "Error base de datos: " . $obj->error));
        }

        if (isset($obj->mensaje)) {
            $error_usuario = true;
        }else{
            $_SESSION["usuario"] = $datos_env["usuario"];
            $_SESSION["clave"] = $datos_env["clave"];
            $_SESSION["ultima_accion"] = time();
            $_SESSION["api_session"]["api_session"] = $obj->api_session;
            header("Location:index.php");
            exit;
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
    <title>Gestion de Guardias</title>
</head>

<body>
    <?php 
if(isset($_SESSION["seguridad"])){
    echo "<p>". $_SESSION['seguridad']."</p>";
}


?>
    <h1>Gestion de Guardias</h1>
    <form method="post" action="index.php">
        <p>

            <label for="usuario">Usuario: </label>
            <input type="text" id="usuario" name="usuario" value="<?php if (isset($_POST['usuario']))
                echo $_POST['usuario']; ?>" />
            <?php
            if (isset($_POST['btnLogin']) && $error_usuario)
                if($_POST["usuario"] =="")
                echo "<span class='error'>*Campo vacio*</span>";
                else
                echo "<span class='error'>*Usuario o contraseña incorrectos*</span>";

            ?>
        </p>
        <p>

            <label for="clave">clave: </label>
            <input type="password" id="clave" name="clave" />
            <?php
            if (isset($_POST['btnLogin']) && $error_clave)
                echo "<span class='error'>*Campo vacio*</span>";
            ?>
        </p>
        <p>
            <button type="submit" name="btnLogin" id="btnLogin">Entrar</button>
    </form>
</body>

</html>