  <div id="gestion-usuarios" class="tab-content">
        <h3>Gestionar Usuarios</h3>
                        
            <!-- BUSQUEDA NOOOO FUNCIONAL :) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
            <div class="cabecera-gestion">
                <div class="buscador">
                    <form action="" method="POST">
                        <select name="filtro" class="selector">
                            <option value="usuario-gral" <?php /* if($filtro=='usuraio-gral') */ echo 'selected'; ?>>Usuarios Generales</option>
                            <option value="socios" <?php /* if($filtro=='socios') */ echo 'selected'; ?>>Socios</option>
                            <option value="profesores" <?php /* if($filtro=='profesores') */ echo 'selected'; ?>>Profesores</option>
                            <option value="administradores" <?php /* if($filtro=='administradores') */ echo 'selected'; ?>>Administradores</option>
                        </select>
                        <input type="text" name="q" class="search-input" placeholder="Buscar..." value="<?php /* echo htmlspecialchars($busqueda); */ ?>">
                        <button type="submit" class="boton-busqueda"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>

                <!-- BOTON NOOOO FUNCIONAL :) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                <div>
                    <button class="bt bt-añadir"><a href="<?php /* echo BASE_URL; > */?>...">Añadir Usuario</a></button>
                </div>
            </div>
            

            <div class="cuerpo-gestion-usuarios">
                <div class="muestra-usuarios">
                    <?php foreach ($listaUsuarios as $usuarioItem) : ?>
                        <div class="usuario">
                            <div class="imagen-usuario-cont">
                                <?php
                                    $defaultImg = 'img/perfil-default.png';
                                    $perfilImg = (isset($usuarioItem['img_perfil']) && !empty($usuarioItem['img_perfil'])) ? $usuarioItem['img_perfil'] : $defaultImg;
                                ?>
                                <img src="<?php echo htmlspecialchars($perfilImg); ?>" alt="Imagen de perfil del usuario">
                            </div>                                    
                            <div class="info-nombre-usuario">
                                <p><?php echo htmlspecialchars($usuarioItem['nombre']) . ' ' . htmlspecialchars($usuarioItem['apellido']);?></p>
                                <!-- BOTON NOOOO FUNCIONAL :) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                <button id="bt-mas-info-usuario"
                                        class="bt-mas-info"
                                        data-usuario="<?php echo $usuarioItem['id']?>"
                                 
                                >+</button>
                            </div>
                        </div>
                        <hr class="linea-divisora">
                    <?php endforeach; ?>
                </div>
            </div>
        </div>