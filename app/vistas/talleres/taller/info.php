<script>


    document.addEventListener('DOMContentLoaded', function() {
        const uploadPhotoInput = document.getElementById('upload-photo');

        uploadPhotoInput.addEventListener('change', function() {
            const file = this.files[0];
            console.log(1)
            if (file) {
                const formData = new FormData();
                formData.append('portada', file);
                formData.append('taller_id', this.getAttribute("tallerId"));

                fetch('<?php echo BASE_URL; ?>taller/subir_portada', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.estado=="exito") {
                        // Recargar la página para mostrar la nueva imagen
                        window.location.reload();
                    } else {
                        console.error('Error al subir la imagen:', data.mensaje);
                        alert('Error al subir la imagen: ' + data.mensaje);
                    }
                })
                .catch(error => {
                    console.error('Error en la petición fetch:', error);
                    alert('Ocurrió un error al intentar subir la imagen.');
                });
            }
        });
    });

    const botonPagar = document.getElementById('bt-pagar-cuota');

    if (botonPagar) {
        botonPagar.addEventListener('click', function(e) {
            e.preventDefault(); // Previene la navegación del <a>

            // Muestra un indicador de carga si quieres
            this.innerText = "Generando link...";

            fetch('<?php echo BASE_URL; ?>/pago/generar')
                .then(response => response.json())
                .then(data => {
                    if (data.link) {
                        // Redirige al usuario al checkout de Mercado Pago
                        window.location.href = data.link;
                    } else {
                        console.error('No se pudo generar el link de pago:', data.error);
                        alert('Hubo un error al generar el link de pago.');
                        this.innerText = "Pagar Cuota"; // Restaura el texto del botón
                    }
                })
                .catch(error => {
                    console.error('Error en la petición:', error);
                    alert('Error de conexión. Inténtalo de nuevo.');
                    this.innerText = "Pagar Cuota"; // Restaura el texto del botón
                });
        });
    }
</script>

<header class="header">
    <?php
        include '../app/vistas/componentes/header.php'; 
    ?> 
</header>

<?php if ($estado == 'admin'):?>
    
    <div class="banner-edit">
        <?php
        $portadaSrc = !empty($taller['portada']) ? BASE_IMG . $taller['portada'] : 'img/talleres-default.webp';
        ?>
        <label for="upload-photo" class="upload-label">
            <img src="<?php echo $portadaSrc; ?>" alt="Portada del taller <?php echo htmlspecialchars($taller['nombre']); ?>">
            <div class="overlay">
                <img src="img/icono-camara.png" alt="Cambiar foto" class="camera-icon">
            </div>
        </label>
        <input type="file" id="upload-photo" tallerId='<?php echo $taller["taller_id"]?>' name="photo" style="display: none;">
    </div>

<?php else:?>

<div class="banner">
    <?php
        $portadaSrc = !empty($taller['portada']) ? BASE_IMG . $taller['portada'] : 'img/talleres-default.webp';
    ?>
    <img src="<?php echo $portadaSrc; ?>" alt="Portada del taller <?php echo htmlspecialchars($taller['nombre']); ?>">                                        
</div>

<?php endif?>

<main id="info-por-taller" class="main-content">
    <div class="info-taller-contenedor">
        <div class="flecha-atras">
            <a href="<?= BASE_URL ?>talleres"><img src="<?= BASE_URL ?>/img/icono-volver.png" alt="Volver a talleres"></a>
        </div>

        <?php if ($estado == 'admin'):?>
            <!-- VISTA DEL ADMIN -->
            <!-- FORMULARIO DE EDICIÓN PARA ADMIN -->

            <form method="POST" action="<?php echo BASE_URL . 'taller/editar/' . $taller["taller_id"]?>">
                <div id="titulo-editable">
                    <input type="text" name="nombre" value="<?php echo $taller["nombre"]; ?>" placeholder="Nombre del Taller">
                    <h3>Profesor/a: <?php echo $taller["profesores_nombre"]?></h3>
                </div>

                <div id="form-contenedor">
                    <div id="form-descripcion">
                        <h3>Sobre el Taller</h3>    
                        <textarea id="descripcion-textarea" name="descripcion" placeholder="Descripción" rows="3"><?php echo $taller["descripcion"]; ?></textarea>
                    </div>
                    <div id="form-detalles">
                        <div class="form-grupo">
                            <p><span class="destacado">Horario:</span></p> 
                            <input type="text" name="horario" value="<?php echo $taller["horario"]; ?>" placeholder="Horario">
                        </div>
                        <div class="form-grupo">
                            <p><span class="destacado">Lugar:</span></p>
                            <input type="text" name="lugar" value="<?php echo $taller["lugar"]; ?>" placeholder="Lugar">                     
                        </div>                        
                    </div>
                </div>

                <div class="editar-taller">
                    <div class="form-grupo">
                        <input type="checkbox" id="taller-activo" name="activo" value="1" <?php if ($taller["activo"]) echo 'checked'; ?>>
                        <label for="taller-activo">Taller Activo</label>
                    </div>
                    <button class="bt destacado" type="submit">Guardar Cambios</button>
                </div>
            </form>

            <form class="form-eliminar-taller" method="POST" action="<?php echo BASE_URL . 'taller/eliminar/' . $taller["taller_id"]?>" onsubmit="return confirm('¿Está seguro de querer borrar el Taller?');">
                <button id="bt-eliminar" class="bt destacado" type="submit">Eliminar Taller</button>
            </form>

            </div>

        <?php else: ?>
            <div id="titulo">
                <h1><?php echo $taller["nombre"]?></h1>
                <h3>Profesor/a: <?php echo $taller["profesores_nombre"]?></h3>
            </div>

        <h3>Sobre el Taller</h3>
        <div class="informacion">
            <div id="descripcion">    
                <p><?php echo $taller["descripcion"]?></p>
            </div>
            <div>
                <p><span class="destacado">Horario:</span> <?php echo $taller["horario"]?>.</p>
                <p><span class="destacado">Lugar:</span> <?php echo $taller["lugar"]?>.</p>
            </div>
        </div>
        
        <div class="contenedor-boton">
            <?php if (isset($_SESSION['usuario_id'])) { ?>
                
            <form method="POST" action="<?php BASE_URL?>taller/ins">

                <input type="hidden" name="taller_id" value="<?php echo $taller["taller_id"]?>">
                <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id'] ?>">
            
                <?php if ($estado == 'inscripto'):?> 
                    <button class="bt destacado" type="submit">
                        <a href="<?php echo BASE_URL . "taller/id/" . $taller["taller_id"]?>">Ir al taller</a>
                    </button>
                <?php endif;?>

                <?php if ($estado == 'no_inscripto'):?> 
                    <button class="bt destacado" type="submit">Anotarse</button>
                <?php endif;?>

                <?php if ($estado == 'en_espera'):?> 
                    <button class="bt destacado" id="bt-pendiente" type="submit">Pendiente</button>
                <?php endif;?>
            </form>

            <?php } else { ?>
                <a href="<?= BASE_URL ?>sesion" class="bt destacado">Anotarse</a>
                <p class="msj-gris">ⓘ Para anotarse a un taller debe estar registrado</p>
            <?php } ?>
        </div>

    <?php endif; ?>
    </div>
</main>

<footer>
    <?php
        include '../app/vistas/componentes/footer.php';
    ?>
</footer>
