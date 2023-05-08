<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Teoría Servicios REST</h1>
    <?php

    function consumir_servicios_REST($url, $metodo, $datos=null)
    {
        $llamada=curl_init();
        curl_setopt($llamada,CURLOPT_URL,$url);
        curl_setopt($llamada,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($llamada,CURLOPT_CUSTOMREQUEST,$metodo);
        if(isset($datos))
            curl_setopt($llamada,CURLOPT_POSTFIELDS,http_build_query($datos));
        
        $respuesta=curl_exec($llamada);
        curl_close($llamada);
        return $respuesta; 
    }

    define("DIR_SERV","http://localhost/Proyectos/Curso22_23/Recup/Servicios_Webs/Teor/servicios_teor_rec");
    $url=DIR_SERV."/saludo/".urlencode("Hola me llamo Juan")."/".urlencode("Hola Me llamo Pepe");
    $respuesta=consumir_servicios_REST($url,"GET");

    $obj=json_decode($respuesta);
    if(!$obj)
    {
        die("<p> Error consumiendo el servicio : $url.</p>".$respuesta);
    }

    echo "<p>".$obj->mensaje."</p>";

    $url=DIR_SERV."/nuevo_saludo";
    $datos_env["mens1"]="Hola mensaje1 con POST";
    $datos_env["mens2"]="Hola mensaje2 con POST";
    $respuesta=consumir_servicios_REST($url,"POST",$datos_env);

    $obj=json_decode($respuesta);
    if(!$obj)
    {
        die("<p> Error consumiendo el servicio : $url.</p>".$respuesta);
    }

    echo "<p>".$obj->mensaje."</p>";

    $url=DIR_SERV."/cambiar_saludo/35";
    $datos_env["mensaje"]="Hola mensaje con PUT";
    $respuesta=consumir_servicios_REST($url,"PUT",$datos_env);

    $obj=json_decode($respuesta);
    if(!$obj)
    {
        die("<p> Error consumiendo el servicio : $url.</p>".$respuesta);
    }

    echo "<p>".$obj->mensaje."</p>";

    $url=DIR_SERV."/borrar_saludo/35";

    $respuesta=consumir_servicios_REST($url,"DELETE");

    $obj=json_decode($respuesta);
    if(!$obj)
    {
        die("<p> Error consumiendo el servicio : $url.</p>".$respuesta);
    }

    echo "<p>".$obj->mensaje."</p>";

    ?>
</body>
</html>