<?php
echo "<form action='gest_comentarios.php'  method='post'>";

echo "<p>";
echo "<label for='titulo'>Titulo:</label><br/>";
echo "<input type='text' name='titulo' value='";
if (isset($_POST["titulo"])) {
    echo $_POST["titulo"];
}
echo "'>";
if (isset($_POST["btnContCrearNoticia"]) && $error_form)
    echo "<span class='error'>* Campo vacío *</span>";
echo "</p>";

echo "<p>";
echo "<label for='copete'>Copete:</label><br/>";
echo "<input type='text' name='copete' value='";
if (isset($_POST["copete"])) {
    echo $_POST["copete"];
}
echo "'>";
if (isset($_POST["btnContCrearNoticia"]) && $error_form)
    echo "<span class='error'>* Campo vacío *</span>";
echo "</p>";


echo "<p>";
echo "<label for='cuerpo'>Cuerpo:</label><br/>";
echo "<input type='text' name='cuerpo' value='";
if (isset($_POST["cuerpo"])) {
    echo $_POST["cuerpo"];
}
echo "'>";
if (isset($_POST["btnContCrearNoticia"]) && $error_form)
    echo "<span class='error'>* Campo vacío *</span>";
echo "</p>";

echo "<p>";
echo "<button>Volver</button>";
echo " <button value='" . $_POST['btnCrearNoticia'] . "' name='btnContCrearNoticia'>Enviar</button>";
echo "</p>";
echo "</form>";


?>