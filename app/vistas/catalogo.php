<header class="header">
        <?php
            include '../app/vistas/componentes/header.php'; 
        ?>
</header>

    <main class="main-content">
        <section class="products-container">
            <header>
                <h1>Catálogo de Libros</h1>
                <p>Resultados encontrados: <?php echo $resultados; ?></p>
            </header>
            <?php if (!empty($libros)): ?>
                <?php foreach ($libros as $libro): ?>
                    <div class="book-item">
                        <img src="vistas/img/portadas/<?php echo htmlspecialchars($libro['portada']); ?>" alt="Portada de <?php echo htmlspecialchars($libro['titulo']); ?>">
                        <h2><?php echo htmlspecialchars($libro['titulo']); ?></h2>
                        <p class="authors"><?php echo htmlspecialchars($libro['autores']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No se encontraron libros.</p>
            <?php endif; ?>
               
        </section>
    </main>

<footer>
        <?php
            include '../app/vistas/componentes/footer.php';
        ?>
</footer>
