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
        #form_regs_buscar{width:90%;margin:0.5em auto;display:flex;justify-content:space-between}
    </style>
</head>
<body>
    <h1>Práctica Rec 2</h1>
    <div>Bienvenido <strong><?php echo $datos_usuario_log["usuario"];?></strong> - <form method="post" action="index.php" class="en_linea"><button class="enlace" name="btnSalir">Salir</button></form>
    </div>
    <h2>Listado de los usuarios no admin</h2>
    <?php
    require "vistas/vista_tabla_principal.php";
    ?>
</body>
</html>