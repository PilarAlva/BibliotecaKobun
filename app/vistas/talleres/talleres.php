<script src="js/talleres2.js"></script>

<header class="header">
    <?php
        include '../app/vistas/componentes/header.php';
    ?>
</header>

<main class="main-content">
    
    <ul class="talleres_vista">

        <?php if (isset($_SESSION['usuario_id'])): ?>
            
            <button id="btn_todos_talleres" tab = "talleres_section_todos_los_talleres" class="taller_menu_btn selected">Todos los talleres</button>    
            <button id="btn_mis_talleres" tab ="talleres_section_mis_talleres" class="taller_menu_btn ">Mis talleres</button>   
        
        <?php endif; ?>
   
    </ul>

    <?php
    $comprar_inscripcion = false;
    if (empty($talleres)) { ?>

        <div class="sin-contenido">
            <p class="msj-gris">No hay Talleres Dsiponibles.</p>
        </div>

    <?php }
    else { ?>
        <div>
            <!-- MUESTRA DE TODOS LOS TALLERES-->
            <div id="talleres_section_todos_los_talleres">
                <h1 class="encabezado-talleres">Todos los Talleres</h1>

                <?php if (empty($talleres)): ?>
                    <p class="msj-gris">No hay talleres disponibles en este momento.</p>
                <?php else: ?>

                <div class="listado_talleres">
                    <?php
                    foreach ($talleres as $taller) { 
                        
                        include '../app/vistas/talleres/componentes/taller_carta.php';
                            
                        } ?> <!-- Fin del foreach --> 
                </div>
                <?php endif; ?>

                
                <!-- MUESTRA LOS TALLERES INACTIVOS - VISTA HABILITADO SOLO PARA ADMINS -->
                <div>
                    <?php if ($estado == 'admin'): ?> 
                        <hr class="linea-divisora">
                        <h2 class="encabezado-talleres"> Talleres Inactivos </h2>
                        <?php if ( empty($talleresInactivos) ): ?>
                            <div class="sin-contenido">
                                <p class="msj-gris">No hay talleres inactivos en este momento.</p>
                            </div>
                        <?php else: ?>
                            <div class="listado_talleres">
                                <?php

                                    foreach ($talleresInactivos as $taller) { 

                                    include '../app/vistas/talleres/componentes/taller_carta.php';

                                } ?>
                            </div> <!-- Fin del listado_talleres -->
                        <?php endif; ?>
                    <?php endif;?>
                </div>
            </div>
            


            <!-- MUESTRA DE LOS TALLERES DEL USUARIO -->
            <div id="talleres_section_mis_talleres" hidden>
                <h1 class="encabezado-talleres">Mis Talleres</h1>

                <?php
                if(empty($mis_talleres)): ?>
                    <div class="sin-contenido">
                        <p class="msj-gris">No se inscribió a ningún taller.</p>
                    </div>
                <?php else: ?>
                    <div class="listado_talleres">
                        <?php 

                            foreach ($mis_talleres as $taller) { 
                            $comprar_inscripcion = true;
                            include '../app/vistas/talleres/componentes/taller_carta.php';
                            
                        } ?> <!-- Fin del foreach --> 
                    </div>
                <?php endif; ?>
            </div>

        </div> <!-- Fin del div: 'talleres-cuerpo' -->
    <?php } ?>


</main>

<footer>
    <?php
        include '../app/vistas/componentes/footer.php';
    ?>
</footer>