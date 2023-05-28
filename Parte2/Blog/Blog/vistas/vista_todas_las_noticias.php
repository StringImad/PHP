<?php
if(isset($_POST["btnVerNoticia"])){
    $idnoticia = $_POST["btnVerNoticia"];
}



$url = DIR_SERV . "/noticias";

// $datos_env["api_session"]=$_SESSION["api_session"];


$respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);

$obj = json_decode($respuesta);
if (!$obj) {
    consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);

    session_destroy();
    
    die("<p>Error consumiendo el servicio: " . $url . "</p></body></html>");
}
if (isset($obj->mensaje_error)) {
    consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);

    session_destroy();
    die("<p>" . $obj->mensaje_error . "</p></body></html>");
}

if (isset($obj->no_login)) {
    consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);

    session_destroy();
    die("<p> El tiempo de session de la API ha expirado  vuelve a loguerarse</p></body></html>");


}
foreach ($obj->noticia as $tupla) {
    echo "<h2>" . $tupla->titulo . "</h2>";
    echo "<p>Publicado por <strong>" . $tupla->usuario . "</strong> en " . $tupla->valor . " el " . $tupla->fPublicacion . "</p>";
    echo "<p>" . $tupla->copete . "</p>";
 
    }

  





?>