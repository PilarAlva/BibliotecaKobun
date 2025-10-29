
<?php session_start(); ?>
<!doctype html>
<html lang="es">
<base href="/BibliotecaKobun/public/">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <!--  <link rel="stylesheet" href="css/estilo.css"> -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
        crossorigin="anonymous">
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