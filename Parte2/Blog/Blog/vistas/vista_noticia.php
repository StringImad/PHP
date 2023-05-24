<?php

$url=DIR_SERV."/noticia/".$_POST["btnVerNoticia"];

// $datos_env["api_session"]=$_SESSION["api_session"];


$respuesta = consumir_servicios_REST($url, "GET",$_SESSION["api_session"]);

$obj = json_decode($respuesta);
echo $obj;

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
if (isset($obj->mensaje)) {
echo "+++++++++++++";
}else{echo "<table id='tabla_principal'>";
echo "<tr>";
echo "<th>ID</th><th>Comentarios</th><th>Opción</th>";
echo "</tr>";
foreach ($obj->noticia as $tupla) {
        echo "<tr>";
        echo "<td>" . $tupla->idNoticia . "</td>";
      

      
                    echo "</tr>";
}
echo "</table>";}


?>