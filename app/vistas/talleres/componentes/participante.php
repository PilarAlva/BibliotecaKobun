<div class="taller_participante">
    
    
    <img class="t-p_foto_perfil" src="img/no.png"/>

    <span class="t-p_autor">
        <?php echo $usuario["usuario_nombre"]?>
    </span>

    <?php if ($es_profesor):?>

        <?php if ($participante_tipo == "profesor"):?>

            <div class="t-p_acciones_menu">
              
            </div>
        
        <?php elseif($participante_tipo == "alumno"):?>
        
            <div class="t-p_acciones_menu">
            
             <form class="t-p_acciones_form" method="POST" action="<?php echo BASE_URL . 'ins/eliminar';?>">
                <input type="hidden" name="accion" value=""/> 
                <input type="hidden" name="taller_id" value="<?php echo $taller_id?>"/> 
                <input type="hidden" name="usuario_id" value="<?php echo $usuario["usuario_id"]?>"/> 
                <button class="t-p_acciones_btn">
                    X
                </button>
                    
            </form>

            </div>

        <?php elseif($participante_tipo == "pendiente"):?>

            

            <div class="t-p_acciones_menu">
            
                <form class="t-p_acciones_form" method="POST" action="<?php echo BASE_URL . 'ins/aceptar/' ?>">
                    <input type="hidden" name="accion" value=""/> 
                    <input type="hidden" name="taller_id" value="<?php echo $taller_id?>"/> 
                    <input type="hidden" name="usuario_id" value="<?php echo $usuario["usuario_id"]?>"/> 
                    <button class="t-p_acciones_btn" type="submit">
                        A
                    </button>
                </form>

                            
                            
                <form class="t-p_acciones_form" method="POST" action="<?php echo BASE_URL . 'ins/rechazar/';?>">
                    <input type="hidden" name="accion" value=""/> 
                    <input type="hidden" name="taller_id" value="<?php echo $taller_id?>"/> 
                    <input type="hidden" name="usuario_id" value="<?php echo $usuario["usuario_id"]?>"/> 
                    <button class="t-p_acciones_btn">
                        X
                    </button>
                    
                </form>

            </div>

            <?php endif;?>
    <?php endif;?>

</div>