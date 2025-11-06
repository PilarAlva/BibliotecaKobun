
window.addEventListener("load", ()=>{

    console.log("Cargado");
    const btn = document.querySelectorAll(".form_boton.despliega");


    btn.forEach((boton)=>{
        //console.log(boton);
        boton.addEventListener("click",()=>{
            
            var seccion = boton.closest(".seccion_formulario");
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

    
}
