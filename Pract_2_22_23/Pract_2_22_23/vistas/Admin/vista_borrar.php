<?php

echo "<h3 class='centrar'>Borrar usuario</h3>";
echo "<p class='centrar'>¿Desea borrar el usuario " . $_POST["btnBorrar"] . "?</p>";
echo "<form class='centrar' action='index.php' method='post'>
                <button type='submit'>Atras</button>
                <button type='submit' name='boton_confirmar_borrar' value='" . $_POST["btnBorrar"] . "'>Confirmar</button>
            </form>";
?>