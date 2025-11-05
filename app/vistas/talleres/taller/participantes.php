
<?php 
    //esta comprabacion probablemente debería pasar en otro lado_
    $es_profesor = false;
    
    //Con este tipo es que parcipante.php te muestra lo que debería mostrar
    $participante_tipo = "";

    foreach($profesores as $profesor){
        if ($_SESSION['usuario_id'] == $profesor['usuario_id']){
            $es_profesor = true;
            break;
        }

    }

?>

<div>
    <span>Profesores:</span>
    <div class="taller_profesores">
        <?php
            if(isset($profesores))
                $participante_tipo = "profesor";
                foreach($profesores as $indice => $usuario){
            
                include '../app/vistas/talleres/componentes/participante.php';

            }
        ?>
    </div>

    <span>Participantes:</span>
    <div class="taller_contenido">
            
        <?php
            if(isset($participantes)){

                $participante_tipo = "alumno";
                foreach($participantes as $indice => $usuario){
            
                include '../app/vistas/talleres/componentes/participante.php';
    
                }
            }
                
        ?>

    </div>

   <?php if ($es_profesor) {?>
    
        <span>Sos profe crack :</span>
        <?php
        if(isset($pendientes)){ 
            $participante_tipo = "pendiente";
            foreach($pendientes as $indice => $usuario){
                
                include '../app/vistas/talleres/componentes/participante.php';

             
        }}} ?>
                    
    
        

</div>