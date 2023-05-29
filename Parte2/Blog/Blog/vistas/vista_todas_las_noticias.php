<?php



$url = DIR_SERV . "/noticias";



$respuesta = consumir_servicios_REST($url, "GET");

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


}
foreach ($obj->noticia as $tupla) {
    echo "<form class='enlinea' action='index.php' method='post'>";
    echo "<button name='btnVerNoticia' value='".$tupla->idNoticia."' class='enlace'>".$tupla->titulo."</button></form>";
    echo "<p>" . $tupla->copete . "</p>";
 
    }

  





?>