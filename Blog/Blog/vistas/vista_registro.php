<?php
if(isset($_POST["btnContRegistro"]))
{
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
        $url=DIR_SERV."/usuarios/usuario/".urlencode($_POST["usuario"]);
        $respuesta=consumir_servicios_REST($url,"GET");
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

        $error_usuario=isset($obj->usuarios);        
    }
    $error_clave=$_POST["clave"]=="";
    $error_email=$_POST["usuario"]==""||!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
    if(!$error_email)
    {
        $url=DIR_SERV."/usuarios/email/".urlencode($_POST["email"]);
        $respuesta=consumir_servicios_REST($url,"GET");
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

        $error_email=isset($obj->usuarios);    
    }

    $error_form=$error_usuario||$error_clave||$error_email;
    if(!$error_form)
    {
        $url=DIR_SERV."/insertarUsuario";
        $datos_env["usuario"]=$_POST["usuario"];
        $datos_env["clave"]=md5($_POST["clave"]);
        $datos_env["email"]=$_POST["email"];
        $respuesta=consumir_servicios_REST($url,"POST",$datos_env);
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

        $_SESSION["usuario"]=$datos_env["usuario"];
        $_SESSION["clave"]=$datos_env["clave"];
        $_SESSION["ultima_accion"]=time();
        $_SESSION["api_session"]["api_session"]=$obj->api_session;

        header("location:principal.php");
        exit();

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
    
</head>
<body>
    <h1>Marbella al Dia</h1>
    <h2>Registro Nuevo usuario</h2>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario : </label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"]?>"/>
            <?php
            if(isset($_POST["btnContRegistro"])&& $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* Usuario en uso *</span>";
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña : </label>
            <input type="password" name="clave" id="clave" />
            <?php
            if(isset($_POST["btnContRegistro"])&& $error_clave)
            {
                echo "<span class='error'>* Campo vacío *</span>";
            }
            ?>
        </p>
        <p>
            <label for="email">Email : </label>
            <input type="text" name="email" id="email" value="<?php if(isset($_POST["email"])) echo $_POST["email"]?>"/>
            <?php
            if(isset($_POST["btnContRegistro"])&& $error_email)
            {
                if($_POST["email"]=="")
                    echo "<span class='error'>* Campo vacío *</span>";
                elseif(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))
                    echo "<span class='error'>* Email no está bien escrito *</span>";
                else
                    echo "<span class='error'>* Email en uso *</span>";
            }
            ?>
        </p>
        <p>
            <button>Volver</button> <button name="btnContRegistro">Continuar</button>
        </p>
    </form>
</body>
</html>