<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/inicio.css">

    <title> <?= $titulo; ?></title>
</head>

    <body>
        <?php require_once '../app/vistas/' . $direccionVista . '.php'; ?>
    </body>

</html>