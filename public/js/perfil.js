import {Formulario, Peticion} from './formulario.js';


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


window.addEventListener("load", async () => {
    
    console.log("Cargado");

    /*Esta es la clase que se va a encargar de manejar la edicion de la informacion */
    console.log(document.getElementById("formulario"));
    const formulario = new Formulario(document.getElementById("formulario"));
    //console.log("nothing changed?" + formulario.getForm());

    //console.log(formulario.getForm() instanceof HTMLFormElement); // true
    //console.log(formulario.getForm().tagName); // FORM
    /*BOTONES*/
    document.addEventListener("click", gestionarClicks.bind(this));
    document.addEventListener("submit", gestionarEnvios.bind(this));
    //document.addEventListener("change", gestionarCambios.bind(this));
    
    
    const btn_mas_info_usuarios = document.querySelectorAll("#bt-mas-info-usuario");
    const btn_agregar_usuario = document.querySelectorAll("#bt-agregar-usuario");
    const cuerpo_material = document.querySelector("#cuerpo-material");
    const cuerpo_usuarios = document.querySelector("#cuerpo-usuarios");
    

    var resultados = await obtenerBusqueda('libros', "", "titulo", 1);
    mostrarResultadosBusqueda(cuerpo_material, resultados.data.resultados, cargarLibro);

    resultados = await obtenerBusqueda('usuarios', "", "todos", 1);
    mostrarResultadosBusqueda(cuerpo_usuarios, resultados.data.resultados, cargarUsuario);
    
    /*SUS 4millones de events */

    function gestionarClicks(event){
        const target = event.target;

        if (target.matches("#bt-mas-info-usuario")) {
            formulario.editarUsuario(target.getAttribute("data-usuario"));
        } else if (target.matches("#bt-agregar-usuario")) {
            formulario.agregarUsuario();
        }

    }
    async function gestionarEnvios(event) {
        const form = event.target;
        if (form.matches("#buscador-material")) {
            event.preventDefault();
            let formData = new FormData(form);
            const q = formData.get('q');
            const filtro = formData.get('filtro');
            //const pagina = formData.get('pagina');

            var resultados = await obtenerBusqueda('libros', q, filtro, 1);
            mostrarResultadosBusqueda(cuerpo_material, resultados.data.resultados, cargarLibro)
        }
    }
    /*
    function gestionarCambios(event) {
        const target = event.target;
        if (target.matches('input, select, textarea')) {
            const form = target.closest('form.form_datos');
            if (form && this.validarCampo(target)) {
                this.insertarCambio(form);
            }
        }
    }*/

    async function mostrarResultadosBusqueda(donde, resultados, plantilla){
        
        let cont = "";
        cont = resultados.map(r => plantilla(r)).join('');

        donde.innerHTML = cont;
    }

    async function obtenerBusqueda(tabla, q, filtro, pagina) {
        const formData = new FormData();
        formData.append('accion', "busqueda-meterial");
        formData.append('tabla', tabla);
        formData.append('q', q);
        formData.append('filtro', filtro);
        formData.append('pagina', pagina);
        return Peticion.peticion(formData);
    }

    function cargarLibro(libro) {
        
        return `
                <div class="form_bloque">
                    <div class="form_fila">        
                        <div>#${libro.id}</div>                           
                        <div class="form_seccion">
                            <h3 class="titulo-libro">${libro.titulo}</h3>
                            <p class="autor-libro">${libro.autores}</p>
                        </div>
                        <button id="bt-mas-info-material"
                            class="bt-mas-info derecha" 
                            data-libro=${libro.id}>
                            +
                        </button>
                    </div>
                </div> 
                `;
        
    }
    function cargarUsuario(usuario) {
    
        return `
             <div class="usuario">
                <div class="imagen-usuario-cont">
                    <?php
                        $defaultImg = 'img/perfil-default.png';
                        $perfilImg = (isset($usuarioItem['img_perfil']) && !empty($usuarioItem['img_perfil'])) ? $usuarioItem['img_perfil'] : $defaultImg;
                    ?>
                    <img src="<?php echo htmlspecialchars($perfilImg); ?>" alt="Imagen de perfil del usuario">
                </div>                                    
                <div class="contenedor-info">
                        <p><?php echo htmlspecialchars($usuarioItem['nombre']) . ' ' . htmlspecialchars($usuarioItem['apellido']);?></p>
                        <button class="bt-mas-info" >+</button>
                    </div>
                </div>
            <hr class="linea-divisora">
        
        `;
    }
    
});