 <!-- Contenido para "Accesibilidad" -->
                <div id="accesibilidad" class="tab-content">
                    <h3>Opciones de Accesibilidad</h3>

                    <!-- FORMULARIO NOOOO FUNCIONAL :) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                    <div>
                        <form method="POST" action="<?php echo BASE_URL . 'perfil/acc'?>">
                            <input type="hidden" name="usuario_id" value="<?php echo $usuario["id"]; ?>"/>

                            <div class="form-datos">
                                <div class="form-group">
                                    <label for="nombre">Su correo</label>
                                    <input type="email" name="mail" value="<?php echo $usuario["mail"]; ?>" placeholder="Correo">
                                </div>
                                <div class="form-group">
                                    <label for="clave_actual">Contraseña actual</label>
                                    <input type="password" id="clave_actual" name="clave_actual" value="" placeholder="Introduce tu contraseña actual" autocomplete="current-password">
                                </div>
                                <div class="form-group password-container">
                                    <label for="clave_nueva">Cambiar la contrseña</label>
                                    <input type="password" id="clave_nueva" name="clave_nueva" value="" placeholder="Introduce tu nueva contraseña">
                                </div>
                                <div class="form-group password-container">
                                    <label for="confirmar_clave_nueva">Confirmar nueva contraseña</label>
                                    <input type="password" id="confirmar_clave_nueva" name="confirmar_clave_nueva" value="" placeholder="Confirma tu nueva contraseña">
                                </div>
                            </div>

                            <div class="boton-derecha">
                                <button type="submit" class="bt-guardar-cambios" class="destacado">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
