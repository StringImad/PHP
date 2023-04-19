<?php
// Código para la paginación
if(!isset($_SESSION["registros"]))
{    
    $_SESSION["registros"]=3;
}



if(!isset($_SESSION["pag"]))
{
    $_SESSION["pag"]=1;
}

if(isset($_POST["pag"]))
{
    $_SESSION["pag"]=$_POST["pag"];
}

if (isset($_POST["boton_confirmar_borrar"])) {

    try {
        $id_usuario = $_POST["boton_confirmar_borrar"];

        $consulta = "DELETE FROM usuarios WHERE id_usuario = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);

        $_SESSION["mensaje_accion"] = "Usuario borrado con éxito";
        $sentencia = null;
        $conexion = null;
        header("Location:index.php");
        exit;
    } catch (PDOException $e) {
        session_destroy();
        $sentencia = null;
        $conexion = null;
        die(error_page("Práctica Rec 2", "Práctica Rec 2", "Imposible borrar el usuario. Error:" . $e->getMessage()));
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Rec 2</title>
    <style>
        .en_linea{display:inline}
        .enlace{background:none;border:none;text-decoration:underline;color:blue;cursor:pointer}
        #tabla_principal, #tabla_principal td, #tabla_principal th{border:1px solid black}
        #tabla_principal{width:90%; border-collapse:collapse;text-align:center;margin:0 auto}
        #tabla_principal th{background-color:#CCC}
        #tabla_principal img{height:75px}
        #bot_pag{display:flex;justify-content:center;margin-top:1em}
        #bot_pag button{margin:0 0.25em;padding:0.25em}
    </style>
</head>
<body>
    <h1>Práctica Rec 2</h1>
    <div>Bienvenido <strong><?php echo $datos_usuario_log["usuario"];?></strong> - <form method="post" action="index.php" class="en_linea"><button class="enlace" name="btnSalir">Salir</button></form>
    </div>
    <h2>Listado de los usuarios no admin</h2>
    <?php
    if (isset($_POST["btnNuevo"]) || isset($_POST["btnContRegistro"])) {

        require "vista_registro.php";
    }
    if (isset($_POST["btnBorrar"])) {

        require "Admin/vista_borrar.php";
    }
    try
    {
        $inicio=($_SESSION["pag"]-1)*$_SESSION["registros"];
        $consulta="select * from usuarios where tipo<>'admin' LIMIT ".$inicio.",".$_SESSION["registros"];
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
        $usuarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia=null;
    }
    catch(PDOException $e)
    {
        session_destroy();
        $sentencia=null;
        $conexion=null; 
        die("<p>Imposible realizar la consulta. Error:".$e->getMessage()."</p></body></html>");
    }

    echo "<table id='tabla_principal'>";
    echo "<tr>";
    echo "<th>#</th><th>Foto</th><th>Nombre</th>";
    echo "<th><form action='index.php' method='post'><button class='enlace' name='btnNuevo'>Usuario+</button></form></th>";
    echo "</tr>";
    foreach($usuarios as $tupla)
    {
        echo "<tr>";
        echo "<td>".$tupla["id_usuario"]."</td>";
        echo "<td><img src='Img/".$tupla["foto"]."' alt='foto' title='foto'/></td>";
        echo "<td>".$tupla["nombre"]."</td>";
        echo "<td><form action='index.php' method='post'><button class='enlace' name=' '>Borrar</button> - <button class='enlace' name='btnEditar'>Editar</button></form></td>";
        echo "</tr>";
    }

    echo "</table>";

    try
    {
        $consulta="select * from usuarios where tipo<>'admin'";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
        $n_usuarios=$sentencia->rowCount();
        $sentencia=null;
    }
    catch(PDOException $e)
    {
        session_destroy();
        $sentencia=null;
        $conexion=null; 
        die("<p>Imposible realizar la consulta. Error:".$e->getMessage()."</p></body></html>");
    }

    $n_paginas=ceil($n_usuarios/$_SESSION["registros"]);
    if($n_paginas>1)
    {
        echo "<div id='bot_pag'>";
        echo "<form action='index.php' method='post'>";
        if($_SESSION["pag"]<>1)
        {
            echo "<button name='pag' value='1'>|<</button>";
            echo "<button name='pag' value='".($_SESSION["pag"]-1)."'><</button>";
        }

        for($i=1; $i<=$n_paginas; $i++)
        {
            if($_SESSION["pag"]==$i)
                echo "<button disabled name='pag' value='".$i."'>".$i."</button>";
            else
                echo "<button  name='pag' value='".$i."'>".$i."</button>";
        }
        
        if($_SESSION["pag"]<>$n_paginas)
        {
            echo "<button name='pag' value='".($_SESSION["pag"]+1)."'>></button>";
            echo "<button name='pag' value='".$n_paginas."'>>|</button>";
        }
        echo "</form>";
        echo "<div>";
    }
    ?>
</body>
</html>