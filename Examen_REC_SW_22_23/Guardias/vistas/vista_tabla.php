<?php
$url = DIR_SERV."/deGuardia/";
$respuesta = consumir_servicios_REST($url, "GET", $datos_env);
echo "<h2>Equipos de Guardia del IES Mar de Alborán</h2>";

echo "<table class='tabla'>";
echo "<tr>";
    echo "<th></th><th>Lunes</th><th>Martes</th><th>Miercoles</th><th>Jueves</th><th>Viernes</th>";
echo "</tr>";
echo "<tr>";

echo "</tr>";
echo "</table>";
?>



