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
                                            $portadaSrc = !empty($libros_prestados[$prestamo["ejemplar_id"]]['portada']) ? 'img/portadas/' . htmlspecialchars($libros_prestados[$prestamo["ejemplar_id"]]['portada']) : 'img/no.png';
                                        ?>
                                        <img src="<?php echo $portadaSrc; ?>" alt="Portada del libro <?php echo htmlspecialchars($libros_prestados[$prestamo["ejemplar_id"]]['titulo']); ?>">
                                    </div>
                                    <div class="info-libro-contenedor">
                                        <div>
                                            <a href="<?=BASE_URL?>libro/id/<?= $libros_prestados[$prestamo["ejemplar_id"]]['id']; ?>">
                                                <h4 class="titulo-libro"><?php echo htmlspecialchars($libros_prestados[$prestamo["ejemplar_id"]]['titulo']); ?></h4>
                                                <p class="autor-libro">Por <?php echo htmlspecialchars($libros_prestados[$prestamo["ejemplar_id"]]['autores']); ?></p>
                                            </a>
                                        </div>
                                        <div>
                                            <?php if ($prestamo['fecha_devolucion']): ?>
                                                <p class="devuelto">Devuelto el: <?php echo date("d/m/Y", strtotime($prestamo['fecha_devolucion'])); ?></p>
                                            <?php else: ?>
                                                <?php if ($prestamo['fecha_vencimiento'] < date('Y-m-d')): ?>
                                                    <p class="msj-rojo">Reservado hasta: <?php echo date("d/m/Y", strtotime($libros_prestados[$prestamo["ejemplar_id"]]['fecha_vencimiento'])); ?></p>
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
