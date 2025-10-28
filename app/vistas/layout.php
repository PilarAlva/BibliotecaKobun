
<?php session_start(); ?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/inicio.css">
    <link rel="stylesheet" href="css/style.css">

    <title> <?= $titulo; ?></title>
</head>

  

    <body>
        <?php require_once '../app/vistas/' . $direccionVista . '.php'; ?>
    </body>

   

</html>