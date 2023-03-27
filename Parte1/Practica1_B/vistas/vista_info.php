<h2>Estos son los datos enviados:</h2>

<?php




echo "<p><strong>El nombre enviado ha sido: </strong>" . $_POST["nombre"] . "</p>";
echo "<p><strong>Ha nacido en: </strong>" . $_POST["nacido"] . "</p>";
echo "<p><strong>El sexo es: </strong>" . $_POST["sexo"] . "</p>";

//Aficiones
if (isset($_POST["aficiones"])) {

    $num_aficiones = count($_POST["aficiones"]);
 

    echo "<ol>";

    for ($i = 0; $i < $num_aficiones; $i++) {

        echo "<li>" . $_POST["aficiones"][$i] . "</li>";
    }
    echo "</ol>";
} else {

    echo "<p><strong>No has seleccionado ninguna afición</strong></p>";
}

if (isset($_POST["coment"]))  echo "<p><strong>El comentario enviado ha sido: </strong>" . $_POST["coment"] . "</p>";
else echo "<p><strong>No has hecho ningún comentario</strong></p>";



?>
  <p>Foto:
                <?php if ($_FILES["foto"]["name"] != "") {

                    $uniq = md5(uniqid(uniqid(), true));
                    $arr_nombre = explode(".", $_FILES["foto"]["name"]);
                    $ext = "";
                    if (count($arr_nombre) > 1) {
                        $ext = "." . end($arr_nombre);
                    }
                    $nuevo_nombre = "img_" . $uniq . $ext;
                } //Con el arroba se avisa del control del warning
                @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "img/" . $nuevo_nombre);
                ?>
            </p>
            <p>
                <?php
                ?>
            <p>
                Nombre:
                <?php echo $_FILES["foto"]["name"] ?><br>
                Tipo:
                <?php echo $_FILES["foto"]["type"] ?><br>
                Tamaño:
                <?php echo $_FILES["foto"]["size"] ?>
                Error:
                <?php echo $_FILES["foto"]["error"] ?>
            </p>
        <?php
         if ($var) {
                    echo "La imagen se ha movido a la carpeta destino con éxito";
                    echo "<img src='img/" . $nuevo_nombre . "'>";
                } else {
                    echo "<p>La imagen no ha podido ser movida por falta de permisos</p>";
                    //sudo chmod 777 -R '/opt/lampp/htdocs/PHP

                }
        ?>
        </p>