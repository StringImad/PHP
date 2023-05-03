<?php

if (isset($_POST["btnContBorrar"])) {
    $url = DIR_SERV . "/borrar_usuario";


    $datos_env["usuario"] = $_POST["id_usuario"];
    $respuesta = consumir_servicios_REST($url, "delete", $datos_env);
    $obj = json_decode($respuesta);
    if (!$obj) {
        session_destroy();
        die(error_page("Práctica 3 - SW", "Práctica 3 - SW", "Error consumiendo el servicio: " . $url . $respuesta));
    }

    if (isset($obj->mensaje_error)) {
        session_destroy();
        die(error_page("Práctica 3 - SW", "Práctica 3 - SW", $obj->mensaje_error));
    }
}

if (isset($_POST["btnListar"])) {

    $url = DIR_SERV . "/obtener_un_usuario/".$_POST["btnListar"];

    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);
    if (!$obj) {
        session_destroy();
        die(error_page("Práctica 3 - SW", "Práctica 3 - SW", "Error consumiendo el servicio: " . $url . $respuesta));
    }

    if (isset($obj->mensaje_error)) {
        session_destroy();
        die(error_page("Práctica 3 - SW", "Práctica 3 - SW", $obj->mensaje_error));
    }

    if(isset($obj->usuarios)){
        foreach ($obj->usuarios as $usuario) {
            echo "<p><strong>ID de usuario: </strong>" . $usuario->id_usuario . "</p>";
            echo "<p><strong>Nombre de usuario: </strong>" . $usuario->usuario . "</p>";
            echo "<p><strong>Nombre: </strong>" . $usuario->nombre . "</p>";
            echo "<p><strong>DNI: </strong>" . $usuario->dni . "</p>";
            echo "<p><strong>Sexo: </strong>" . $usuario->sexo . "</p>";
            echo "<p><strong>Foto: </strong> <img src='" . $usuario->foto . "' alt =''</p>";
            echo "<p><strong>Subscripción: </strong>" . $usuario->subscripcion . "</p>";
            echo "<p><strong>Tipo: </strong>" . $usuario->tipo . "</p>";
        }
    }else{
        echo "El usuario no se encuentra rresgisrtadi";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 3 - SW</title>
    <style>
        .enlinea {
            display: inline
        }

        .enlace {
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer
        }

        .en_linea {
            display: inline
        }

        .enlace {
            background: none;
            border: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        #tabla_principal,
        #tabla_principal td,
        #tabla_principal th {
            border: 1px solid black
        }

        #tabla_principal {
            width: 90%;
            border-collapse: collapse;
            text-align: center;
            margin: 0 auto
        }

        #tabla_principal th {
            background-color: #CCC
        }

        #tabla_principal img {
            height: 75px
        }
    </style>
</head>

<body>
    <h1>Práctica 3 - SW</h1>
    <div>
        Bienvenido <strong>
            <?php echo $datos_usu_log->usuario; ?>
        </strong> -
        <form class="enlinea" action="index.php" method="post">
            <button name="btnSalir" class="enlace">Salir</button>
        </form>
    </div>
    <?php

    if (isset($_POST["btnBorrar"])) {
        echo "<div>";
        echo "<h2>Borrado del usuario con id: " . $_POST["btnBorrar"] . "</h2>";
        echo "<form action='index.php' method='post'>";
        echo "<input type='hidden' value='" . $_POST["foto"] . "' name='foto'/>";

        echo "<p class='centrado'>Se dispone usted a borrar al usuario con id: " . $_POST["btnBorrar"] . "<br/>";
        echo "¿Estás seguro?</p>";
        echo "<p class='centrado'><button>Cancelar</button> <button name='btnContBorrar' value='" . $_POST["btnBorrar"] . "'>Continuar</button>";
        echo "</form>";
        echo "</div>";
    } ?>

    <div class="tabla_admin">
        <?php

        require "Admin/vista_tabla.php";
        ?>

    </div>

</body>

</html>