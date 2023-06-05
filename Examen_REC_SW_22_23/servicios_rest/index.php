<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;



$app->get('/conexion_PDO', function ($request) {

    echo json_encode(conexion_pdo());
});


$app->post('/Salir', function ($request) {
    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();
    echo json_encode(array("log_out" => "Cerrada sesión en la API"));

});
$app->post('/Login', function ($request) {
    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");

    echo json_encode(login_usuario($datos));

});
$app->get('/Logueado', function ($request) {
    session_id($request->getAttribute("api_session"));
    session_start();

    $datos = array();
    if (isset($_SESSION["usuario"]) && isset($_SESSION["clave"])) {
        $datos[] = $_SESSION["usuario"];
        $datos[] = $_SESSION["clave"];
    }

    echo json_encode(logueado($datos));
});

$app->get('/obtenerUsuario/{id_usuario}', function ($request) {
    // session_id($request->getAttribute("api_session"));
    // session_start();

    // $datos = array();
    // if (isset($_SESSION["usuario"]) && isset($_SESSION["clave"])) {

    // }
    $datos[] = $request->getAttribute("id_usuario");

    echo json_encode(obtenerUsuario($datos));
});
$app->get('/usuariosGuardia/{dia}/{hora}', function ($request) {

    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    echo json_encode(obtener_usuariosGuardia($datos));
});
$app->get('/deGuardia/{dia}/{hora}/{id_usuario}', function ($request) {

    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_usuario");

    echo json_encode(obtener_deGuardia($datos));
});
// Una vez creado servicios los pongo a disposición
$app->run();
?>