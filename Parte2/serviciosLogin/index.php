<?php
session_name("pract3_sw_22_23");
session_start();

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
define("DIR_SERV", "http://localhost/proyectos/PHP/Parte2/serviciosLogin/servicios_rest");

if (isset($_SESSION["usuario"])) {
    //logueado
    echo "logueado";
} else {
require "vistas/vista_home.php";
}
