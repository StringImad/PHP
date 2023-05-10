<?php
$url=DIR_SERV."/obtener_usuarios";
$respuesta=consumir_servicios_REST($url,"GET",$_SESSION["api_session"]);
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

if(isset($obj->no_login))
{
session_destroy();
    die("<p> El tiempo de session de la API ha expirado  vuelve a loguerarse</p></body></html>");

    session_unset();
    $_SESSION["seguridad"]="El tiempo de session de la API ha expirado";
    header("Location:index.php");
    exit;
}
echo "<h2>Listado de los usuarios no admin</h2>";
echo "<table id='tabla_principal'>";
echo "<tr>";
echo "<th>#</th><th>Foto</th><th>Nombre</th>";
echo "<th><form action='index.php' method='post'><button class='enlace' name='btnNuevo'>Usuario+</button></form></th>";
echo "</tr>";
foreach($obj->usuarios as $tupla)
{
    if($tupla->tipo=="normal")
    {
        echo "<tr>";
        echo "<td>".$tupla->id_usuario."</td>";
        echo "<td><img src='Img/".$tupla->foto."' alt='foto' title='foto'/></td>";
        echo "<td><form action='index.php' method='post'><button class='enlace' value='".$tupla->id_usuario."' name='btnListar' >".$tupla->nombre."</button></form></td>";
        echo "<td><form action='index.php' method='post'><input type='hidden' name='foto' value='".$tupla->foto."'/><button class='enlace' value='".$tupla->id_usuario."' name='btnBorrar'>Borrar</button> - <button class='enlace' value='".$tupla->id_usuario."' name='btnEditar'>Editar</button></form></td>";
        echo "</tr>";
    }
}
echo "</table>";
?>