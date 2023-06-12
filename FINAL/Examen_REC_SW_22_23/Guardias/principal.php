<?php
// require "src/funciones.php";
session_name("recup");
session_start();
  require "src/seguridad.php";
  if(isset($_POST["btnSalir"]))
{
    session_destroy();
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
    <style>
        .tabla {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
            margin: 0 auto;
            text-align: center;
        }

        tr,
        th,
        td {
            border: 1px solid black;

        }

        th {
            background-color: #ccc;
        }

        .enlinea {
            display: inline;
        }

        .enlace {
            border: none;
            background-color: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <h1>Gestion de Guardias</h1>
    <div>Bienvenido<strong>

            <?php
             echo $datos_usu_log->usuario;
            //  session_destroy();
            ?>
        </strong>
         <form class='enlinea' method="post" action="principal.php">
            <button class='enlace' type="submit" name="btnSalir">Salir</button>
        </form> 
    </div>

</body>

</html>