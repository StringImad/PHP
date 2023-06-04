<?php

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

echo "<h2>Todas las noticias</h2>";

echo "<table id='tabla_comentarios'>";
echo "<tr><th>ID</th><th>Noticias</th>
<th><form action='gest_comentarios.php' method='post'><button class='enlace' name='btnCrearNoticia'>Crear Noticia</button></form></th>
</tr>";
foreach ($obj->noticias as $tupla)
{
    echo "<tr>";
    echo "<td>".$tupla->idNoticia."</td>";
    echo "<td>";
    echo"<br/>Creada por: <strong>".$tupla->usuario."</strong>:";
    echo "<form class='enlinea' action='gest_comentarios.php' method='post'>";
    echo "<button name='btnVerNoticia' value='".$tupla->idNoticia."' class='enlace'>".$tupla->titulo."</button></form>";
    echo "</td>";
    echo "<td><form action='gest_comentarios.php' method='post'>";
    echo "<button class='enlace' value='".$tupla->idNoticia."' name='btnEditarNoticia'>Editar</button> - ";
    echo "<button class='enlace' value='".$tupla->idNoticia."' name='btnBorrar´Noticia'>Borrar</button>";
    echo "</form></td>";
    echo "</tr>";
}

echo "</table>";
?>