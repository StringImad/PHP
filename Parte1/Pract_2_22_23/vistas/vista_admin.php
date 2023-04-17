<?php

//codigo para la paginacion
if (!isset($_SESSION["registros"])) {
    $_SESSION["registros"] = 3;
}
if (isset($POST["pag"])) {
    $_SESSION["pag"] = 2;
}
if (!isset($POST["pag"])) {
    $_SESSION["pag"] = 1;
}

if (isset($_POST["boton_confirmar_borrar"])) {

    try {
        $id_usuario = $_POST["boton_confirmar_borrar"];

        $consulta = "DELETE FROM usuarios WHERE id_usuario = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);

        $_SESSION["mensaje_accion"] = "Usuario borrado con éxito";
        $sentencia = null;
        $conexion = null;
        header("Location:index.php");
        exit;
    } catch (PDOException $e) {
        session_destroy();
        $sentencia = null;
        $conexion = null;
        die(error_page("Práctica Rec 2", "Práctica Rec 2", "Imposible borrar el usuario. Error:" . $e->getMessage()));
    }
}

if (isset($_POST["boton_listar"])) {
    try {
        $consulta = "select * from usuarios where id_usuario = ?";
        $id_usuario = $_POST["boton_borrar"];
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);

        $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        echo "<div class='centrar'>";
        if ($sentencia->rowCount() > 0) { //Si el usuario sigue existiendo

            $tupla = mysqli_fetch_assoc($resultado);

            echo "<h3>Datos del usuario " . $_POST["boton_listar"] . "</h3>";
            echo "<p><strong>Nombre: </strong>" . $tupla["nombre"] . "</p>";
            echo "<p><strong>Usuario: </strong>" . $tupla["usuario"] . "</p>";
            echo "<p><strong>E-mail: </strong>" . $tupla["email"] . "</p>";
            echo "<form action='index.php' method='post'><button type='submit'>Atrás</button></form>";
        } else { //Si el usuario se borra durante

            echo "<p class ='error'>Error de consistencia. El usuario seleccionado ya no existe</p>";
        }

        echo "</div>";
    } catch (PDOException $e) {
        session_destroy();
        $sentencia = null;
        $conexion = null;
        die(("<p>Imposible realizar la consulta. Error:" . $e->getMessage()) . "</p></body></html>");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Rec 2</title>
    <style>
        table {
            border-collapse: collapse;
            text-align: center;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        img {
            height: 100px;
            width: auto;
        }

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        .enlinea {
            display: inline
        }

        .centrar {
            width: 80%;
            margin: 1rem auto;
        }

        .centrar-texto {
            text-align: center;
        }

        .flexible {
            display: flex;
            justify-content: space-between;
        }
        #bot_pag{
            display: flex;
            justify-content: center;
            margin-top: 1em;
        }
        </style>
</head>

<body>
    <h1>Práctica Rec 2</h1>
    <div>Bienvenido <strong>
            <?php echo $datos_usuario_log["usuario"]; ?>
        </strong> - <form method="post" action="index.php" class="en_linea"><button class="enlace" name="btnSalir">Salir</button></form>
    </div>
    <?php


    if (isset($_POST["btnUsuarioNuevo"]) || isset($_POST["btnContRegistro"])) {

        require "vista_registro.php";
    }
    if (isset($_POST["boton_borrar"])) {

        require "Admin/vista_borrar.php";
    }
    if (isset($_POST["boton_listar"])) {

        require "Admin/vista_listar_usuario.php";
    }

    require "Admin/vista_listar.php";

    ?>
</body>

</html>