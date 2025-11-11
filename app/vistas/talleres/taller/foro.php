<div id="foro-flex-container">

    <div class="taller_contenido">
        <?php
            if(isset($publicaciones))
            foreach($publicaciones as $indice => $publicacion){
        
        
                include '../app/vistas/talleres/componentes/publicacion.php';
            }
        ?>
    </div>
        

</div>