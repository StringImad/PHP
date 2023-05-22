<?php
if(isset($_POST["btnContBorrar"]))
{
    
    $url=DIR_SERV."/borrar_comentario/".$_POST["btnBorrar"];
    $respuesta=consumir_servicios_REST($url,"DELETE");
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        session_destroy();
        die(error_page("Práctica 3 - SW","Práctica 3 - SW","Error consumiendo el servicio: ".$url));
    }
    if(isset($obj->mensaje_error))
    {
        session_destroy();
        die(error_page("Práctica 3 - SW","Práctica 3 - SW",$obj->mensaje_error));
    } 
    
   
    
    $_SESSION["accion"]="El comentario ha sido borrado con éxito";
   
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Exam</title>
    <style>
        .enlinea{display:inline}
        .enlace{border:none;background:none;color:blue;text-decoration:underline;cursor:pointer}
        #tabla_principal, #tabla_principal td, #tabla_principal th{border:1px solid black}
        #tabla_principal{width:90%; border-collapse:collapse;text-align:center;margin:0 auto}
        #tabla_principal th{background-color:#CCC}
        #tabla_principal img{height:75px}
    </style>
</head>

<body>

<?php



?>

    <h1>GESTION DE COMENTARIOS</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log->usuario; ?></strong> -
        <form class="enlinea" action="gest_comentarios.php" method="post">
            <button name="btnSalir" class="enlace">Salir</button>
        </form>
    </div>
    <h2>Todos los comentarios</h2>

    <?php
    if(isset($_POST["btnVerNoticia"])){

    }else{
        if(isset($_POST["btnBorrar"])){

        }
        if(isset($_POST["btnAprobar"])){
            
        }
        require "../vistas/vista_tabla.php";

    }
    
    ?>


</body>

</html>