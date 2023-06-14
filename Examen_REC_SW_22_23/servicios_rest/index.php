<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;


$app->post('/login', function ($request) {
    $datos[] = $request->getParam('usuario');
    $datos[] = $request->getParam('clave');

    echo json_encode(login($datos));
});



$app->post('/salir', function ($request) {
    session_id($request->getParam('api_session'));
    session_start();
    session_destroy();
    echo json_encode(array("log_out" => "Tiempo de sesion terminadio"));
});

$app->get('/logueado', function ($request) {
    session_id($request->getParam('api_session'));
    session_start();
    if (isset($_SESSION["usuario"])) {
        $datos[] = $_SESSION["usuario"];
        $datos[] = $_SESSION["clave"];
        echo json_encode(logueado($datos));

    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "Tiempo de sesion terminadio"));

    }

});

// Una vez creado servicios los pongo a disposición
$app->run();
?>