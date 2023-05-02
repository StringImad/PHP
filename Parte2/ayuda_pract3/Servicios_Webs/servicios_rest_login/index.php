<?php
require "src/funciones.php";
require __DIR__ . '/Slim/autoload.php';


$app= new \Slim\App;





$app->post('/login',function($request){
    
    $datos[]=$request->getParam("usuario");
    $datos[]=$request->getParam("clave");


    echo json_encode(login($datos));

});

//LISTAR usuarios

$app->get('/usuarios', function ($request) {

    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {

        echo json_encode(usuarios());
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "No logueado"));
    }
});
$app->post('/salir', function ($request) {

    session_id($request->getParam("api_session")); //Coge la sesion de la api
    session_start(); //La inicia
    session_destroy(); //Para destruirla
    echo json_encode(array("no_login" => "No logueado"));
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>