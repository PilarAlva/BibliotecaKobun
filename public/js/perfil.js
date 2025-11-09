import {Formulario} from './formulario.js';


/*------------------ACA HACE TODAS LAS PETICIONES-------------------------- */
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-perfil .nav-link');
    const tabContents = document.querySelectorAll('.contenido-perfil .tab-content');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            // Quitar clase 'active' de todos los links y contenidos
            navLinks.forEach(nav => nav.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            // Añadir clase 'active' al link clickeado
            this.classList.add('active');

            // Mostrar el contenido correspondiente
            const targetId = this.getAttribute('data-target');
            const targetContent = document.getElementById(targetId);
            if (targetContent) {
                targetContent.classList.add('active');
            }
        });
    });
});


window.addEventListener("load", () => {

    console.log("Cargado");

    /*Esta es la clase que se va a encargar de manejar la edicion de la informacion */
    console.log(document.getElementById("formulario"));
    const formulario = new Formulario(document.getElementById("formulario"));
    //console.log("nothing changed?" + formulario.getForm());

    //console.log(formulario.getForm() instanceof HTMLFormElement); // true
    //console.log(formulario.getForm().tagName); // FORM
    /*BOTONES*/

    const btn_mas_info_usuarios = document.querySelectorAll("#bt-mas-info-usuario");


    /*SUS 4millones de events */

    btn_mas_info_usuarios.forEach((boton) => {

        //console.log(boton);

        boton.addEventListener("click",
            function(event) {

                let usuarioID = boton.dataset.usuario;
                masInfoUsuario(usuarioID);

            })
    });



    function masInfoUsuario(id) {

        formulario.editarUsuario(id);

    }



});