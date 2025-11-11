

<header class="header">
    <?php
            include '../app/vistas/componentes/header.php'; 
        ?>
</header>

<main class="taller-main-content">
    
    <div class= "banner" >                
        <?php
            $portadaSrc = !empty($taller['taller_portada']) ? 'img/portadas/' . htmlspecialchars($taller['taller_portada']) : 'img/talleres-default.webp';
        ?>
        <div class="titulo-taller">
            <?php
                $titulo = htmlspecialchars($taller['taller_nombre']);
                echo "<h2>" . $titulo . "</h2>";
            ?>
        </div>
        <img src="<?php echo $portadaSrc; ?>" alt="Portada del taller <?php echo htmlspecialchars($taller['taller_nombre']); ?>">
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