<?php
if(isset($_POST["btnVerNoticia"]))
    $id_noticia=$_POST["btnVerNoticia"];
elseif(isset($_POST["btnCrearComentario"]))
    $id_noticia=$_POST["btnCrearComentario"];
else
    $id_noticia=$_SESSION["comentario"];


$url=DIR_SERV."/noticia/".$id_noticia;
$respuesta=consumir_servicios_REST($url,"GET");
$obj=json_decode($respuesta);
if(!$obj)
{
    if(isset($_SESSION["usuario"]))
        consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);

    session_destroy();
    die("<p>Error consumiendo el servicio: ".$url."</p></body></html>");
}
if(isset($obj->mensaje_error))
{
    if(isset($_SESSION["usuario"]))
        consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
    session_destroy();
    die("<p>".$obj->mensaje_error."</p></body></html>");
}



if(isset($obj->mensaje))
{
    //mensaje de que la Noticia ya no se encuentra en la BD y botón volver
    echo "<form action='gest_comentarios.php' method='post'>";
    echo "<p>La noticia ya no se encuentra registrada en la BD</p>";
    echo "<p><button>Volver</button></p>";
    echo "</form>";
}
else
{
    echo "<h2>".$obj->noticia->titulo."</h2>";
    echo "<p>Publicado por <strong>".$obj->noticia->usuario."</strong> en <em>".$obj->noticia->valor."</em></p>";
    echo "<p>".$obj->noticia->copete."</p>";

    echo "<p>".$obj->noticia->cuerpo."</p>";

    echo "<h2>Comentarios</h2>";
    $url=DIR_SERV."/comentarios/".$id_noticia;
    $respuesta=consumir_servicios_REST($url,"GET");
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        if(isset($_SESSION["usuario"]))
            consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
        session_destroy();
        die("<p>Error consumiendo el servicio: ".$url."</p></body></html>");
    }
    if(isset($obj->mensaje_error))
    {
        if(isset($_SESSION["usuario"]))
            consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
        session_destroy();
        die("<p>".$obj->mensaje_error."</p></body></html>");
    }

    
    foreach($obj->comentarios as $tupla)
    {
        if($tupla->estado=="apto" || (isset($datos_usu_log) && $datos_usu_log->tipo=="admin"))
            echo "<p><strong>".$tupla->usuario."</strong> dijo:<br/>".$tupla->comentario."</p>"; 
    }


    //Aquí iría el formulario para insertar el comentario
    echo "<form  method='post'>";
    echo "<p>";
    echo "<label for='comentario'>Dejar un comentario:</label><br/>";
    echo "<textarea cols='40' rows='8' name='comentario' id='comentario'>";
    if(!isset($_SESSION["usuario"]))
        echo "Debe estar usted logueado para escribir un comentario";
    echo "</textarea>";
    if(isset($_POST["btnCrearComentario"])&& $error_form)
        echo "<span class='error'>* Campo vacío *</span>";
    echo "</p>";
    echo "<p>";
    echo "<button>Volver</button>";
    if(isset($_SESSION["usuario"]))
        echo " <button value='".$id_noticia."' name='btnCrearComentario'>Enviar</button>";
    echo "</p>";
    echo "</form>";

    if(isset($_SESSION["comentario"]))
    {
        if($datos_usu_log->tipo=="admin")
            echo "<p class='mensaje'>El comentario se ha realizado con éxito</p>";
        else
            echo "<p class='mensaje'>El comentario se ha realizado con éxito y está a la espera de ser validado por un administrador</p>";
        unset($_SESSION["comentario"]);
    }

}
?>