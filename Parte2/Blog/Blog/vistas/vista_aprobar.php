<?php
echo "<div>";
echo "<h2>Aprobación del comentario con id: ".$_POST["btnAprobar"]."</h2>";
echo "<form action='gest_comentarios.php' method='post'>";
echo "<p class='centrado'>Se dispone usted a Aprobar el comentario con id: ".$_POST["btnAprobar"]."<br/>";
echo "¿Estás seguro?</p>";
echo "<p class='centrado'><button>Cancelar</button> <button name='btnContAprobar' value='".$_POST["btnAprobar"]."'>Continuar</button>";
echo "</form>";
echo "</div>";
?>