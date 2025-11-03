window.addEventListener("load", function(){

    const boton_pubicar = document.querySelector(".sp_btn_publicar");
    const sp_publicacion = document.querySelector(".subir_publicacion");

    const inputs = this.document.querySelectorAll(".carga_menu_input");

    const carga_archivos = this.document.querySelectorAll(".contenido_item");

    const lista_archivos = this.document.querySelector(".sp_archivos");

    const files = [];

    const quill = new Quill('#editor', {
        placeholder: 'Escribí el contenido aca ',
        modules: {
            toolbar: [
            ['bold', 'italic'],
            ['link', 'blockquote', 'code-block'],
            ],
        },
        theme: 'snow',
    });
    

    inputs.forEach((input) =>{
        input.addEventListener("change", (event)=>{
            informacionCargada(input.files[0]);
        });

    });

    carga_archivos.forEach((carga) =>{

        carga.addEventListener("click", ()=>{
            
            cargarArchivo(carga.id);

        })

    });

    document.querySelector(".sp_btn_archivo").addEventListener("click", ()=>{
        
        
        document.querySelector(".sp_archivo_menu_contenido").classList.toggle("hide");
        document.querySelector(".sp_archivo_menu_contenido").classList.toggle("selected");

     });

     document.querySelector(".sp_btn_borrar").addEventListener("click", ()=>{

        borrarTodo();
        if(boton_pubicar.hasAttribute("enviar")){
            boton_pubicar.removeAttribute("enviar");
            document.querySelector(".sp_btn_archivo").classList.toggle("hide");
            document.querySelector(".sp_cuerpo").classList.toggle("selected");
            
            document.querySelector(".sp_encabezado_texto").classList.toggle("hide");
            document.querySelector(".sp_encabezado_texto_usuario").classList.toggle("hide");
            document.querySelector(".sp_btn_borrar").classList.toggle("hide");
    
    
            boton_pubicar.classList.toggle("selected");
            sp_publicacion.classList.toggle("selected");
        }

     });

    boton_pubicar.addEventListener("click", (e)=>{

        if(boton_pubicar.hasAttribute("enviar")){

            

            var archivos_id = guardarArchivos();;
            var text_body = quill.root.innerHTML;
            var text_title = document.getElementById("titulo");

            document.querySelector('#inp_text').value = quill.root.innerHTML;
            
            const formData = new FormData();
            formData.append('titulo', text_title);
            formData.append('cuerpo', text_body);
            formData.append('archivos_id', archivos_id);
            formData.append('usuario_id', usuario_id);
            formData.append('taller_id', taller_id);

            fetch('http://192.168.1.51/BibliotecaKobun/public/publicacion/subir', { 
            method: 'POST',
            body: formData
            })
            .then(response => response.text())
            .then(result => {
                console.log(result); 
                alert('Publicacion subida');
            })
            .catch(error => {
                console.error('Error subiendo la publicacion', error);
                alert('Error subiendo la publicacion, intente mas tarde.');
            });

        }else{

            document.querySelector(".sp_btn_archivo").classList.toggle("hide");
            document.querySelector(".sp_cuerpo").classList.toggle("selected");
            
            document.querySelector(".sp_encabezado_texto").classList.toggle("hide");
            document.querySelector(".sp_encabezado_texto_usuario").classList.toggle("hide");
            document.querySelector(".sp_btn_borrar").classList.toggle("hide");
    
    
            boton_pubicar.classList.toggle("selected");
            boton_pubicar.toggleAttribute("enviar");
            sp_publicacion.classList.toggle("selected");

        }

    })

    function cargarArchivo(id_carga){
        
        
        switch(id_carga){
            case 'btn_imagen':
                
                inputs.forEach((input)=>{ if (input.id == "inp_imagen"){
                    console.log(input);  
                  input.click();
                } })
                    
                break;
            case "btn_pdf":
                inputs.forEach((input)=>{ if (input.id == "inp_pdf") input.click() })
                break;
            case "btn_word":
                inputs.forEach((input)=>{ if (input.id == "inp_word") input.click()})
                break;
            

        }

    }
    function informacionCargada(file){

        
        const archivo_nombre = document.createElement("span");
        archivo_nombre.classList.add("a_n");
        archivo_nombre.appendChild(document.createTextNode(file["name"]));

        const archivo_borrar = document.createElement("span");
        archivo_borrar.classList.add("sp_archivo_borrar");
        archivo_borrar.appendChild(document.createTextNode("x"));

        archivo_borrar.addEventListener("click", (event)=>{
        
            lista_archivos.appendChild(archivo);
            let index = -1;


            files.forEach((f)=>{ 
                if(f["name"] === archivo_borrar.parentNode.querySelector(".a_n").textContent)
                {
                    index = files.indexOf(f);
                    archivo_borrar.parentNode.remove();
                }
            });

            if (index > -1) {
                files.splice(index, 1); 
            }


        })

    
        const archivo = document.createElement("div");
        archivo.classList.add("sp_archivo");
        
        archivo.appendChild(archivo_borrar);
        archivo.appendChild(archivo_nombre);

        if(files.length <=5){

            lista_archivos.appendChild(archivo);
            files.push(file);

        }else{
            alert('Solo podés hasta 5 archivos o explota todo!');
        }


        console.log("archivo cargado: ");
        console.log(files);

    }
    function borrarTodo(){

        while(files.length > 0) {
        files.pop();
        }

        
    }

    function guardarArchivos(){

        if(files.length < 1){
            null;
        }
        

        files.forEach( (file)=>{
    

            const formData = new FormData();
            formData.append('image_uploads', file);
            formData.append('titulo', file["name"]);

            fetch('http://192.168.1.51/BibliotecaKobun/public/archivo/subir', { 
            method: 'POST',
            body: formData
            })
            .then(response => response.text())
            .then(result => {
                console.log(result); 
                alert('Archivo subido correctamente.');
            })
            .catch(error => {
                console.error('Error uploading file:', error);
                alert('Error subiendo el archivo, intente mas tarde.');
            });

            
        });

        
        

            




            
            
        }


    

});