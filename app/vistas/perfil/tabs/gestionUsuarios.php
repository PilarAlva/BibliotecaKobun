  <div id="gestion-usuarios" class="tab-content">
        <h3>Gestionar Usuarios</h3>
                        
            <!-- BUSQUEDA NOOOO FUNCIONAL :) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
            <div class="cabecera-gestion">
                <div class="buscador">
                        <form id="buscador-material" action="/" method="POST">
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
                    <button id="bt-agregar-usuario" class="bt bt-añadir">Añadir Usuario</button>
                </div>
            </div>
            

            <div class="cuerpo-gestion-usuarios">
                <div id ="cuerpo-usuarios" class="muestra-usuarios">
                    No hay usuarios todavía
                </div>
            </div>
        </div>