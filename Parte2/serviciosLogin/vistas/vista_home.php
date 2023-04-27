<?php


if (isset($_POST["btnLogin"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    if (!$error_usuario && !$error_clave) {

        $url = DIR_SERV . "/login";
        $datos_env["usuario"] = $_POST["usuario"];
        $datos_env["clave"] = md5($_POST["clave"]);

        $respuesta = consumir_servicios_rest($url, "POST", $datos_env);
        $obj = json_decode($respuesta);
        echo $respuesta;
        if (!$obj) { //Si falla el servicio REST
            session_destroy();
            die("<p>Error al consumir el servicio REST: " . $url . "</p>" . $respuesta . " </body></html>");
        }

        if (isset($obj->error)) {
            session_destroy();

            die("<p>" . $obj->error . "</p></body></html>");
        }
        if (isset($obj->mensaje)) {
            $error_usuario = true;
        } else {
            $_SESSION["usuario"] = $datos_env["usuario"];
            $_SESSION["clave"] = $datos_env["clave"];
            $_SESSION["ultimo_acceso"] = time();
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
    <h1>Practica 3 SW</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value='<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>'>
            <?php
            // if (isset($_POST["usuario"]) && $error_usuario) {
            //     if ($_POST["usuario"] == "") {
            //         echo "<span>Campo vacio</span>";
            //     } else {
            //         echo "<span>Usuario y/o contrsaeña incorrectos</span>";
            //     }
            // }

            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave">
            <?php
            if (isset($_POST["btnLogin"]) && $error_clave) {

                echo "<span>Campo vacio</span>";
            }

            ?>
        </p>
        <button name="btnLogin">Entrar</button>
    </form>
<?php
if(isset($_SESSION["seguridad"])){
    echo "<p class='mensaje'>.";
}

?>
</body>

</html>