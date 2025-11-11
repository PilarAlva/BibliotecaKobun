

<div class="taller_recurso">

            <div class="t-p_encabezado">

                <img class="t-p_foto_perfil" src="img/no.png"/>

                <span class="t-p_autor">
                    <?php echo $recurso["titulo"] ?>
                    <?php /*echo $recurso["usuario_nombre"]*/?>
                </span>

                <div class="t-p_acciones_menu 
                <?php if($_SESSION["usuario_id"] == $recurso["usuario_id"])
                        echo 'editable';
                        ?>
                ">

                    ...
                    <?php if($_SESSION["usuario_id"] == $recurso["usuario_id"]):
                            
                    ?>

                        <div class="t-p_acciones_menu_cont">

                            <form class="t-p_acciones_form" method="POST" action="<?php echo BASE_URL . 'publicacion/' ?>">
                                <input type="hidden" name="accion" value="borrar"/> 
                                <input type="hidden" name="id" value="<?php echo ' '?>"/> 
                                <input type="hidden" name="usuario_id" value="<?php echo '' ?>"/> 
                                <button class="t-p_acciones_btn" type="submit">
                                    X
                                </button>
                            </form>
                        </div>

                    <?php 
                        endif;
                    ?>
                    
                    
                </div>

            </div>
            
            <div class= "t-p_autor
            ">

                <p class="t-p_cuerpo_text">
                    <?php echo $recurso["usuario_nombre"]?>    
                </p>
            

            </div>
            

    

</div>
