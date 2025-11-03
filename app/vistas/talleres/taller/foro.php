<div>

     <?php
            $alcance = 'foro';
            $accion_publicacion = 'publicar';
            
            include '../app/vistas/talleres/componentes/subir_publicacion.php'; 
        

            if(isset($publicaciones))
            foreach($publicaciones as $indice => $publicacion){
        
                $accion_publicacion = 'mostrar';
                if(isset($publicacion_editar) && $publicacion_editar["id"] == $publicacion["id"]){
                    $accion_publicacion = 'editar';
                }

                include '../app/vistas/talleres/componentes/publicacion.php';

            }
        ?>

        

</div>