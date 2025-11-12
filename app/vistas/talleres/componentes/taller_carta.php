
<div class="taller">
    <a href="<?=BASE_URL?>taller/id/<?= $taller['taller_id']; ?>">
        <div class="taller-contenedor">  
            <div class="imagen-taller-cont">
                <?php
                    $portadaSrc = !empty($taller['portada']) ? BASE_IMG . $taller['portada'] : 'img/talleres-default.webp';
                ?>
                <img src="<?php echo $portadaSrc; ?>" alt="Portada del taller <?php echo htmlspecialchars($taller['nombre']); ?>">
            </div>  
            <div class="info-taller-contenedor">
                <h4><?php echo htmlspecialchars($taller['nombre']); ?></h4>
                <p>Profesor: <?php echo htmlspecialchars($taller['profesores_nombre'])?></p>
                
                <?php
                // Se verifica si el taller actual existe en el mapa de búsqueda.
                if ($comprar_inscripcion) {
                    if ($taller["usuario_activo"] == 1) { ?>
                        <small style="color: green">Anotado</small>
                    <?php }else{ ?>
                        <small style="color: red">Pendiente</small>
                    <?php }} ?>

            </div>
        </div>
    </a>
</div> 

