
<?php session_start(); ?>
<!doctype html>
<html lang="es">
<base href="/BibliotecaKobun/public/">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <!--  <link rel="stylesheet" href="css/estilo.css"> -->

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/inicio.css">

    <title> <?= $titulo; ?></title>
</head>


    <body>
        <?php require_once '../app/vistas/' . $direccionVista . '.php'; ?>
    </body>

   
 <!-- Archivos .js -->
    <script src="js/main.js"></script>


</html>