<?php
require "src/funciones.php";
require __DIR__ . '/Slim/autoload.php';


$app = new \Slim\App;




$app->post('/salir', function ($request) {
    session_id($request->getParam("api_session"));

    session_start();

    session_destroy();
    echo json_encode(array('logout' => 'Close session'));
});

$app->post('/logueado', function ($request) {
    session_id($request->getParam("api_session"));

    session_start();

    if(isset($_SESSION["tipo"])){
        $datos[]=$_SESSION["tipo"];
        $datos[]=$_SESSION["clave"];
        echo json_encode(logueado($datos));
    }else{
        session_destroy();
        echo json_encode(array('no_login'=>'No logueado'));
    }
});

$app->post('/login', function ($request) {

    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");


    echo json_encode(login($datos));
});

$app->get('/obtener_usuarios', function ($request) {
    session_id($request->getParam("api_session"));

    session_start();
    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"]=="admin") {
        echo json_encode(obtener_usuarios());

    }else{
        session_destroy();
        echo json_encode(array('no_login'=>'No logueado'));
    }
});

$app->get('/obtener_usuario/{id}', function ($request) {
    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"]=="admin") {
        echo json_encode(obtener_usuario($request->getAttribute('id')));

    }else{
        session_destroy();
        echo json_encode(array('no_login'=>'No logueado'));
    }
});

$app->delete('/borrar_usuario/{id}', function ($request) {

    echo json_encode(borrar_usuario($request->getAttribute('id')));
});


$app->get('/repetido_reg/{columna}/{valor}', function ($request) {

    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"]=="admin") {
        echo json_encode(repetido($request->getAttribute('columna'), $request->getAttribute('valor')));

    }else{
        session_destroy();
        echo json_encode(array('no_login'=>'No logueado'));
    }

});

$app->get('/repetido_edit/{columna}/{valor}/{columna_id}/{valor_id}', function ($request) {

    echo json_encode(repetido($request->getAttribute('columna'), $request->getAttribute('valor'), $request->getAttribute('columna_id'), $request->getAttribute('valor_id')));
});

$app->post('/insertar_usuario', function ($request) {

    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"]=="admin") {

        $datos[] = $request->getParam("usuario");
        $datos[] = $request->getParam("clave");
        $datos[] = $request->getParam("nombre");
        $datos[] = $request->getParam("dni");
        $datos[] = $request->getParam("sexo");
        $datos[] = $request->getParam("subs");
    
        echo json_encode(insertar_usuario($datos));
    }else{
        session_destroy();
        echo json_encode(array('no_login'=>'No logueado'));
    }


});

$app->put('/modificar_usuario/{id_usuario}', function ($request) {

    echo json_encode(modificar_usuario($request->getAttribute("id_usuario"), $request->getParam("usuario"), $request->getParam("clave"), $request->getParam("nombre"), $request->getParam("dni"), $request->getParam("sexo"), $request->getParam("subs")));
});

$app->put('/cambiar_foto/{id}', function ($request) {
    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"]=="admin") {
        echo json_encode(cambiar_foto($request->getAttribute('id'), $request->getParam('foto')));

    }else{
        session_destroy();
        echo json_encode(array('no_login'=>'No logueado'));
    }
});

// Una vez creado servicios los pongo a disposición
$app->run();
