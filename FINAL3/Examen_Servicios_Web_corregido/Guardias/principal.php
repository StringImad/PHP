<?php
session_name("examen_final");
session_start();

require "src/funciones.php";

if (isset($_POST["btnSalir"])) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
    session_destroy();
    header("Location:index.php");
    exit;
}

if (isset($_SESSION["usuario"])) {

    require "src/seguridad.php";

    $url = DIR_SERV . "/guardiasUsuario/".$datos_usu_log->id_usuario;

    $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);

    $obj = json_decode($respuesta);

    if (!$obj) {
        session_destroy();
        die(error_page("error", "Error consumiendo el servicio: ", $url));
    }
    if (isset($obj->error)) {
        session_destroy();
        die(error_page("error", "Error de la BD: ", $obj->error));
    }

    if (isset($obj->mensaje)) {
        session_destroy();
        die(error_page("error", "Error no hay guardias: ", $obj->mensaje));
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
                width: 100%;
                border-collapse: collapse;
                text-align: center;
                margin: 0 auto;
            }

            th {
                background-color: #ccc;
            }
 
            tr,
            td,
            th {
                border: 1px solid black;

            }
        </style>
    </head>

    <body>

        <h1>GESTION DE GUARDIAS</h1>
        <div>
            Bienvenidoo: <strong><?php
                                   echo $datos_usu_log->usuario; ?></strong>
            <form method="post" action="principal.php">
                <button type="submit" name="btnSalir">Salir</button>
            </form>

            <h2>Equipos de Guardia del IES Mar De alboran</h2>
            <?php

            echo "<table class='tabla'>";
            echo "<tr>";
            echo "<th></th><th>Lunes</th><th>Martes</th><th>Miercoles</th><th>Jueves</th><th>Viernes</th>";
            echo "</tr>";
            $hora = 1;
            $m = 1;
            for ($i = 0; $i < 7; $i++) {
                echo "<tr>";
                $dia = 1;

                if ($i == 3) {
                    echo "<td colspan=6>Recreo</td>";
                } else {
                    echo "<td>" . $hora . "Hora</td>";

                    for ($j = 0; $j < 5; $j++) {

                        echo "<td>";
                        foreach ($obj->guardias as $tuplas) {
                            if ($tuplas->hora == $hora && $tuplas->dia == $dia) {
                                echo " <form action='principal.php' method='post'>
                                        <input type='hidden' name='dia' value='" . $dia . "' />
                                        <input type='hidden' name='hora' value='" . $hora . "' />
        
                                       <button type='submit' name='btnVerEquipo' value ='" . $m . "'>" . $dia . "Equipo</button>
                                       </form>";
                            }
                        }
                        echo "</td>";

                        $dia++;
                        $m++;
                    }
                    $hora++;
                }

                echo "</tr>";
            }
            echo "</table>";
            if (isset($_POST["btnVerEquipo"]) || isset($_POST["btnVerProfesor"])) {
                echo "<h1>Equipo de guardia: " . $_POST["btnVerEquipo"] . "</h1>";

                $url = DIR_SERV . "/usuariosGuardia/" . $_POST["dia"] . "/" . $_POST["hora"];

                $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);

                $obj = json_decode($respuesta);

                if (!$obj) {
                    session_destroy();
                    die(error_page("error", "Error consumiendo el servicio: ", $url));
                }
                if (isset($obj->error)) {
                    session_destroy();
                    die(error_page("error", "Error de la BD: ", $obj->error));
                }

                if (isset($obj->mensaje)) {
                    session_destroy();
                    die(error_page("error", "Error no hay guardias: ", $obj->mensaje));
                }

                foreach ($obj->usuarios as $tuplas) {
                    echo "<form action='principal.php' method='post'>";
                    echo "   <input type='hidden' name='dia' value='" . $_POST['dia'] . "' />";
                    echo "   <input type='hidden' name='hora' value='" . $_POST['hora'] . "' />";
                    echo "   <input type='hidden' name='btnVerEquipo' value='" . $_POST['btnVerEquipo'] . "' />";

                    echo "<button type='submit' name='btnVerProfesor' value='" . $tuplas->id_usuario . "'>";
                    echo $tuplas->nombre;
                    echo "</button>";
                    echo "</form>";
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

                    echo "<h1>Informacion del profesor</h1>";
                    echo "Nombre: " . $obj2->usuario->nombre;
                    echo "</br>usuario: " . $obj2->usuario->usuario;
                }
            }
            ?>
        </div>
    </body>

    </html>
<?php
} else {
    header("Location:index.php");
    exit;
}

?>