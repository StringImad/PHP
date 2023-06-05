<?php
if(isset($_POST["btnContBorrar"]))
{
    $url=DIR_SERV."/borrarComentario/".$_POST["btnContBorrar"];
    $respuesta=consumir_servicios_REST($url,"DELETE",$_SESSION["api_session"]);
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        session_destroy();
        die(error_page("Marbella al Dia","Marbella al Dia","Error consumiendo el servicio: ".$url));
    }
    if(isset($obj->mensaje_error))
    {
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

    $_SESSION["accion"]="Comentario borrado con éxito";
    header("Location:gest_comentarios.php");
    exit;

}
if(isset($_POST["btnContBorrarNoticia"]))
{
    $url=DIR_SERV."/borrarNoticia/".$_POST["btnContBorrarNoticia"];
    $respuesta=consumir_servicios_REST($url,"DELETE",$_SESSION["api_session"]);
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        session_destroy();
        die(error_page("Marbella al Dia","Marbella al Dia","Error consumiendo el servicio: ".$url));
    }
    if(isset($obj->mensaje_error))
    {
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

    $_SESSION["accion"]="Noticia borrado con éxito";
    header("Location:gest_comentarios.php");
    exit;

}
if(isset($_POST["btnContAprobar"]))
{
    $url=DIR_SERV."/actualizarComentario/".$_POST["btnContAprobar"];
    $datos_act["estado"]="apto";
    $datos_act["api_session"]=$_SESSION["api_session"]["api_session"];
    $respuesta=consumir_servicios_REST($url,"PUT",$datos_act);
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

    $_SESSION["accion"]="Comentario aprobado con éxito";
    header("Location:gest_comentarios.php");
    exit;

}

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
        header("Location:gest_comentarios.php");
        exit;

    }
}
if(isset($_POST["btnContCrearNoticia"]))
{
    $error_titulo=$_POST["titulo"]=="";
    $error_copete=$_POST["copete"]=="";
    $error_cuerpo=$_POST["cuerpo"]=="";
    $error_form = $error_titulo || $error_copete || $error_cuerpo;
    //idUsuario es el usuario que este logueado y el idCategoria sacarlo desde un sele
    if(!$error_form)
    {
        // $datos_usu["idUsuario"]=$datos_usu_log->idusuario;
        $url2=DIR_SERV."/insertarNoticia/".$_POST['titulo']."/".$_POST['copete']."/".$_POST['cuerpo']."/2/2";
        echo $url2;
        $url=DIR_SERV."/insertarNoticia";
        $datos_env["titulo"] = $_POST['titulo'];
        $datos_env["copete"] = $_POST['copete'];
        $datos_env["cuerpo"] = $_POST['cuerpo'];
        $datos_env["idUsuario"] =2;
        $datos_env["idCategoria"] = $_POST['categoria'];

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
        $_SESSION["Noticia"]=$_POST["btnContCrearNoticia"];
        $_SESSION["accion"]="Noticia creada con éxito";

        header("Location:gest_comentarios.php");
        exit;

    }
}


if(isset($_POST["btnContEditarNoticia"])){

    $error_titulo=$_POST["titulo"]=="";
    $error_copete=$_POST["copete"]=="";
    $error_cuerpo=$_POST["cuerpo"]=="";


    $error_form = $error_titulo || $error_copete || $error_cuerpo;
    //idUsuario es el usuario que este logueado y el idCategoria sacarlo desde un sele
    if(!$error_form)
    {
        // $datos_usu["idUsuario"]=$datos_usu_log->idusuario;


        $url2=DIR_SERV."/actualizarNoticia/".$_POST["btnContEditarNoticia"]."/".$_POST["titulo"]."/".$_POST["copete"]."/".$_POST["cuerpo"]."/".$_POST["idCategoria"];
        $url=DIR_SERV."/actualizarNoticia/".$_POST["btnContEditarNoticia"];

         $datos_env["titulo"] = $_POST['titulo'];
         $datos_env["copete"] = $_POST['copete'];
         $datos_env["cuerpo"] = $_POST['cuerpo'];
         $datos_env["idCategoria"] = $_POST['idCategoria'];

        $datos_env["api_session"]=$_SESSION["api_session"]["api_session"];
        $respuesta=consumir_servicios_REST($url,"PUT",$datos_env);
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

        $mensaje=$obj->mensaje;
        $_SESSION["accion"]=$mensaje;

        header("Location:gest_comentarios.php");
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
        .enlinea{display:inline}
        .enlace{border:none;background:none;color:blue;text-decoration:underline;cursor:pointer}
        #tabla_comentarios, #tabla_comentarios td, #tabla_comentarios th{border:1px solid black}
        #tabla_comentarios{width:90%; border-collapse:collapse;text-align:center;margin:0 auto}
        #tabla_comentarios th{background-color:#CCC}
    </style>
</head>
<body>
    <h1>Marbella al Dia</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log->usuario;?></strong> - 
        <form class="enlinea" action="gest_comentarios.php" method="post"> 
            <button name="btnSalir" class="enlace">Salir</button>
        </form>
    </div> 

    <?php
        if(isset($_POST["btnVerNoticia"]) || isset($_POST["btnCrearComentario"]) || isset($_SESSION["comentario"]))
        {
            require "../vistas/vista_ver_noticia.php";

        }
        else
        {
            if(isset($_POST["btnCrearNoticia"])|| isset($_POST["btnContCrearNoticia"]))
            {
                echo "<h2>Crear Noticia</h2>";
                require "../vistas/vista_crear_noticia.php";
            
            }
            if(isset($_POST["btnBorrarNoticia"]))
            {
                echo "<h2>Borrar Noticia</h2>";

                require "../vistas/vista_conf_borrar_noticia.php";
            
            }

            if(isset($_POST["btnEditarNoticia"]))
            {
                echo "<h2>Editar Noticia</h2>";

                require "../vistas/vista_editar_noticia.php";
            }
            require "../vistas/vista_tabla_noticias.php";

            if(isset($_POST["btnBorrar"]))
            {
                require "../vistas/vista_conf_borrar.php";
            
            }

            if(isset($_POST["btnAprobar"]))
            {
                require "../vistas/vista_conf_aprobar.php";
            }

            require "../vistas/vista_tabla_comentarios.php";

            if(isset($_SESSION["accion"]))
            {
                echo "<p class='mensaje'>".$_SESSION["accion"]."</p>";
                unset($_SESSION["accion"]);
            }
        }
       
    ?>

</body>
</html>