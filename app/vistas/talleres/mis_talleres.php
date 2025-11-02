

    <h3>Mis Tallers</h3>
    <p>Cantidad de Resultados <?php echo $resultados ?></p>


    <table class="tabla-libro">
        <tbody>
            <?php foreach ($mis_talleres as $indice => $taller) { ?>
            <tr>
                <td id="numero"><?php echo $indice + 1 ?>.</td>
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

                                <?php if ($taller["activo_usuario"] == 1):?>
                                    
                                    <small style="color: green"> Anotado</small>
                                    
                                    
                                    <?php  else: ?>
                                        <small style="color: red"> En espera</small>
                                <?php endif;?>

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

