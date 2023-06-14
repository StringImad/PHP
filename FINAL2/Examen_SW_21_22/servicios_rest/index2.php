<?php

require "src/funciones_servicios2.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->post('/salir',function($request){

    session_id($request->getParam('api_session'));
    session_start();
    session_destroy();
    echo json_encode(array("logout"=>"Cerrada API"));
});


$app->post('/logueado',function($request){

    session_id($request->getParam('api_session'));
    session_start();
    if(isset($_SESSION["tipo"]))
    {

        $datos[]=$_SESSION['usuario'];
        $datos[]=$_SESSION['clave'];
        echo json_encode(logueado($datos));
    }
    else
    {
        session_destroy();
        echo json_encode(array("no_login"=>"No logueado en la API"));
    }

});


$app->post('/login',function($request){

    $datos[]=$request->getParam('usuario');
    $datos[]=$request->getParam('clave');
    echo json_encode(login($datos));

});

$app->get('/horario/{id_usuario}',function($request){


    session_id($request->getParam('api_session'));
    session_start();
    if(isset($_SESSION["tipo"]))
    {
        echo json_encode(obtener_horario($request->getAttribute('id_usuario')));

    }
    else
    {
        session_destroy();
        echo json_encode(array("no_login"=>"No logueado en la API"));
    }

});

$app->get('/usuarios',function($request){

    
    session_id($request->getParam('api_session'));
    session_start();
    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"]=="admin" )
    {
        echo json_encode(obtener_usuarios());

    }
    else
    {
        session_destroy();
        echo json_encode(array("no_login"=>"No logueado en la API"));
    }
    
});

$app->get('/grupos/{dia}/{hora}/{id_usuario}',function($request){

 

    session_id($request->getParam('api_session'));
    session_start();
    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"]=="admin" )
    {
        $datos[]=$request->getAttribute('dia');
        $datos[]=$request->getAttribute('hora');
        $datos[]=$request->getAttribute('id_usuario');
        echo json_encode(obtener_grupos($datos));

    }
    else
    {
        session_destroy();
        echo json_encode(array("no_login"=>"No logueado en la API"));
    }
    
});

$app->get('/gruposLibres/{dia}/{hora}/{id_usuario}',function($request){


    session_id($request->getParam('api_session'));
    session_start();
    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"]=="admin" )
    {
        $datos[]=$request->getAttribute('dia');
        $datos[]=$request->getAttribute('hora');
        $datos[]=$request->getAttribute('id_usuario');
        echo json_encode(obtener_grupos_libres($datos));

    }
    else
    {
        session_destroy();
        echo json_encode(array("no_login"=>"No logueado en la API"));
    }
    
});

// Este servicio no se ha usado en la aplicación del examen
$app->get('/tieneGrupos/{dia}/{hora}/{id_usuario}',function($request){

    session_id($request->getParam('api_session'));
    session_start();
    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"]=="admin" )
    {
        $datos[]=$request->getAttribute('dia');
        $datos[]=$request->getAttribute('hora');
        $datos[]=$request->getAttribute('id_usuario');
        echo json_encode(obtener_tiene_grupos($datos));

    }
    else
    {
        session_destroy();
        echo json_encode(array("no_login"=>"No logueado en la API"));
    }
    
});

$app->post('/insertarGrupo/{dia}/{hora}/{id_usuario}/{id_grupo}',function($request){


    session_id($request->getParam('api_session'));
    session_start();
    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"]=="admin" )
    {
        $datos[]=$request->getAttribute('id_usuario');
        $datos[]=$request->getAttribute('dia');
        $datos[]=$request->getAttribute('hora');
        $datos[]=$request->getAttribute('id_grupo');
        echo json_encode(insertar_grupo($datos));

    }
    else
    {
        session_destroy();
        echo json_encode(array("no_login"=>"No logueado en la API"));
    }
    
});

$app->delete('/borrarGrupo/{dia}/{hora}/{id_usuario}/{id_grupo}',function($request){

 

    session_id($request->getParam('api_session'));
    session_start();
    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"]=="admin" )
    {
        $datos[]=$request->getAttribute('dia');
        $datos[]=$request->getAttribute('hora');
        $datos[]=$request->getAttribute('id_usuario');
        $datos[]=$request->getAttribute('id_grupo');
        echo json_encode(borrar_grupo($datos));

    }
    else
    {
        session_destroy();
        echo json_encode(array("no_login"=>"No logueado en la API"));
    }
    
});


// Una vez creado servicios los pongo a disposición
$app->run();
?>
