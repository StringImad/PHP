<?php
//devuelve tres posibles Json
//'mensaje error' muero
//'usuario' datos del usuario
//'mensaje' usuario no se encuentra en la bd
require __DIR__ . '/Slim/autoload.php';
define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_tienda");

$app = new \Slim\App;
function login($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "select * from usuarios where id_usuario = ? and clave = ?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$datos[0],$datos[1]]);
            $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            $respuesta["mensaje_error"] = "Imposible realizar la consulta. Error:" . $e->getMessage();
        }

        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error:" . $e->getMessage();
    }


    return $respuesta;
}
$app->post('/login', function ($request) {

    $datos[] = $request->getParam('usuario');
    $datos[] = $request->getParam('clave');

    echo json_encode(login($datos));
});

// Una vez creado servicios los pongo a disposición
$app->run();
