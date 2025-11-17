
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

                            <form method="POST" action="<?php echo BASE_URL . "/perfil/editar"?>">
                                <div class="form-group">
                                    <input type="hidden" name="usuario_id" value="<?php echo $usuario["id"]; ?>">

                                    <label for="nombre">NOMBRE</label>
                                    <input type="text" name="nombre" value="<?php echo $usuario["nombre"]; ?>" placeholder="Nombre">
                                    <label for="apellido">APELLIDO</label>
                                    <input type="text" name="apellido" value="<?php echo $usuario["apellido"]; ?>" placeholder="Apellido">
                                </div>

                                <div class="boton-derecha">
                                    <p class="msj-rojo">
                                        <?php if (!empty($_SESSION["msj_acc"]))
                                            echo htmlspecialchars($_SESSION["msj_acc"]) ;
                                            ?>
                                    </p>
                                    <button type="submit" class="bt-guardar-cambios" class="destacado">Guardar Cambios</button>
                                </div>
                            </form>
                        </div>                        
                    </div>

                    <!-- Vista Adicional de Socios -->
                    <?php
                    if(empty($multas)){
                        $multas["cantidad"] = 0;
                    }
                    if ($socio) {
                        $msjColor = '';
                        if ($estadoSocio == "Activo" ) {
                            $msjColor = 'msj-verde';
                        } else {
                            $msjColor = 'msj-rojo';
                        } 
                        $socioHabilitado =   true;
                        if($mesesAdeudados > 0) {
                            
                            if($mesesAdeudados == 1){
                                $mesesAdeudados = "1 Mes Adeudado";
                            }
                        }
                        if((int)$multas["cantidad"] > 2){
                            $socioHabilitado = false;
                        }
                        ?>
                        <hr class="linea-divisora">
                        <div class="info-socio">
                            <p>Usted es:<span class="<?php echo $msjColor?>"> Socio <?php echo $estadoSocio ?></span> </p>
                            <?php if ($estadoSocio == "Activo"): ?>
                                <p>Estado de Cuota:
                                    <?php if ($cuotaAlDia): ?>
                                        <span class="msj-verde">Al día</span>
                                    <?php else: ?>
                                        <span class="msj-rojo"><?php echo $mesesAdeudados; ?></span>
                                    <?php endif; ?>
                                </p>
                                <?php if ($multas["cantidad"] > 0): ?>
                                    <p>Multas: <span class="msj-rojo"><?php echo htmlspecialchars(number_format($multas["monto_total"], 2)); ?>$</span></p>
                                <?php endif; ?>
                                <?php if ($cuotaAlDia && $multas["cantidad"] == 0): ?>
                                    <p class="msj-gris">ⓘ Habilitado para préstamos</p>
                                <?php else: ?>
                                    <p class="msj-rojo">ⓘ Inhabilitado para préstamos</p>
                                <?php endif; ?>
                                <?php endif; ?>
                                
                                <button class="bt" id="bt-pagar-cuota"><a target="_blank" href="<?php echo PAGO_CUOTA ?>">Pagar Cuota</a></button>
                        </div>

                    <?php
                    } ?>
                    
                    
                    <div class="info-adicional">
                        <div class="boton-derecha">
                            <button class="bt" id="bt-cerrar-sesion"><a href="<?php echo BASE_URL; ?>sesion/cerrar">Cerrar Sesión</a></button>
                        </div>
                    </div>
                    
                    
                </div>