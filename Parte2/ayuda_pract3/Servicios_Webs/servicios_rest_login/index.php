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

$app->get('/obtener_usuarios', function ($request) {

  

        echo json_encode(usuarios());
  
});


$app->get('/obtener_un_usuario/{id}', function($request){
    $datos[]=$request->getAttribute("id");

    echo json_encode(obtenerUsuario($datos));


});

$app->delete('/borrar_usuario', function ($request) {
    $datos[]=$request->getParam("id_usuario");

  echo json_encode(borrarUsuario($datos));

});

// Una vez creado servicios los pongo a disposición
$app->run();
