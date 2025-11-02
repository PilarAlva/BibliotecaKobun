<header class="header">
    <?php
        include '../app/vistas/componentes/header.php';
    ?>
</header>

<main class="main-content">

    <div class="buscador">
        <form action="<?php BASE_URL?>catalogo/b/" method="POST">
            <input type="text" name="q" class="search-input" placeholder="Buscar..." value="<?php echo htmlspecialchars(''); ?>">
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
                <?php foreach ($talleres as $indice => $taller) { ?>
                <tr>
                    <td id="numero"><?php echo $offset + $indice + 1;?>.</td>
                    <td class="imagen-libro">
                        <img src="img/no.png" alt="...">
                    </td>
                    <td>
                        <div class="info-libro-contenedor">
                            <div class="info-libro">
                                <a href="<?=BASE_URL?>taller/info/<?= $taller['taller_id']; ?>" class="info-libro-link">
                                    <h3 class="titulo-libro"><?php echo htmlspecialchars($taller['taller_nombre']); ?></h3>
                                    <p class="autor-libro">Por <?php echo htmlspecialchars($taller['profesor_nombre']); ?></p>
                                    <p class="descripcion-libro"><?php echo htmlspecialchars($taller['descripcion']); ?></p>

                                </a>
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
