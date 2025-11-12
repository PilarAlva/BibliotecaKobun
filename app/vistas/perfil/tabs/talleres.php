  <!-- Contenido para "Talleres" -->
                <div id="talleres" class="tab-content">
                    <h3>Mis Talleres</h3>
                    <div class="talleres-grid">
                        <?php
                            if (empty($talleres)) {
                        ?>
                            <div class="sin-contenido">
                                <p>No participa de ningún taller.</p>
                                <div class="boton-derecha">
                                    <button class="bt"><a href="<?php echo BASE_URL; ?>talleres">Ver Talleres</a></button>
                                </div>
                            </div>
                        <?php } else {
                                // Iteracion sobre cada taller
                                foreach ($talleres as $taller) { ?>
                                    <div class="taller">
                                        <a href="<?=BASE_URL?>taller/id/<?= $taller['taller_id']; ?>">
                                            <div class="taller-contenedor">  
                                                <div class="imagen-taller-cont">
                                                    <?php
                                                        $portadaSrc = !empty($taller['taller_portada']) ? 'img/portadas/' . htmlspecialchars($taller['taller_portada']) : 'img/talleres-default.webp';
                                                    ?>
                                                    <img src="<?php echo $portadaSrc; ?>" alt="Portada del taller <?php echo htmlspecialchars($taller['taller_nombre']); ?>">
                                                </div>
                                                <div class="info-taller-contenedor">
                                                    <h4 class="titulo-taller"><?php echo htmlspecialchars($taller['taller_nombre']); ?></h4>
                                                    <p>Profesor: <?php echo htmlspecialchars($taller['profesor_nombre'])?></p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php } // Fin del foreach
                            }
                        ?>

                    </div>

                </div>
