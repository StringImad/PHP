<?php
if(isset($_POST["btnBorrarNuevo"]))
{
    unset($_POST);
    $_SESSION["btnBorrarNuevo"]=true;
  
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
        
        if(isset($_POST["btnEditar"])||isset($_SESSION["borrarFoto"]))
        {
            if(isset($_POST["btnEditar"]))
                $id_usuario=$_POST["btnEditar"];
            else
            {
                $id_usuario=$_SESSION["borrarFoto"];
                unset($_SESSION["borrarFoto"]);
            }
            
            $url=DIR_SERV."/obtener_usuario/".$id_usuario;
            $respuesta=consumir_servicios_REST($url,"GET");
            $obj=json_decode($respuesta);
            if(!$obj)
            {
                session_destroy();
                die("<p>Error consumiendo el servicio: ".$url."</p></body></html>");
            }
            if(isset($obj->mensaje_error))
            {
                session_destroy();
                die("<p>".$obj->mensaje_error."</p></body></html>");
            }

   
            if(isset($obj->usuario))
            {           
                $nombre=$obj->usuario->nombre;
                $usuario=$obj->usuario->usuario;
                $dni=$obj->usuario->dni;
                $foto_bd=$obj->usuario->foto;
                $subs=$obj->usuario->subscripcion;
                $sexo=$obj->usuario->sexo;
            }
            else
            {
                $error_existencia=true;
            }
 
            
        }
        else
        {
            $id_usuario=$_POST["id_usuario"];
            $subs=0;
            if(isset($_POST["subcripcion"]))
                $subs=1;
         
            $usuario=$_POST["usuario"];
            $nombre=$_POST["nombre"];
            $dni=$_POST["dni"];
            $sexo=$_POST["sexo"];
            $foto_bd=$_POST["foto_bd"];
        }

        echo "<h2>Editando el usuario con id: ".$id_usuario."</h2>";
        if(isset($error_existencia))
        {
            echo "<form action='index.php' method='post'>";
            echo "<p>El usuario ya no se encuentra registrado en la BD</p>";
            echo "<p><button>Volver</button></p>";
            echo "</form>";
        }
        else
        {
        ?>
            <form id="form_editar" action="index.php" method="post" enctype="multipart/form-data">
            <div>    
            <p>
                <label for="usuario">Usuario:</label><br/>
                <input type="text" id="usuario" name="usuario" placeholder="Usuario..." value="<?php echo $usuario;?>"/>
                <?php
                if(isset($_POST["btnContEditar"])&&$error_usuario)
                {
                    if($_POST["usuario"]=="")
                        echo "<span class='error'> Campo Vacío </span>";
                    else
                        echo "<span class='error'> Usuario repetido </span>";
                }
                ?>
            </p>
            <p>
                <label for="nombre">Nombre:</label><br/>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre..." value="<?php echo $nombre;?>"/>
                <?php
                if(isset($_POST["btnContEditar"])&&$error_nombre)
                {
                    echo "<span class='error'> Campo Vacío </span>";
                }
                ?>
            </p>
            <p>
                <label for="clave">Contraseña:</label><br/>
                <input type="password" id="clave" name="clave" placeholder="Contraseña..." value=""/>
                
            </p>
            <p>
                <label for="dni">DNI:</label><br/>
                <input type="text" id="dni" name="dni" placeholder="DNI: 11223344Z" value="<?php echo $dni;?>"/>
                <?php
                if(isset($_POST["btnContEditar"])&&$error_dni)
                    if($_POST["dni"]=="")
                        echo "<span class='error'> Campo Vacío </span>";
                    else if(!dni_bien_escrito($_POST["dni"]))
                        echo "<span class='error'> DNI no está bien escrito </span>";
                    else if(!dni_valido($_POST["dni"]))
                        echo "<span class='error'> DNI no válido </span>";
                    else
                        echo "<span class='error'> DNI repetido </span>";
                ?>
            </p>
            <p>
                <label>Sexo:</label>
                <?php
                if(isset($_POST["btnContEditar"])&&$error_sexo)
                    echo "<span class='error'> Debes seleccionar un sexo </span>";
                ?>
                <br/>
                <input type="radio" <?php if($sexo=="hombre") echo "checked";?> name="sexo" id="hombre" value="hombre"/> <label for="hombre">Hombre</label><br/>
                <input type="radio" <?php if($sexo=="mujer") echo "checked";?> name="sexo" id="mujer" value="mujer"/> <label for="mujer">Mujer</label>

            </p>
            <p>
                <label for="foto">Incluir mi foto (Máx 500 KB):</label><input type="file" id="foto" name="foto" accept="image/*"/>
                <?php
                if(isset($_POST["btnContEditar"])&&$error_foto)
                {
                    if($_FILES["foto"]["error"])
                    {
                        echo "<span class='error'> Error en la subida del fichero al servidor </span>";
                    }
                    elseif(!getimagesize($_FILES["foto"]["tmp_name"]))
                    {
                        echo "<span class='error'> Error, no has seleccionado un archivo imagen </span>";
                    }
                    else
                        echo "<span class='error'> Error, el tamaño del fichero seleccionado supera los 500KB </span>";
                }
                ?>
            </p>
            <p>
                <input type="checkbox" <?php if($subs==1) echo "checked";?>  name="subcripcion" id="sub"/> <label for="sub">Subcribirme al boletín de novedades</label>
            
            </p>
            <p>
                <input type="hidden" value="<?php echo $foto_bd;?>" name="foto_bd"/>
                <input type="hidden" value="<?php echo $id_usuario;?>" name="id_usuario"/>
                <input type="submit" name="btnContEditar" value="Guardar Cambios"/> 
                <input type="submit" name="btnVolver" value="Volver"/>
            </p>
            </div>
            <div class='centrado'>
                <img src='Img/<?php echo $foto_bd;?>' alt='Foto perfil' title='Foto perfil'/><br/>
                <?php
                if($foto_bd!="no_imagen.jpg")
                {
              
                    if(isset($_POST["btnBorrarFoto"]))
                    {
                            echo "<p>¿Estás seguro que quieres borrar foto?</p>";
                            echo "<p><button name='btnVolverBorrarFoto'>Volver</button> <button name='btnContBorrarFoto'>Continuar</button></p>";
                    }
                    else
                    {
                        echo "<button name='btnBorrarFoto'>Borrar</button>";
                    }
                }
                ?>
            </div>
        </form>
        <?php
        }
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