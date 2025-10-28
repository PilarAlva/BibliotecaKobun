<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>MVC PHP Example</title>
</head>
<body>
    <main class="wrapper">
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
</body>
</html>