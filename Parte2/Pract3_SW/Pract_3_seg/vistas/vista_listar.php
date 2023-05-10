<?php
$url=DIR_SERV."/obtener_usuario/".$_POST["btnListar"];
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

if(isset($obj->usuario))
{
    
    echo "<p><strong>Nombre: </strong>".$obj->usuario->nombre."</p>";
    echo "<p><strong>Usuario: </strong>".$obj->usuario->usuario."</p>";
    echo "<p>.......................</p>";
}
else
{
    echo "<p>El usuario ya no se encuentra registrado en la BD</p>";
}
echo "<form action='index.php' method='post'><button>Volver</button></form>";


?>