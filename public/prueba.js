
window.addEventListener("load", ()=>{

    console.log("Cargado");
    const btn = document.querySelectorAll(".form_boton.despliega");


    btn.forEach((boton)=>{
        //console.log(boton);
        boton.addEventListener("click",()=>{

            var desplegable = boton.parentNode;
            //querySelector(".form_desplegable");
            desplegable = console.log(desplegable.querySelector(".form_desplegable_cont"));
            console.log(desplegable);
            desplegable.classList.toggle("desplegado");

        });
    })
    
    
    
    
});

