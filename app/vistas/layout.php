<!doctype html>
<html lang="es">
<!-- <base href="/BibliotecaKobun/public/"> -->
<base href="/Kobun/public/">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <!-- CSS Global que se carga en todas las páginas -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Carga de CSS específico para cada página -->
    <?php if (isset($cssEspecifico) && !empty($cssEspecifico)): ?>
        <link rel="stylesheet" href="css/<?php echo htmlspecialchars($cssEspecifico); ?>">
    <?php endif; ?>
    
    <title> <?= $titulo; ?></title>
</head>


    <body>
        <?php require_once '../app/vistas/' . $direccionVista . '.php'; ?>
    </body>

   
    <!-- Archivos .js -->
    <script src="js/main.js"></script>


</html>