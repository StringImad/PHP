<?php
if(isset($_POST["btnBorrar"]))
{
    
    $url=DIR_SERV."/borrar_comentario/".$_POST["btnBorrar"];
    $respuesta=consumir_servicios_REST($url,"DELETE");
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        session_destroy();
        die(error_page("Práctica 3 - SW","Práctica 3 - SW","Error consumiendo el servicio: ".$url));
    }
    if(isset($obj->mensaje_error))
    {
        session_destroy();
        die(error_page("Práctica 3 - SW","Práctica 3 - SW",$obj->mensaje_error));
    } 
    
   
    
    $_SESSION["accion"]="El comentario ha sido borrado con éxito";
   
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Exam</title>
    <style>
        .enlinea{display:inline}
        .enlace{border:none;background:none;color:blue;text-decoration:underline;cursor:pointer}
        #tabla_principal, #tabla_principal td, #tabla_principal th{border:1px solid black}
        #tabla_principal{width:90%; border-collapse:collapse;text-align:center;margin:0 auto}
        #tabla_principal th{background-color:#CCC}
        #tabla_principal img{height:75px}
    </style>
</head>

<body>
    <h1>GESTION DE COMENTARIOS</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log->usuario; ?></strong> -
        <form class="enlinea" action="gest_comentarios.php" method="post">
            <button name="btnSalir" class="enlace">Salir</button>
        </form>
    </div>
    <h2>Todos los comentarios</h2>

    <?php

    $url = DIR_SERV . "/obtener_comentarios";

    $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
    $obj = json_decode($respuesta);
    if (!$obj) {
        session_destroy();
        die("<p>Error consumiendo el servicio: " . $url . "</p></body></html>");
    }
    if (isset($obj->mensaje_error)) {
        session_destroy();
        die("<p>" . $obj->mensaje_error . "</p></body></html>");
    }

    if (isset($obj->no_login)) {
        session_destroy();
        die("<p> El tiempo de session de la API ha expirado  vuelve a loguerarse</p></body></html>");

        session_unset();
        $_SESSION["seguridad"] = "El tiempo de session de la API ha expirado";
        header("Location:index.php");
        exit;
    }
    echo "<table id='tabla_principal'>";
    echo "<tr>";
    echo "<th>ID</th><th>Comentarios</th><th>Opción</th>";
    echo "</tr>";
    foreach ($obj->comentarios as $tupla) {
            echo "<tr>";
            echo "<td>" . $tupla->idComentario . "</td>";
            echo "<td>".$tupla->comentario . "</br> Dijo ".$tupla->usuario." en <a href=''>".$tupla->titulo."</a></td>";
            echo "<td><form action='gest_comentarios.php' method='post'>";

            if ($tupla->estado == "apto") {
                echo "<button class='enlace' value='" . $tupla->idComentario . "' name='btnAprobar'>Aprobar</button> - ";
            }
            
            echo "<button class='enlace' value='" . $tupla->idComentario . "' name='btnBorrar'>Borrar</button></form></td>";
                        echo "</tr>";
    }
    echo "</table>";
    ?>


</body>

</html>