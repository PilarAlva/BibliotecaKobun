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
    //console.log(document.getElementById("formulario"));
    if(document.getElementById("formulario")){
        const formulario = new Formulario(document.getElementById("formulario"));
    }
    //console.log("nothing changed?" + formulario.getForm());

    //console.log(formulario.getForm() instanceof HTMLFormElement); // true
    //console.log(formulario.getForm().tagName); // FORM
    /*BOTONES*/
    document.addEventListener("click", gestionarClicks.bind(this));
    document.addEventListener("submit", gestionarEnvios.bind(this));
    //document.addEventListener("change", gestionarCambios.bind(this));
    
    
    const btn_mas_info_usuarios = document.querySelectorAll("#bt-mas-info-usuario");
    const btn_agregar_usuario = document.querySelectorAll("#bt-agregar-usuario");
    const btn_mas_info_libro = document.querySelectorAll("#bt-mas-info-material");
    const cuerpo_material = document.querySelector("#cuerpo-material");
    const cuerpo_usuarios = document.querySelector("#cuerpo-usuarios");
    const cuerpo_talleres = document.querySelector("#cuerpo-talleres");
    const cuerpo_multas = document.querySelector("#cuerpo-multas");
    

    var resultados = await obtenerBusqueda('libros', "", "titulo", 1);
    mostrarResultadosBusqueda(cuerpo_material, resultados.data.resultados, cargarLibro);

    resultados = await obtenerBusqueda('usuarios', "", "todos", 1);
    mostrarResultadosBusqueda(cuerpo_usuarios, resultados.data.resultados, cargarUsuario);

    resultados = await obtenerBusqueda('talleres', "", "titulo", 1);
    mostrarResultadosBusqueda(cuerpo_talleres, resultados.data.resultados, cargarTaller);

    resultados = await obtenerMultas('multas', "", 1, 1, 1);
    mostrarResultadosBusqueda(cuerpo_multas, resultados.data.resultados, cargarMulta);
    
    /*SUS 4millones de events */

    function gestionarClicks(event){
        const target = event.target;
        if(!formulario) return;
        if (target.matches("#bt-mas-info-usuario")) {
            formulario.editarUsuario(target.getAttribute("data-usuario"));
        } else if (target.matches("#bt-agregar-usuario")) {
            formulario.agregarUsuario();
        }else if (target.matches("#bt-mas-info-material")) {
            formulario.editarLibro(target.getAttribute("data-libro"));
        }else if (target.matches("#bt-agregar-material")) {
            formulario.agregarLibro();
        }else if (target.matches("#bt-agregar-taller")) {
            formulario.agregarTaller();
        }else if(target.matches("#bt-mas-info-taller")){
             formulario.editarTaller(target.getAttribute("data-taller"));
        }

    }
    async function gestionarEnvios(event) {
        const form = event.target;
        if (form.matches("#buscador-material")) {
            let formData = new FormData(form);
            const q = formData.get('q');
            const filtro = formData.get('filtro');
            event.preventDefault();

            var resultados = await obtenerBusqueda('libros', q, filtro, 1);
            mostrarResultadosBusqueda(cuerpo_material, resultados.data.resultados, cargarLibro)
        }else if (form.matches("#buscador-usuarios")) {
            event.preventDefault();
            let formData = new FormData(form);
            const q = formData.get('q');
            const filtro = formData.get('filtro');

            var resultados = await obtenerBusqueda('usuarios', q, filtro, 1);
            mostrarResultadosBusqueda(cuerpo_usuarios, resultados.data.resultados, cargarUsuario)
        }else if (form.matches("#buscador-talleres")) {
            event.preventDefault();
            let formData = new FormData(form);
            const q = formData.get('q');
            const filtro = formData.get('filtro');

            var resultados = await obtenerBusqueda('talleres', q, filtro, 1);
            mostrarResultadosBusqueda(cuerpo_talleres, resultados.data.resultados, cargarTaller)
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

    async function obtenerMultas(tabla, q, filtro, pagina, socio_id) {
        const formData = new FormData();
        formData.append('accion', "busqueda-dinamica");
        formData.append('tabla', 'multas');
        formData.append('q', q);
        formData.append('filtro', filtro);
        
        let id = await obtenerSocioId();
        formData.append('socio_id', id.data.id);
        formData.append('pagina', pagina);
        return Peticion.peticion(formData);
    }
    async function obtenerSocioId() {
        const formData = new FormData();
        formData.append('accion', "obtener-socio-id");
        return Peticion.peticion(formData);
    }

    async function obtenerBusqueda(tabla, q, filtro, pagina) {
        const formData = new FormData();
        formData.append('accion', "busqueda-dinamica");
        formData.append('tabla', tabla);
        formData.append('q', q);
        formData.append('filtro', filtro);
        formData.append('pagina', pagina);
        return Peticion.peticion(formData);
    }

    //------------------------------------------------
    // Plantilla HTML
    //------------------------------------------------

    function cargarLibro(libro) {
        
        return `
                <div class="form_bloque">
                    <div class="form_fila">        
                        <div class="numero_id">#${libro.id}</div>                           
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
    
        let perfilImg = usuario.img_perfil? usuario.img_perfil : 'img/perfil-default.png';


        return `
            <div class="usuario">
                <div class="imagen-usuario-cont">
                    <img src=${perfilImg} alt="Imagen de perfil del usuario">
                </div>                                    
                 <div class="contenedor-info">
                    <p> ${usuario.nombre}  ${usuario.apellido}</p>
                    <button id="bt-mas-info-usuario"
                            class="bt-mas-info"
                            data-usuario=${usuario.id}>
                            +
                    </button>
                </div>
            </div>
            <hr class="linea-divisora">
        
        `;
    }

    function cargarTaller(taller) {
        
        return `
            <div class="form_bloque">
                <div class="form_fila">        
                    <span>#${taller.id}</span>
                    <div>${taller.nombre}</div>
                    <button id="bt-mas-info-taller"
                        class="bt-mas-info derecha" 
                        data-taller=${taller.id}>
                        +
                    </button>     
                </div>
            </div>
        `;
    }   

    function cargarMulta(multa) {

        let pagar = multa.fecha_pago ? '' :
        `<button id="bt-mas-info-taller"
            class="bt-mas-info derecha" 
            data-taller=${multa.id}>
            pagar
        </button>` 

        return `
            <div class="form_bloque">
                <div class="form_fila">        
                    <div>${multa.monto}</div>
                    ${pagar}
                         
                </div>
            </div>
        `;
    }
});