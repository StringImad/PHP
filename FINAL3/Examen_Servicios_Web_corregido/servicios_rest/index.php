<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;


$app->post('/login', function ($request) {
    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");


    echo json_encode(login($datos));
});
$app->post('/salir', function ($request) {
    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();

    echo json_encode(array("log_out" => "Cerrada sesión en la API"));
});

$app->get('/logueado', function ($request) {
    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["usuario"])) {
        $datos[] = $_SESSION["usuario"];
        $datos[] = $_SESSION["clave"];
        echo json_encode(logueado($datos));
    } else {
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

$app->get('/usuario/{id_usuario}', function ($request) {
    
    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["usuario"])) {
        $datos[] = $request->getAttribute("id_usuario");
        echo json_encode(obtener_usuario($datos));
    } else {
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});
$app->get('/usuariosGuardia/{dia}/{hora}', function ($request) {
    // $datos[] = $request->getAttribute("dia");
    // $datos[] = $request->getAttribute("hora");
    // echo json_encode(obtener_guardias($datos));
   session_id($request->getParam("api_session"));
   session_start();
   if (isset($_SESSION["usuario"])) {
       $datos[] = $request->getAttribute("dia");
       $datos[] = $request->getAttribute("hora");

       echo json_encode(obtener_guardias($datos));
   } else {
       echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
   }
});

$app->get('/guardiasUsuario/{id_usuario}', function ($request) {

    //        $datos[] = $request->getAttribute("id_usuario");

    //    echo json_encode(obtener_guardiasUsuario($datos));
    
  session_id($request->getParam("api_session"));
  session_start();
  if (isset($_SESSION["usuario"])) {
      $datos[] = $request->getAttribute("id_usuario");

      echo json_encode(obtener_guardiasUsuario($datos));
  } else {
      echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
  }
});


$app->run();
