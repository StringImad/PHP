<?php
if(isset($_POST["btnCrearComentario"]))
{
    $error_form=$_POST["comentario"]=="";
    if(!$error_form)
    {
        $url=DIR_SERV."/insertarComentario/".$_POST["btnCrearComentario"];
        $datos_env["comentario"]=$_POST["comentario"];
        $datos_env["idUsuario"]=$datos_usu_log->idusuario;
        $datos_env["api_session"]=$_SESSION["api_session"]["api_session"];
        $respuesta=consumir_servicios_REST($url,"POST",$datos_env);
        $obj=json_decode($respuesta);
        if(!$obj)
        {
            consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
            session_destroy();
            die(error_page("Marbella al Dia","Marbella al Dia","Error consumiendo el servicio: ".$url));
        }
        if(isset($obj->mensaje_error))
        {
            consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
            session_destroy();
            die(error_page("Marbella al Dia","Marbella al Dia",$obj->mensaje_error));
        }

        if(isset($obj->no_login))
        {
            session_unset();
            $_SESSION["seguridad"]="El tiempo de sesión de la API ha expirado";
            header("Location:../index.php");
            exit;
        }

        $_SESSION["comentario"]=$_POST["btnCrearComentario"];
        header("Location:principal.php");
        exit;

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marbella al Dia</title>
    <style>
        .grande{font-size:1.5em}
        .enlinea{display:inline}
        .enlace{border:none;background:none;color:blue;text-decoration:underline;cursor:pointer}
    </style>
</head>
<body>
    <h1>Marbella al Dia</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log->usuario;?></strong> - 
        <form class="enlinea" action="principal.php" method="post"> 
            <button name="btnSalir" class="enlace">Salir</button>
        </form>
    </div>
    <?php
    require "vistas/vista_noticias.php";
    ?>
</body>
</html>