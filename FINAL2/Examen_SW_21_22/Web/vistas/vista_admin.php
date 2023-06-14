<?php
if (isset($_POST['btnQuitarGrupo'])) {
    $url = DIR_SERV . "/borrarGrupo/" . $_POST["dia"] . "/" . $_POST["hora"] . "/" . $_POST["profesor"] . "/" . $_POST["grupo"];
    $respuesta = consumir_servicios_REST($url, "DELETE");
    $obj = json_decode($respuesta);
    if (!$obj) {
        consumir_servicios_REST("/salir", "POST", $_SESSION["api_session"]);
        session_destroy();
        die(error_page("error", "error consumiendo servicio: ". $url));
    }
    if (isset($obj->error)) {
        consumir_servicios_REST("/salir", "POST", $_SESSION["api_session"]);
        session_destroy();
        die(error_page("error", "error en la BD: ", $url));
    }
    if (isset($obj->mensaje)) {
        $_SESSION["mensaje_accion"] = $obj->mensaje."</br> ". $url ;
    }

 
}
if (isset($_POST['btnInsertarGrupo'])) {
    $url = DIR_SERV . "/insertarGrupo/" . $_POST["dia"] . "/" . $_POST["hora"] . "/" . $_POST["profesor"] . "/" . $_POST["grupo"];
    $respuesta = consumir_servicios_REST($url, "POST");
    $obj = json_decode($respuesta);
    if (!$obj) {
        consumir_servicios_REST("/salir", "POST", $_SESSION["api_session"]);
        session_destroy();
        die(error_page("error", "error consumiendo servicio: ". $url));
    }
    if (isset($obj->error)) {
        consumir_servicios_REST("/salir", "POST", $_SESSION["api_session"]);
        session_destroy();
        die(error_page("error", "error en la BD: ", $url));
    }
    if (isset($obj->mensaje)) {
        $_SESSION["mensaje_accion"] = $obj->mensaje."</br> ". $url ;
    }

    if (isset($obj->depu)) {
        $_SESSION["depu"] = $obj->depu ;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
    <style>
        table {
            width: 60%;
            text-align: center;
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
        <?php echo $_SESSION["usuario"];
        ; ?>
        <form method="post" action="index.php"><button type="submit" name="btnSalir">Salir</button></form>
    </div>
    <p>
        <label for="profesor">Seleccion el Profesor</label>
        <?php
        $url = DIR_SERV . "/usuarios";
        //API session falta
        $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
        $obj = json_decode($respuesta);
        if (!$obj) {
            //consumir servicios salir
            consumir_servicios_REST("/salir", "POST", $_SESSION["api_session"]);
            session_destroy();
            die("<p>Error consumir servicios" . $url . "</p></body></html>");
        }
        if (isset($obj->error)) {
            //consu8mir salir
            consumir_servicios_REST("/salir", "POST", $_SESSION["api_session"]);

            //cambiar error page por p
            session_destroy();
            die(error_page("ERROR", "Error en la BD" . $obj->error));

        }
        echo "<form method='post' action='index.php'>";
        echo "<select name='profesor' id='profesor'  >";
        foreach ($obj->usuarios as $tuplas) {
            echo "<option value='" . $tuplas->id_usuario . "'>" . $tuplas->nombre . "</option>";
        }
        echo "</select>";
        ?>
        <button type="submit" name="btnVerHorario">Ver horario</button>
        </form>
    </p>
    <?php
    if (isset($_POST['btnVerHorario']) || isset($_POST['btnEditar'])) {
        ?>

        <h1>Horario del profesor:
            <?php
            echo $_POST["profesor"];
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
                $url = DIR_SERV . "/horario/" . $_POST["profesor"];
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
                    $tramo;
                    echo " <td> ";
                    if ($i < 3) {
                        $tramo = $horas . ":15-" . ($horas + 1) . ":15";

                        echo $tramo;

                    } else if ($i == 3) {
                        $tramo = ($horas) . ":15-" . ($horas) . ":45";
                        echo $tramo;

                    } else {
                        $tramo = ($horas - 1) . ":45-" . ($horas) . ":45";
                        echo $tramo;

                    }

                    echo "</td>";
                    for ($j = 1; $j < 6; $j++) {
                        // echo " <td>";
                        if ($hor == 4) {
                            echo " <td>";

                            echo "recreo";
                            echo " </td>";


                        } else {
                            echo " <td>";

                            foreach ($obj->horario as $tuplas) {
                                if ($tuplas->dia == $j && $tuplas->hora == $hor) {
                                    echo $tuplas->nombre;
                                    // echo "<input type='hidden' name='id_grupo' value='" . $tuplas->id_grupo . "' />";
            
                                }

                            }
                            // echo "hora: ".$hor;
                            echo "<form method='post' action='index.php'>";
                            echo "<input type='hidden' name='profesor' value='" . $_POST["profesor"] . "' />";

                            echo "<input type='hidden' name='hora' value='" . $hor . "' />";
                            echo "<input type='hidden' name='dia' value='" . $j . "' />";

                            echo "<button type='submit' name='btnEditar' value='" . $tramo . "'>Editar</button>";
                            echo "</form>";
                            // echo "dia: ".$j;
                            echo "</td>";
                        }

                    }
                    $horas++;
                    $hor++;
                    echo "</tr>";
                }


                ?>

        </table>

        <?php

        if (isset($_POST["btnEditar"])) {
            $diaSemana;
            switch ($_POST["dia"]) {
                case '1':
                    $diaSemana = "Lunes";
                    break;

                case '2':
                    $diaSemana = "Martes";
                    break;
                case '3':
                    $diaSemana = "Miercoles";
                    break;
                case '4':
                    $diaSemana = "Jueves";
                    break;
                case '5':
                    $diaSemana = "Viernes";
                    break;

            }
            echo "<h2>Editando la " . $_POST["hora"] . " hora (" . $_POST["btnEditar"] . ") del  " . $diaSemana . " dia" . $_POST["dia"] . " con id_usuario: " . $_POST["profesor"] . "</h2>";
            $url = DIR_SERV . "/grupos/" . $_POST["dia"] . "/" . $_POST["hora"] . "/" . $_POST["profesor"];
            $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
            $obj2 = json_decode($respuesta);
            if (!$obj2) {
                consumir_servicios_REST("/salir", "POST", $_SESSION["api_session"]);
                session_destroy();
                die("<p>Error consumir servicios" . $url . "</p></body></html>");
            }
            if (isset($obj2->error)) {
                //consu8mir salir
                consumir_servicios_REST("/salir", "POST", $_SESSION["api_session"]);

                //cambiar error page por p
                session_destroy();
                die(error_page("ERROR", "Error en la BD" . $obj2->error));

            }

            if (isset($obj3->no_auth)) {
                session_unset();
                $_SESSION["seguridad"] = "sesion expirada";
                header("Location:index.php");
                exit();
            }
            // foreach ($obj2->grupos as $tuplas) {
            //     echo "1.- ".$tuplas->id_grupo;
            // }
            echo "<table>";
            echo "<tr>";
            echo "<th>Grupo</th><th>Acción</th>";
            echo "</tr>";

            foreach ($obj2->grupos as $tuplas) {
                echo "<tr>";
                echo "<td>";

                echo $tuplas->nombre;
                echo "</td>";
                echo "<td>";
                echo "<form method='post' action='index.php'>";
                echo "<input type='hidden' name='profesor' value='" . $_POST["profesor"] . "' />";
                echo "<input type='hidden' name='hora' value='" . $_POST["hora"] . "' />";
                echo "<input type='hidden' name='dia' value='" . $_POST["dia"] . "' />";
                // echo "<input type='hidden' name='btnVerHorario' value='" . $_POST["btnVerHorario"] . "' />";
                echo "<input type='hidden' name='btnEditar' value='" . $_POST["btnEditar"] . "' />";
                echo "<button type='submit' name='btnQuitarGrupo' value='$tuplas->id_grupo'>Quitar</button>";

                echo "</td>";

                echo "</tr>";
            }

            echo "</table>";
            $url = DIR_SERV . "/gruposLibres/" . $_POST["dia"] . "/" . $_POST["hora"] . "/" . $_POST["profesor"];

            $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
            $obj3 = json_decode($respuesta);
            if (!$obj3) {
                consumir_servicios_REST("/salir", "POST", $_SESSION["api_session"]);
                session_destroy();
                die("<p>Error consumir servicios" . $url . "</p></body></html>");
            }
            if (isset($obj3->error)) {
                consumir_servicios_REST("/salir", "POST", $_SESSION["api_session"]);
                //cambiar error page por p
                session_destroy();
                die(error_page("ERROR", "Error en la BD" . $obj3->error));

            }

            if (isset($obj3->no_auth)) {
                session_unset();
                $_SESSION["seguridad"] = "sesion expirada";
                header("Location:index.php");
                exit();
            }
            echo "<form method='post' action='index.php'>";
            echo "<input type='hidden' name='profesor' value='" . $_POST["profesor"] . "' />";
            echo "<input type='hidden' name='hora' value='" . $_POST["hora"] . "' />";
            echo "<input type='hidden' name='dia' value='" . $_POST["dia"] . "' />";
            // echo "<input type='hidden' name='btnVerHorario' value='" . $_POST["btnVerHorario"] . "' />";
            // echo "<input type='hidden' name='btnEditar' value='" . $_POST["btnEditar"] . "' />";
            echo "<select name='grupo' id='grupo'>";
            foreach ($obj3->grupos_libres as $tuplas) {
                echo "<option value='" . $tuplas->id_grupo . "'>" . $tuplas->nombre . "</option>";
            }
            echo "</select>";
            ?>
            <button type="submit" name="btnInsertarGrupo">Añadir</button>
            </form>
            <?php
        }
    }
    if (isset($_SESSION["mensaje_accion"])) {
        echo "Hay un mensaje: " . $_SESSION["mensaje_accion"];
        unset($_SESSION["mensaje_accion"]);

    }
    if (isset($_SESSION["depu"])) {
        echo "Hay un mensaje: " . var_dump($_SESSION["depu"]);
        unset($_SESSION["depu"]);

    }
    if (isset($_SESSION["seguridad"])) {
        echo "Hay un mensaje de seguridad: " . $_SESSION["seguridad"];
        unset($_SESSION["seguridad"]);
    }
    ?>

</body>

</html>