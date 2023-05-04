<?php

if (isset($_POST["btnContBorrar"])) {

    $url = DIR_SERV . "/obtener_un_usuario/" . $_POST["btnContBorrar"];

    $respuesta = consumir_servicios_REST($url, "delete");
    $obj = json_decode($respuesta);
    if (!$obj) {
        session_destroy();
        die(error_page("Práctica 3 - SW", "Práctica 3 - SW", "Error consumiendo el servicio: " . $url . $respuesta));
    }

    if (isset($obj->error)) {
        session_destroy();
        die(error_page("Práctica 3 - SW", "Práctica 3 - SW", $obj->mensaje_error));
    }
    echo "usuario borrado";
}


if (isset($_POST["btnContNuevo"])) {
    //comprobar errores formulario
    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {
        $url = DIR_SERV . "/repetido_reg/usuario/" . urlencode($_POST["usuario"]);

        $respuesta = consumir_servicios_REST($url, "GET");

        $obj = json_decode($respuesta);
        //si no es un json
        if (!$obj) {
            session_destroy();
            die(error_page("Práctica 3 - SW", "Práctica 3 - SW", "Error consumiendo el servicio: " . $url . $respuesta));
        }

        if (isset($obj->error)) {
            session_destroy();
            die(error_page("Práctica 3 - SW", "Práctica 3 - SW", $obj->mensaje_error));
        }

        $error_usuario = $obj->repetido;
    }
    $error_nombre = $_POST["nombre"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_dni = $_POST["dni"] == "" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    if (!$error_dni) {
       

        $url = DIR_SERV . "/repetido_reg/dni/" . urlencode(strtoupper($_POST["dni"]));

        $respuesta = consumir_servicios_REST($url, "GET");

        $obj = json_decode($respuesta);
        //si no es un json
        if (!$obj) {
            session_destroy();
            die(error_page("Práctica 3 - SW", "Práctica 3 - SW", "Error consumiendo el servicio: " . $url . $respuesta));
        }

        if (isset($obj->error)) {
            session_destroy();
            die(error_page("Práctica 3 - SW", "Práctica 3 - SW", $obj->mensaje_error));
        }

        $error_dni= $obj->repetido;

    }
    $error_sexo = !isset($_POST["sexo"]);
    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1024);
    $error_form = $error_usuario || $error_nombre || $error_clave || $error_dni || $error_sexo || $error_foto;

    if (!$error_form) {

            $subs = 0;
            if (isset($_POST["subcripcion"]))
                $subs = 1;
            $datos[] = $_POST["usuario"];
            $datos[] = md5($_POST["clave"]);
            $datos[] = $_POST["nombre"];
            $datos[] = strtoupper($_POST["dni"]);
            $datos[] = $_POST["sexo"];
            $datos[] = $subs;
    

            $url = DIR_SERV . "/insertar_usuario";

            $respuesta = consumir_servicios_REST($url, "POST",$datos);
    
            $obj = json_decode($respuesta);
            //si no es un json
            if (!$obj) {
                session_destroy();
                die(error_page("Práctica 3 - SW", "Práctica 3 - SW", "Error consumiendo el servicio: " . $url . $respuesta));
            }
    
            if (isset($obj->error)) {
                session_destroy();
                die(error_page("Práctica 3 - SW", "Práctica 3 - SW", $obj->mensaje_error));
            }

            
        if ($_FILES["foto"]["name"] != "") {
            $ultm_id = $obj->ultimo_id;
            $array_ext = explode(".", $_FILES["foto"]["name"]);
            $ext = "";
            if (count($array_ext) > 0)
                $ext = "." . end($array_ext);

            $nombre_nuevo_img = "img_" . $ultm_id . $ext;
            @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Img/" . $nombre_nuevo_img);
            if ($var) {

                $url = DIR_SERV . "/cambiar_foto/".$ultm_id;

                $respuesta = consumir_servicios_REST($url, "PUT",$datos);
        
                $obj = json_decode($respuesta);
                //si no es un json
                if (!$obj) {
                    session_destroy();
                    die(error_page("Práctica 3 - SW", "Práctica 3 - SW", "Error consumiendo el servicio: " . $url . $respuesta));
                }
        
                if (isset($obj->error)) {
                    unlink("Img/" . $nombre_nuevo_img);
                    die(error_page("Práctica 3 - SW", "Práctica 3 - SW", $obj->mensaje_error));
                }
    

               
            } else
                $mensaje = "El usuario ha sido registrado con la imagen por defecto por no poder mover imagen a carpeta destino en el servidor";
        }

        $_SESSION["accion"] = $mensaje;
        header("Location: index.php");
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
    <title>Práctica 3 - SW</title>
    <style>
        .enlinea {
            display: inline
        }

        .enlace {
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer
        }

        .en_linea {
            display: inline
        }

        .enlace {
            background: none;
            border: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        #tabla_principal,
        #tabla_principal td,
        #tabla_principal th {
            border: 1px solid black
        }

        #tabla_principal {
            width: 90%;
            border-collapse: collapse;
            text-align: center;
            margin: 0 auto
        }

        #tabla_principal th {
            background-color: #CCC
        }

        #tabla_principal img {
            height: 75px
        }
    </style>
</head>

<body>
    <h1>Práctica 3 - SW</h1>
    <div>
        Bienvenido <strong>
            <?php echo $datos_usu_log->usuario; ?>
        </strong> -
        <form class="enlinea" action="index.php" method="post">
            <button name="btnSalir" class="enlace">Salir</button>
        </form>
    </div>
    <?php
    if (isset($_POST["btnNuevo"])) {
    ?>
        <h2>Registro de un nuevo Usuario</h2>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <p>
                <label for="usuario">Usuario:</label><br />
                <input type="text" id="usuario" name="usuario" placeholder="Usuario..." value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>" />
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_usuario) {
                    if ($_POST["usuario"] == "")
                        echo "<span class='error'> Campo Vacío </span>";
                    else
                        echo "<span class='error'> Usuario repetido </span>";
                }
                ?>
            </p>
            <p>
                <label for="nombre">Nombre:</label><br />
                <input type="text" id="nombre" name="nombre" placeholder="Nombre..." value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>" />
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_nombre) {
                    echo "<span class='error'> Campo Vacío </span>";
                }
                ?>
            </p>
            <p>
                <label for="clave">Contraseña:</label><br />
                <input type="password" id="clave" name="clave" placeholder="Contraseña..." value="" />
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_clave) {
                    echo "<span class='error'> Campo Vacío </span>";
                }
                ?>
            </p>
            <p>
                <label for="dni">DNI:</label><br />
                <input type="text" id="dni" name="dni" placeholder="DNI: 11223344Z" value="<?php if (isset($_POST["dni"])) echo $_POST["dni"]; ?>" />
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_dni)
                    if ($_POST["dni"] == "")
                        echo "<span class='error'> Campo Vacío </span>";
                    else if (!dni_bien_escrito($_POST["dni"]))
                        echo "<span class='error'> DNI no está bien escrito </span>";
                    else if (!dni_valido($_POST["dni"]))
                        echo "<span class='error'> DNI no válido </span>";
                    else
                        echo "<span class='error'> DNI repetido </span>";
                ?>
            </p>
            <p>
                <label>Sexo:</label>
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_sexo)
                    echo "<span class='error'> Debes seleccionar un sexo </span>";
                ?>
                <br />
                <input type="radio" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "hombre") echo "checked"; ?> name="sexo" id="hombre" value="hombre" /> <label for="hombre">Hombre</label><br />
                <input type="radio" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer") echo "checked"; ?> name="sexo" id="mujer" value="mujer" /> <label for="mujer">Mujer</label>

            </p>
            <p>
                <label for="foto">Incluir mi foto (Máx 500 KB):</label><input type="file" id="foto" name="foto" accept="image/*" />
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_foto) {
                    if ($_FILES["foto"]["error"]) {
                        echo "<span class='error'> Error en la subida del fichero al servidor </span>";
                    } elseif (!getimagesize($_FILES["foto"]["tmp_name"])) {
                        echo "<span class='error'> Error, no has seleccionado un archivo imagen </span>";
                    } else
                        echo "<span class='error'> Error, el tamaño del fichero seleccionado supera los 500KB </span>";
                }
                ?>
            </p>
            <p>
                <input type="checkbox" <?php if (isset($_POST["subcripcion"])) echo "checked"; ?> name="subcripcion" id="sub" /> <label for="sub">Subcribirme al boletín de novedades</label>

            </p>
            <p>
                <input type="submit" name="btnContNuevo" value="Guardar Cambios" />
                <input type="submit" name="btnBorrarNuevo" value="Borrar los datos introducidos" />
                <input type="submit" name="btnVolver" value="Volver" />
            </p>
        </form>

    <?php

    }
    if (isset($_POST["btnListar"])) {
        require "vistas/Admin/vista_listar.php";
    }


    if (isset($_POST["btnBorrar"])) {
        require "vistas/Admin/vista_borrar.php";
    } ?>

    <div class="tabla_admin">
        <?php

        require "Admin/vista_tabla.php";
        ?>

    </div>

</body>

</html>