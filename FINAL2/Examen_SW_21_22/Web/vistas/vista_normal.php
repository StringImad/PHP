<?php


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NORMAL</title>
    <style>
        table {
            width: 60%;
        }

        table,
        tr,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;

        }

        th {
            background-color: #ccc;
        }
    </style>
</head>

<body>
    <div>
        Bienvenido:
        <?php echo $datos_usu_log->usuario; ?>
        <form method="post" action="index.php"><button type="submit" name="btnSalir">Salir</button></form>

        <h1>Horario del profesor:
            <?php
            echo $datos_usu_log->nombre;
            ?>
        </h1>

        <table class="tabla">
            <tr>
                <th></th>
                <th>Lunes</th>
                <th>Martes</th>
                <th>Miercoles</th>
                <th>jueves</th>
                <th>viernes</th>
            <tr>

                <?php
                $url = DIR_SERV . "/horario/" . $datos_usu_log->id_usuario;
                //MANDAR api session tmnm
                $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
                $obj = json_decode($respuesta);
                if (!$obj) {
                    //consu8mir salir
                    session_destroy();
                    die(error_page("ERROR", "Error consumiendo el servicio: " . $url));
                }

                if (isset($obj->error)) {
                    //consu8mir salir
                
                    session_destroy();
                    die(error_page("ERROR", "Error en la BD" . $obj->error));

                }

                $horas = 8;
                $hor = 1;
                $dia = 1;
                for ($i = 0; $i < 7; $i++) {
                    echo "<tr>";
                    echo " <td> ";
                    if ($i < 3) {
                        echo $horas . ":15-" . ($horas + 1) . ":15";

                    } else if ($i == 3) {
                        echo ($horas) . ":15-" . ($horas) . ":45";

                    } else {
                        echo ($horas - 1) . ":45-" . ($horas) . ":45";

                    }

                    echo "</td>";
                    for ($j = 1; $j < 6; $j++) {
                        echo " <td>";
                        if ($hor == 4) {
                            echo "recreo";
                        } else {
                            foreach ($obj->horario as $tuplas) {
                                if ($tuplas->dia == $j && $tuplas->hora == $hor) {
                                    echo $tuplas->nombre;
                                }
                            }
                        }
                        // echo "hora: ".$hor;
                
                        // echo "dia: ".$j;
                        echo "</td>";
                    }
                    $horas++;
                    $hor++;
                    echo "</tr>";
                }


                ?>

        </table>




        <p>
            <?php

            if (isset($_SESSION["seguridad"])) {
                echo $_SESSION["seguridad"];

            } ?>
        </p>
    </div>
</body>

</html>