
window.addEventListener("load", ()=>{

    console.log("Cargado");
    const btn = document.querySelectorAll(".form_boton.despliega");


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
