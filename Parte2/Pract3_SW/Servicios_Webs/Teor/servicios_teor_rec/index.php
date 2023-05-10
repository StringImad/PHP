<?php

require __DIR__ . '/Slim/autoload.php';
$app= new \Slim\App;



$app->get('/saludo',function(){
    
    echo json_encode(array("mensaje"=> "Hola en General"));

});

$app->get("/saludo/{mens}",function($datos){

    echo json_encode(array("mensaje"=>$datos->getAttribute('mens')));
});

$app->get("/saludo/{mens1}/{mens2}",function($datos){

    echo json_encode(array("mensaje"=>"Mensaje1: ".$datos->getAttribute('mens1').", Mensaje2: ".$datos->getAttribute('mens2')));
});

$app->post("/nuevo_saludo",function($request){

    $datos[]=$request->getParam("mens1");
    $datos[]=$request->getParam("mens2");

    echo json_encode(array("mensaje"=>"Mensaje1: ".$datos[0].", Mensaje2: ".$datos[1]));

});

$app->put("/cambiar_saludo/{id}",function($request){


    echo json_encode(array("mensaje"=>"Actualizo el mensaje con id:".$request->getAttribute('id')." a el nuevo valor:".$request->getParam("mensaje")));

});

$app->delete("/borrar_saludo/{id}",function($request){


    echo json_encode(array("mensaje"=>"Borro el mensaje con id:".$request->getAttribute('id')));

});

/*
$app->put();

$app->delete();
*/


// Una vez creado servicios los pongo a disposición
$app->run();
?>