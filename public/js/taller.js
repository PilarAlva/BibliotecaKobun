window.addEventListener("DOMContentLoaded", function() {

    console.log("cargado el taller");

    const btn_taller_menu = document.querySelectorAll(".taller_menu_btn");

    const taller_tab = document.querySelector(".taller_cuerpo");

    console.log(btn_taller_menu);
    
    btn_taller_menu.forEach((boton) => {

        console.log(boton);

        boton.addEventListener("click", function(){

            
            btn_taller_menu.forEach((sub) => {
            
                sub.classList.remove("selected");

            });

            boton.classList.add("selected");

            mostrarVista(boton.getAttribute("tab"));


        });

    } )


    function mostrarVista(id){
        console.log(id);

        Array.from(taller_tab.children).forEach((tab) => {
            console.log(tab);
            tab.setAttribute("hidden", "");
            if(tab.id == id ){
                console.log(id);
                tab.removeAttribute("hidden");

            }

            

        });

    }


});