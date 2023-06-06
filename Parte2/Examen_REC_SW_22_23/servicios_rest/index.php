<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;



$app->post("/salir",function($request){
    session_id($request->getParam('api_session'));
    session_start();
    session_destroy();
    echo json_encode(array('logout'=>'Close session'));

});

$app->get('/logueado',function($request){

    session_id($request->getParam('api_session'));
    session_start();
    if(isset($_SESSION["usuario"]))
    {
        $datos[]=$_SESSION["usuario"];
        $datos[]=$_SESSION["clave"];
        echo json_encode(logueado($datos));
    }
    else
    {
        session_destroy();
        echo json_encode(array('no_auth'=>'No logueado'));
    }


});

$app->post('/login',function($request){
    
    $datos[]=$request->getParam("usuario");
    $datos[]=$request->getParam("clave");

    echo json_encode(login($datos));

});

$app->get('/usuariosGuardia/{dia}/{hora}',function($request){

    session_id($request->getParam('api_session'));
    session_start();
    if(isset($_SESSION["usuario"]))
    {
        $datos[]=$request->getAttribute('dia');
        $datos[]=$request->getAttribute('hora');
        echo json_encode(usuarios_guardia($datos));
    }
    else
    {
        session_destroy();
        echo json_encode(array('no_auth'=>'No logueado'));
    }


});

$app->get('/deGuardia/{dia}/{hora}/{id_usuario}',function($request){

    session_id($request->getParam('api_session'));
    session_start();
    if(isset($_SESSION["usuario"]))
    {
        $datos[]=$request->getAttribute('id_usuario');
        $datos[]=$request->getAttribute('dia');
        $datos[]=$request->getAttribute('hora');
        
        echo json_encode(de_guardia($datos));
    }
    else
    {
        session_destroy();
        echo json_encode(array('no_auth'=>'No logueado'));
    }


});

$app->get('/usuario/{id_usuario}',function($request){

    session_id($request->getParam('api_session'));
    session_start();
    if(isset($_SESSION["usuario"]))
    {
        
        echo json_encode(obtener_usuario($request->getAttribute('id_usuario')));
    }
    else
    {
        session_destroy();
        echo json_encode(array('no_auth'=>'No logueado'));
    }


});


// Una vez creado servicios los pongo a disposición
$app->run();
?>
