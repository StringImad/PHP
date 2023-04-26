<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App1</title>
</head>

<body>
    <h1>Teoria servicios Rest app1</h1>
    <?php
    function consumir_servicios_REST($url, $metodo, $datos = null)
    {
        $llamada = curl_init();

        curl_setopt($llamada, CURLOPT_URL, $url);
        //fundamental poner el true
        curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);

        if (isset($datos)) {
            curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
        }

        $respuesta = curl_exec($llamada);
        curl_close($llamada);
        return $respuesta;
    }
    define("DIR_SERV", "http://localhost/proyectos/PHP/Parte2/Teoria/servicios_rest");
    //esta solo sirve para geŧ
    $url = DIR_SERV . "/saludo";
    $url = DIR_SERV . "/saludo/" . urlencode("juan");

    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);
    //si por lo que sea no recibimos el json morimos
    if (!$obj) {
        die("<p>Error consumiendo el servicio:" . $url . "</p>" . $respuesta);
    }

    echo "<p>" . $obj->mensaje . "</p>";
    $url = DIR_SERV . "/nuevo_saludo";
    $datos_env["mensj1"] = "hola 1";
    $datos_env["mensj2"] = "hola 2";

    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);
    //si por lo que sea no recibimos el json morimos
    if (!$obj) {
        die("<p>Error consumiendo el servicio:" . $url . "</p>" . $respuesta);
    }

    $url = DIR_SERV . "/cambiar_saludo";
    $datos_env["mensj1"] = "hola 1";
    $datos_env["mensj2"] = "hola 2";

    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);
    //si por lo que sea no recibimos el json morimos
    if (!$obj) {
        die("<p>Error consumiendo el servicio:" . $url . "</p>" . $respuesta);
    }


    ?>
</body>

</html>