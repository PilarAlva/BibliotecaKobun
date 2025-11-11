<div>
       
    <div class="taller_contenido">
        <?php
            if(isset($recursos))
                
                foreach($recursos as $indice => $recurso){
            
                include '../app/vistas/talleres/componentes/recurso.php';

            }
        ?>
    </div>

</div>