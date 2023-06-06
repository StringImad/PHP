<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Guardias</title>
    <style>
        .enlinea{display:inline}
        .enlace{border:none;background:none;color:blue;text-decoration:underline;cursor:pointer}
        #tabla_equipos {border-collapse:collapse;width:90%;margin:0 auto;text-align:center}
        #tabla_equipos,#tabla_equipos td, #tabla_equipos th{border:1px solid black}
        #tabla_equipos th{background-color:#CCC}
        #tabla_prof {border-collapse:collapse}
        #tabla_prof,#tabla_prof td, #tabla_prof th{border:1px solid black}
        #tabla_prof th{background-color:#CCC}
    </style>
</head>
<body>
<h1>Gestión de Guardias</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log->usuario;?></strong> - 
        <form class="enlinea" action="index.php" method="post"> 
            <button name="btnSalir" class="enlace">Salir</button>
        </form>
    </div>
    <?php

    $dias_semana[0]="";
    $dias_semana[1]="Lunes";
    $dias_semana[2]="Martes";
    $dias_semana[3]="Miércoles";
    $dias_semana[4]="Jueves";
    $dias_semana[5]="Viernes";

    echo "<h2>Equipos de Guardias del IES Mar de Alborán</h2>";
    echo "<table id='tabla_equipos'>";
    echo "<tr>";
    for($i=0;$i<=5;$i++)
        echo "<th>".$dias_semana[$i]."</th>";
   
    echo "</tr>";
    $cont=1;
    for($horas=1; $horas<=7; $horas++)
    {
        echo "<tr>";
            
            if($horas==4)
            {
                echo "<td colspan='6'>RECREO</td>";
            }
            else
            {
                if($horas<=3)
                    echo "<td>".$horas."º Hora"."</td>";
                else
                    echo "<td>".($horas-1)."º Hora"."</td>";
                for($dias=1;$dias<=5;$dias++)
                {
                    echo "<td>";
                    echo "<form action='index.php' method='post'>";
                    echo "<input type='hidden' name='dia' value='".$dias."'/>";
                    echo "<input type='hidden' name='hora' value='".$horas."'/>";
                    echo "<input type='hidden' name='equipo' value='".$cont."'/>";
                    echo "<button class='enlace' name='btnVerEquipo'>Equipo ".$cont."</button>";
                    echo "</form>";
                    echo "</td>";
                    $cont++;
                }
            }
            
        echo "</tr>";
    }

    echo "</table>";

    if(isset($_POST["btnVerEquipo"])||isset($_POST["btnVerUsuario"]))
    {
        echo "<h1>EQUIPO DE GUARDIA ".$_POST["equipo"]."</h1>";
        
        
        $url=DIR_SERV."/deGuardia/".$_POST["dia"]."/".$_POST["hora"]."/".$datos_usu_log->id_usuario;
        $respuesta=consumir_servicios_REST($url,"GET",$_SESSION["api_session"]);
        $obj=json_decode($respuesta);
        if(!$obj)
        {
            consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
            session_destroy();
            die(error_page("Gestión de Guardias","Gestión de Guardias","Error consumiendo el servicio: ".$url));
        }
        if(isset($obj->error))
        {
            consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
            session_destroy();
            die(error_page("Gestión de Guardias","Gestión de Guardias",$obj->error));
        }
        
        if(isset($obj->no_auth))
        {
            session_unset();
            $_SESSION["seguridad"]="El tiempo de sesión de la API ha expirado";
            header("Location:index.php");
            exit;
        }
        if($obj->de_guardia)
        {
            if($_POST["hora"]<=3)
                echo "<h2>".$dias_semana[$_POST["dia"]]." ".$_POST["hora"]."º hora</h2>";
            else
                echo "<h2>".$dias_semana[$_POST["dia"]]." ".($_POST["hora"]-1)."º hora</h2>";

            $url=DIR_SERV."/usuariosGuardia/".$_POST["dia"]."/".$_POST["hora"];
            $respuesta=consumir_servicios_REST($url,"GET",$_SESSION["api_session"]);
            $obj=json_decode($respuesta);
            if(!$obj)
            {
                consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
                session_destroy();
                die(error_page("Gestión de Guardias","Gestión de Guardias","Error consumiendo el servicio: ".$url));
            }
            if(isset($obj->error))
            {
                consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
                session_destroy();
                die(error_page("Gestión de Guardias","Gestión de Guardias",$obj->error));
            }
            
            if(isset($obj->no_auth))
            {
                session_unset();
                $_SESSION["seguridad"]="El tiempo de sesión de la API ha expirado";
                header("Location:index.php");
                exit;
            }

            if(isset($_POST["btnVerUsuario"]))
            {
                $url=DIR_SERV."/usuario/".$_POST["btnVerUsuario"];
                $respuesta=consumir_servicios_REST($url,"GET",$_SESSION["api_session"]);
                $obj2=json_decode($respuesta);
                if(!$obj2)
                {
                    consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
                    session_destroy();
                    die(error_page("Gestión de Guardias","Gestión de Guardias","Error consumiendo el servicio: ".$url));
                }
                if(isset($obj2->error))
                {
                    consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
                    session_destroy();
                    die(error_page("Gestión de Guardias","Gestión de Guardias",$obj2->error));
                }
                
                if(isset($obj2->no_auth))
                {
                    session_unset();
                    $_SESSION["seguridad"]="El tiempo de sesión de la API ha expirado";
                    header("Location:index.php");
                    exit;
                }

            }



            echo "<table id='tabla_prof'>";
            echo "<tr>";
            echo "<th>Profesores de Guardia</th>";
            echo "<th>Información del Profesor con Id: ";
            if(isset($_POST["btnVerUsuario"]))
                echo $_POST["btnVerUsuario"];
            echo "</th>";
            echo "</tr>";
            $primera_fila=true;
            foreach($obj->usuarios as $tupla)
            {
                if($primera_fila)
                {
                    echo "<tr>";
                    echo "<td>";
                    echo "<form action='index.php' method='post'>";
                    echo "<input type='hidden' name='dia' value='".$_POST["dia"]."'/>";
                    echo "<input type='hidden' name='hora' value='".$_POST["hora"]."'/>";
                    echo "<input type='hidden' name='equipo' value='".$_POST["equipo"]."'/>";
                    echo "<button class='enlace' name='btnVerUsuario' value='".$tupla->id_usuario."'>".$tupla->nombre."</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "<td rowspan='".count($obj->usuarios)."'>";
                    if(isset($_POST["btnVerUsuario"]))
                    {
                        if(isset($obj2->mensaje))
                        {
                            echo "El usuario seleccionado ya no se encuentra en la BD";
                        }
                        else
                        {
                            echo "<strong>Nombre: </strong>".$obj2->usuario->nombre."<br/>";
                            echo "<strong>Usuario: </strong>".$obj2->usuario->usuario."<br/>";
                            echo "<strong>Contraseña:</strong><br/>";
                            if(isset($obj2->usuario->email))
                                echo "<strong>Email: </strong>".$obj2->usuario->email;
                            else
                                echo "<strong>Email: </strong>Email no disponible";
                        }
                    }
                    echo "</td>";
                    echo "</tr>";
                    $primera_fila=false;
                }
                else
                {
                    echo "<tr>";
                    echo "<td>";
                    echo "<form action='index.php' method='post'>";
                    echo "<input type='hidden' name='dia' value='".$_POST["dia"]."'/>";
                    echo "<input type='hidden' name='hora' value='".$_POST["hora"]."'/>";
                    echo "<input type='hidden' name='equipo' value='".$_POST["equipo"]."'/>";
                    echo "<button class='enlace' name='btnVerUsuario' value='".$tupla->id_usuario."'>".$tupla->nombre."</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
            echo "</table>";

        }
        else
        {
            if($_POST["hora"]<=3)
                echo "<p>Usted no se encuentra de guardia el ".$dias_semana[$_POST["dia"]]." ".$_POST["hora"]."º hora</p>";
            else
                echo "<p>Usted no se encuentra de guardia el ".$dias_semana[$_POST["dia"]]." ".($_POST["hora"]-1)."º hora</p>";
        }
            

    }
    ?>
</body>
</html>