<!doctype html>
<html lang="es">
<!-- <base href="/BibliotecaKobun/public/"> -->
<base href="/BibliotecaKobun/public/">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <!--  <link rel="stylesheet" href="css/estilo.css"> -->
    <link rel="stylesheet" href="css/style.css">

    <?php if (isset($cssEspecifico) && !empty($cssEspecifico)){
            if (!is_array($cssEspecifico)) $cssEspecifico = [$cssEspecifico];
            
            foreach($cssEspecifico as $css){
        ?>
        
            <link rel="stylesheet" href="css/<?php echo htmlspecialchars($css); ?>">

    <?php }} ?>

    <title> <?= $titulo; ?></title>
</head>

    <body>
        <?php require_once '../app/vistas/' . $direccionVista . '.php'; ?>
    </body>
   
 <!-- Archivos .js -->
    <script src="js/main.js"></script>
    <script src="js/subir_archivo.js"></script>
    
    


</html>