<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;



$app->get('/conexion_PDO',function($request){

    echo json_encode(conexion_pdo());
});

$app->get('/conexion_MYSQLI',function($request){
    
    echo json_encode(conexion_mysqli());
});
$app->post('/Login',function($request){
    $datos[]=$request->getParam("usuario");
    $datos[]=$request->getParam("clave");

    echo json_encode(login_usuario($datos));

});


// Una vez creado servicios los pongo a disposición
$app->run();
?>
