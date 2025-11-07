class Cambio{

    constructor(form, formData, mensaje) {
        this.form = form;
        this.formData = formData;
        this.mensaje = mensaje;
    }



}
window.addEventListener("load", ()=>{

    console.log("Cargado");
    const btn = document.querySelectorAll(".form_boton.despliega");
    const btn_guardar = document.querySelector("#btn-guardar");
    const btn_cerrar = document.querySelector("#btn-cerrar");
    
    //acá solo habría UPDATES, INSERTS y DELETES 
    const cola_cambios = [{}];

    btn_guardar.addEventListener("click", ()=>{guardarCambios()});
    btn_cerrar.addEventListener("click", ()=>{});

    const form_datos = document.getElementById("form-insertar-usuario");

    form_datos.addEventListener("submit", (event)=>{
        event.preventDefault();
        validar(form_datos);
        //insertarCambio();
    });
    form_datos.addEventListener('change', (event) =>{
    
        if (event.target.matches('input, select, textarea')) {
            //console.log('An input value changed:', event.target.name, event.target.value);
            if(validarCampo(event.target))
                insertarCambio(this.target);  
            else{

            }
        //console.log(event);
    }});
    form_datos.addEventListener('input', (event) =>{
    
        if (event.target.matches('input, select, textarea')) {
            //console.log('An input value changed:', event.target.name, event.target.value);
            
    }});

    function guardarCambios(){
        
        console.log(cola_cambios);
        if(cola_cambios.length > 0){
            cola_cambios.forEach(async (cambio)=>{

                respuesta = await peticion(cambio.formData);
                console.log(respuesta);
                if(respuesta.estado == "error")
                    mostrarMensaje(cambio.mensaje, respuesta.mensaje, "form_error");
                else if(respuesta.estado == "exito")
                    mostrarMensaje(cambio.mensaje, respuesta.mensaje, "form_exito");
                

            })

        }else{
            console.log("no hay cambios");
        }

    }

    function mostrarMensaje(contenedor, mensaje, tipo = 'form_error'){

        contenedor.innerText = mensaje;
        contenedor.classList.add("ocultado");

        contenedor.classList.remove("ocultado");
        contenedor.classList.add("form_exito");
        contenedor.classList.add("form_error");
        contenedor.classList.remove("form_error");
        contenedor.classList.remove("form_exito");

        contenedor.classList.add(tipo);
        



    }

    function insertarCambio(){
        const index = cola_cambios.findIndex(form_datos => form_datos.id === id);
        console.log(form_datos);
        
        const formData = new FormData(form_datos);

        const cambio = new Cambio(form_datos, formData, form_datos.querySelector(".form_mensaje"));
        
        if (index !== -1) {
            cola_cambios[index] = cambio;
        } else {
            
            var id = form_datos.id;
            cola_cambios.push({id, cambio});
        }

        //console.log(cola_cambios);
        //form_datos.dispatchEvent(new Event('submit'));
    }

    function validar(form){

        
        var campos = form.getElementsByTagName("input");

        console.log(campos);
        campos = Array.from(campos);

        var aceptado = true;

        campos.forEach((campo)=>{
            
            if(!validarCampo(campo)) aceptado = false;
            
        });

        return aceptado;

    }
    function validarCampo(campo){

      
        var err = "";
        var name = campo.name;
        var value = campo.value;
        console.log(name + ": " + value);

        if (value == null || value == "") {
            err = name + " es requerido";
            
        } else if(name == "mail"){
                var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 
                if (!emailRegex.test(value)) { 
                    err = "Email invalido"}  
            }


        //Despues de todas las comprobaciones se muestra o no el error de cada input
        
        var span_error = campo.parentNode.querySelector(".form_input_mensaje");
        span_error.innerText = "";
        span_error.classList.add("ocultado");
        if(err != ""){
            span_error.innerText = err;
            span_error.classList.remove("ocultado");
            
            return false;
        }
        return true;
                
            
        


    }

    btn.forEach((boton)=>{
        //console.log(boton);
        boton.addEventListener("click",()=>{
            
            this.usuarios();

            var seccion = boton.closest(".form_desplegable");
            var ocultar = seccion.querySelectorAll(".se_oculta");
            var plegar = seccion.querySelectorAll(".se_despliega");
            if(ocultar){
                ocultar.forEach((node)=>{ node.classList.toggle("ocultado") });
            }
            if(plegar){
                plegar.forEach((node)=>{ 
                    node.classList.toggle("desplegado");
                    node.classList.toggle("plegado");
                });
            }


        });
    })
    
    
});


function usuarios(){

            const formData = new FormData();
            formData.append('accion', "usuarios");;

            fetch("http://localhost/BibliotecaKobun/public/peticion", { 
            method: 'POST',
            body: formData
            })
            .then(response => response.text())
            .then(result => {

                var data = JSON.parse(result).data;
                //data.forEach((dato) => {console.log("dato: " + data);  })
                console.log(data.usuarios[0]); 
                

            })
            .catch(error => {
                console.error('Error subiendo la publicacion', error);
                
            });

}

async function peticion(formData){
        
        return new Promise((resolve, reject) => {
    
            fetch("http://localhost/BibliotecaKobun/public/peticion", {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                try {
                    resolve(JSON.parse(result));
                } catch (e) {
                    reject(e);
                }
            })
            .catch(error => {
                console.error('Error en la peticion', error);
                reject(error);
            });
        });

    }

