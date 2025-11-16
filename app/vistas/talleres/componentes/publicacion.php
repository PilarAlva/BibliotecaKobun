

<div class="taller_publicacion">

    <div class="t-p_encabezado">

        <?php
            $defaultImg = 'img/perfil-default.png';
            $perfilImg = isset($publicacion['img_perfil']) ? $publicacion['img_perfil'] : $defaultImg;
        ?>
        <img class="t-p_foto_perfil" src="<?php echo htmlspecialchars($perfilImg); ?>" alt="Imagen de perfil del usuario">
        

        <span class="t-p_autor">
            <?php echo $publicacion["usuario_nombre"]?>
        </span>

        <div class="t-p_acciones_menu 
        <?php if($_SESSION["usuario_id"] == $publicacion["usuario_id"] || $_SESSION["rol_id"] == 2)
                echo ' editable';
                ?>
        ">

            <span class="t-p_fecha_pub">

                <?php echo $publicacion["fecha_publicacion"]?>
            </span>

            <?php if($_SESSION["usuario_id"] == $publicacion["usuario_id"] || $_SESSION["rol_id"] == 2):
                    
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
                    
                    <form class="t-p_acciones_form" method="POST" action="<?php echo BASE_URL . 'publicacion/editar/';?>">
                        <input type="hidden" name="accion" value="editar"/> 
                        <input type="hidden" name="id" value="<?php echo $publicacion["id"]?>"/> 
                        <input type="hidden" name="usuario_id" value="<?php echo $publicacion["usuario_id"]?>"/> 
                        <button class="t-p_acciones_btn">
                            E
                        </button>
                        
                    </form>

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
            <div class="t-p_cuerpo_text">
                <?php echo $publicacion["cuerpo"]?>    
            </div>
        
        </div>
        <div class= "t-p_cuerpo_archivos">
            <?php if(isset($publicacion["archivos_titulos"])){
                    $archivos = explode(',', $publicacion['archivos_titulos']);
                    $archivos_id = explode(',', $publicacion['archivos_id']);
                    $archivos_dirs = explode(',', $publicacion['archivos_direcciones']);
                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']; // Extensiones de imagen
                    foreach($archivos as $index => $archivo){
                        $fullPath = $archivos_dirs[$index];
                        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
                        $isImage = in_array(strtolower($extension), $imageExtensions);
            ?>

                <span class="t-p_archivo">
                    <?php if ($isImage): ?>
                        <a href="<?php echo BASE_URL . "archivo/id/".$archivos_id[$index]; ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo BASE_URL . "archivo/id/".$archivos_id[$index]; ?>" alt="<?php echo htmlspecialchars($archivo); ?>" class="t-p_archivo_preview_img">
                        </a>
                    <?php else: ?>
                        <a href= "<?php echo BASE_URL . "archivo/id/".$archivos_id[$index]?>" >
                        <?php echo htmlspecialchars($archivo); ?>
                        </a>
                    <?php endif; ?>
                </span>

            <?php 
            }};
            ?>
            
        </div>

    </div>

</div>
