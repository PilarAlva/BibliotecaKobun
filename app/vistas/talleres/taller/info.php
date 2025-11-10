<header class="header">
        <?php
            include '../app/vistas/componentes/header.php'; 
        ?>
    </header>
    
    <div class="banner">
        <?php
            $portadaSrc = !empty($taller['taller_portada']) ? 'img/portadas/' . htmlspecialchars($taller['taller_portada']) : 'img/talleres-default.webp';
        ?>
        <img src="<?php echo $portadaSrc; ?>" alt="Portada del taller <?php echo htmlspecialchars($taller['taller_nombre']); ?>">                                        
    </div>

    <main id="info-por-taller" class="main-content">
        <div class="flecha-atras">
            <a href="<?= BASE_URL ?>talleres"><img src="<?= BASE_URL ?>/img/icono-back.png" alt="Volver a talleres"></a>
        </div>

        <div>
            <h1><?php echo $taller["taller_nombre"]?></h1>
            <h3>Profesor/a: <?php echo $taller["profesor_nombre"]?></h3>
        </div>

        <h3>Sobre el Taller</h3>
        <div class="informacion">
            <div>    
                <p><?php echo $taller["descripcion"]?></p>
            </div>
            <div>
                <p><span class="destacado">Horario:</span> <?php echo $taller["horario"]?></p>
                <p><span class="destacado">Lugar:</span> <?php echo $taller["lugar"]?></p>
            </div>
        </div>
        
        <!-- ACAAAA ME QUEDEEEE, VER EL TEMA DEL BOTÓN.  -->
        <div class="bt">
            <?php if (isset($_SESSION['usuario_id'])) { ?>

            <?php echo $estado; ?>
            <form method="POST" action="<?php BASE_URL?>taller/ins">

                <input type="hidden" name="taller_id" value="<?php echo $taller["taller_id"]?>">
                <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id'] ?>">
                
                <!-- <?php if ($estado == 'inscripto'):?> 
                    <button type="submit" class="destacado">Ir al taller</button>
                <?php endif;?> -->
            
                <?php if ($estado == 'no_inscripto'):?> 
                    <button type="submit" class="destacado">Anotarse</button>
                <?php endif;?>

                <?php if ($estado == 'en_espera'):?> 
                    <button type="submit" class="destacado">Pendiente</button>
                <?php endif;?>
                
            </form>

            <?php } else { ?>
                <p>Para incribirse a un taller debe estar registrado - <a href="<?php BASE_URL?>sesion">iniciar sesión</a></p>
            <?php } ?>
        </div>

    </main>

    <footer>
        <?php
            include '../app/vistas/componentes/footer.php';
        ?>

</footer>