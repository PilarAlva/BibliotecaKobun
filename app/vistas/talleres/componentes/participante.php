<div class="taller_participante">
    
    <?php
        $defaultImg = 'img/perfil-default.png';
        $perfilImg = isset($_SESSION['img_perfil']) && !empty($_SESSION['img_perfil']) ? $_SESSION['img_perfil'] : $defaultImg;
    ?>
    <img class="t-p_foto_perfil" src="<?php echo htmlspecialchars($perfilImg); ?>" alt="Imagen de perfil del usuario">
    

    <span class="t-p_autor">
        <?php echo htmlspecialchars($usuario["nombre"] ?? $usuario["usuario_nombre"] ?? 'Usuario');?>
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
                    <img src="<?= BASE_URL ?>/img/icono-rechazar.png" alt="Rechazar">
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
                        <img src="<?= BASE_URL ?>/img/icono-aceptar.png" alt="Aceptar">
                    </button>
                </form>

                            
                            
                <form class="t-p_acciones_form" method="POST" action="<?php echo BASE_URL . 'ins/rechazar/';?>">
                    <input type="hidden" name="accion" value=""/> 
                    <input type="hidden" name="taller_id" value="<?php echo $taller_id?>"/> 
                    <input type="hidden" name="usuario_id" value="<?php echo $usuario["usuario_id"]?>"/> 
                    <button class="t-p_acciones_btn">
                        <img src="<?= BASE_URL ?>/img/icono-rechazar.png" alt="Rechazar">
                    </button>
                    
                </form>

            </div>

            <?php endif;?>
    <?php endif;?>

</div>