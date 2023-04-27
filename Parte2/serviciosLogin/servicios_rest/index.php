<?php
//devuelve tres posibles Json
//'mensaje error' muero
//'usuario' datos del usuario
//'mensaje' usuario no se encuentra en la bd
require 'src/funciones.php';

require __DIR__ . '/Slim/autoload.php';


$app = new \Slim\App;

$app->post('/login', function ($request) {

    $datos[] = $request->getParam('usuario');
    $datos[] = $request->getParam('clave');
//lo que devuelva login, tienen que ser un array para que lo convierta en un json
    echo json_encode(login($datos));
});

// Una vez creado servicios los pongo a disposición
$app->run();
