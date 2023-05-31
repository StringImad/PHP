<?php
if (isset($_POST["btnVerNoticia"])) {
    $idnoticia = $_POST["btnVerNoticia"];
} elseif (isset($_POST["btnEnviarComentario"])) {
    $idnoticia = $_POST["btnEnviarComentario"];
} else {
    $idnoticia = $_SESSION["comentario"];
}

echo "idNoticia" . $idnoticia;

$url = DIR_SERV . "/noticia/" . $idnoticia;

// $datos_env["api_session"]=$_SESSION["api_session"];


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


if (isset($obj->mensaje)) {
    echo "-----------aqui1---------";

    echo "<form method='post' action='gest_comentarios.php";
    echo "<p>La noticia ya no se encuentra en la BD</p>
<p><button>Volver</button></p></form>";
} else {
    echo "-----------aqui---------";
    if (isset($_SESSION["usuario"])) {
        echo "<h2>" . $obj->noticia->titulo . "</h2>";
        echo "<p>Publicado por <strong>" . $obj->noticia->usuario . "</strong> en " . $obj->noticia->valor . " el " . $obj->noticia->fPublicacion . "</p>";
        echo "<p>" . $obj->noticia->cuerpo . "</p>";
        echo "<h2>Comentarios</h2>";
        $url = DIR_SERV . "/comentarios/" . $idnoticia;
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
        }
        foreach ($obj->comentarios as $tupla) {
            echo "<p><strong>" . $tupla->usuario . "</strong> Dijo:</p>";
            echo "<p>" . $tupla->comentario . "</p>";
        }
        echo "<form method='post' action='gest_comentarios.php'>";
        echo "<p><label for='comentario'>";

        echo "Dejar un comentario</label></p>";
        echo "<textarea  cols='40' rows='8' name='comentario' id='comentario' ></textarea>";
        if (isset($_POST["btnEnviarComentario"]) && $error_form) {
            echo "<p>Campo vacio</p>";
        }
        echo "<p><button type='submit' name='btnVolver'>Volver</button>";
        echo "<button type='submit' name='btnEnviarComentario' value='" . $idnoticia . "'>Enviar</button></p>";
        echo "</form>";
    } else {
        echo "<h2>No esta logueado<h2>";
        echo "<h2>" . $obj->noticia->titulo . "</h2>";
        echo "<p>Publicado por <strong>" . $obj->noticia->usuario . "</strong> en " . $obj->noticia->valor . " el " . $obj->noticia->fPublicacion . "</p>";
        echo "<p>" . $obj->noticia->cuerpo . "</p>";
        echo "<form method='post' action='gest_comentarios.php'>";
        echo "<p><label for='comentario'>";

        echo "Dejar un comentario</label></p>";
        echo "<textarea  cols='40' rows='8' name='comentario' id='comentario' ></textarea>";
        if (isset($_POST["btnEnviarComentario"]) && $error_form) {
            echo "<p>Campo vacio</p>";
        }
        echo "<p><button type='submit' name='btnVolver'>Volver</button>";
        echo "<button type='submit' name='btnEnviarComentario' value='" . $idnoticia . "'>Enviar</button></p>";
        echo "</form>";
    }
}
