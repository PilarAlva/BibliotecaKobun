window.addEventListener("DOMContentLoaded", function() {

    console.log("cargado el taller");

    const btn_taller_menu = document.querySelectorAll(".taller_menu_btn");
    const taller_tab = document.querySelector(".taller_cuerpo");

    const subir_publicacion = document.querySelector(".subir_publicacion");


    console.log(btn_taller_menu);
    
    btn_taller_menu.forEach((boton) => {

        console.log(boton);

        boton.addEventListener("click", async function(){

            
            btn_taller_menu.forEach((sub) => {
            
                sub.classList.remove("selected");

            });

            boton.classList.add("selected");

            await mostrarVista(boton.getAttribute("tab"));
            
            


        });

    } )


    async function mostrarVista(id){
        

        
        subir_publicacion.parentNode.classList.remove("hide");
        
        const profe = await this.es_profesor(subir_publicacion.dataset.uid);
        console.log("profesor: " + profe.resultado);

        Array.from(taller_tab.children).forEach(async (tab) => {

            console.log(tab);
            tab.setAttribute("hidden", "");
            if(tab.id == id ){
                console.log(id);
                tab.removeAttribute("hidden");

            }
            if(id == "taller_section_participantes"){
                subir_publicacion.parentNode.classList.add("hide");
            }else if(id == "taller_section_recursos"){
                
                if( profe.resultado == 1){
                    subir_publicacion.dataset.alcance = "recurso";
                    
                }else{
                    subir_publicacion.parentNode.classList.add("hide");
                }
            }else if(id == "taller_section_libreta"){
                subir_publicacion.dataset.alcance = "libreta";
            }else if(id == "taller_section_foro"){
                subir_publicacion.dataset.alcance = "foro";
            }

            

        });

    }


});

async function es_profesor(uid) {
    const API_URL = "http://localhost/Kobun/public/peticion";

    const formData = new FormData();
    formData.append('usuario_id', uid);
    formData.append('accion', "es-profesor");

    
    try {
            const response = await fetch(API_URL, {
                method: 'POST',
                body: formData
            });
            const resultado = await response.text();
            try {
                return JSON.parse(resultado);
            } catch (e) {
                console.warn("error en el JSON:", resultado);
                return resultText;
            }
        } catch (error) {
            console.error('Error en la peticion:', error);
            throw error;
        }
} 