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
            <?php echo $datos_usu_log->usuario;

            ?>
        </strong>
        <form class='enlinea' method="post" action="index.php">
            <button class='enlace' type="submit" name="btnSalir">Salir</button>
        </form>
    </div>
    <?php
    if (isset($_SESSION["seguridad"])) {
        echo "<p>" . $_SESSION['seguridad'] . "</p>";
    }
    ?>
    <h1>Equipos de Guardia IES Mar de Alborán</h1>
    <?php
    $hora = 1;
    $num = 1;
    echo "<table class='tabla'>";
    echo "<tr>";
    echo "<th></th><th>Lunes</th><th>Martes</th><th>Miercoles</th><th>Jueves</th><th>Viernes</th>";
    echo "</tr>";
    for ($i = 1; $i < 8; $i++) {
        $dia = 1;

        echo "<tr>";
        if ($i == 4) {
            echo "<td colspan=6> Recreo</td>";

        } else {

            echo "<td>" . $hora . "º Hora</td>";
            for ($j = 0; $j < 5; $j++) {

                echo "<td> <form class='enlinea' method='post' action='index.php'>
                <input type='hidden' name='dia' value='" . $dia . "' />
                <input type='hidden' name='hora' value='" . $hora . "' />

                <input type='hidden' name='num' value='" . $num . "' />

                <button class='enlace' type='submit' name='btnVerEquipo'>".$dia. " Equipo " . $num . "</button>
            </form></td>";
                $num++;
                $dia++;

            }
            $hora++;
        }




        echo "</tr>";

    }
    echo "</table>";
 
    if (isset($_POST["btnVerEquipo"]) || isset($_POST["btnVerProfesor"])) {
        $diaSemana;
        switch ($_POST["dia"]) {
            case 1:
                $diaSemana = "Lunes";
                break;
            case 2:
                $diaSemana = "Martes";
                break;
            case 3:
                $diaSemana = "Miercoles";
                break;
            case 4:
                $diaSemana = "Jueves";
                break;
            case 5:
                $diaSemana = "Viernes";
                break;
    
        }
        echo "<h2>Equipos de Guardia: " . $_POST["num"] . "</h2>";
        $url = DIR_SERV . "/deGuardia/" . $_POST["dia"] . "/" . $_POST["hora"] . "/" . $datos_usu_log->id_usuario;
        // $datos_guar["dia"] = $_POST["dia"];
        // $datos_guar["hora"] = $_POST["hora"];
        // $datos_guar["id_usuario"] = $datos_usu_log->id_usuario;
        // $datos_guar["api_session"] = $_SESSION["api_session"];
    
        $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);

        $obj = json_decode($respuesta);

        if (!$obj) {
            consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);

            session_destroy();
            die(error_page("Error", "Error consumiendo el servicio:", $url));

        }
        if (isset($obj->error)) {
            die(error_page("Error", "Error de la bd:", $obj->error));

        }
      
        if ($obj->deGuardia) {
            $diaSemana;
            switch ($_POST["dia"]) {
                case 1:
                    $diaSemana = "Lunes";
                    break;
                case 2:
                    $diaSemana = "Martes";
                    break;
                case 3:
                    $diaSemana = "Miercoles";
                    break;
                case 4:
                    $diaSemana = "Jueves";
                    break;
                case 5:
                    $diaSemana = "Viernes";
                    break;
        
            }

            echo "<h3> " . $diaSemana . " a " . $_POST["hora"] . " hora</h3>";

            $url = DIR_SERV . "/usuariosGuardia/" . $_POST["dia"] . "/" . $_POST["hora"];


            $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);

            $obj = json_decode($respuesta);

            if (!$obj) {
                consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
                session_destroy();
                die(error_page("Error", "Error consumiendo el servicio: ", $url));
            }

            if (isset($obj->error)) {
                consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
                session_destroy();
                die(error_page("Error", "Error BD: ", $obj->error));
            }
            if (isset($obj->no_auth)) {
                session_unset();
                $_SESSION["seguridad"] = "No esta autorizado";
                header("Location:index.php");
                exit;
            }
        
            if (isset($_POST["btnVerProfesor"])) {
                $url = DIR_SERV . "/usuario/" . $_POST["btnVerProfesor"];
                $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);

                $obj2 = json_decode($respuesta);

                if (!$obj2) {
                    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
                    session_destroy();
                    die(error_page("error", "error consumiendo servicio: ", $url));
                }

                if(isset($obj2->error)) {
                    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
                    session_destroy();
                    die(error_page("error", "error BD: ", $obj2->error));
                }
                if(isset($obj2->no_auth)){
                    session_unset();
                    $_SESSION["seguridad"] = "no tienes authenticated";
                    header("Location:index.php");
                    exit;
                }
                if(isset($obj2->mensaje)){
                    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
                    session_destroy();
                    die(error_page("error", "error BD: ", $obj2->mensaje));
                }

            }
         
            foreach ($obj->usuarios as $tuplas) {
                # code...
                echo "<p> <form method='post' action='index.php'>
                <input type='hidden' name='dia' value='" . $_POST["dia"]. "' />
                <input type='hidden' name='hora' value='" . $_POST["hora"] . "' />

                <input type='hidden' name='num' value='" . $_POST["num"]. "' />
                <button type='submit' class='enlace' name='btnVerProfesor' value='" . $tuplas->usuario . "' >" . $tuplas->nombre . "
                </button>
                </form></p>";

            }
            echo "<th>Información del Profesor con Id:</br> ";

            if(isset($_POST["btnVerProfesor"])){
                echo "Nombre: ".$obj2->usuario->nombre;
                echo "</br>usuario: ".$obj2->usuario->usuario;

            }
        } else {
         
            echo "<h3>Usted no se encuentra de guardia el dia: " . $dia . " a " . $_POST["hora"] . " hora</h3>";

        }
    }
    ?>
</body>

</html>