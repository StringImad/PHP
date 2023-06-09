<?php

require "src/funciones.php";
require __DIR__ . '/Slim/autoload.php';


$app = new \Slim\App;



$app->post("/salir", function ($request) {
    session_id($request->getParam('api_session'));
    session_start();
    session_destroy();
    echo json_encode(array('logout' => 'Close session'));

});

$app->post('/logueado', function ($request) {

    session_id($request->getParam('api_session'));
    session_start();
    if (isset($_SESSION["tipo"])) {
        $datos[] = $_SESSION["usuario"];
        $datos[] = $_SESSION["clave"];
        echo json_encode(logueado($datos));
    } else {
        session_destroy();
        echo json_encode(array('no_login' => 'No logueado'));
    }


});

$app->post('/login', function ($request) {

    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");

    echo json_encode(login($datos));

});


$app->post('/insertarUsuario', function ($request) {



    $datos[] = $request->getParam('usuario');
    $datos[] = $request->getParam('clave');
    $datos[] = $request->getParam('email');

    echo json_encode(insertar_usuario($datos));


});



$app->get('/obtenerNoticias', function () {

    echo json_encode(obtener_noticias());

});
$app->get('/obtenerCategorias', function () {

    echo json_encode(obtener_categorias());

});

$app->get('/comentarios', function ($request) {

    session_id($request->getParam('api_session'));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(obtener_comentarios());
    } else {
        session_destroy();
        echo json_encode(array('no_login' => 'No logueado'));
    }

});



$app->get('/usuarios/{columna}/{valor}', function ($request) {


    echo json_encode(obtener_usuarios($request->getAttribute('columna'), $request->getAttribute('valor')));


});

$app->get('/comentarios/{id_noticia}', function ($request) {


    echo json_encode(obtener_comentarios_noticia($request->getAttribute('id_noticia')));


});


$app->get('/usuario/{id}', function ($request) {

    session_id($request->getParam('api_session'));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(obtener_usuario($request->getAttribute('id')));
    } else {
        session_destroy();
        echo json_encode(array('no_login' => 'No logueado'));
    }

});

$app->get('/noticia/{id}', function ($request) {


    echo json_encode(obtener_noticia($request->getAttribute('id')));


});

$app->get('/categoria/{id}', function ($request) {

    session_id($request->getParam('api_session'));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(obtener_categoria($request->getAttribute('id')));
    } else {
        session_destroy();
        echo json_encode(array('no_login' => 'No logueado'));
    }

});

$app->get('/comentario/{id}', function ($request) {

    session_id($request->getParam('api_session'));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(obtener_comentario($request->getAttribute('id')));
    } else {
        session_destroy();
        echo json_encode(array('no_login' => 'No logueado'));
    }

});


$app->put('/actualizarComentario/{id}', function ($request) {

    session_id($request->getParam('api_session'));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        $datos[] = $request->getParam('estado');
        $datos[] = $request->getAttribute('id');
        echo json_encode(actualizar_comentario($datos));
    } else {
        session_destroy();
        echo json_encode(array('no_login' => 'No logueado'));
    }

});
$app->put('/actualizarNoticia2/{idNoticia}/{titulo}/{copete}/{cuerpo}/{idCategoria}', function ($request) {

    $datos[] = $request->getAttribute('titulo');
    $datos[] = $request->getAttribute('copete');
    $datos[] = $request->getAttribute('cuerpo');
    $datos[] = $request->getAttribute('idCategoria');
    $datos[] = $request->getAttribute('idNoticia');

    echo json_encode(modificar_noticia($datos));
    // session_id($request->getParam('api_session'));
    // session_start();
    // if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {

    // } else {
    //     session_destroy();
    //     echo json_encode(array('no_login' => 'No logueado'));
    // }
});
$app->put('/actualizarNoticia/{idNoticia}', function ($request) {


    session_id($request->getParam('api_session'));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        $datos[] = $request->getParam('titulo');
        $datos[] = $request->getParam('copete');
        $datos[] = $request->getParam('cuerpo');
        $datos[] = $request->getParam('idCategoria');
        $datos[] = $request->getAttribute('idNoticia');

        echo json_encode(modificar_noticia($datos));
    } else {
        session_destroy();
        echo json_encode(array('no_login' => 'No logueado'));
    }
});
$app->delete('/borrarComentario/{id}', function ($request) {

    session_id($request->getParam('api_session'));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {

        echo json_encode(borrar_comentario($request->getAttribute('id')));
    } else {
        session_destroy();
        echo json_encode(array('no_login' => 'No logueado'));
    }

});

$app->post('/insertarComentario/{id_noticia}', function ($request) {

    session_id($request->getParam('api_session'));
    session_start();
    if (isset($_SESSION["tipo"])) {
        $datos[] = $request->getParam("comentario");
        $datos[] = $request->getParam("idUsuario");
        $datos[] = $request->getAttribute("id_noticia");
        if ($_SESSION["tipo"] == "admin")
            $datos[] = "apto";
        else
            $datos[] = "sin validar";

        echo json_encode(insertar_comentario($datos));
    } else {
        session_destroy();
        echo json_encode(array('no_login' => 'No logueado'));
    }
});

$app->post('/insertarNoticia', function ($request) {

    session_id($request->getParam('api_session'));
    session_start();


    if (isset($_SESSION["tipo"])) {

        $datos[] = $request->getParam("titulo");
        $datos[] = $request->getParam("copete");
        $datos[] = $request->getParam("cuerpo");
        $datos[] = $request->getParam("idUsuario");
        $datos[] = $request->getParam("idCategoria");
        echo json_encode(insertar_noticia($datos));
    } else {
        session_destroy();
        echo json_encode(array('no_login' => 'No logueado'));
    }
});

$app->delete('/borrarNoticia/{id}', function ($request) {

    session_id($request->getParam('api_session'));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {

        echo json_encode(borrar_noticia($request->getAttribute('id')));
    } else {
        session_destroy();
        echo json_encode(array('no_login' => 'No logueado'));
    }

});


// Una vez creado servicios los pongo a disposición
$app->run();
?>