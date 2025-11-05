

<header class="header">
    <?php
            include '../app/vistas/componentes/header.php'; 
        ?>
</header>

<main class="taller_main-content">
    
    <div class= "taller_encabezado" >
        <img class="taller_portada" src="img/image.png" alt="...">
    </div>

    <nav class="taller_paginas">
        
        <ul class="taller_menu">
            
            <button id="btn_t_fp" tab ="taller_section_foro" class="taller_menu_btn selected">Foro</button>
            <button id="btn_t_r" tab = "taller_section_recursos" class="taller_menu_btn">Recursos</button>
            <button id="btn_t_l" tab = "taller_section_libreta" class="taller_menu_btn">Libreta</button>
            <button id="btn_t_p" tab = "taller_section_participantes" class="taller_menu_btn">Participantes</button>
                
        </ul>
        
    </nav>
    
    <div class="taller_cuerpo">

        <div id="taller_section_foro">
            <?php include '../app/vistas/talleres/taller/foro.php' ?>
        </div>

        <div id="taller_section_recursos" hidden>
            <?php include '../app/vistas/talleres/taller/recursos.php' ?>
        </div>

        <div id="taller_section_libreta" hidden>
            <?php include '../app/vistas/talleres/taller/libreta.php' ?>
        </div>      
        <div id="taller_section_participantes" hidden>
            <?php include '../app/vistas/talleres/taller/participantes.php' ?>
        </div>      

    <div>
               
            
</main>

<footer>
        <?php
            include '../app/vistas/componentes/footer.php';
            ?>
</footer>

<script src="js/taller.js"></script>