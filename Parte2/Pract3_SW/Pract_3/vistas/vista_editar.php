<?php
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
?>