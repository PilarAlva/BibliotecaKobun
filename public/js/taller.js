window.addEventListener("DOMContentLoaded", function() {

    console.log("cargado el taller");

    const btn_taller_menu = document.querySelectorAll(".taller_menu_btn");

    const talleres_tabs = this.document.querySelector(".taller_contenido");

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

        Array.from(talleres_tabs.children).forEach((tab) => {

            tab.setAttribute("hidden", "");
            if(tab.id == id ){

                tab.removeAttribute("hidden");

            }

            

        });

    }


});