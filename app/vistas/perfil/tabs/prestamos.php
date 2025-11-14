<!-- Contenido para "Préstamos" -->
                <div id="prestamos" class="tab-content">
                    <h3>Mis Préstamos</h3>
                    
                    <div>
                        <?php
                        if (!$socio) {
                            echo '<p class="sin-contenido">Para pedir préstamos, primero debe asociarse a la biblioteca.</p>';
                        } elseif (empty($prestamos)) {
                            echo '<p class="sin-contenido">No tiene préstamos activos.</p>';
                        } else {
                            // Iteramos sobre cada préstamo para mostrarlo
                            foreach ($prestamos as $prestamo) { ?>
                                <div class="libro">
                                    <div class="imagen-libro-cont">
                                        <?php
                                            $portadaSrc = BASE_IMG . $prestamo['portada'];;
                                        ?>
                                        <img src="<?php echo $portadaSrc; ?>" alt="Portada del libro <?php echo htmlspecialchars($prestamo['titulo']); ?>">
                                    </div>
                                    <div class="info-libro-contenedor">
                                        <div>
                                            <a href="<?=BASE_URL?>libro/id/<?= $prestamo['id']; ?>">
                                                <h4 class="titulo-libro"><?php echo htmlspecialchars($prestamo['titulo']); ?></h4>
                                                <p class="autor-libro">Por <?php echo htmlspecialchars($prestamo['autores']); ?></p>
                                            </a>
                                        </div>
                                        <div>
                                            <?php if ($prestamo['fecha_devolucion']): ?>
                                                <p class="devuelto">Devuelto el: <?php echo date("d/m/Y", strtotime($prestamo['fecha_devolucion'])); ?></p>
                                            <?php else: ?>
                                                <?php if ($prestamo['fecha_vencimiento'] < date('Y-m-d')): ?>
                                                    <p class="msj-rojo">Reservado hasta: <?php echo date("d/m/Y", strtotime($prestamo['fecha_vencimiento'])); ?></p>
                                                <?php else: ?>
                                                    <p>Reservado hasta: <?php echo date("d/m/Y", strtotime($prestamo['fecha_vencimiento'])); ?></p>                                                
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                        <?php } // Fin del foreach
                        } // Fin del else ?>
                    </div>
                </div>
