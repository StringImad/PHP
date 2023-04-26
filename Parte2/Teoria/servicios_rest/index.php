<?php

require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->get('/saludo',function(){

    //$datos["cod"]=$request->getParam('cod');
    echo json_encode(array("mensaje"=> "Hola en general"));

});

$app->get('/saludo/{codigo}',function($datos){

    //$datos["cod"]=$request->getParam('cod');
    echo json_encode(array("mensaje"=> "Hola ".$datos->getAttribute('codigo')) ,JSON_FORCE_OBJECT);

});

$app->get('/saludo/{datos1}/{datos2}',function($datos){

    echo json_encode(array("mensaje"=> "Hola ".$datos->getAttribute('datos1')." y ".$datos->getAttribute('datos2'),JSON_FORCE_OBJECT));

});

$app->post('/nuevo_saludo',function($request){
    $datos[]=$request->getParam('datos1');
    $datos[]=$request->getParam('datos2');
    echo json_encode(array("mensaje"=>"manesaje1 con POST: ".$datos[0].", mensj: : ".$datos[1]));

});
$app->put('/cambiar_saludo',function($request){
    $datos[]=$request->getParam('datos1');
    $datos[]=$request->getParam('datos2');
    echo json_encode(array("mensaje"=>"manesaje2 con put ".$datos[0].", mensj: ".$datos[1]));

});
// Una vez creado servicios los pongo a disposición
$app->run();
?>