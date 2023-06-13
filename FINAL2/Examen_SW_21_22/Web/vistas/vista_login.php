<?php
if (isset($_POST['btnLogin'])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {
        //hacer servicio
        $url = DIR_SERV . "/login";
        $datos_env["usuario"] = $_POST["usuario"];
        $datos_env["clave"] = md5($_POST["clave"]);

        $respuesta = consumir_servicios_REST($url, "POST", $datos_env);
        $obj = json_decode($respuesta);
        if (!$obj) {
            session_destroy();
            die(error_page("ERROR", "Error consumiendo el servicio".$url));
        }

         if(isset($obj->error)) {
            session_destroy();
             die(error_page("ERROR", "Error en la BD".$obj->error));

         }

        if(isset($obj->mensaje)) {

            $error_usuario = true;

        }else{
            $_SESSION["usuario"] = $datos_env["usuario"];
            $_SESSION["clave"] = $datos_env["clave"];
            $_SESSION["tipo"] = $obj->usuario->tipo;
            // $_SESSION["api_session"]["api_session"] = session_id();

            $_SESSION["ultima_accion"] = time();
        }
    }


}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen4 PHP</title>
</head>

<body>

    <form method="post" action="index.php">
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"]))
                echo $_POST["usuario"]; ?>" />
            <?php
            if (isset($_POST["btnLogin"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>*Campo Vacio*</span>";
                } else {
                    echo "<span class='error'>*Usuario o contraseña incorrectos*</span>";

                }
            }
            ?>
        </p>
        <label for="clave">Clave:</label>
        <input type="password" name="clave" id="clave" />
        <?php
        if (isset($_POST["btnLogin"]) && $error_clave) {

            echo "<span class='error'>*Campo Vacio*</span>";


        }
        ?>
        <p>
        </p>
        <p>
            <button type="submit" name="btnLogin" id="btnLogin">Login</button>
        </p>
    </form>

</body>

</html>