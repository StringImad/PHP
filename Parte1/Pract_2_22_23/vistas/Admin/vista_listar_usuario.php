<?php
  try {
    $consulta = "select * from usuarios where id_usuario = ?";
    $id_usuario = $_POST["btnListarUsuario"];
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$id_usuario]);

    // $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    echo "<div class='centrar'>";
    if ($sentencia->rowCount() > 0) { //Si el usuario sigue existiendo

        $tupla = $sentencia->fetch(PDO::FETCH_ASSOC);

        echo "<h3>Datos del usuario " . $_POST["btnListarUsuario"] . "</h3>";
        echo "<p><strong>Nombre: </strong>" . $tupla["nombre"] . "</p>";
        echo "<p><strong>Usuario: </strong>" . $tupla["usuario"] . "</p>";
        echo "<form action='index.php' method='post'><button type='submit'>Atrás</button></form>";
    } else { //Si el usuario se borra durante

        echo "<p class ='error'>Error de consistencia. El usuario seleccionado ya no existe</p>";
        echo "<form action='index.php' method='post'><button type='submit'>Atrás</button></form>";

    }

    echo "</div>";
} catch (PDOException $e) {
    session_destroy();
    $sentencia = null;
    $conexion = null;
    die(("<p>Imposible realizar la consulta. Error:" . $e->getMessage()) . "</p></body></html>");
}
?>