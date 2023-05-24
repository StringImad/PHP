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
        echo "<td>".$tupla->comentario . "</br> Dijo ".$tupla->usuario." en <form action='gest_comentarios.php' method='post'>
        <button value='" . $tupla->idNoticia . " class='enlace' name='btnVerNoticia'>".$tupla->titulo."</button></form></td>";
        echo "<td><form action='gest_comentarios.php' method='post'>";

        if ($tupla->estado == "apto") {
            echo "<button class='enlace' value='" . $tupla->idComentario . "' name='btnAprobar'>Aprobar</button> - ";
        }
        
        echo "<button class='enlace' value='" . $tupla->idComentario . "' name='btnBorrar'>Borrar</button></form></td>";
                    echo "</tr>";
}
echo "</table>";


?>