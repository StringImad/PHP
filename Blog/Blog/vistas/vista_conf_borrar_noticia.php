<?php
echo "<h2>Borrado de una noticia</h2>";
echo "<form action='gest_comentarios.php' method='post'>";
echo "<p>¿Está usted seguro que quieres borrar la noticia con Id=".$_POST["btnBorrarNoticia"]." y todos sus comentarios?</p>";
echo "<p><button>Cancelar</button> <button name='btnContBorrarNoticia' value='".$_POST["btnBorrarNoticia"]."'>Continuar</button></p>";
echo "</form>";
?>