<div id="foro-flex-container">

    <div class="taller_subir">
    <?php
        $alcance = 'foro';
    
        include '../app/vistas/talleres/componentes/subir_publicacion.php';             
    ?>
    </div> 

    <div class="taller_contenido">
        <?php
            if(isset($publicaciones))
            foreach($publicaciones as $indice => $publicacion){
        
        
                include '../app/vistas/talleres/componentes/publicacion.php';
            }
        ?>
    </div>
        

</div>