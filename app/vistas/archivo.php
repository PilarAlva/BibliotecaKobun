<header class="header">
        <?php
            include '../app/vistas/componentes/header.php'; 
        ?>
    </header>
    
    <main class="main-content">

        <h1> Archivos </h1>
        
        <div style="max-width: 500px; margin: 0 auto;">
            <?php
            
                include '../app/vistas/componentes/subir_archivo.php';
            ?>
        </div>

        <a href="<?php echo BASE_URL ?>archivo/lista">Ir a la lista de archivos</a>

</main>

    <footer>

        <?php
            include '../app/vistas/componentes/footer.php';
        ?>

</footer>