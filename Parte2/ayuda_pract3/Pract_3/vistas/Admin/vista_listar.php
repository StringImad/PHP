<?php 
$url = DIR_SERV . "/obtener_un_usuario/" . $_POST["btnListar"];

$respuesta = consumir_servicios_REST($url, "GET");
$obj = json_decode($respuesta);
if (!$obj) {
    session_destroy();
    die(error_page("Práctica 3 - SW", "Práctica 3 - SW", "Error consumiendo el servicio: " . $url . $respuesta));
}

if (isset($obj->mensaje_error)) {
    session_destroy();
    die(error_page("Práctica 3 - SW", "Práctica 3 - SW", $obj->mensaje_error));
}

if (isset($obj->usuarios)) {
    foreach ($obj->usuarios as $usuario) {
        echo "<p><strong>ID de usuario: </strong>" . $usuario->id_usuario . "</p>";
        echo "<p><strong>Nombre de usuario: </strong>" . $usuario->usuario . "</p>";
        echo "<p><strong>Nombre: </strong>" . $usuario->nombre . "</p>";
        echo "<p><strong>DNI: </strong>" . $usuario->dni . "</p>";
        echo "<p><strong>Sexo: </strong>" . $usuario->sexo . "</p>";
        echo "<p><strong>Foto: </strong> <img src='" . $usuario->foto . "' alt =''</p>";
        echo "<p><strong>Subscripción: </strong>" . $usuario->subscripcion . "</p>";
        echo "<p><strong>Tipo: </strong>" . $usuario->tipo . "</p>";
    }
} else {
    echo "El usuario no se encuentra rresgisrtadi";
}

?>