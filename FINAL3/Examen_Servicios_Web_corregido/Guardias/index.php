<?php
session_name("examen_final");
session_start();
require "src/funciones.php";

// if (isset($_POST["btnSalir"])) {
//     consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
//     session_destroy();
// }
if (isset($_SESSION["usuario"])) {

    //   require "src/seguridad.php";
    // require "vistas/vista_principal.php";

      header("Location:principal.php");
     exit;
} else {
    require "vistas/vista_login.php";
}
?>
</body>

</html>