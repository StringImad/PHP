<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

    </style>
</head>

<body>
    <div>
        Bienvenido
        <?php echo $datos_usu_log->usuario; ?>
        <form method="post" action="index.php">
            <button type="submit" name="btnSalir">Salir</button>
        </form>
    </div>

    <h2>Equipos de guardia del Mar de Alboran</h2>
    <table class="tabla">
        <tr>
            <th></th>
            <th>Lunes</th>
            <th>MArte</th>
            <th>Mierco</th>
            <th>Jueve</th>
            <th>Vierne</th>
        </tr>
        <?php
        for ($i = 0; $i < 7; $i++) {
            echo "<tr>";
            for ($j = 0; $j < 5; $j++) {
                echo "<th>-";

                echo "</th>";

            }
            echo "</tr>";
        }
        ?>
    </table>
    <?php

    if (isset($_SESSION["seguridad"])) {
        echo "<p>" . $_SESSION["seguridad"] . "</p>";
    }
    ?>
</body>

</html>