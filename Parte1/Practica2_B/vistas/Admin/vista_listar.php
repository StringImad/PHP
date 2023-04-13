<h2 class="centrar">Listado de usuarios</h2>
<?php
$consulta = "select * from usuarios ";
try {
    $resultado = mysqli_query($conexion, $consulta);
    echo "<table class='centrar'>";

    echo "<tr>
    <th>#</th>
    <th>Foto</th>
    <th>Nombre</th>
            <th> <form action='index.php' method='post'><button type='submit' name='boton_nuevo'>Usuario+</button></form></th>
          
        </tr>";

    while ($tupla = mysqli_fetch_assoc($resultado)) {

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
                        <td> Borrar - Editar</td>
                    </tr>";
    }

    echo "</table>";
} catch (Exception $e) {

    $mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
    mysqli_close($conexion);
    session_destroy();
    die($mensaje);
}
?>