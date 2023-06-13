<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
</head>

<body>
    <div>
        Bienvenido:
        <?php echo $_SESSION["usuario"];
        ; ?>
        <form method="post" action="index.php"><button type="submit" name="btnSalir">Salir</button></form>
    </div>
</body>

</html>