<?php
if(isset($_POST["btnQuitar"]))
{
    $url=DIR_SERV."/borrarGrupo/".$_POST["dia"]."/".$_POST["hora"]."/".$_POST["profesor"]."/".$_POST["btnQuitar"];
    $respuesta=consumir_servicios_REST($url,"DELETE",$_SESSION["api_session"]);
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        $url=DIR_SERV."/salir";
        consumir_servicios_REST($url,"POST",$_SESSION["api_session"]);
        session_destroy();
        die("<p>Error consumiendo el servicio: ".$url."</p>".$respuesta."</body></html>");
    }
    if(isset($obj->error))
    {
        $url=DIR_SERV."/salir";
        consumir_servicios_REST($url,"POST",$_SESSION["api_session"]);
        session_destroy();
        die("<p>".$obj->error."</p></body></html>");
    }
    if(isset($obj->no_login))
    {
        session_unset();
        $_SESSION["seguridad"]="El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }
    $_SESSION["accion"]=$obj->mensaje;
    $_SESSION["profesor"]=$_POST["profesor"];
    $_SESSION["dia"]=$_POST["dia"];
    $_SESSION["hora"]=$_POST["hora"];
    header("Location:index.php");
    exit;
}

if(isset($_POST["btnAgregar"]))
{
    $url=DIR_SERV."/insertarGrupo/".$_POST["dia"]."/".$_POST["hora"]."/".$_POST["profesor"]."/".$_POST["grupo"];
    $respuesta=consumir_servicios_REST($url,"POST",$_SESSION["api_session"]);
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        $url=DIR_SERV."/salir";
        consumir_servicios_REST($url,"POST",$_SESSION["api_session"]);
        session_destroy();
        die("<p>Error consumiendo el servicio: ".$url."</p>".$respuesta."</body></html>");
    }
    if(isset($obj->error))
    {
        $url=DIR_SERV."/salir";
        consumir_servicios_REST($url,"POST",$_SESSION["api_session"]);
        session_destroy();
        die("<p>".$obj->error."</p></body></html>");
    }
    if(isset($obj->no_login))
    {
        session_unset();
        $_SESSION["seguridad"]="El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }
    $_SESSION["accion"]=$obj->mensaje;
    $_SESSION["profesor"]=$_POST["profesor"];
    $_SESSION["dia"]=$_POST["dia"];
    $_SESSION["hora"]=$_POST["hora"];
    header("Location:index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen4 PHP</title>
    <style>
        .enlace{border:none;background:none;text-decoration:underline;color:blue;cursor:pointer}
        .enlinea{display:inline}
        table,th,td{border:1px solid black}
        table{text-align:center;border-collapse:collapse}
        th{background-color:#CCC}
    </style>
</head>
<body>

    <h1>Examen4 PHP</h1>
    <div>
        Bienvenido <strong><?php echo $_SESSION["usuario"];?></strong> - <form class="enlinea" method="post" action="index.php"><button class="enlace" name="btnCerrarSesion">Salir</button></form>
    </div>
    <?php
        



        $url=DIR_SERV."/usuarios";
        $respuesta=consumir_servicios_REST($url,"GET",$_SESSION["api_session"]);
        $obj=json_decode($respuesta);
        if(!$obj)
        {
            $url=DIR_SERV."/salir";
            consumir_servicios_REST($url,"POST",$_SESSION["api_session"]);
            session_destroy();
            die("<p>Error consumiendo el servicio: ".$url."</p>".$respuesta."</body></html>");
            
        }
        if(isset($obj->error))
        {
            $url=DIR_SERV."/salir";
            consumir_servicios_REST($url,"POST",$_SESSION["api_session"]);
            session_destroy();
            die("<p>".$obj->error."</p></body></html>");
            
        }
        if(isset($obj->no_login))
        {
            session_destroy();
            die("<p>El tiempo de sesión de la API ha expirado. Vuelva a loguearse</p></body></html>");
            
        }
    ?>
        <form action="index.php" method="post">
            <p>
                <label for="profesor">Seleccione profesor:</label>
                <select id="profesor" name="profesor">
                <?php
                foreach($obj->usuarios as $tupla)
                {
                    if((isset($_POST["profesor"]) && $_POST["profesor"]==$tupla->id_usuario)||isset($_SESSION["profesor"]) && $_SESSION["profesor"]==$tupla->id_usuario)
                    {
                        echo "<option selected value='".$tupla->id_usuario."'>".$tupla->nombre."</option>";
                        $nombre_profesor=$tupla->nombre;
                    }
                    else
                        echo "<option value='".$tupla->id_usuario."'>".$tupla->nombre."</option>";
                }
                ?>
                </select>
                <button type="submit" name="btnVerHorario">Ver Horario</button>
            </p>
        </form>
        <?php
            if(isset($_POST["profesor"])||isset($_SESSION["profesor"]))
            {
                if(isset($_SESSION["profesor"]))
                {
                    $profesor=$_SESSION["profesor"];
                    unset($_SESSION["profesor"]);
                }
                else
                    $profesor=$_POST["profesor"];
                


                $url=DIR_SERV."/horario/".$profesor;
                $respuesta=consumir_servicios_REST($url,"GET",$_SESSION["api_session"]);
                $obj=json_decode($respuesta);
                if(!$obj)
                {
                    $url=DIR_SERV."/salir";
                    consumir_servicios_REST($url,"POST",$_SESSION["api_session"]);
                    session_destroy();
                    die("<p>Error consumiendo el servicio: ".$url."</p>".$respuesta."</body></html>");
                }
                if(isset($obj->error))
                {
                    $url=DIR_SERV."/salir";
                    consumir_servicios_REST($url,"POST",$_SESSION["api_session"]);
                    session_destroy();
                    die("<p>".$obj->error."</p></body></html>");
                }
                if(isset($obj->no_login))
                {
                    session_destroy();
                    die("<p>El tiempo de sesión de la API ha expirado. Vuelva a loguearse</p></body></html>");
                }

                foreach($obj->horario as $tupla)
                {
                    if(isset($horario[$tupla->dia][$tupla->hora]))
                        $horario[$tupla->dia][$tupla->hora].="/".$tupla->nombre;
                    else
                        $horario[$tupla->dia][$tupla->hora]=$tupla->nombre;
                }

                
                $horas[1]="8:15 - 9:15";
                $horas[2]="9:15 - 10:15";
                $horas[3]="10:15 - 11:15";
                $horas[4]="11:15 - 11:45";
                $horas[5]="11:45 - 12:45";
                $horas[6]="12:45 - 13:45";
                $horas[7]="13:45 - 14:45";

                $dias[1]="Lunes";
                $dias[2]="Martes";
                $dias[3]="Miércoles";
                $dias[4]="Jueves";
                $dias[5]="Viernes";

                echo "<h3>Horario del Profesor: ".$nombre_profesor."</h3>";
                echo "<table>";
                echo "<tr>";
                echo "<th></th>";
                for($i=1;$i<=5;$i++)
                    echo "<th>".$dias[$i]."</th>";
                echo "</tr>";
                for($hora=1;$hora<=7;$hora++)
                {
                    echo "<tr>";
                    echo "<th>".$horas[$hora]."</th>";
                    if($hora==4)
                    {
                        echo "<td colspan='5'>RECREO</td>";
                    }
                    else
                    {
                        for($dia=1;$dia<=5;$dia++)
                        {
                            if(isset($horario[$dia][$hora]))
                                echo "<td>".$horario[$dia][$hora];
                            else
                                echo "<td>";

                            echo "<form action='index.php' method='post'>";
                            echo "<input type='hidden' name='hora' value='".$hora."'/>";
                            echo "<input type='hidden' name='dia' value='".$dia."'/>";
                            echo "<input type='hidden' name='profesor' value='".$profesor."'/>";
                            echo "<button class='enlace' type='submit' name='btnEditar'>Editar</button>";
                            echo "</form>";
                            echo "</td>";
                            
                        }
                    }
                    echo "</tr>";
                }
                echo "</table>";

                if(isset($_POST["btnEditar"])||isset($_POST["btnQuitar"])||isset($_SESSION["dia"]))
                {
                    if(isset($_SESSION["dia"]))
                    {
                        $dia=$_SESSION["dia"];
                        $hora=$_SESSION["hora"];
                        unset($_SESSION["dia"]);
                        unset($_SESSION["hora"]);
                    }
                    else
                    {
                        $dia=$_POST["dia"];
                        $hora=$_POST["hora"];
                    }

                    if($hora<=3)
                        echo "<h2>Editando la ".$hora."º hora (".$horas[$hora].") del ".$dias[$dia]."</h2>";
                    else
                        echo "<h2>Editando la ".($hora-1)."º hora (".$horas[$hora].") del ".$dias[$dia]."</h2>";
                
                    
                    $url=DIR_SERV."/grupos/".$dia."/".$hora."/".$profesor;
                    $respuesta=consumir_servicios_REST($url,"GET",$_SESSION["api_session"]);
                    $obj=json_decode($respuesta);
                    if(!$obj)
                    {
                        $url=DIR_SERV."/salir";
                        consumir_servicios_REST($url,"POST",$_SESSION["api_session"]);
                        session_destroy();
                        die("<p>Error consumiendo el servicio: ".$url."</p>".$respuesta."</body></html>");
                    }
                    if(isset($obj->error))
                    {
                        $url=DIR_SERV."/salir";
                        consumir_servicios_REST($url,"POST",$_SESSION["api_session"]);
                        session_destroy();
                        die("<p>".$obj->error."</p></body></html>");
                    }
                    if(isset($obj->no_login))
                    {
                        session_destroy();
                        die("<p>El tiempo de sesión de la API ha expirado. Vuelva a loguearse</p></body></html>");
                    }
                    
                    echo "<table>";
                    echo "<tr><th>Grupos</th><th>Acción</th></tr>";
                    foreach($obj->grupos as $tupla)
                    {
                        echo "<tr>";
                        echo "<td>".$tupla->nombre."</td>";
                        echo "<td>";
                        echo "<form action='index.php' method='post'>";
                        echo "<input type='hidden' name='hora' value='".$hora."'/>";
                        echo "<input type='hidden' name='dia' value='".$dia."'/>";
                        echo "<input type='hidden' name='profesor' value='".$profesor."'/>";
                        echo "<button class='enlace' type='submit' value='".$tupla->id_grupo."' name='btnQuitar'>Quitar</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    if(isset($_SESSION["accion"]))
                    {
                        echo "<p class='mensaje'>".$_SESSION["accion"]."</p>";
                        unset($_SESSION["accion"]);
                    }

                    $url=DIR_SERV."/gruposLibres/".$dia."/".$hora."/".$profesor;
                    $respuesta=consumir_servicios_REST($url,"GET",$_SESSION["api_session"]);
                    $obj=json_decode($respuesta);
                    if(!$obj)
                    {
                        $url=DIR_SERV."/salir";
                        consumir_servicios_REST($url,"POST",$_SESSION["api_session"]);
                        session_destroy();
                        die("<p>Error consumiendo el servicio: ".$url."</p>".$respuesta."</body></html>");
                    }
                    if(isset($obj->error))
                    {
                        $url=DIR_SERV."/salir";
                        consumir_servicios_REST($url,"POST",$_SESSION["api_session"]);
                        session_destroy();
                        die("<p>".$obj->error."</p></body></html>");
                    }
                    if(isset($obj->no_login))
                    {
                        session_destroy();
                        die("<p>El tiempo de sesión de la API ha expirado. Vuelva a loguearse</p></body></html>");
                    }

                    echo "<br/><br/>";
                    if(count($obj->grupos_libres)>0)
                    {
                        echo "<form action='index.php' method='post'>";
                        echo "<input type='hidden' name='hora' value='".$hora."'/>";
                        echo "<input type='hidden' name='dia' value='".$dia."'/>";
                        echo "<input type='hidden' name='profesor' value='".$profesor."'/>";
                        echo "<select name='grupo'>";
                        foreach($obj->grupos_libres as $tupla)
                        {
                            echo "<option value='".$tupla->id_grupo."'>".$tupla->nombre."</option>";
                        }
                        echo "</select>";
                        echo "<button type='submit' name='btnAgregar'>Añadir</button>";
                        echo "</form>";
                    }

                }

            }
        ?>
</body>
</html>