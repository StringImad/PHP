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

$app->delete('/borrar_usuario/{id}', function($request){
    $datos[]=$request->getAttribute("id");

    echo json_encode(borrarUsuario($datos));


});

$app->get('/repetido_reg/{columna}/{valor}',function ($request){


    echo json_encode(repetido($request->getAttribute("columna"),$request->getAttribute("valor")));
});

$app->post('/insertar_usuario',function($request){
    
   
    $datos[0] = $request->getParam("usuario");
    $datos[1] = $request->getParam("clave");
    $datos[2] = $request->getParam("nombre");
    $datos[3] = $request->getParam("dni");
    $datos[4] = $request->getParam("sexo");
    $datos[5] = $request->getParam("subs");

    echo json_encode(insertar_usuario($datos));

});

$app->put('/cambiar_foto/{id}',function($request){

    echo json_encode(cambiar_foto($request->getAttribute("id"),$request->getAttribute("foto")));
});

// Una vez creado servicios los pongo a disposición
$app->run();
