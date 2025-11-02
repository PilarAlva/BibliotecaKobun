<div class="taller_publicacion">

            <div class="t-p_encabezado">

                <img class="t-p_foto_perfil" src="img/no.png"/>

                <span class="t-p_autor">
                    <?php echo $publicacion["usuario_nombre"]?>
                </span>

                <span class="t-p_fecha_pub">
                    <?php echo $publicacion["fecha_publicacion"]?>
                </span>

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
                    <?php if(isset($publicacion["archivos_id"])){
                            $archivos = explode(',', $publicacion['archivos_id']);
                            foreach($archivos as $archivo){
                    ?>

                        <span class="t-p_archivo">
                            <?php echo $archivo?>
                        </span>

                    <?php 
                    }}
                    ?>
                    
                </div>

                </div>

</div>