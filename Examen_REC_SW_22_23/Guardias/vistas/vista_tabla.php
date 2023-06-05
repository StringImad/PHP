<?php
$url = DIR_SERV."/deGuardia/";
$respuesta = consumir_servicios_REST($url, "GET", $datos_env);
echo "<h2>Equipos de Guardia del IES Mar de Alborán</h2>";

echo "<table class='tabla'>";
echo "<tr>";
    echo "<th></th><th>Lunes</th><th>Martes</th><th>Miercoles</th><th>Jueves</th><th>Viernes</th>";
echo "</tr>";
$l = 1;
$m = 0;
$h = 1;
for ($i = 0; $i <7; $i++) {
    echo "<tr>";

    if($i==3){
        echo "<td id='recreo'colspan=6>Recreo</td>";

    }else{
        echo "<td>".$l." hora</td>";
        for ($j = 0; $j <5; $j++) {
            $m++;

            echo "<form action=index.php method=post>";
            echo "<input type='hidden' name='numEquipo' value='".$m."'/>";
            echo "<input type='hidden' name='hora' value='".$h."'/>";
            echo "<input type='hidden' name='dia' value='".($j+1)."'/>";

            echo "<td><button class='enlace' name='btnVerEquipo' value=''>Equipo ".$m."</button></td>";
            echo "</form>";
        }
        $h++;


    }

    echo "</tr>";
    $l++;

}
echo "</table>";
if(isset($_POST['btnVerEquipo']) || isset($_POST['btnVerProfesor'])){
echo "<h2>Equipo de Guardia ".$_POST["numEquipo"]."</h2>";

$url = DIR_SERV . "/deGuardia/".$_POST["dia"]."/".$_POST["hora"]."/".$_SESSION["id_usuario"];
$datos_env["dia"] = $_POST["dia"];
$datos_env["hora"] = $_POST["hora"];
$datos_env["id_usuario"] = $_SESSION["id_usuario"];

$respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
$obj = json_decode($respuesta);

if (!$obj) {
    die(error_page("Recup exam", "error", "error consumiendo el servicio: " . $url . $respuesta));
}

if (isset($obj->error)) {
    die(error_page("Recup exam",  "error en la bd", $obj->$error));
}
if(isset($obj->deGuardia)){
    $estaDeGuardia = $obj->deGuardia;

}


$url = DIR_SERV . "/usuariosGuardia/".$_POST["dia"]."/".$_POST["hora"];
$datos_env["dia"] = $_POST["dia"];
$datos_env["hora"] = $_POST["hora"];
$datos_env["id_usuario"] = $_SESSION["id_usuario"];

$respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
$obj = json_decode($respuesta);

if (!$obj) {
    die(error_page("Recup exam", "error", "error consumiendo el servicio: " . $url . $respuesta));
}

if (isset($obj->error)) {
    die(error_page("Recup exam",  "error en la bd", $obj->$error));
}
if (isset($obj->mensaje)) {
    die(error_page("Recup exam",  "No hay usuarios", $obj->$error));
}

if($estaDeGuardia){
    echo "<h3>Esta de guardia</h3>";
    echo "<table class='tabla'>";
    echo "<tr>";
    echo "<th>Profesores de Guardia</th>";
    echo "<th>Informacion del profesor con id_usuario</th>";

    echo "</tr>";
  
    foreach ($obj->usuario as $tupla) {
        echo "<tr>";
        echo "<td>";
        echo "<form  method=post>";
        echo "<input type='hidden' name='btnVerProfesor2'  value='".$tupla->id_usuario."'>";

        echo "<button class='enlace' name='btnVerProfesor' value='".$tupla->id_usuario."'>".$tupla->nombre . "</button>";
        echo "</form></br>";
        echo "</td>";
        echo "<td>";

         $url = DIR_SERV . "/obtenerUsuario/".$tupla->id_usuario;
      
         $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
         $obj = json_decode($respuesta);
        
         if (!$obj) {
             die(error_page("Recup exam", "error", "error consumiendo el servicio: " . $url . $respuesta));
         }
        
         if (isset($obj->error)) {
             die(error_page("Recup exam",  "error en la bd", $obj->$error));
         }
         if (isset($obj->mensaje)) {
             die(error_page("Recup exam",  "No hay usuarios", $obj->$error));
         }
         if(isset($_POST["btnVerProfesor"])){
            echo "Nombre: .$tupla->nombre .";

         }
     
      
       
        echo "</td>";
        echo"</tr>";

    }
 
  

    echo "</table>";

}else{
    echo "<h3>Usted no esta de guardia</h3>";
}
}
?>



