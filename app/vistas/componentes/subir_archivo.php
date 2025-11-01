



<?php 
    $archivo_subido = isset($archivo_subido) ? $archivo_subido : "alg0.img";
?>

<div class= "subir_archivo">
  
  <label class="subir_archivo__encabezado">
    Suba un archivo
  </label>
  
  <div class="subir_archivo__cuerpo">

    <div class="subir_archivo__cuerpo_contenedor">

        <div id = "archivo_cargado">
            <button
                  class="subir_archivo__cuerpo_borrar"
                  id= "boton_borrar"
                  type="button"
                  aria-label="Borrar archivo"
                >
                  X
            </button>
            <input
              
                class="subir_archivo__cuerpo_input"
                id ="nombre_archivo"
                type="text"
                value= ""
            />
            <button
                  id= "boton_subir"
                  class="subir_archivo__cuerpo_subir"
                  type="button"
                  aria-label="Subir archivo"
                >
            </button>
        </div>
        
        <div id = "archivo_cargar">
          <div class="subir_archivo__carga">

            <div class="subir_archivo__carga_menu">
              <button
                class="subir_archivo__carga_boton"
                type="button"
                aria-label="Upload file"
              >
              +  
            </button>
            <div class="subir_archivo__carga_menu_contenedor">
              <div class="subir_archivo__carga_menu_item" id = "btn_imagen">
                Imagen
              </div>
              <div class="subir_archivo__carga_menu_item" id= "btn_word" >
                Documento de Word             
              </div>
              <div class="subir_archivo__carga_menu_item" id = "btn_pdf">
                PDF
              </div>
            </div>
            
          </div>

          <input
              type="file"
              accept="image/*"
              class="carga_menu_input"
              id="inp_imagen"
              aria-label="Image file input"
            />
            <input
              type="file"
              accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
              class="carga_menu_input"
              id="inp_word"
              aria-label="Word file input"
            />
            <input
              type="file"
              accept=".pdf,application/pdf"
              class="carga_menu_input"
              id="inp_pdf"
              aria-label="PDF file input"
            />
        
          </div>
        </div>
      </div>

</div>