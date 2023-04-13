<?php
function LetraNIF($dni)
{
    return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1);
}

function dni_bien_escrito($texto)
{
    $dni = strtoupper($texto);
    return strlen($dni) == 9 && is_numeric(substr($dni, 0, 8)) && substr($dni, 8, 1) >= "A" && substr($dni, 8, 1) <= "Z";
}
function dni_valido($dni)
{
    return LetraNIF(substr($dni, 0, 8)) == strtoupper(substr($dni, -1));
}

function repetido($conexion, $tabla, $columna, $valor, $columna_clave = null, $valor_clave = null)
{


    if (isset($columna_clave)) {

        $consulta = "SELECT * FROM " . $tabla . " WHERE " . $columna . " = ? AND " . $columna_clave . "<> ?";
        $datos[] = $valor;
        $datos[] = $valor_clave;
    } else {

        $consulta = "SELECT * FROM " . $tabla . " WHERE " . $columna . " = ?";
        $datos[] = $valor;
    }

    try{
$sentencia = $conexion->prepare($consulta); //Prepara la consulta
    $sentencia->execute($datos); //La ejecuta


    $repetido = $sentencia->rowCount() > 0; //Si existe, está repetido
    $sentencia = null;

    } catch (PDOException $e){

        $repetido = "No se ha podido comprobar la BD. Error: ".$e->getMessage();
    }

    return $repetido;
}

function error_page($title,$encabezado,$mensaje)
{
    return "<!DOCTYPE html>
    <html lang='es'>
        <head>
            <meta charset='UTF-8'/>
            <title>".$title."</title>
        </head>
        <body>
            <h1>".$encabezado."</h1>
            <p>".$mensaje."</p>
        </body>
    </html>";
    
}

?>