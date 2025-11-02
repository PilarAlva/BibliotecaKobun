<div>

     <?php
            include '../app/vistas/componentes/subir_archivo.php'; 
        
            if(isset($publicaciones))
            foreach($publicaciones as $indice => $publicacion){
        
                include '../app/vistas/talleres/componentes/publicacion.php';

            }
        ?>

        

</div>