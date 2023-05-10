<?php
echo "<div>";
echo "<h2>Borrado del usuario con id: ".$_POST["btnBorrar"]."</h2>";
echo "<form action='index.php' method='post'>";
echo "<input type='hidden' value='".$_POST["foto"]."' name='foto'/>";
echo "<p class='centrado'>Se dispone usted a borrar al usuario con id: ".$_POST["btnBorrar"]."<br/>";
echo "¿Estás seguro?</p>";
echo "<p class='centrado'><button>Cancelar</button> <button name='btnContBorrar' value='".$_POST["btnBorrar"]."'>Continuar</button>";
echo "</form>";
echo "</div>";
?>