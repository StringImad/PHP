<?php
if(isset($_POST["btnBorrarNuevo"]))
{
    unset($_POST);
    $_SESSION["btnBorrarNuevo"]=true;
  
}

if(isset($_POST["btnContBorrarFoto"]))
{
     
    $url=DIR_SERV."/cambiar_foto/".$_POST["id_usuario"];
    $datos_update["foto"]="no_imagen.jpg";
    $respuesta=consumir_servicios_REST($url,"PUT",$datos_update);
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

    unlink("Img/".$_POST["foto_bd"]);
    $_SESSION["borrarFoto"]=$_POST["id_usuario"];
    header("Location:index.php");
    exit;
        

}
if(isset($_POST["btnContEditar"]))
{
    //comprobar errores formulario
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
        
        $url=DIR_SERV."/repetido_edit/usuario/".urlencode($_POST["usuario"])."/id_usuario/".urlencode($_POST["id_usuario"]);
        $respuesta=consumir_servicios_REST($url,"GET");
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
        $error_usuario=$obj->repetido;
       
    }
    $error_nombre=$_POST["nombre"]=="";
    $error_dni=$_POST["dni"]==""||!dni_bien_escrito($_POST["dni"])||!dni_valido($_POST["dni"]);
    if(!$error_dni)
    { 

        $url=DIR_SERV."/repetido_edit/dni/".strtoupper($_POST["dni"])."/id_usuario/".urlencode($_POST["id_usuario"]);
        $respuesta=consumir_servicios_REST($url,"GET");
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
        $error_dni=$obj->repetido;

    }
    $error_sexo=!isset($_POST["sexo"]);
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) ||$_FILES["foto"]["size"] >500*1024);
    $error_form=$error_usuario||$error_nombre||$error_dni||$error_sexo||$error_foto;

    if(!$error_form)
    {
        $subs=0;
        if(isset($_POST["subcripcion"]))
            $subs=1;

        $datos["nombre"]=$_POST["nombre"];
        $datos["usuario"]=$_POST["usuario"];
        $datos["dni"]=strtoupper($_POST["dni"]);
        $datos["sexo"]=$_POST["sexo"];
        $datos["subs"]=$subs;
        if($_POST["clave"]=="")
            $datos["clave"]=$_POST["clave"];
        else
            $datos["clave"]=md5($_POST["clave"]);

        
        $url=DIR_SERV."/modificar_usuario/".$_POST["id_usuario"];
        $respuesta=consumir_servicios_REST($url,"PUT",$datos);
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
            
       
  ///////////////////////////////      
        $mensaje="El usuario ha sido editado con éxito";

        if($_FILES["foto"]["name"]!="")
        {
            $array_ext=explode(".", $_FILES["foto"]["name"]);
            $ext="";
            if(count($array_ext)>0)
                $ext=".".end($array_ext);

            $nombre_nuevo_img="img_".$_POST["id_usuario"].$ext;

            //Siempre se mueve la nueva imagen y después se actualiza o no la base de datos
            @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"Img/".$nombre_nuevo_img);
            if($var)
            {
                //Si la nueva imagen movida, tiene distinto nombre
                //Hay que actualizar en la BD
                if($nombre_nuevo_img!=$_POST["foto_bd"])
                {
                    
                    $url=DIR_SERV."/cambiar_foto/".$_POST["id_usuario"];
                    $datos_update["foto"]=$nombre_nuevo_img;
                    $respuesta=consumir_servicios_REST($url,"PUT",$datos_update);
                    $obj=json_decode($respuesta);
                    if(!$obj)
                    {
                        unlink("Img/".$nombre_nuevo_img);
                        session_destroy();
                        die(error_page("Práctica 3 - SW","Práctica 3 - SW","Error consumiendo el servicio: ".$url));
                    }
                    if(isset($obj->mensaje_error))
                    {
                        unlink("Img/".$nombre_nuevo_img);
                        session_destroy();
                        die(error_page("Práctica 3 - SW","Práctica 3 - SW",$obj->mensaje_error));
                    } 

                    
                    if($_POST["foto_bd"]!="no_imagen.jpg")
                            unlink("Img/".$_POST["foto_bd"]);

                }
            }
            else
            {
                $mensaje="El usuario ha sido editado dejando la imagen anterior al no poder mover nueva imagen a carpeta destino en el servidor";
            }  
        }
        $_SESSION["accion"]=$mensaje;
        header("Location: index.php");
        exit;

     

    }

}


if(isset($_POST["btnContNuevo"]))
{
    //comprobar errores formulario
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
        
        $url=DIR_SERV."/repetido_reg/usuario/".urlencode($_POST["usuario"]);
        $respuesta=consumir_servicios_REST($url,"GET");
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
        $error_usuario=$obj->repetido;
       
    }
    $error_nombre=$_POST["nombre"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_dni=$_POST["dni"]==""||!dni_bien_escrito($_POST["dni"])||!dni_valido($_POST["dni"]);
    if(!$error_dni)
    { 

        $url=DIR_SERV."/repetido_reg/dni/".strtoupper($_POST["dni"]);
        $respuesta=consumir_servicios_REST($url,"GET");
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
        $error_dni=$obj->repetido;

    }
    $error_sexo=!isset($_POST["sexo"]);
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) ||$_FILES["foto"]["size"] >500*1024);
    $error_form=$error_usuario||$error_nombre||$error_clave||$error_dni||$error_sexo||$error_foto;

    if(!$error_form)
    {
        
        $subs=0;
        if(isset($_POST["subcripcion"]))
            $subs=1;
        $datos["usuario"]=$_POST["usuario"];
        $datos["clave"]=md5($_POST["clave"]);
        $datos["nombre"]=$_POST["nombre"];
        $datos["dni"]=strtoupper($_POST["dni"]);
        $datos["sexo"]=$_POST["sexo"];
        $datos["subs"]=$subs;

        $url=DIR_SERV."/insertar_usuario";
        $respuesta=consumir_servicios_REST($url,"POST",$datos);
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

        $mensaje="El usuario ha sido registrado con éxito";
        if($_FILES["foto"]["name"]!="")
        {
            $ultm_id=$obj->ultimo_id;
            $array_ext=explode(".", $_FILES["foto"]["name"]);
            $ext="";
            if(count($array_ext)>0)
                $ext=".".end($array_ext);

            $nombre_nuevo_img="img_".$ultm_id.$ext;
            @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"Img/".$nombre_nuevo_img);
            if($var)
            {
                
                $url=DIR_SERV."/cambiar_foto/".$ultm_id;
                $datos_update["foto"]=$nombre_nuevo_img;
                $respuesta=consumir_servicios_REST($url,"PUT",$datos_update);
                $obj=json_decode($respuesta);
                if(!$obj)
                {
                    session_destroy();
                    die(error_page("Práctica 3 - SW","Práctica 3 - SW","Error consumiendo el servicio: ".$url));
                }
                if(isset($obj->mensaje_error))
                {
                    unlink("Img/".$nombre_nuevo_img);
                    $mensaje="El usuario ha sido registrado con éxito con la imagen por defecto, por un problema con la BD";
                } 
               
            }
            else
                $mensaje="El usuario ha sido registrado con la imagen por defecto por no poder mover imagen a carpeta destino en el servidor";
        }

        $_SESSION["accion"]=$mensaje;
        header("Location: index.php");
        exit;
    }
}





if(isset($_POST["btnContBorrar"]))
{
    
    $url=DIR_SERV."/borrar_usuario/".$_POST["btnContBorrar"];
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
    
    if($_POST["foto"]!="no_imagen.jpg")
        unlink("Img/".$_POST["foto"]);
    
    $_SESSION["accion"]="El usuario ha sido borrado con éxito";
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 3 - SW</title>
    <style>
        .enlinea{display:inline}
        .enlace{border:none;background:none;color:blue;text-decoration:underline;cursor:pointer}
        #tabla_principal, #tabla_principal td, #tabla_principal th{border:1px solid black}
        #tabla_principal{width:90%; border-collapse:collapse;text-align:center;margin:0 auto}
        #tabla_principal th{background-color:#CCC}
        #tabla_principal img{height:75px}
        .centrado{text-align:center}
        .mensaje{color:blue;font-size:1.25em}
        #form_editar{display:flex;justify-content:space-between;}
        #form_editar img{width:60%}
    </style>
</head>
<body>
    <h1>Práctica 3 - SW</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log->usuario;?></strong> - 
        <form class="enlinea" action="index.php" method="post"> 
            <button name="btnSalir" class="enlace">Salir</button>
        </form>
    </div>
    <?php

    if(isset($_POST["btnNuevo"])|| isset($_SESSION["btnBorrarNuevo"])|| isset($_POST["btnContNuevo"]))
    {
        require "vistas/vista_usuario_nuevo.php";
    }


    if(isset($_POST["btnBorrar"]))
    {
        require "vistas/vista_borrar.php";
    }

    if(isset($_POST["btnListar"]))
    {
        require "vistas/vista_listar.php";
    }

    if(isset($_POST["btnEditar"]) ||  isset($_SESSION["borrarFoto"])||  isset($_POST["btnVolverBorrarFoto"])||  isset($_POST["btnContEditar"])|| isset($_POST["btnBorrarFoto"]))
    {
        require "vistas/vista_editar.php";
    }


    if(isset($_SESSION["accion"]))
    {
        echo "<p class='mensaje'>".$_SESSION["accion"]."</p>";
        unset($_SESSION["accion"]);
    }    

    require "vistas/vista_tabla_principal.php";
    ?>
</body>
</html>