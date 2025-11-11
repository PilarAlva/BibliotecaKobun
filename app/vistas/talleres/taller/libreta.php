<div>
       
    <div class="taller_contenido">
        <?php
            if(isset($recursos))
                
                foreach($recursos as $indice => $publicacion){
            
                include '../app/vistas/talleres/componentes/publicacion.php';

            }
        ?>
    </div>

</div>