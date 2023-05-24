<?php
echo "<div>";
echo "<h2>Borrado del comentario con id: ".$_POST["btnBorrar"]."</h2>";
echo "<form action='gest_comentarios.php' method='post'>";
echo "<p class='centrado'>Se dispone usted a borrar el comentario con id: ".$_POST["btnBorrar"]."<br/>";
echo "¿Estás seguro?</p>";
echo "<p class='centrado'><button>Cancelar</button> <button name='btnContBorrar' value='".$_POST["btnBorrar"]."'>Continuar</button>";
echo "</form>";
echo "</div>";
?>