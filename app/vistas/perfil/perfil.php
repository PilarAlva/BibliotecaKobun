<header class="header">
    <?php
        include '../app/vistas/componentes/header.php'; 
    ?>
</header>

    <main class="main-content  <?php if ($usuario['rol_id'] == 1) echo "admin"; ?>">
        
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
                            <li><a href="#" class="nav-link" data-target="gestion-material">Gestionar Material</a></li>
                            <li><a href="#" class="nav-link" data-target="gestion-talleres">Gestionar Talleres</a></li>
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

                    <?php include '../app/vistas/perfil/tabs/gestionTalleres.php' ?>

                    <?php } ?>

                </div>

            </div>
        </div>
        
        <?php
    if ($usuario['rol_id'] == 1) { ?>
        <div id= "formulario" class="form_contenedor">
            <div id="btn-despliege" class="form_seccion form_lengueta">
                  <
            </div>
            <div class="form_cuerpo">
                <section class="form_cabezera">
                        <div class="form_fila rellena">
                            <!-- <div id="btn-retroceso" class="form_boton"><</div> -->
                            <!-- <div id="cant-cambios">Cantidad de cambios:</div> -->
                            <!-- <div id="btn-cerrar" class="form_boton">X</div> -->
                        </div>

                </section>

                <div class="form_contenido"> 
                    Primero deberías tocar alguna opcion crack!   
                </div>
                    
                    
                <section class="form_pie">
                    <div class="form_fila rellena">
                        <!-- <div id= "btn-cerrar" class="form_boton rojo">Cerrar</div> -->
                        <!-- <div id= "btn-guardar" class="form_boton verde">Guardar</div> -->
                    </div>
                </section>

            </div>
        </div>


    <?php } ?>
        
    </main>
    <!-- FORMULARIO DEL ADMIN -->
    


<footer>

    <?php
        include '../app/vistas/componentes/footer.php';
    ?>

</footer>

<script src="js/perfil.js" type="module"></script>
<script src="https://kit.fontawesome.com/fe0bc071f5.js" crossorigin="anonymous"></script>