<?php
if (isset($_POST["btnSalir"])) {
    session_destroy();
    mysqli_close($conexion);
    header("Location:index.php");
    exit;
}
?>
 <div class="centrar">
        Bienvenid@ <strong><?php echo $datos_usuario_log["usuario"]; ?></strong> 
        <form class="enlinea" action="index.php" method="post">
            <button class='enlace' name='btnSalir'>Salir</button>
        </form>
    </div>
<?php

require "vista_listar.php";
?>