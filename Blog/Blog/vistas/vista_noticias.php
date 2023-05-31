<?php

if(isset($_POST["btnVerNoticia"])|| isset($_POST["btnCrearComentario"]) || isset($_SESSION["comentario"]))
{
    //Código ver noticia
    require "vistas/vista_ver_noticia.php";
}
else
{
    echo "<h2>Noticias</h2>";

    $url=DIR_SERV."/obtenerNoticias";
    $respuesta=consumir_servicios_REST($url,"GET");
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        session_destroy();
        die("<p>Error consumiendo el servicio: ".$url."</p></body></html>");
    }
    if(isset($obj->mensaje_error))
    {
        session_destroy();
        die("<p>".$obj->mensaje_error."</p></body></html>");
    }

    foreach($obj->noticias as $tupla)
    {
        echo "<form  method='post'>";
        echo "<p>";
        echo "<button class='enlace grande' name='btnVerNoticia' value='".$tupla->idNoticia."'>";
        echo $tupla->titulo."</button></p>";
        echo "<p>".$tupla->copete."</p>";
        echo "</form>";
    }
}
?>