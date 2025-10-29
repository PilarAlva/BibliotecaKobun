<header class="header">
        <?php
            include '../app/vistas/componentes/header.php'; 
        ?>
</header>

        <main class="main-container">

            <div class="row justify-content-center my-5">
                <div class="col">
                    <form action="<?php BASE_URL?>catalogo/b/" method="POST" class="d-flex">
                        <select name="filtro" class="form-select w-25 me-2 selector">
                            <option value="titulo" <?php if($filtro=='titulo') echo 'selected'; ?>>Título</option>
                            <option value="autor" <?php if($filtro=='autor') echo 'selected'; ?>>Autor</option>
                            <option value="genero" <?php if($filtro=='genero') echo 'selected'; ?>>Género</option>
                            <option value="contenido" <?php if($filtro=='contenido') echo 'selected'; ?>>Contenido</option>
                        </select>
                        <input type="text" name="q" class="form-control me-2 search-input" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda); ?>">
                        <button type="submit" class="btn btn-primary rounded-circle boton-busqueda"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>
            </div>
       
        <div class="my-5">
            <h3>Resultados de búsqueda</h3>
            <p>Cantidad de Resultados <?php echo $resultados ?></p>
        </div>

        <div class="flex mx-auto row w-75 p-3">
            <table class="table table-striped">

             <tbody>
                <?php foreach ($libros as $indice => $libro) { ?>

            <tr>
              
                <td></td>

                    <td><?php echo $offset + $indice + 1;?>.</td>

                    
                    <td class="w-0 mw-0 my-0">
                        <img src="img/no.png" class="mw-" alt="...">
                    </td>

                    
                    <td>
                        <div class="libro">
                            <a href="<?php BASE_URL . 'libro/id/' . $libro['id']?>">
                            <div>
                                <h5><?php echo htmlspecialchars($libro['titulo']); ?></h5>
                                <p style="margin: 0; padding: 0;">Por <?php echo htmlspecialchars($libro['autores']); ?></p>
                                <p><?php echo htmlspecialchars($libro['descripcion']); ?></p>

                                <div class="my-2">
                                    <small>Disponibilidad: </small>
                                    <?php if ($libro['cantidad'] > 0) {?>
                                    <small style="color: green"><?php echo $libro['cantidad']?> Disponibles</small>
                                    <?php } else { ?>
                                    <small style="color: red"> No hay ejemplares disponibles</small>
                                    <?php }  ?>

                                </div>
                            </div>
                            </a>
                            

                            <div>
                            <?php 
                            if (!empty($libro['generos'])) {
                            $generosArray = explode(',', $libro['generos']);
                            foreach ($generosArray as $genero) {
                                $genero = trim($genero);
                                if ($genero === '') continue;
                                $safeText = htmlspecialchars($genero, ENT_QUOTES, 'UTF-8');
                                $safeUrl  = rawurlencode($genero);
                                echo '<a class="btn btn-sm btn-outline-secondary rounded-pill me-2" href="index.php?filtro=genero&q=' . $safeUrl . '#">' . $safeText . '</a>';
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


<nav aria-label="Paginación">
    <ul class="pagination justify-content-center">
        <!-- Página anterior -->
        <li class="page-item <?php if($pagina <= 1) echo 'disabled'; ?>">
            <a class="page-link" href="?filtro=<?php echo $filtro; ?>&q=<?php echo urlencode($busqueda); ?>&pagina=<?php echo $pagina-1; ?>">Anterior</a>
        </li>

        <!-- Números de página -->
        <?php for($i = 1; $i <= $cantidad_paginas; $i++): ?>
            <li class="page-item <?php if($i == $pagina) echo 'active'; ?>">
                <a class="page-link" href="?filtro=<?php echo $filtro; ?>&q=<?php echo urlencode($busqueda); ?>&pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <!-- Página siguiente -->
        <li class="page-item <?php if($pagina >= $cantidad_paginas) echo 'disabled'; ?>">
            <a class="page-link" href="?filtro=<?php echo $filtro; ?>&q=<?php echo urlencode($busqueda); ?>&pagina=<?php echo $pagina+1; ?>">Siguiente</a>
        </li>
    </ul>
</nav>
        </div>

       
    </main>

    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
        crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/fe0bc071f5.js" crossorigin="anonymous"></script>

<footer>
        <?php
            include '../app/vistas/componentes/footer.php';
        ?>
</footer>
