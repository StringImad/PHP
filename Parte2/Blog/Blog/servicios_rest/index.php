<?php

require "src/funciones.php";
require __DIR__ . '/Slim/autoload.php';


$app= new \Slim\App;



$app->post("/salir",function($request){
    session_id($request->getParam('api_session'));
    session_start();
    session_destroy();
    echo json_encode(array('logout'=>'Close session'));

});

$app->post('/logueado',function($request){

    session_id($request->getParam('api_session'));
    session_start();
    if(isset($_SESSION["tipo"]))
    {
        $datos[]=$_SESSION["usuario"];
        $datos[]=$_SESSION["clave"];
        echo json_encode(logueado($datos));
    }
    else
    {
        session_destroy();
        echo json_encode(array('no_login'=>'No logueado'));
    }


});

$app->post('/login',function($request){
    
    $datos[]=$request->getParam("usuario");
    $datos[]=$request->getParam("clave");
    echo json_encode(login($datos));

});



// Una vez creado servicios los pongo a disposición
$app->run();
?>