<script src="js/talleres2.js"></script>

<header class="header">
    <?php
        include '../app/vistas/componentes/header.php';
    ?>
</header>

<main class="main-content">
    
    <ul class="talleres_vista">
        <button id="btn_todos_talleres" tab = "talleres_section_todos_los_talleres" class="taller_menu_btn selected">Todos los talleres</button>    
        <button id="btn_mis_talleres" tab ="talleres_section_mis_talleres" class="taller_menu_btn ">Mis talleres</button>
    </ul>

    <?php
    if (empty($talleres)) { ?>
        <div class="sin-contenido">
            <p class="msj-gris">No hay Talleres Dsiponibles.</p>
        </div>
    <?php }
    else { ?>
        <div>
            <!-- MUESTRA DE TODOS LOS TALLERES-->
            <div id="talleres_section_todos_los_talleres">
                <h1 class="encabezado-talleres">Todos los Talleres</h1>
                <?php if (empty($talleres)): ?>
                    <p class="msj-gris">No hay talleres disponibles en este momento.</p>
                <?php else: ?>

                <div class="listado_talleres">
                    <?php
                    // Mapa de búsqueda para acceso rápido -> clave: 'taller_id', valor: el taller completo.
                    $misTalleresLookup = array_column($mis_talleres, null, 'taller_id');
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
                                        
                                        <?php
                                        // Se verifica si el taller actual existe en el mapa de búsqueda.
                                        if (isset($misTalleresLookup[$taller['taller_id']])) {
                                            $mi_taller_coincidente = $misTalleresLookup[$taller['taller_id']];
                                            if ($mi_taller_coincidente["activo_usuario"] == 1) : ?>
                                                <small style="color: green">Anotado</small>
                                            <?php else: ?>
                                                <small style="color: red">Pendiente</small>
                                            <?php endif;
                                        } ?>

                                    </div>
                                </div>
                            </a>
                        </div>            
                    <?php } ?> <!-- Fin del foreach --> 
                </div>
                <?php endif; ?>

                
                <!-- MUESTRA LOS TALLERES INACTIVOS - VISTA HABILITADO SOLO PARA ADMINS -->
                <div>
                    <?php if ($estado == 'admin'): ?> 
                        <hr class="linea-divisora">
                        <h2 class="encabezado-talleres"> Talleres Inactivos </h2>
                        <?php if ( empty($talleresInactivos) ): ?>
                            <div class="sin-contenido">
                                <p class="msj-gris">No hay talleres inactivos en este momento.</p>
                            </div>
                        <?php else: ?>
                            <div class="listado_talleres">
                                <?php foreach ($talleresInactivos as $taller) { ?>
                                    <div class="taller">
                                        <a href="<?=BASE_URL?>taller/id/<?= $taller['taller_id']; ?>">
                                            <div class="taller-contenedor">
                                                <div class="imagen-taller-cont">
                                                    <img src="img/talleres-default.webp" alt="Portada del taller <?php echo htmlspecialchars($taller['taller_nombre']); ?>">
                                                </div>
                                                <div class="info-taller-contenedor">
                                                    <h4 class="titulo-taller"><?php echo htmlspecialchars($taller['taller_nombre']); ?></h4>
                                                    <p>Profesor: <?php echo htmlspecialchars($taller['profesor_nombre'])?></p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div> <!-- Fin del listado_talleres -->
                        <?php endif; ?>
                    <?php endif;?>
                </div>
            </div>
            


            <!-- MUESTRA DE LOS TALLERES DEL USUARIO -->
            <div id="talleres_section_mis_talleres" hidden>
                <h1 class="encabezado-talleres">Mis Talleres</h1>

                <?php
                if(empty($mis_talleres)): ?>
                    <div class="sin-contenido">
                        <p class="msj-gris">No se inscribió a ningún taller.</p>
                    </div>
                <?php else: ?>
                    <div class="listado_talleres">
                        <?php foreach ($mis_talleres as $taller) { ?> 
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
                                            
                                            <?php if ($taller["activo_usuario"] == 1):?>                                
                                                <small style="color: green">Anotado</small>
                                            <?php  else: ?>
                                                <small style="color: red">Pendiente</small>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </a>
                            </div>            
                        <?php } ?> <!-- Fin del foreach --> 
                    </div>
                <?php endif; ?>
            </div>

        </div> <!-- Fin del div: 'talleres-cuerpo' -->
    <?php } ?>


</main>

<footer>
    <?php
        include '../app/vistas/componentes/footer.php';
    ?>
</footer>