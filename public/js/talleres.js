console.log("cargando... - talleres");
window.addEventListener("DOMContentLoaded", function() {

    const btn_mis_talleres = document.getElementById('btn_mis_talleres');
    const btn_talleres_busqueda = document.getElementById('btn_talleres_busqueda');

    const section_mis_talleres = document.getElementById('talleres_section_mis_talleres');
    const section_talleres_busqueda = document.getElementById('talleres_section_talleres_busqueda');

    
    console.log("cargado - talleres");

    console.log(btn_mis_talleres);
    console.log(btn_talleres_busqueda);

    console.log(section_mis_talleres);
    console.log(section_talleres_busqueda);


        btn_mis_talleres.addEventListener('click', function() {

            select(this);
            deselect(btn_talleres_busqueda);
            section_talleres_busqueda.setAttribute("hidden", "");
            section_mis_talleres.removeAttribute("hidden");

        });

        btn_talleres_busqueda.addEventListener('click', function() {

            select(this);
            deselect(btn_mis_talleres);
             section_mis_talleres.setAttribute("hidden", "");
            section_talleres_busqueda.removeAttribute("hidden", "");
            

        });

    

    function select(button){
        button.classList.add('selected');

    }
    function deselect(button){
        button.classList.remove('selected');
    }



    



});