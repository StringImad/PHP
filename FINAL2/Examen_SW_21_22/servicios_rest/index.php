<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;


$app->get('/logueado', function ($request) {
    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["usuario"])) {
        $datos[] = $_SESSION["usuario"];
        $datos[] = $_SESSION["clave"];
        echo json_encode(logueado($datos));

    } else {
        echo json_encode(array("no_auth" => "Session api terminadoa"));

    }

});

$app->post('/salir', function ($request) {
    session_id($request->getParam("api_session"));

    session_start();
    session_destroy();

    echo json_encode(array("log_out" => "saliendo de la api"));
});


$app->post('/login', function ($request) {
    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");
    echo json_encode(login($datos));
});

$app->get('/horario/{id_usuario}', function ($request) {
    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["usuario"])) {
        $datos[] = $request->getAttribute("id_usuario");
        echo json_encode(obtenerHorarioUsuario($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "saliendo de la api"));

    }


});

$app->get('/usuarios', function ($request) {
    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(obtenerUsuariosNoAdmin());

    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "saliendo de la api"));

    }

});

$app->get('/tieneGrupo/{dia}/{hora}/{id_usuario}', function ($request) {
    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_usuario");

    echo json_encode(obtenerTieneGrupo($datos));

});

$app->get('/grupos/{dia}/{hora}/{id_usuario}', function ($request) {
    session_id($request->getParam('api_session'));
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        $datos[] = $request->getAttribute("dia");
        $datos[] = $request->getAttribute("hora");
        $datos[] = $request->getAttribute("id_usuario");

        echo json_encode(obtenerGrupoDiaHoraUsuario($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "tiempo expierado"));

    }


});

$app->get('/gruposLibres/{dia}/{hora}/{id_usuario}', function ($request) {
    session_id($request->getParam('api_session'));
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {

        $datos[] = $request->getAttribute("dia");
        $datos[] = $request->getAttribute("hora");
        $datos[] = $request->getAttribute("id_usuario");

        echo json_encode(obtenerNoGrupoDiaHoraUsuario($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "tiempo expierado"));

    }
});


$app->delete('/borrarGrupo/{dia}/{hora}/{id_usuario}/{id_grupo}', function ($request) {
    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_usuario");

    $datos[] = $request->getAttribute("id_grupo");

    echo json_encode(borrarUsuarioDeGuardia($datos));

});

$app->post('/insertarGrupo/{dia}/{hora}/{id_usuario}/{id_grupo}', function ($request) {
    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_usuario");

    $datos[] = $request->getAttribute("id_grupo");

    echo json_encode(insertarUsuario($datos));

});
//Una vez creado servicios los pongo a disposición
$app->run();
?>