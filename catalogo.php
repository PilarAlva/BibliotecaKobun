
<header class="header">
    <?php
        include '../app/vistas/componentes/header.php';
    ?>
</header>

<main class="main-content">

    <div class="buscador">
        <form action="<?= BASE_URL ?>catalogo/b/" method="POST">
            <select name="filtro" class="selector">
                <option value="titulo" <?php if($filtro=='titulo') echo 'selected'; ?>>Título</option>
                <option value="autor" <?php if($filtro=='autor') echo 'selected'; ?>>Autor</option>
                <option value="genero" <?php if($filtro=='genero') echo 'selected'; ?>>Género</option>
                <option value="contenido" <?php if($filtro=='contenido') echo 'selected'; ?>>Contenido</option>
            </select>

            <input type="text" name="q" class="search-input" placeholder="Buscar..." 
                   value="<?php echo htmlspecialchars($busqueda); ?>">

            <button type="submit" class="boton-busqueda">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <div class="encabezado">
        <h3>Resultados de búsqueda</h3>
        <p>Cantidad de Resultados <?php echo $resultados ?></p>
    </div>

    <div>
        <table class="tabla-libro">
            <tbody>
                <?php foreach ($libros as $indice => $libro) { ?>
                <tr>

                    <?php
                        // Ruta completa de imagen
                        $portada_full = BASE_IMG . $libro['portada'];

                        // Si no existe, usar imagen por defecto
                        if (!file_exists($portada_full)) {
                            $portada = BASE_IMG . "default.jpg";
                        } else {
                            $portada = $portada_full;
                        }
                    ?>

                    <td id="numero"><?php echo $offset + $indice + 1;?>.</td>

                    <td class="imagen-libro">
                        <img src="<?php echo $portada; ?>" alt="Portada del libro">
                    </td>

                    <td>
                        <div class="info-libro-contenedor">
                            <div class="info-libro">

                                <a href="<?= BASE_URL ?>libro/id/<?= $libro['id']; ?>" class="info-libro-link">

                                    <h3 class="titulo-libro">
                                        <?= htmlspecialchars($libro['titulo']); ?>
                                    </h3>

                                    <p class="autor-libro">
                                        Por <?= htmlspecialchars($libro['autores']); ?>
                                    </p>

                                    <p class="descripcion-libro">
                                        <?= htmlspecialchars($libro['descripcion']); ?>
                                    </p>

                                    <div>
                                        <small>Disponibilidad: </small>

                                        <?php if ($libro['cantidad'] > 0) { ?>
                                            <small style="color: green">
                                                <?= $libro['cantidad'] ?> Disponibles
                                            </small>
                                        <?php } else { ?>
                                            <small style="color: red">
                                                No hay ejemplares disponibles
                                            </small>
                                        <?php } ?>

                                    </div>

                                </a>
                            </div>

                            <div class="generos-libro">
                                <?php
                                if (!empty($libro['generos'])) {
                                    $generosArray = explode(',', $libro['generos']);

                                    foreach ($generosArray as $genero) {
                                        $genero = trim($genero);
                                        if ($genero === '') continue;

                                        $genero_url = str_replace(' ', '_', $genero);
                                        $safeText = htmlspecialchars($genero, ENT_QUOTES, 'UTF-8');
                                        
                                        echo '<a class="genero-libro" href="' 
                                            . BASE_URL . 'catalogo/b/genero/' . $genero_url . '">'
                                            . $safeText . '</a>';
                                    }
                                }
                                ?>
                            </div>

                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <nav aria-label="Paginación" class="paginacion">

            <div class="paginacion_anterior <?php if ($pagina <= 1) echo 'disabled'; ?>">
                <?php if ($pagina > 1): ?>
                    <a href="<?= $url_paginacion . ($pagina - 1); ?>">Anterior</a>
                <?php else: ?>
                    <span>Anterior</span>
                <?php endif; ?>
            </div>

            <ul class="paginacion_numeros">
                <?php foreach($paginas_mostrar as $i => $num_pagina) { ?>
                    <li>
                        <a class="paginacion_numero <?php if ($num_pagina == $pagina) echo 'active'; ?>"
                           href="<?= $url_paginacion . $num_pagina ?>">
                           <?= $num_pagina ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>

            <div class="paginacion_siguiente <?php if ($pagina >= $cantidad_paginas) echo 'disabled'; ?>">
                <?php if ($pagina < $cantidad_paginas): ?>
                    <a href="<?= $url_paginacion . ($pagina + 1); ?>">Siguiente</a>
                <?php else: ?>
                    <span>Siguiente</span>
                <?php endif; ?>
            </div>

        </nav>

    </div>
</main>

<script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    crossorigin="anonymous"></script>

<script src="https://kit.fontawesome.com/fe0bc071f5.js" crossorigin="anonymous"></script>

<footer>
    <?php include '../app/vistas/componentes/footer.php'; ?>
</footer>