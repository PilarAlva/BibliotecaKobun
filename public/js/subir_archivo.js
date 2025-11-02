document.addEventListener("DOMContentLoaded", function() {

    console.log("cargado");

    const subir_archivo = document.querySelector('.subir_archivo');

    const botones_carga = subir_archivo.querySelectorAll('.subir_archivo__carga_menu_item');
    
    const inputs_carga = subir_archivo.querySelectorAll('.carga_menu_input');

    const archivo_cargado = subir_archivo.querySelectorAll('.archivo_cargado');
    const archivo_cargar = subir_archivo.querySelectorAll('.archivo_cargar');

    const nombre_archivo = document.getElementById('nombre_archivo');
    const boton_borrar =  document.getElementById('boton_borrar');
    
    const boton_subir = document.getElementById('boton_subir');

    archivo_cargado.forEach(function(cosa) {

                    
                    cosa.classList.toggle("cls");

                }); 

    inputs_carga.forEach(function(input) {
        
            input.addEventListener("change", (event) => { 

                archivo_cargado.forEach((cosa1) =>{

                    cosa1.classList.toggle("cls");

                }); 
                archivo_cargar.forEach((cosa2) =>{

                    cosa2.classList.toggle("cls");

                });
                
                
                if(input.files[0]){

                    var nombre = limpiarNombre(input.files[0].name);

                    nombre_archivo.value = nombre;
                }

                
            });

    });

    


    botones_carga.forEach(function(boton) {
        
        console.log("asd");

        switch(boton.id){
            case "btn_imagen":

                boton.addEventListener('click', function() {   

                    console.log(boton.id);
                    document.getElementById('inp_imagen').click();

                });

                break;
            case "btn_word":
                
                boton.addEventListener('click', function() {   

                    console.log(boton.id);
                    document.getElementById('inp_word').click();

                });

                break;
            case "btn_pdf":

                boton.addEventListener('click', function() {   

                    console.log(boton.id);
                    document.getElementById('inp_pdf').click();

                });

                break;
            



        }

        
    });

    boton_borrar.addEventListener('click', function() {
    
        nombre_archivo.value = "";

        inputs_carga.forEach(function(input) {
            
            input.value = '';
            // Create and dispatch a new 'change' event
            const changeEvent = new Event('change', { bubbles: true }); // 'bubbles: true' allows the event to bubble up the DOM tree
            input.dispatchEvent(changeEvent);

        });

    });

    boton_subir.addEventListener('click', function() {
    
        if(nombre_archivo.value){

            let file;

            inputs_carga.forEach(function(input) {
                
                if(input.files[0]){
                    file = input.files[0];
                }
                
            });

            if (!file) {
                alert('Please select a file to upload.');
                return;
            }

            const formData = new FormData();
            formData.append('image_uploads', file);
            formData.append('titulo', nombre_archivo.value ) 

            console.log(file);


            fetch('archivo/subir', { 
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
            
        }

        

    });

    limpiarNombre = (nombre) => {
    
        const lastDotIndex = nombre.lastIndexOf('.');

        if (lastDotIndex > 0) {
            return nombre.substring(0, lastDotIndex);
        } else {
            return nombre;
        }
    }   

});



