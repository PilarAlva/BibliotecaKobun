<header class="header">
    <?php
        include '../app/vistas/componentes/header.php'; 
    ?>
</header>

<div class="formulario-content" style="display: flex;">
    <main class="main-content">
        
        <div class="perfil-contenedor">
            <div class="encabezado">
                <h1> Mi Perfil </h1>
            </div>

            <!-- Botón para el menú de perfil en móviles -->
            <button id="perfil-nav-toggle" aria-expanded="false">Menú de Perfil</button>

            <div class="cuerpo-perfil">
                <nav class="nav-perfil">
                    <ul>
                        <!-- Se añade la clase 'active' al primer elemento y atributos data-target -->
                        <li><a href="#" class="nav-link active" data-target="info-personal">Información Personal</a></li>
                        <li><a href="#" class="nav-link" data-target="prestamos">Préstamos</a></li>
                        <li><a href="#" class="nav-link" data-target="talleres">Talleres</a></li>
                        <li><a href="#" class="nav-link" data-target="accesibilidad">Accesibilidad</a></li>

                        <!-- VISTAS ADICIONALES DE ADMINISTRADOR -->
                        <?php
                        if ($usuario['rol_id'] == 1){ ?>
                            <li><a href="#" class="nav-link" data-target="gestion-usuarios">Gestionar Usuarios</a></li>
                            <li><a href="#" class="nav-link" data-target="gestion-material">Gestionar Material Bibliográfico</a></li>
                        <?php } ?>
                    </ul>
                </nav>

            <!-- PESTAÑAS DEL PERFIL -->
                <div class="contenido-perfil">
                
                            
                    <?php include '../app/vistas/perfil/tabs/infoPersonal.php' ?>

                    <?php include '../app/vistas/perfil/tabs/prestamos.php' ?>

                    <?php include '../app/vistas/perfil/tabs/talleres.php' ?>

                    <?php include '../app/vistas/perfil/tabs/accesibilidad.php' ?>

                    
                    
                    <!-- VISTAS ADICIONALES DE ADMINISTRADOR -->
                    <?php
                    if ($usuario['rol_id'] == 1) { ?>
                    
                    <?php include '../app/vistas/perfil/tabs/gestionUsuarios.php' ?>

                    <?php include '../app/vistas/perfil/tabs/gestionMaterial.php' ?>

                    <?php } ?>

                </div>

            </div>
        </div>
        
        
        
    </main>

    <div id= "formulario" class="form_contenedor">

            <section class="form_cabezera">
            
                    <div class="form_fila rellena">

                        <div id="btn-retroceso" class="form_boton"><</div>
                        <div id="btn-cerrar" class="form_boton">X</div>

                    </div>

            </section>

            <div class="form_contenido">

                    <div class="form_titulo subrayado">Martin Mariano Mendez</div>

                    <section class="form_seccion subrayado">

                        <div class="form_informacion">
                            
                            <div class="form_fila">
                                <span>Correo: martinmm@kobun.com</span>
                            </div>
                            <div class="form_fila">
                                <span>Tipo de Usuario: General </span>
                            </div>
                            <div class="form_fila">
                                <span>Socio: No </span>
                            </div>
                        </div>
                        
                    </section>

                    <section class="form_seccion">

                        <div class="form_fila">
                            
                            <div class="form_error">
                                Acá iria un error
                            </div>

                        </div>

                        <div class="form_fila">

                                <div class="seccion_formulario form_desplegable">
            
                                    <button class="form_boton despliega">Hacer Socio</button> 

                                    <div class="form_desplegable_cont se_despliega plegado">
                                        <form class="form_datos"> 
                                            <label>Nombre</label>
                                            <input class="form_input" type="text"/>
                                            <label>Apellido</label>
                                            <input class="form_input" type="text"/>
                                            <label>DNI</label>
                                            <input class="form_input" type="text"/>
                                        </form>
                                    <div>
                                
                                </div>
                                
                            </div>
                            
                        </div>

                    </section>

                    <div class="form_subtitulo">Ejemplares</div>

                    <section class="form_seccion subrayado">

                        <section class="seccion_formulario">

                            <div class="form_bloque">
                                
                                <div class="form_fila rellena">
                                    <div class="form_subtitulo">
                                        <span>Libro</span>
                                    </div>
                                    <input type="checkbox"></input>
            
                                </div>
            
                                <div  class="form_fila rellena">
            
                                    <div class="form_seccion se_oculta">
                                        <div class="form_fila">
                                            <span>Codigo ejemplar</span>
                                        </div>
                                        <div class="form_fila">
                                            <span>Codigo ejemplar</span>
                                        </div>
                                        <div class="form_fila">
                                            <span>Codigo ejemplar</span>
                                        </div>
                                    </div>
                                    
                                    <div class="form_desplegable rellena inv">
                
                                    <div class="form_boton despliega">Hacer Socio</div> 

                                        <div class="form_desplegable rellena se_despliega plegado">
                                            <form class="form_datos"> 
                                                
                                                <input class="form_input" type="text"/>
                                                
                                                <input class="form_input" type="text"/>
                                                
                                                <input class="form_input" type="text"/>

                                                <input class="form_input" type="text"/>

                                            </form>
            
                                        </div>
            
                                    </div>
                                </div>
                                
                                <div class="form_fila rellena">
                                    <div class="form_error">
                                        Acá iria un error
                                    </div>
                                    <div class="boton">
                                        Guardar
                                    </div>
                                </div>
            
                            </div>
                                
                        </section>

                        

                        </section>

                        

                    </section>

                    <div class="form_subtitulo subrayado">Nuevo Libro</div>

                    <div class="form_seccion">

                        <from class="form_datos">

                            <label>Titulo</label>
                            <div class="form_fila">
                            
                                <input class="form_input">
                                
                            </div>

                            
                            <div class="seccion_formulario form_seccion">
                                <label>Autor</label>
                                <div class="form_fila">
                                    
                                    <select name="filtro" class="form_input">
                                        <option value="titulo">Título</option>
                                        <option value="autor" >Autor</option>
                                        <option value="genero">Género</option>
                                        <option value="contenido">Contenido</option>
                                    </select>
            
                                    <div class="form_boton despliega">+
                                    </div>
            
                                </div>

                                <div class="form_informacion se_despliega plegado">
                                <div class="form_fila">Hola buenas</div> 
                                <div class="form_fila">Hola buenas</div> 
                                <div class="form_fila">Hola buenas</div> 
                                <div class="form_fila">Hola buenas</div> 
                            </div>

                            </div>


                            <label>Editorial</label>
                            <div class="form_fila rellena">

                                <select name="filtro" class="form_input">
                                    <option value="titulo">Título</option>
                                    <option value="autor" >Autor</option>
                                    <option value="genero">Género</option>
                                    <option value="contenido">Contenido</option>
                                </select>
                                <div class="form_boton">+
                                </div>
                                
                            </div>
                            


                        </formr>


                    </div>

                    
                    
                    
                </div>
                
                
            <section class="form_pie">
            <div class="form_fila">

                <div class="form_boton">Quitar privilegios</div>
                
            </div>


            <div class="form_fila rellena">

                <div id= "btn-cerrar" class="form_boton rojo">Cerrar</div>
                <div id= "btn-guardar" class="form_boton verde">Guardar</div>

            </div>

        </section>

    </div>


</div>



<footer>

    <?php
        include '../app/vistas/componentes/footer.php';
    ?>

</footer>


<script src="js/perfil.js" type="module"></script>




<script src="https://kit.fontawesome.com/fe0bc071f5.js" crossorigin="anonymous"></script>