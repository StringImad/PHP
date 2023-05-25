<?php
if(isset($_POST["btnContBorrar"]))
{
    $url=DIR_SERV."/borrar_comentario/".$_POST["btnContBorrar"];
    $respuesta=consumir_servicios_REST($url,"DELETE");
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);

        session_destroy();
        die(error_page("Práctica 4 - SW","Práctica 4 - SW","Error consumiendo el servicio: ".$url));
    }
    if(isset($obj->mensaje_error))
    {
        consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);

        session_destroy();
        die(error_page("Práctica 4 - SW","Práctica 4 - SW",$obj->mensaje_error));
    } 
    
   
    
    $_SESSION["accion"]="El comentario ha sido borrado con éxito";
   
}
if(isset($_POST['btnEnviarComentario'])){

    $error_form=$_POST["comentario"]=="";
    if(!$error_form){
    $url = DIR_SERV . "/insertarComentario/".$_POST['btnEnviarComentario'];
    $datos['comentario'] = $_POST['comentario'];
    $datos['idUsuario'] = $datos_usu_log->idusuario;
    $datos['api_session'] = $_SESSION['api_session']["api_session"];
    $respuesta = consumir_servicios_REST($url,"POST", $datos);
    $obj = json_decode($respuesta);
   json_encode($obj);
    if (!$obj) {
        consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);

        session_destroy();
        die(error_page("BLOG 4 - SW","Práctica 4 - SW","Error consumiendo el servicio: ".$url));
    }
    if (isset($obj->mensaje_error)) {
        consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);

        session_destroy();
        
        die(error_page("Práctica 4 - SW","Práctica 4 - SW",$obj->mensaje_error));
    }

    if (isset($obj->no_login)) {
        consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);

        session_destroy();
        die("<p> El tiempo de session de la API ha expirado  vuelve a loguerarse</p></body></html>");


    }

    
    $_SESSION["comentario"]=$_POST['btnEnviarComentario'];
    header("Location:gest_comentarios.php");
    exit;
}else{

    }
    // header("Location:gest_comentarios.php");
    // exit;
}
if(isset($_POST["btnContAprobar"]))
{

    $url=DIR_SERV."/actualizarComentario/".$_POST["btnContAprobar"];
    $datos_act["estado"]="apto";
    $datos_act["api_session"]=$_SESSION["api_session"]["api_session"];
    $respuesta=consumir_servicios_REST($url,"put",$datos_act);
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        session_destroy();
        die(error_page("Práctica 4 - SW","Práctica 4 - SW","Error consumiendo el servicio: ".$url));
    }
    if(isset($obj->mensaje_error))
    {
        session_destroy();
        die(error_page("Práctica 4 - SW","Práctica 4 - SW",$obj->mensaje_error));
    } 
    
   
    
    $_SESSION["accion"]="El comentario ha sido actualizado con éxito";
    header("Location:gest_comentarios.php");
    exit;
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

    <?php
    if(isset($_POST["btnVerNoticia"])||isset($_POST["btnEnviarComentario"])|| isset($_SESSION["comentario"])){
  
        require "../vistas/vista_noticia.php";

    }else{
        if(isset($_POST["btnBorrar"])){
            require "../vistas/vista_borrar.php";
        }
        if(isset($_POST["btnAprobar"])){
            require "../vistas/vista_aprobar.php";

        }
        echo "<h2>Todos los comentarios</h2>";
        require "../vistas/vista_tabla.php";

    }
    
    ?>


</body>

</html>