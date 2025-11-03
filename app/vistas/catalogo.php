<header class="header">
    <?php
        include '../app/vistas/componentes/header.php';
    ?>
</header>

<main class="main-content">

    <div class="buscador">
        <form action="<?php BASE_URL?>catalogo/b/" method="POST">
            <select name="filtro" class="selector">
                <option value="titulo" <?php if($filtro=='titulo') echo 'selected'; ?>>Título</option>
                <option value="autor" <?php if($filtro=='autor') echo 'selected'; ?>>Autor</option>
                <option value="genero" <?php if($filtro=='genero') echo 'selected'; ?>>Género</option>
                <option value="contenido" <?php if($filtro=='contenido') echo 'selected'; ?>>Contenido</option>
            </select>
            <input type="text" name="q" class="search-input" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda); ?>">
            <button type="submit" class="boton-busqueda"><i class="fa-solid fa-magnifying-glass"></i></button>
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
                    <td id="numero"><?php echo $offset + $indice + 1;?>.</td>
                    <td class="imagen-libro">
                        <img src="img/no.png" alt="...">
                    </td>
                    <td>
                        <div class="info-libro-contenedor">
                            <div class="info-libro">
                                <a href="<?=BASE_URL?>libro/id/<?= $libro['id']; ?>" class="info-libro-link">
                                    <h3 class="titulo-libro"><?php echo htmlspecialchars($libro['titulo']); ?></h3>
                                    <p class="autor-libro">Por <?php echo htmlspecialchars($libro['autores']); ?></p>
                                    <p class="descripcion-libro"><?php echo htmlspecialchars($libro['descripcion']); ?></p>

                                    <div>
                                        <small>Disponibilidad: </small>
                                        <?php if ($libro['cantidad'] > 0) {?>
                                        <small style="color: green"><?php echo $libro['cantidad']?> Disponibles</small>
                                        <?php } else { ?>
                                        <small style="color: red"> No hay ejemplares disponibles</small>
                                        <?php }  ?>
                                    </div>
                                </a>
                            </div>
    
                            <div>
                                <?php
                                if (!empty($libro['generos'])) {
                                    $generosArray = explode(',', $libro['generos']);
                                    foreach ($generosArray as $genero) {
                                        $genero = trim($genero);
                                        if ($genero === '') continue;
                                        $safeText = htmlspecialchars($genero, ENT_QUOTES, 'UTF-8');
                                        $safeUrl  = rawurlencode($genero);
                                        echo '<a class="genero-libro" href="index.php?filtro=genero&q=' . $safeUrl . '#">' . $safeText . '</a>';
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
            <ul>
                <!-- Página anterior -->
                <li>
                    <a href="<?php  echo $url_paginacion . $pagina-1 ?>">Anterior</a>
                </li>

                <!-- Números de página -->
                <?php for($i = 1; $i <= $cantidad_paginas; $i++): ?>
                    <li class="<?php if ($i == $pagina) echo 'active'; ?>">
                        <a href="<?php  echo $url_paginacion . $i ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Página siguiente -->
                <li>
                    <a href="<?php  echo $url_paginacion . $pagina+1 ?>">Siguiente</a>
                </li>
            </ul>
        </nav>

    </div>
</main>

<script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/fe0bc071f5.js" crossorigin="anonymous"></script>

<footer>
    <?php
        include '../app/vistas/componentes/footer.php';
    ?>
</footer>
