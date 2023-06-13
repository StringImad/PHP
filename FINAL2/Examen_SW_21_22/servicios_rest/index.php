<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;


$app->post('/logueado', function ($request) {
    // session_start();??????????
    if (isset($_SESSION["usuario"])) {
        $datos[] = $_SESSION["usuario"];
        $datos[] = $_SESSION["clave"];
        echo json_encode(login($datos));

    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "Session api terminadoa"));

    }

});

$app->post('/salir', function ($request) {
    // session_start();???????????
    session_destroy();
    echo json_encode(array("log_out" => "saliendo de la api"));
});


$app->post('/login', function ($request) {
    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");
    echo json_encode(login($datos));
});

$app->get('/horario/{id_usuario}', function ($request) {
    $datos[] = $request->getAttribute("id_usuario");
    echo json_encode(obtenerHorarioUsuario($datos));

});
// Una vez creado servicios los pongo a disposición
$app->run();
?>