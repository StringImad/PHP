<?php
if (isset($_POST["btnContRegistro"])) {
    echo "dentro btnConRegistro";
    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {

        $url = DIR_SERV . "/usuarios/usuario/" . urlencode($_POST["usuario"]);
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
        
        if (isset($obj->mensaje)) {
            $error_usuario = true;
        }


    }
    $error_email = $_POST["email"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_usuario || $error_email || $error_clave;

    if (!$error_form) {
        $datos["usuario"]=$_POST["usuario"];
        $datos["clave"]=md5($_POST["clave"]);
        $datos["email"]=$_POST["email"];
        $url=DIR_SERV."/insertar_usuario";
        echo "url: " . $url;
        echo "datos: " . $datos;
        $respuesta=consumir_servicios_REST($url,"POST",$datos);
        $obj=json_decode($respuesta);
        if(!$obj)
        {
            session_destroy();
            die(error_page("Práctica 4 - SW","Práctica 4 - SW","Error consumiendo el servicio: ".$url));
        }
        if(isset($obj->mensaje_error))
        {
            session_destroy();
            die(error_page("Práctica 4 - SW","Práctica 4 - SW",$obj->mensaje_error));
        } 

        $mensaje="El usuario ha sido registrado con éxito";
        $_SESSION["accion"]=$mensaje;
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
            <input type="text" id="usuario" name="usuario" placeholder="Usuario..." value="<?php if (isset($_POST["usuario"]))
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
            <label for="email">email:</label><br />
            <input type="text" id="email" name="email" placeholder="email..." value="<?php if (isset($_POST["email"]))
                echo $_POST["email"]; ?>" />
            <?php
            if (isset($_POST["btnContRegistro"]) && $error_email) {
                echo "<span class='error'> Campo Vacío </span>";
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña:</label><br />
            <input type="password" id="clave" name="clave" placeholder="Contraseña..." value="" />
            <?php
            if (isset($_POST["btnContRegistro"]) && $error_clave) {
                echo "<span class='error'> Campo Vacío </span>";
            }
            ?>
        </p>
        <p>
            <input type="submit" name="btnContRegistro" value="Guardar Cambios" />
            <input type="submit" name="btnVolver" value="Volver" />
        </p>
    </form>
</body>

</html>