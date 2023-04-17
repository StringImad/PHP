<h2 class="centrar">Listado de usuarios</h2>
<?php
try {
    $consulta = "select * from usuarios ";

    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();

    $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    echo "<table class='centrar'>";

    echo "<tr>
    <th>#</th>
    <th>Foto</th>
    <th>Nombre</th>
            <th> <form action='index.php' method='post'><button type='submit' name='btnUsuarioNuevo'>Usuario+</button></form></th>
          
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
                        <button type='submit' name='boton_listar' value='" . $tupla["id_usuario"] . "'>
                            " . $tupla["nombre"] . "
                        </button>
                    </form>   
                        </td>
                        <td>  <form action='index.php' method='post'>
                        <button type='submit' name='boton_borrar' value='" . $tupla["id_usuario"] . "'>
                       Borrar </button>
                    </form> -  <form action='index.php' method='post'>
                    <button type='submit' name='boton_editar' value='" . $tupla["id_usuario"] . "'>
       Editar
                    </button>
                </form></td>
                    </tr>";
    }

    echo "</table>";
} catch (PDOException $e) {
    session_destroy();
    $sentencia = null;
    $conexion = null;
    die(error_page("Práctica Rec 2", "Práctica Rec 2", "Imposible realizar la consulta. Error:" . $e->getMessage()));
}
?>