<div class="taller_publicacion">

            <div class="t-p_encabezado">

                <img class="t-p_foto_perfil" src="img/no.png"/>

                <span class="t-p_autor">
                    <?php echo $publicacion["usuario_nombre"]?>
                </span>

                <div class="t-p_acciones_menu">

                    <span class="t-p_fecha_pub">
                        <?php echo $publicacion["fecha_publicacion"]?>
                    </span>

                    <?php if($_SESSION["usuario_id"] == $publicacion["usuario_id"]):
                            
                    ?>

                        <div class="t-p_acciones_menu_cont">
                            <form class="t-p_acciones_form" method="POST" action="<?php echo BASE_URL . 'publicacion/' ?>">
                                <input type="hidden" name="accion" value="borrar"/> 
                                <input type="hidden" name="id" value="<?php echo $publicacion["id"]?>"/> 
                                <input type="hidden" name="usuario_id" value="<?php echo $publicacion["usuario_id"]?>"/> 
                                <button class="t-p_acciones_btn" type="submit">
                                    X
                                </button>
                            </form>

                            <span>|</span>
                            <button class="t-p_acciones_btn">E</button>
                        </div>

                    <?php 
                        endif;
                    ?>
                    
                    
                </div>

                

            </div>
            <div class="t-p_cuerpo">
                <div class="t-p_titulo">
                    <span class="t-p_titulo_text">
                        <?php echo $publicacion["titulo"]?>    
                    </span>
                </div>
                <div class="t-p_cuerpo_contenido">
                    <p class="t-p_cuerpo_text">
                        <?php echo $publicacion["cuerpo"]?>    
                    </p>
                
                </div>
                <div class= "t-p_cuerpo_archivos">
                    <?php if(isset($publicacion["archivos_titulos"])){
                            $archivos = explode(',', $publicacion['archivos_titulos']);
                            $archivos_id = explode(',', $publicacion['archivos_id']);
                            foreach($archivos as $index => $archivo){
                    ?>

                        <span class="t-p_archivo">
                            <a href= "<?php echo BASE_URL . "archivo/id/" . $archivos_id[$index]?>" >
                            <?php echo $archivo ?>
                            </a>
                        </span>

                    <?php 
                    }};
                    ?>
                    
                </div>

            </div>

</div>