<div>

     <?php
            $alcance = 'foro';
    
            include '../app/vistas/talleres/componentes/subir_publicacion.php'; 
        
            if(isset($publicaciones))
            foreach($publicaciones as $indice => $publicacion){
        
        
                include '../app/vistas/talleres/componentes/publicacion.php';

            }
        ?>

        

</div>