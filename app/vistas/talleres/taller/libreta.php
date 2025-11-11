<div>
       
    <div class="taller_contenido">
        <?php
            if(isset($libreta))
                
                foreach($libreta as $indice => $publicacion){
            
                include '../app/vistas/talleres/componentes/publicacion.php';

            }
        ?>
    </div>

</div>