<h2 class="centrar">Listado de los usuarios</h2>
<?php
$inicio = ($_SESSION["pag"] - 1) * $_SESSION["registros"];
try {
    $consulta = "select * from usuarios  
    
    LIMIT " . $inicio . "," . $_SESSION["registros"];


    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();

    $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    echo "<table class='centrar'>";

    echo "<tr>
    <th>#</th>
    <th>Foto</th>
    <th>Nombre</th>
            <th> <form action='index.php' method='post'>
            <button type='submit' name='btnUsuarioNuevo'>Usuario+</button></form></th>
          
        </tr>";
    foreach ($resultado as $tupla) {

        echo "<tr>
                        <td>
                                    " . $tupla["id_usuario"] . "
                        </td>
                        <td>
                        <img class='perfil' src='Img/" . $tupla["foto"] . "' alt='Foto de perfil' title='Imagen identificativa del usuario'/>
                        </td>
                        <td>
                            <form action='index.php' method='post'>
                                <button type='submit' name='btnListarUsuario' value='" . $tupla["id_usuario"] . "'>".$tupla["nombre"]."</button>

                                </form>   
                        </td>

                        <td>  
                            <form action='index.php' method='post'>
                                <button type='submit' name='btnBorrar' value='" . $tupla["id_usuario"] . "'>Borrar</button>
                                <input type='hidden' name='foto' value='" . $tupla["foto"] . "'>

                            </form> 
                    - 
                        
                            <form action='index.php' method='post'>
                                <button type='submit' name='btnEditar' value='" . $tupla["id_usuario"] . "'>
                                          Editar
                                </button>
                             </form>
                    </td>
                    </tr>";
    }

    echo "</table>";
    try {
        $consulta = "select * from usuarios  
        WHERE tipo = 'normal'";

        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
        $n_usuarios = $sentencia->rowCount();
        $sentencia = null;
    } catch (PDOException $e) {
        session_destroy();
        $sentencia = null;
        $conexion = null;
        die(("<p>Imposible realizar la consulta. Error:" . $e->getMessage()) . "</p></body></html>");
    }
} catch (PDOException $e) {
    session_destroy();
    $sentencia = null;
    $conexion = null;
    die(("<p>Imposible realizar la consulta. Error:" . $e->getMessage()) . "</p></body></html>");
}
$n_paginas = ceil($n_usuarios / $_SESSION["registros"]);
if ($n_paginas > 1) {
    echo "<div id='bot_pag'>";

    echo " <form action='index.php' method='post'>";
    if ($_SESSION["pag"] <> 1) {
        echo "  <button name='pag' value='1'>
    |< </button>";
        echo "  <button name='pag' value='" . ($_SESSION["pag"] - 1) . "'>
    < </button>";
    }
    for ($i = 1; $i <= $n_paginas; $i++) {
        if ($_SESSION["pag"] == $i) {
            echo "  <button disabled  name='" . $i . "' value='" . $i . "'>
        |< </button>";
        } else {
            echo "  <button  name='" . $i . "' value='" . $i . "'>
            " . $i . "< </button>";
        }
    }
    if ($_SESSION["pag"] <> $n_paginas) {
        echo "  <button name='pag' value='" . ($_SESSION["pag"] + 1) . "'>
    |< </button>";
        echo "  <button name='pag' value='" . $n_paginas . "'>
    < </button>";
    }
    echo "</form>";
    echo "</div>";
}

?>