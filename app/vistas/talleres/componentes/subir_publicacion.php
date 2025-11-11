<link href="css/style.css" rel="stylesheet" />
<link href="css/reset.css" rel="stylesheet" />
<link href="css/subir_publicacion.css" rel="stylesheet" />

<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

<script src="js/subir_publicacion.js"></script>

    <div class= "subir_publicacion" 
        id="sp" 
        data-ref="<?php BASE_URL?>"
        data-uid="<?php echo $usuario_id?>"
        data-tid="<?php echo $taller_id?>"
        data-alcance ="foro"     
        >
        
        <div class="sp_encabezado">

            <?php
                $defaultImg = 'img/perfil-default.png';
                $perfilImg = isset($_SESSION['img_perfil']) && !empty($_SESSION['img_perfil']) ? $_SESSION['img_perfil'] : $defaultImg;
            ?>
            <img class="sp_foto_perfil" src="<?php echo htmlspecialchars($perfilImg); ?>" alt="Imagen de perfil del usuario">
            
            <div class="sp_encabezado_info">

                <span class="sp_encabezado_texto">
                    Publicar en foro
                </span>
                <span class="sp_encabezado_texto_usuario hide">

                    <?php echo $_SESSION['usuario_nombre'] .
                    ' ' . $_SESSION['usuario_apellido']?>

                </span>

                <span class="sp_fecha_pub">
                    
                </span>
            </div>

            <div class="sp_btn_borrar hide">
                <img src="<?= BASE_URL ?>/img/letra-x.png" alt="Borrar">
            </div>

        </div>

        <div class="sp_cuerpo hide">
            <textarea Rows= 1
             autocapitalize="true"
             id="titulo"
            placeholder="Agrega un asunto"
             ></textarea>
            <div id="editor"></div>
        </div>

        <div class="sp_archivos"> 
            
        </div>   
            

        <div class="sp_info">

            
            <div class="sp_archivo_menu">
                
                <div class="sp_btn_archivo hide">+</div>

              
                <div class="sp_archivo_menu_contenido hide">
                    <div class="contenido_item" id = "btn_imagen">
                        Imagen
                    </div>
                    <div class="contenido_item" id= "btn_word" >
                        Documento de Word             
                    </div>
                    <div class="contenido_item" id = "btn_pdf">
                        PDF
                    </div>

                </div>
              
            </div>

            <div id="publicar-<?php $alcance?>" class="sp_btn_publicar">
                <span>
                    PUBLICAR
                </span>
            </div>
        </div>

        <div style="display: none">
            <input
                type="file"
                accept="image/*"
                class="carga_menu_input"
                id="inp_imagen"
            />
            <input
                type="file"
                accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                class="carga_menu_input"
                id="inp_word"
            />
            <input
                type="file"
                accept=".pdf,application/pdf"
                class="carga_menu_input"
                id="inp_pdf"
            />
        </div>
            
        

    </div>
