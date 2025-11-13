<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadPhotoInput = document.getElementById('upload-photo');

        uploadPhotoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const formData = new FormData();
                formData.append('photo', file);

                fetch('<?php echo BASE_URL; ?>/perfil/subir_imagen', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Recargar la página para mostrar la nueva imagen
                        window.location.reload();
                    } else {
                        console.error('Error al subir la imagen:', data.error);
                        alert('Error al subir la imagen: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error en la petición fetch:', error);
                    alert('Ocurrió un error al intentar subir la imagen.');
                });
            }
        });
    });
</script>


<!-- Contenido para "Información Personal" -->
                <div id="info-personal" class="tab-content active">
                    <div class="info-datos-personales">
                        <?php
                            $defaultImg = 'img/perfil-default.png';
                            $perfilImg = isset($_SESSION['img_perfil']) && !empty($_SESSION['img_perfil']) ? $_SESSION['img_perfil'] : $defaultImg;
                        ?>
                        <div class="perfil-img-cont">
                            <label for="upload-photo" class="upload-label">
                                <img src="<?php echo htmlspecialchars($perfilImg); ?>" alt="Imagen de perfil del usuario">
                                <div class="overlay">
                                    <img src="img/icono-camara.png" alt="Cambiar foto" class="camera-icon">
                                </div>
                            </label>
                            <!-- FALTA FUNCION PARA GURDAR Y/O ACTUALIZAR LA IMAGEN DEL USUARIO EN LA BD !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                            <input type="file" id="upload-photo" name="photo" style="display: none;">
                        </div>

                        <div class="form-datos-personales">
                            <?php
                                if (isset($usuario['rol_id'])) {
                                    $rol_texto = '';
                                    $rol_clase = ''; 
                                    switch ((int)$usuario['rol_id']) {
                                        case 1:
                                            $rol_texto = 'Administrador';
                                            $rol_clase = 'rol-admin'; 
                                            break;
                                        case 2:
                                            $rol_texto = 'Profesor';
                                            $rol_clase = 'rol-profesor';
                                            break;
                                    }
                                    if (!empty($rol_texto)) {
                                        echo '<p class="info-rol ' . $rol_clase . '">' . htmlspecialchars($rol_texto) . '</p>';
                                    }
                                }
                            ?>

                            <!-- FORMULARIO NOOOO FUNCIONAL :) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                            <form method="POST" action="<?php echo BASE_URL . "/perfil/editar"?>">
                                <div class="form-group">
                                    <input type="hidden" name="usuario_id" value="<?php echo $usuario["id"]; ?>">

                                    <label for="nombre">NOMBRE</label>
                                    <input type="text" name="nombre" value="<?php echo $usuario["nombre"]; ?>" placeholder="Nombre">
                                    <label for="apellido">APELLIDO</label>
                                    <input type="text" name="apellido" value="<?php echo $usuario["apellido"]; ?>" placeholder="Apellido">
                                </div>

                                <div class="boton-derecha">
                                    <button type="submit" class="bt-guardar-cambios" class="destacado">Guardar Cambios</button>
                                </div>
                            </form>
                        </div>                        
                    </div>

                    <!-- Vista Adicional de Socios -->
                    <?php
                    if ($socio) {
                        $msjColor = '';
                        if ($estadoSocio == "Activo" ) {
                            $msjColor = 'msj-verde';
                        } else {
                            $msjColor = 'msj-rojo';
                        } ?>
                        <hr class="linea-divisora">
                        <div class="info-socio">
                            <p>Usted es:<span class="<?php echo $msjColor?>"> Socio <?php echo $estadoSocio ?></span> </p>
                            <?php if ($socioInfoDeudas): ?>
                                <p>Estado de Cuota Socio:
                                    <?php if ($socioInfoDeudas['cuotaAlDia']): ?>
                                        <span class="msj-verde"><?php echo htmlspecialchars(number_format($socioInfoDeudas['montoCuota'], 2)); ?>$</span>
                                    <?php else: ?>
                                        <span class="msj-rojo"><?php echo htmlspecialchars(number_format($socioInfoDeudas['montoCuota'], 2)); ?>$</span>
                                    <?php endif; ?>
                                </p>
                                <?php if ($socioInfoDeudas['montoMultas'] > 0): ?>
                                    <p>Multas: <span class="msj-rojo"><?php echo htmlspecialchars(number_format($socioInfoDeudas['montoMultas'], 2)); ?>$</span></p>
                                <?php endif; ?>
                                <?php if ($socioHabilitado) ?>
                                    <p class="msj-gris">ⓘ Habilitado para préstamos</p>
                                <?php else: ?>
                                    <p class="msj-rojo">ⓘ Inhabilitado para préstamos</p>
                                <?php endif; ?>

                                <!-- BOTON NO FUNCIONALL !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                <button class="bt" id="bt-pagar-cuota"><a href="<?php echo BASE_URL; ?>">Pagar Cuota</a></button>
                        </div>

                    <?php
                    } ?>
                    
                    
                    <div class="info-adicional">
                        <div class="boton-derecha">
                            <button class="bt" id="bt-cerrar-sesion"><a href="<?php echo BASE_URL; ?>sesion/cerrar">Cerrar Sesión</a></button>
                        </div>
                    </div>
                    
                    
                </div>