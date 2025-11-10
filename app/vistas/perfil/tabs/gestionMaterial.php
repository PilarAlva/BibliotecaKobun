
                    <div id="gestion-material" class="tab-content">
                        <h3>Gestionar Material Bibliográfico</h3>
                        <!-- BUSQUEDA NOOOO FUNCIONAL :) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                        <div class="cabecera-gestion">
                            <div class="buscador">
                                <form id="buscador-material" action="/" method="POST">
                                    <select name="filtro" class="selector">
                                        <option value="titulo" <?php /* if($filtro=='titulo') */ echo 'selected'; ?>>Título</option>
                                        <option value="autor" <?php /* if($filtro=='autor') */ echo 'selected'; ?>>Autor</option>
                                        <option value="genero" <?php /* if($filtro=='genero') */ echo 'selected'; ?>>Género</option>
                                        <option value="contenido" <?php /* f($filtro=='contenido') */ echo 'selected'; ?>>Contenido</option>
                                        <option value="isbn" <?php /* f($filtro=='contenido') */ echo 'selected'; ?>>ISBN</option>
                                    </select>
                                    <input type="text" name="q" class="search-input" placeholder="Buscar..." value="<?php /* echo htmlspecialchars($busqueda); */ ?>">
                                    <button type="submit" class="boton-busqueda"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </form>
                            </div>
                            
                            <!-- BOTON NOOOO FUNCIONAL :) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                            <div>
                                <button class="bt bt-añadir"><a href="<?php /* echo BASE_URL; > */?>...">Añadir Material</a></button>
                            </div>
                        </div>

                        <div class="cuerpo-gestion-material">
                    
                            <div class="muestra_meterial" id="cuerpo-material" >
                                No hay material todavía 
                            </div>

                        </div>

                    </div>