<?php
if (isset($_POST["boton_confirmar_borrar"])) {

    try {
        $id_usuario = $_POST["boton_confirmar_borrar"];

        $consulta = "DELETE FROM usuarios WHERE id_usuario = ?";
        $sentencia->execute([$id_usuario]);

        $sentencia = $conexion->prepare($consulta);
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
    </style>
</head>

<body>
    <h1>Práctica Rec 2</h1>
    <div>Bienvenido <strong>
            <?php echo $datos_usuario_log["usuario"]; ?>
        </strong> - <form method="post" action="index.php" class="en_linea"><button class="enlace"
                name="btnSalir">Salir</button></form>
    </div>
    <?php


    if (isset($_POST["btnUsuarioNuevo"]) || isset($_POST["btnContRegistro"])) {

        require "vista_registro.php";
    }
    if (isset($_POST["boton_borrar"])) {

        require "Admin/vista_borrar.php";
    }
    require "Admin/vista_listar.php";

    ?>
</body>

</html>