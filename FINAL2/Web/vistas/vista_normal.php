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
        Bienvenido <strong><?php echo $datos_usuario_log->usuario;?></strong> - <form class="enlinea" method="post" action="index.php"><button class="enlace" name="btnCerrarSesion">Salir</button></form>
    </div>
    <h2>Su horario</h2>
    <?php
        $url=DIR_SERV."/horario/".$datos_usuario_log->id_usuario;
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
        echo "<h3>Horario del Profesor: ".$datos_usuario_log->nombre."</h3>";
        echo "<table>";
        echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";
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
                        echo "<td>".$horario[$dia][$hora]."</td>";
                    else
                        echo "<td></td>";
                    
                }
            }
            echo "</tr>";
        }
        echo "</table>";
    ?>
</body>
</html>