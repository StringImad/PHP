<?php
if (isset($_POST["btnContRegistro"])) {
    echo "dentro btnConRegistro";
    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {

        $url = DIR_SERV."/usuarios/usuario/".urlencode($_POST["usuario"]);
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);
        if (!$obj) {
            session_destroy();
            die(error_page("Práctica 4 - SW", "Práctica 4 - SW", "Error consumiendo el servicio: " . $url));
        }
        if (isset($obj->mensaje_error)) {
            session_destroy();
            die(error_page("Práctica 4 - SW", "Práctica 4 - SW", $obj->mensaje_error));
        }

            $error_usuario = isset($obj->usuarios);
    }
    $error_email = $_POST["email"] == "" || !filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
    if (!$error_email) {

        $url = DIR_SERV . "/usuarios/email/" . urlencode($_POST["email"]);
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);
        if (!$obj) {
            session_destroy();
            die(error_page("Práctica 4 - SW", "Práctica 4 - SW", "Error consumiendo el servicio: " . $url));
        }
        if (isset($obj->mensaje_error)) {
            session_destroy();
            die(error_page("Práctica 4 - SW", "Práctica 4 - SW", $obj->mensaje_error));
        }

            $error_email = isset($obj->usuarios);
    }
    
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_usuario || $error_email || $error_clave;

    if (!$error_form) {
        $url = DIR_SERV . "/insertarUsuario";

        $datos["usuario"] = $_POST["usuario"];
        $datos["clave"] = md5($_POST["clave"]);
        $datos["email"] = $_POST["email"];

        $respuesta = consumir_servicios_REST($url, "POST", $datos);
        $obj = json_decode($respuesta);
        if (!$obj) {
            session_destroy();
            die(error_page("Práctica 4 - SW", "Práctica 4 - SW", "Error consumiendo el servicio: " . $url));
        }
        if (isset($obj->mensaje_error)) {
            session_destroy();
            die(error_page("Práctica 4 - SW", "Práctica 4 - SW", $obj->mensaje_error));
        }
        $_SESSION["segurdad"]= "El usuario ha sido registrado con éxito";
        
        header("Location: index.php");
        exit;
    }
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
            <label for="usuario">Usuario:</label><br />
            <input type="text" id="usuario" name="usuario" value="<?php if (isset($_POST["usuario"]))
                                                                        echo $_POST["usuario"]; ?>" />
            <?php
            if (isset($_POST["btnContRegistro"]) && $error_usuario) {
                if ($_POST["usuario"] == "")
                    echo "<span class='error'> Campo Vacío </span>";
                else
                    echo "<span class='error'> Usuario repetido </span>";
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña:</label><br />
            <input type="password" id="clave" name="clave" />
            <?php
            if (isset($_POST["btnContRegistro"]) && $error_clave) {
                echo "<span class='error'> Campo Vacío </span>";
            }
            ?>
        </p>
        <p>
            <label for="email">email:</label><br />
            <input type="text" id="email" name="email" value="<?php if (isset($_POST["email"]))
                                                                    echo $_POST["email"]; ?>" />
            <?php
            if (isset($_POST["btnContRegistro"]) && $error_email) {
                if($_POST["email"]=="")
                echo "<span class='error'> Campo Vacío </span>";
                else if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))
                echo "<span class='error'> Email mal escrito </span>";
                else
                echo "<span class='error'> Email en uso </span>";

            }
            ?>
        </p>

        <p>
            <button name="btnContRegistro">Continuar </button>
            <button>Volver</button>
        </p>
    </form>
</body>

</html>