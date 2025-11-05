<header class="header">
        <?php
            include '../app/vistas/componentes/header.php'; 
        ?>
    </header>
    
    <main class="main-content">

        <link href="css/reset.css" rel="stylesheet" />
       
        <link href="css/style.css" rel="stylesheet" />
        <link href="css/subir_publicacion.css" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

        <script src="js/subir_publicacion.js"></script>


    
    <div class= "subir_publicacion selected" 
        id="sp" 
        data-ref="<?php BASE_URL?>"
        
        >
        
        <div class="sp_encabezado ">

                <img class="sp_foto_perfil" src="img/no.png"/>
                
                <div class="sp_encabezado_info">

                    <span class="sp_encabezado_texto hide">
                        Publicar en foro
                    </span>
                    <span class="sp_encabezado_texto_usuario">

                        <?php echo $_SESSION['usuario_nombre'] .
                        ' ' . $_SESSION['usuario_apellido']?>

                    </span>

                    <span class="sp_fecha_pub">
                        
                    </span>

                    <div class="sp_btn_borrar hide">
                    
                    </div>
                </div>

        </div>

        <div class="sp_cuerpo selected">
            <textarea Rows= 1
             autocapitalize="true"
             id="titulo"
             placeholder="Agrega un asunto"><?php echo $publicacion["titulo"]; ?>
            </textarea>

            <div id="editor">
                <?php echo $publicacion["cuerpo"]; ?>
            </div>

        </div>

        <div class="sp_archivos"> 
            <?php


                if(isset($publicacion["archivos_titulos"])){
                    $archivos = explode(',', $publicacion['archivos_titulos']);
                    $archivos_id = explode(',', $publicacion['archivos_id']);
                    
                    foreach($archivos as $archivo){

                    ?>
                    <div class="sp_archivo">
                        <span class="sp_archivo_borrar">x</span>
                        <span class="a_n"><?php echo $archivo ?><span>
                    </div>

                    <?php
                

                }}
            
            ?>
            
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

            <div editar=<?php echo $publicacion["id"]; ?> class="sp_btn_publicar selected">
                <span>
                    EDITAR
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



    </main>

    <footer>
        <?php
            include '../app/vistas/componentes/footer.php';
        ?>

</footer>