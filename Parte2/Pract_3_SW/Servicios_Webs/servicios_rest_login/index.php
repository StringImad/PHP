<?php
require "src/funciones.php";
require __DIR__ . '/Slim/autoload.php';


$app= new \Slim\App;





$app->post('/login',function($request){
    
    $datos[]=$request->getParam("usuario");
    $datos[]=$request->getParam("clave");


    echo json_encode(login($datos));

});

$app->get('/obtener_usuarios',function(){

    echo json_encode(obtener_usuarios());
});

$app->get('/obtener_usuario/{id}',function($request){

    echo json_encode(obtener_usuario($request->getAttribute('id')));
});

$app->delete('/borrar_usuario/{id}',function($request){

    echo json_encode(borrar_usuario($request->getAttribute('id')));
});


$app->get('/repetido_reg/{columna}/{valor}',function($request){

    echo json_encode(repetido($request->getAttribute('columna'),$request->getAttribute('valor')));
});

$app->post('/insertar_usuario',function($request){

    $datos[]=$request->getParam("usuario");
    $datos[]=$request->getParam("clave");
    $datos[]=$request->getParam("nombre");
    $datos[]=$request->getParam("dni");
    $datos[]=$request->getParam("sexo");
    $datos[]=$request->getParam("subs");

    echo json_encode(insertar_usuario($datos));
});

$app->put('/cambiar_foto/{id}',function($request){

    echo json_encode(cambiar_foto($request->getAttribute('id'),$request->getParam('foto')));
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>