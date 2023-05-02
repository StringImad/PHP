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
    <div class="tabla_admin">
        <?php

        $url = DIR_SERV . "/usuarios";
        $respuesta = consumir_servicios_rest($url, "GET");
        $obj = json_decode($respuesta);

        if (!$obj) {
            session_destroy();
            die(error_page("Práctica 3 - SW", "Práctica 3 - SW", "Error consumiendo el servicio: " . $url . $respuesta));
        }

        if (isset($obj->mensaje_error)) {
            session_destroy();
            die(error_page("Práctica 3 - SW", "Práctica 3 - SW", $obj->mensaje_error));
        }

        if (isset($obj->mensaje))
            $error_usuario = true;
        else {
        
            echo "<h1>" . $obj . "</h1>";
            echo "<h2>
                     Listado de los usuarios (" . count($obj->usuarios) . ")
                     <form class='linea' method='post'><button name='boton_nuevo' class='enlace'> [+] </button></form>
                 </h2>";
    
    
    
    
            echo "<table>";
            echo "<tr>
                     <th>ID</th>
                     <th>Usuario</th>
                     <th>Foto</th>
                     <th>Acción</th>
                 </tr>";
    
            foreach ($obj->usuarios as $tupla) {
    
                echo "<tr>
                         <th>" . $tupla->id_usuario . "</th>
                         <td><form action='index.php' method='post'><button class='enlace' name='boton_info' value='$tupla->id_usuario'>" . $tupla->usuario . "</button></form></td>
                         <td><img src='img/" . $tupla->foto . "' width='100px' height='auto'/></td>
                         <td>
                             <form action='index.php' method='post'>
                                 <button class='enlace' name='boton_editar' value='" . $tupla->id_usuario . "'>Editar</button>
                                 <span> - </span>
                                 <button class='enlace' name='boton_borrar' value='" . $tupla->id_usuario . "'>Borrar</button>
                             </form>
                         </td>
                     </tr>";
            }
            echo "</table>";
        }

        ?>

    </div>

</body>

</html>