<?php
if(isset($_POST["btnEditarNoticia"])){
    $id_noticia=$_POST["btnEditarNoticia"];
   
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


    if(isset($obj->noticia))
    {           
        $titulo=$obj->noticia->titulo;
        $copete=$obj->noticia->copete;
        $cuerpo=$obj->noticia->cuerpo;
        $idCategoria=$obj->noticia->idCategoria;
        $idUsuario = $obj->noticia->idUsuario;
    }
    else
    {
        $error_existencia=true;
    }
}else{



    $titulo = $_POST['titulo'];
    $copete = $_POST['copete'];
    $cuerpo = $_POST['cuerpo'];
    $idUsuario =2;
    
    $idCategoria = $_POST['categoria'];
}
echo "<h2>Editando la noticia con id: " . $_POST["btnEditarNoticia"] . "</h2>";
if (isset($error_existencia)) {
    echo "<form action='index.php' method='post'>";
    echo "<p>El usuario ya no se encuentra registrado en la BD</p>";
    echo "<p><button>Volver</button></p>";
    echo "</form>";
} else {

    echo "<form action='gest_comentarios.php'  method='post'>";
    echo "<p>";
    $url=DIR_SERV."/obtenerCategorias";
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
   
   echo "<form action='gest_comentarios.php'  method='post'>";
   echo "<p>";
   echo "<select name='idCategoria' id='categoriaSelca'>";
   
   foreach ($obj->categorias as $tupla)
   {
       echo "<option value='$tupla->idCategoria'>$tupla->valor</option>";
   
   }
   echo "</select>";

    echo "</p>";
    echo "<p>";
    echo "<label for='titulo'>Titulo:</label><br/>";

    echo "<textarea name='titulo' value='";

    echo $titulo;

echo "'>$titulo</textarea>";
    if (isset($_POST["btnContCrearNoticia"]) && $error_form)
        echo "<span class='error'>* Campo vacío *</span>";
    echo "</p>";

    echo "<p>";
    echo "<label for='copete'>Copete:</label><br/>";

    echo "<textarea name='copete' value='";

    echo $copete;

echo "'>$copete</textarea>";
    if (isset($_POST["btnContCrearNoticia"]) && $error_form)
        echo "<span class='error'>* Campo vacío *</span>";
    echo "</p>";


    echo "<p>";
    echo "<label for='cuerpo'>Cuerpo:</label><br/>";
    echo "<textarea name='cuerpo' value='";

        echo $cuerpo;

    echo "'>$cuerpo</textarea>";
    if (isset($_POST["btnContCrearNoticia"]) && $error_form)
        echo "<span class='error'>* Campo vacío *</span>";
    echo "</p>";

    echo "<p>";
    echo "<button>Volver</button>";
    echo " <button value='".$_POST["btnEditarNoticia"]."' name='btnContEditarNoticia'>Enviar</button>";
    echo "</p>";
    
    echo "</form>";


}
?>