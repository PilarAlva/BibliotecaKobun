/**
 * @file Refactored form handling logic for BibliotecaKobun.
 * @author Gemini
 */

/**
 * Represents a change to be sent to the server.
 */
export class Cambio {
    constructor(target, form, formData, mensaje, plantilla, data) {
        this.target = target;
        this.form = form;
        this.formData = formData;
        this.mensaje = mensaje;
        this.plantilla = plantilla;
        this.data = data;
    }
}

/**
 * Handles API requests to the backend.
 */
export class Peticion {
    static API_URL = "http://localhost/BibliotecaKobun/public/peticion";

    /**
     * Performs a fetch request.
     * @param {FormData} formData - The data to be sent.
     * @returns {Promise<any>} - The JSON response from the server.
     */
    static async peticion(formData) {
        try {
            const response = await fetch(this.API_URL, {
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


    static transaccion(accion) {
        const formData = new FormData();
        formData.append('accion', accion);
        return this.peticion(formData);
    }

    static empezar() {
        return this.transaccion("empezar-transaccion");
    }

    static cerrar() {
        return this.transaccion("cerrar-transaccion");
    }

    static aceptar() {
        return this.transaccion("commit-transaccion");
    }
}

export class Formulario {
    formulario;
    contenido;
    colaPaginas = [];
    colaCambios = [];
    cant_cambios;

    constructor(formulario) {
        this.formulario = formulario;
        this.contenido = this.formulario.querySelector(".form_contenido");
        this.cant_cambios = this.formulario.querySelector("#cant-cambios");
        
        Peticion.empezar();
        this.colaPaginas.push(this.contenido.cloneNode(true));
        this.eventos();
    }

    eventos() {
        this.formulario.addEventListener("click", this.gestionarClicks.bind(this));
        this.formulario.addEventListener("submit", this.gestionarEnvios.bind(this));
        this.formulario.addEventListener("input", this.gestionarCambios.bind(this));
    }

    gestionarClicks(event) {
        const target = event.target;

        if (target.matches("btn-retroceso")) {
            this.retroceder();
        } else if (target.matches("btn-guardar")) {
            this.guardarCambios();
        } else if (target.matches("btn-cerrar")) {
            this.borrarCambios();
        } else if (target.matches(".form_boton.despliega")) {
            this.toggleDesplegable(target);
        } else if (target.matches(".form_checkbox")) {
            this.handleCheckboxClick(target);
        } else if (target.closest('.form_multiselect_contenedor')) {
            this.gestionarMultiselectClick(event);
        }

        if (!target.closest('.form_multiselect_contenedor')) {
            this.cerrarTodosLosMultiselect();
        }
    }

    gestionarEnvios(event) {
        event.preventDefault();
        const form = event.target;
        if (form.matches(".form_datos") && this.validar(form)) {
            this.insertarCambio(form);
            this.cargarCambio();
        }
    }

    gestionarCambios(event) {
        const target = event.target;
        console.log("cambio")
        if (target.matches('.form_multiselect_filtro')) {
            const contenedor = target.closest('.form_multiselect_contenedor');
            const filtro = target.value.toLowerCase();
            const opciones = contenedor.querySelectorAll('.form_multiselect_opcion');
            opciones.forEach(opcion => {
                const nombre = opcion.dataset.nombre.toLowerCase();
                opcion.style.display = nombre.includes(filtro) ? '' : 'none';
            });
        }
    }

    toggleDesplegable(boton) {
        const seccion = boton.closest(".form_desplegable, .seccion_formulario");
        if (!seccion) return;

        seccion.querySelectorAll(".se_oculta").forEach(node => node.classList.toggle("ocultado"));
        seccion.querySelectorAll(".se_despliega").forEach(node => {
            node.classList.toggle("desplegado");
            node.classList.toggle("plegado");
        });
    }

    handleCheckboxClick(check) {
        const seccion = check.closest(".form_checks");
        if (!seccion) return;

        const seccionVisible = seccion.querySelector(".form_checks_cont");
        const checks = seccion.querySelectorAll(".form_checkbox");
        const isAnyChecked = Array.from(checks).some(c => c.checked);

        seccionVisible?.classList.toggle("ocultado", !isAnyChecked);
    }

    gestionarMultiselectClick(event) {
        const contenedor = event.target.closest('.form_multiselect_contenedor');
        if (!contenedor) return;

        const opcionesLista = contenedor.querySelector('.form_multiselect_opciones');


        if (event.target.matches('.form_multiselect_desplegar, .form_multiselect_filtro')) {
            const estaAbierto = !opcionesLista.classList.contains('ocultado');
            this.cerrarTodosLosMultiselect();
            if (!estaAbierto) {
                opcionesLista.classList.remove('ocultado');
            }
        }

      
        if (event.target.matches('.form_multiselect_opcion')) {
            this.toggleOpcionMultiselect(event.target);
        }

    
        if (event.target.matches('.pill_remover')) {
            const pill = event.target.parentElement;
            const id = pill.dataset.id;
            const opcionCorrespondiente = contenedor.querySelector(`.form_multiselect_opcion[data-id="${id}"]`);
            if (opcionCorrespondiente) {
                this.toggleOpcionMultiselect(opcionCorrespondiente);
            }
        }
    }

    toggleOpcionMultiselect(opcion) {
        const contenedor = opcion.closest('.form_multiselect_contenedor');
        const id = opcion.dataset.id;
        const nombre = opcion.dataset.nombre;
        const pillsContenedor = contenedor.querySelector('.form_multiselect_pills');
        const inputOculto = contenedor.querySelector('input[type="hidden"]');

        opcion.classList.toggle('seleccionado');

        if (opcion.classList.contains('seleccionado')) {
            const pillHTML = `<span class="pill" data-id="${id}">${nombre} <button type="button" class="pill_remover">×</button></span>`;
            pillsContenedor.insertAdjacentHTML('beforeend', pillHTML);
        } else {
            const pillParaQuitar = pillsContenedor.querySelector(`.pill[data-id="${id}"]`);
            if (pillParaQuitar) {
                pillParaQuitar.remove();
            }
        }

        const pillsActuales = pillsContenedor.querySelectorAll('.pill');
        const idsSeleccionados = Array.from(pillsActuales).map(p => p.dataset.id);
        inputOculto.value = idsSeleccionados.join(',');
    }

    cerrarTodosLosMultiselect() {
        document.querySelectorAll('.form_multiselect_opciones').forEach(lista => {
            lista.classList.add('ocultado');
        });
    }



    //--------------------------------------------------------------------------
    //  La parte publica
    //--------------------------------------------------------------------------

    async editarUsuario(id) {
        try {
            const usuarioData = await this.obtenerUsuario(id);
            if(usuarioData.data.usuario.socio_id){
                var socio_id = usuarioData.data.usuario.socio_id;
                const prestamosData = await this.obtenerPrestamos(socio_id);
                const multasData = await this.obtenerMultas(id);
                const estadoCuentaData = await this.obtenerEstadoCuenta(id);

                

                this.mostrarPaginaUsuario(usuarioData.data.usuario, prestamosData.data.prestamos, multasData.data.multas, estadoCuentaData.data.estadoCuenta);

            }else{
                this.mostrarPaginaUsuario(usuarioData.data.usuario);
            }

            this.mostrarPagina();
        } catch (error) {
            console.error("No se pudo cargar el usuario:", error);
            this.mostrarMensaje(this.contenido, "Error al cargar los datos del usuario.", "form_error");
            return null;
        }
    }

    agregarUsuario() {

        this.mostrarPaginaAgregarUsuario();
        this.mostrarPagina();
 
    }

    async editarLibro(id){
        try {
            
            const libroData = await this.obtenerLibro(id);
            if(libroData.data.libro.activo){

                var libro_id = libroData.data.libro.id;
                
                const cantidadData = await this.obtenerEjemplaresDisponibles(libro_id);
                const ejemplaresData = await this.obtenerEjemplares(libro_id);

                this.mostrarPaginaLibro(libroData.data.libro,
                                        cantidadData.data.disponibles,
                                        ejemplaresData.data.ejemplares);
            }

            this.mostrarPagina();
        } catch (error) {
            console.error("No se pudo cargar el libro:", error);
            this.mostrarMensaje(this.contenido, "Error al cargar los datos del libro.", "form_error");
            return null;
        }
    }
    async agregarLibro() {

        const autoresData = await this.obtenerOpciones("autores");
        const editorialesData = await this.obtenerOpciones("editoriales");
        const generosData = await this.obtenerOpciones("generos");


        this.mostrarPaginaAgregarLibro(autoresData.data, editorialesData.data, generosData.data);
        this.mostrarPagina();
 
    }

    //--------------------------------------------------------------------------
    // Paginas y la cola de páginas 
    //--------------------------------------------------------------------------

    retroceder() {
        if (this.colaPaginas.length > 1) {
            this.colaPaginas.pop();
            this.mostrarPagina();
        }
    }

    mostrarPagina() {
        const pagina = this.colaPaginas[this.colaPaginas.length - 1];
        if (pagina) {
            this.contenido.innerHTML = ''; // Clear existing content
            this.contenido.appendChild(pagina);
        }
    }

    borrarCambios() {
        console.log("Borrando cambios:", this.colaCambios);
        this.colaCambios = [];
        Peticion.cerrar().then(() => Peticion.empezar()); 
    }

    async cargarCambio() {
        if (this.colaCambios.length === 0) {
            console.log("No hay cambios para cargar.");
            return;
        }
        let cantidad = this.colaCambios.length;
        this.cant_cambios.innerText = "Cantidad de cambios: " + cantidad;

        const { id, cambio } = this.colaCambios.pop();
        console.log("Procesando cambio:", cambio.formData.get('accion'));

        try {
            const respuesta = await Peticion.peticion(cambio.formData);
            if (respuesta.estado === "exito") {
                
                // Después de una acción exitosa, actualiza la sección correspondiente.
                const accion = cambio.formData.get('accion');
                const usuario_id = cambio.formData.get('usuario_id');
                const socio_id = cambio.formData.get('socio_id');

                switch (accion) {
                    case 'devolver-prestamo':
                        if (usuario_id) {
                            const nueva_seccion = await this.actualizarSeccionPrestamos(usuario_id, socio_id);
                            //console.log(cambio.mensaje);
                        
                            var mensaje = nueva_seccion.querySelector(".form_mensaje");
                            
                            this.mostrarMensaje(mensaje, "Prestamo devuelto", "form_exito");
                        }
                        break;
                    case 'agregar-socio':
                        if (usuario_id) {
                            //console.log(cambio.mensaje);
                            
                            await this.editarUsuario(usuario_id);
                            mensaje = this.formulario.querySelector(".form_mensaje");
                            this.mostrarMensaje(mensaje, "Socio agregado", "form_exito");   

                        }
                        break;
                    case 'quitar-profesor':
                    case 'agregar-profesor':
                        if (usuario_id) {
                            
                            await this.editarUsuario(usuario_id);
                            mensaje = this.formulario.querySelector(".form_mensaje");
                            this.mostrarMensaje(mensaje, "Cambio de esto", "form_exito");   

                        }
                    
                    break;
                    case 'registrar-usuario':
                        await this.editarUsuario(respuesta.data.usuario_id);
                        mensaje = this.formulario.querySelector(".form_mensaje");
                        this.mostrarMensaje(mensaje, "Registro exitoso", "form_exito");   
                        break;

                    }
                    
            } else {
                this.mostrarMensaje(cambio.mensaje, respuesta.mensaje || "Ocurrió un error.", "form_error");
            }
        } catch (error) {
            this.mostrarMensaje(cambio.mensaje, "Error de conexión al procesar el cambio.", "form_error");
            console.error("Error en el puto submit", error);
        }
    }

    async guardarCambios() {
        if (this.colaCambios.length === 0) {
            console.log("No hay cambios para guardar.");
            return;
        }

        const peticiones = this.colaCambios.map(cambio =>
            Peticion.peticion(cambio.formData).then(respuesta => ({
                respuesta,
                cambio
            }))
        );

        try {
            const resultados = await Promise.all(peticiones);
            resultados.forEach(({ respuesta, cambio }) => {
                const messageType = respuesta.estado === "exito" ? "form_exito" : "form_error";
                this.mostrarMensaje(cambio.mensaje, respuesta.mensaje, messageType);
            });

            // Clear queue after processing
            this.colaCambios = [];
            console.log("Todos los cambios han sido procesados.");
        } catch (error) {
            console.error("Error al guardar cambios:", error);
        }
    }

    insertarCambio(form) {
        const id = form.id;
        if (!id) {
            console.error("Form must have an ID to track changes.", form);
            return;
        }

        const formData = new FormData(form);
        const cambio = new Cambio(
            form,
            form,
            formData,
            form.querySelector(".form_mensaje")
            // Add plantilla and data if needed
        );

        const index = this.colaCambios.findIndex(c => c.id === id);
        if (index !== -1) {
            this.colaCambios[index] = { id, cambio };
        } else {
            this.colaCambios.push({ id, cambio });
        }
        console.log("Cambio insertado/actualizado. Cola:", this.colaCambios);
    }

    //--------------------------------------------------------------------------
    // La validación de campos
    //--------------------------------------------------------------------------

    validar(form) {
        let esValido = true;
        form.querySelectorAll('input[required], select[required], textarea[required]').forEach(campo => {
            if (!this.validarCampo(campo)) {
                esValido = false;
            }
        });
        return esValido;
    }

    validarCampo(campo) {
        const spanError = campo.parentNode.querySelector(".form_input_mensaje");
        let err = "";

        if (!campo.value.trim()) {
            err = `${campo.name} es requerido.`;
        } else if (campo.type === "email") {
            const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (!emailRegex.test(campo.value)) {
                err = "Email inválido.";
            }
        }

        if (spanError) {
            spanError.innerText = err;
            spanError.classList.toggle("ocultado", !err);
        }

        return !err;
    }

    mostrarMensaje(contenedor, mensaje, tipo = 'form_error') {
        if (!contenedor) return;
        contenedor.innerText = mensaje;
        contenedor.className = "form_mensaje"; 
        contenedor.classList.add(tipo);
        contenedor.classList.add("aparecer");

        setTimeout(() =>{
            contenedor.classList.remove("aparecer");
        },10);

        setTimeout(() =>{
            contenedor.classList.add("desaparecer");
             setTimeout(() =>{
                contenedor.classList.remove("desaparecer");
                contenedor.classList.add("ocultado");
            },100);
        },2000);

    }

    async actualizarSeccionPrestamos(usuario_id, socio_id) {
        console.log(`Actualizando sección de préstamos para el usuario ${socio_id}...`);
        try {
            const seccion = this.formulario.querySelector('#seccion-prestamos-seccion');
            if (!seccion) {
                console.error("No está la sección crack");
                return;
            }

            
            const prestamosData = await this.obtenerPrestamos(socio_id);

            if (prestamosData && prestamosData.data) {
                const nuevoHtml = this.cargarPrestamos({"usuario_id": usuario_id, "socio_id": socio_id}, prestamosData.data.prestamos);
                seccion.innerHTML = nuevoHtml;
                console.log("Sección de préstamos actualizada.");
            } else {
                console.error("No se consiguieron los préstamos");
            }
            return seccion;
        } catch (error) {
            console.error("Hubo un error master:", error);
            return null;
        }
    }


    //--------------------------------------------------------------------------
    // Datos
    //--------------------------------------------------------------------------

    async obtenerUsuario(id) {
        const formData = new FormData();
        formData.append('accion', "usuario");
        formData.append('usuario_id', id);
        return Peticion.peticion(formData);
    }
    async obtenerPrestamos(socio_id) {
        const formData = new FormData();
        formData.append('accion', "prestamos");
        formData.append('socio_id', socio_id);
        return Peticion.peticion(formData);
    }
    async obtenerMultas(socio_id) {
        const formData = new FormData();
        formData.append('accion', "multas");
        formData.append('socio_id', socio_id);
        return Peticion.peticion(formData);
    }
    async obtenerEstadoCuenta(socio_id) {
        const formData = new FormData();
        formData.append('accion', "estado-cuenta");
        formData.append('socio_id', socio_id);
        return Peticion.peticion(formData);
    }
    async obtenerLibro(id) {
        const formData = new FormData();
        formData.append('accion', "libro");
        formData.append('libro_id', id);
        return Peticion.peticion(formData);
    }
    async obtenerEjemplares(id) {
        const formData = new FormData();
        formData.append('accion', "ejemplares");
        formData.append('libro_id', id);
        return Peticion.peticion(formData);
    }
    async obtenerEjemplaresDisponibles(id) {
        const formData = new FormData();
        formData.append('accion', "ejemplares-disponibles");
        formData.append('libro_id', id);
        return Peticion.peticion(formData);
    }    
    async obtenerOpciones(opcion){
        const formData = new FormData();
        formData.append('accion', "opciones");
        formData.append('nombre', opcion);
        return Peticion.peticion(formData);
    }

    //--------------------------------------------------------------------------
    // HTML Template Generators
    //--------------------------------------------------------------------------
    mostrarPaginaUsuario(usuario, prestamos = [], multas = [], estado_cuenta =[]) {

        const contenido = document.createElement("div");
        contenido.classList.add("form_contenido_dinamico");

        const pie = document.createElement("div");
        pie.classList.add("form_pie");

        const paginaHTML = this.cargarPaginaUsuario(usuario, prestamos, multas, estado_cuenta);
        
        if(typeof paginaHTML === "string"){
            contenido.innerHTML = paginaHTML;
        }else{
            contenido.appendChild(paginaHTML);
        }
        this.colaPaginas.push(contenido);

    }
    async mostrarPaginaAgregarUsuario(){

        const contenido = document.createElement("div");
        contenido.classList.add("form_contenido_dinamico");

        const paginaHTML = await this.cargarPaginaAgregarUsuario();
        
        if(typeof paginaHTML === "string"){
            contenido.innerHTML = paginaHTML;
        }else{
            contenido.appendChild(paginaHTML);
        }
        this.colaPaginas.push(contenido);

    }
    mostrarPaginaLibro(libro, disponibles, ejemplares){

        const contenido = document.createElement("div");
        contenido.classList.add("form_contenido_dinamico");

        const paginaHTML = this.cargarPaginaInfoLibro(libro, disponibles, ejemplares);
       
        if(typeof paginaHTML === "string"){
            contenido.innerHTML = paginaHTML;
        }else{
            contenido.appendChild(paginaHTML);
        }
        this.colaPaginas.push(contenido);

    }
    mostrarPaginaAgregarLibro(autores, editoriales, generos){
        const contenido = document.createElement("div");
        contenido.classList.add("form_contenido_dinamico");

        console.log(autores, editoriales, generos);

        const paginaHTML = this.cargarPaginaAgregarLibro(autores, editoriales, generos);
        
        if(typeof paginaHTML === "string"){
            contenido.innerHTML = paginaHTML;
        }else{
            contenido.appendChild(paginaHTML);
        }
        this.colaPaginas.push(contenido);
    }

    async cargarPaginaAgregarUsuario(){
         let cont =`
            <div class="form_titulo subrayado">Nuevo usuario</div>
            <form class="form_datos" id="form-registrar-usuario">
                <input name="accion" value="registrar-usuario" type="hidden" />
                <div class="form_seccion">
                    <span class="form_mensaje ocultado"></span>
                    ${this.cargarInputNormal('Correo:', 'mail', '', 'email', 'required')}
                    ${this.cargarInputNormal('Nombre:', 'nombre', '', 'text', 'required')}
                    ${this.cargarInputNormal('Apellido:', 'apellido', '', 'text', 'required')}
                
                </div>
                <span class="form_mensaje ocultado"></span>
                <button class="form_boton">Registrar</button>
            </form>`;
            return cont;
    }

    cargarPaginaUsuario(usuario, prestamos, multas, estado_cuenta) {

        let cont = this.cargarEstadoUsuario(usuario);

        if (usuario.socio_id) {
            cont += this.cargarPrestamos(usuario, prestamos);
            if (estado_cuenta) {
                cont += this.cargarEstadoCuenta(estado_cuenta);
            }
            if (multas && multas.length > 0) {
                cont += this.cargarMultas(multas);
            }
            if (usuario.socio_habilitado) {
                cont += this.cargarPrestarLibro(usuario);
            }
        } else {
            cont += this.cargarHacerSocio(usuario);
        }

        cont += this.cargarHacerProfesorBorrar(usuario);

        return cont
    }

    cargarPaginaAgregarLibro(autores, editoriales, generos){
        
        let todos_autores = autores.map(a => this.cargarOpcion(a));
        let todos_editoriales = editoriales.map(a => this.cargarOpcion(a));
        let todos_generos = generos.map(a => this.cargarOpcion(a));

        let cont = `
            <div class="form_titulo subrayado">Nuevo libro</div>
            
            
            <form class="form_datos" id="form-registrar-usuario">
            <form class="form_datos" id="form-registrar-libro">
                <input name="accion" value="registrar-usuario" type="hidden" />
                <div class="form_seccion">
                    <span class="form_mensaje ocultado"></span>
                    ${this.cargarInputNormal('Titulo:', 'titulo', '', 'text', 'required')}
                    ${this.cargarInputDesplegable('Autores:', 'autores', todos_autores, 'text', 'required')}
                    ${this.cargarInputDesplegable('Editorial:', 'editorial', todos_editoriales, 'text', 'required')}
                    ${this.cargarInputNormal('ISBN:', 'isbn', '', 'text', 'required')}
                    ${this.cargarInputNormal('Codigo Topográfico:', 'codigo_topografico', '', 'text', 'required')}
                    ${this.cargarInputNormal('Descripcion', 'descripcion', 'text', '', 'textrequired')}
                    ${this.cargarInputDesplegable('Generos:', 'generos', todos_generos, 'text', 'required')}
                    ${this.cargarInputNormal('Descripcion', 'descripcion', '', 'text', 'required')}
                    ${this.cargarInputMultiselect('Géneros:', 'generos', generos, )}
                    ${this.cargarInputImagen('Portada:', 'portada', '', 'required')}
                
                </div>
                <span class="form_mensaje ocultado"></span>
                <button class="form_boton">Agregar</button>
            </form>`;
            return cont;
    }

    cargarPaginaInfoLibro(libro, disponibles, ejemplares){

        let checked = libro.activado == 1 ? 'checked' : '';

        return `
            <div class="form_titulo subrayado">${libro.titulo}</div>

            <section class="form_seccion subrayado">
                
                <div class="form_seccion">
                    <div class="form_informacion">
                        
                        <div class="form_fila">
                            <span>Autor: ${libro.autores}</span>
                            <span class="form_subtitulo derecha">ID: 102${libro.id}</span>
                        </div>   
                        <div class="form_fila">
                            <span>Editorial: ${libro.editorial}</span>
                        </div>
                        <div class="form_fila">
                            <span>ISBN: ${libro.isbn}</span>
                        </div>
                        <div class="form_fila">
                            <span>Descripcion: ${libro.descripcion}</span>
                            
                        </div>
                        <div class="form_fila subtitulo">
                            <span>Cantidad de ejemplares: ${ejemplares.length}</span>
                        </div>
                        <div class="form_fila subtitulo">
                            <span>Disponilbles: ${disponibles.length}</span>
                            <form class="form_datos rellena" id="form-estado-libro">
                                <input name="accion" value="estado-libro" type="hidden"></input>
                                <input name="libro_id" value=${libro.id} type="hidden"></input>
                                <span class="form_mensaje ocultado" ></span>
                                <div class="form_fila derecha">
                                    <span >Libro Activo: </span>
                                    
                                    <input name="activo" type="checkbox" ${checked}></input>
                                    <span class="form_input_mensaje ocultado" ></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </section>

            ${this.cargarSeccionEjemplares(ejemplares, libro.titulo)}

        `;

    }

    cargarEstadoUsuario(usuario) {
        return `
            <div class="form_titulo subrayado">${usuario.nombre} ${usuario.apellido}</div>
            <section class="form_seccion subrayado">
                <div class="form_informacion">
                    <div class="form_fila"><span class="form_mensaje ocultado"></span></div>
                    <div class="form_fila"><span>Correo: ${usuario.mail}</span></div>
                    <div class="form_fila"><span>Tipo de Usuario: ${this.cargarTipoUsuario(usuario)}</span></div>
                    ${this.cargarEsSocio(usuario)}
                </div>
            </section>`;
    }

    cargarTipoUsuario(usuario) {
        const roles = { 1: "Admin", 2: "Profesor", 3: "General" };
        return roles[usuario.rol_id] || "Desconocido";
    }

    cargarEsSocio(usuario) {
        if (usuario.socio_id) {
            return `
                <div class="form_fila"><span>Socio: Si</span></div>
                <div class="form_fila"><span>Fecha alta: ${usuario.fecha_alta}</span></div>
                <div class="form_fila"><span>Telefono: ${usuario.telefono}</span></div>
                <div class="form_fila"><span>DNI: ${usuario.dni}</span></div>
                <div class="form_fila"><span>Fecha nacimiento: ${usuario.fecha_nacimiento}</span></div>`;
        }
        return `<div class="form_fila"><span>Socio: no</span></div>`;
    }

    cargarOpcion(opcion){
        let cont = `
        <option data-id=${opcion.id} value=${opcion.nombre}>${opcion.nombre}
        </option>
        
        `

        return cont;

    }

    cargarPrestamos(usuario, prestamos) {
        const activos = prestamos?.filter(p => p.activo == 1) || [];
        const devueltos = prestamos?.filter(p => p.activo != 1) || [];

        const prestamos_activos = activos.length > 0
            ? activos.map(p => this.cargarLibroPrestamo(p.id, p.titulo, p.autores, p.fecha_prestamo, p.fecha_vencimiento)).join('')
            : "<div class='form_informacion'>No tiene préstamos activos</div>";

        const prestamos_devueltos = devueltos.length > 0
            ? devueltos.map(p => this.cargarLibroDevuelto(p.id, p.titulo, p.autores, p.fecha_prestamo, p.fecha_devolucion)).join('')
            : "<div class='form_petit'>No tiene historial de devoluciones</div>";

        return `
        <div id="seccion-prestamos-seccion">
            <span class="form_subtitulo">Libros en préstamo</span>
            <form class="form_datos form_seccion subrayado" id="devolver-prestamos">
                <div class="form_fila"><span class="form_mensaje ocultado"></span></div>
                <input name="accion" value="devolver-prestamo" type="hidden" />
                <input name="usuario_id" value="${usuario.usuario_id}" type="hidden" />
                <input name="socio_id" value="${usuario.socio_id}" type="hidden" />
                <div class="form_checks form_seccion" id="form-prestamos">
                    ${prestamos_activos}
                    <div class="form_checks_cont form_fila rellena ocultado">
                        <button type="submit" class="form_boton derecha">Devolver</button>
                    </div>
                </div>
                <div class="form_desplegable form_seccion">
                    <div class="form_fila rellena">
                        <span class="form_subtitulo se_oculta ocultado">Libros devueltos:</span>
                        <div class="form_boton despliega derecha">Libros devueltos</div>
                    </div>
                    <div class="form_seccion se_despliega plegado">${prestamos_devueltos}</div>
                </div>
            </form>
        </div>`;
    }

    cargarLibroPrestamo(id, titulo, autor, fecha1, fecha2) {
        return `
            <div class="form_bloque">
                <div class="form_fila rellena">
                    <div class="form_seccion">
                        <div class="form_informacion">
                            <span>${titulo}</span>
                            <span class="form_petit">${autor}</span>
                        </div>
                    </div>
                    <div class="form_seccion">
                        <input class="form_checkbox derecha" name="prestamo_id" value=${id} type="checkbox">
                        <span class="form_input_mensaje form_error ocultado">error</span>
                        <span class="form_petit derecha">Prestado: ${fecha1}</span>
                        <span class="form_petit derecha">Hasta: ${fecha2}</span>
                    </div>
                </div>
            </div>`;
    }

    cargarLibroDevuelto(id, titulo, autor, fecha1, fecha2) {
        return `
            <div class="form_bloque">
                <div class="form_fila rellena">
                    <div class="form_seccion">
                        <div class="form_informacion">
                            <span>${titulo}</span>
                            <span class="form_petit">${autor}</span>
                        </div>
                    </div>
                    <div class="form_seccion">
                        <span class="form_petit derecha">Prestado: ${fecha1}</span>
                        <span class="form_petit derecha">Devuelto: ${fecha2}</span>
                    </div>
                </div>
            </div>`;
    }

    cargarMultas(multas) {
        const total_multas = multas.reduce((acc, multa) => acc + parseFloat(multa.total_multa || 0), 0);
        const multas_todas = multas.map(multa => this.cargarMulta(multa.titulo, multa.total_multa)).join('');

        return `
            <span class="form_subtitulo">Multas</span>
            <section class="form_seccion subrayado">
                <div class="form_fila rellena"><span>Multa por libro:</span></div>
                ${multas_todas}
                <div class="form_fila">
                    Total de multas: <span class="form_error">${total_multas.toFixed(2)}</span>
                    <div class="form_boton derecha">Cancelar multa</div>
                </div>
            </section>`;
    }

    cargarMulta(titulo, monto) {
        return `
            <div class="form_fila form_desplegable expande">
                <div class="form_bloque se_oculta">
                    <div class="form_fila">
                        <span>${titulo}:</span>
                        <span class="form_error">${monto}</span>
                    </div>
                </div>
                <div class="form_boton despliega derecha">Eliminar</div>
            </div>`;
    }

    cargarEstadoCuenta(estado_cuenta) {
        return `
            <section class="form_seccion subrayado">
                <div class="form_subtitulo">Estado de Cuota</div>
                <div class="form_informacion">
                    <div class="form_fila">Cuota: <span class="form_exito">AL DÍA</span></div>
                    <div class="form_fila">Ultimo pago registrado: ${estado_cuenta.ultimo_pago}</div>
                </div>
            </section>`;
    }

    cargarHacerSocio(usuario) {
        return `
            <div class="form_desplegable">
                <button class="form_boton despliega">Hacer Socio</button>
                <div class="form_desplegable_cont se_despliega plegado">
                    <form class="form_datos" id="form-agregar-socio">
                        <input name="accion" value="agregar-socio" type="hidden" />
                        <input name="usuario_id" value=${usuario.usuario_id} type="hidden" />
                        <span class="form_mensaje ocultado"></span>
                        ${this.cargarInputNormal('Teléfono:', 'telefono', '', 'number', 'required')}
                        ${this.cargarInputNormal('DNI:', 'dni', '', 'text', 'required')}
                        ${this.cargarInputNormal('Fecha de Nacimiento:', 'fecha_nacimiento', '', 'date', 'required')}
                        <button type="submit" class="form_boton verde">Confirmar</button>
                    </form>
                </div>
            </div>`;
    }

    cargarPrestarLibro(usuario) {
        return `
            <section class="form_seccion">
                <form class="form_datos form_desplegable form_seccion subrayado" id="form-prestar-libro">
                    <div class="form_fila rellena">
                        <div class="form_boton despliega derecha">Prestar un libro</div>
                    </div>
                    <div class="form_seccion se_despliega plegado">
                        <span class="form_mensaje ocultado"></span>
                        <input name="accion" value="prestar-libro" type="hidden" />
                        <input name="usuario_id" value=${usuario.id} type="hidden" />
                        ${this.cargarInputNormal('Identificador del ejemplar:', 'ejemplar_id', '', 'number', 'required')}
                        <div class="form_informacion" data-libro-info></div>
                        ${this.cargarInputNormal('Fecha Límite:', 'fecha_limite', '', 'date', 'required')}
                        <div class="form_fila">
                            <button type="submit" class="form_boton derecha verde">Realizar prestamo</button>
                        </div>
                    </div>
                </form>
            </section>`;
    }

    cargarInputNormal(titulo, nombre, clase, tipo, extras) {
        return `
            <label>${titulo}</label>
            <div class="form_fila">
                <input name="${nombre}" class="form_input ${clase}" type="${tipo}" ${extras} />
                <span class="form_input_mensaje form_error ocultado"></span>
            </div>`;
    }
    cargarInputDesplegable(titulo, nombre, opciones, submenu = ""){
        return `
            <div class="form_desplegable form_seccion">
                <label>${titulo}</label>
                <div class="form_fila">
                    
                    <select name=${nombre} class="form_input">
                        ${opciones} 
                    </select>

                    <div class="form_boton despliega">+
                    </div>

                </div>

                <div class="form_informacion se_despliega plegado">
                    ${submenu}
                </div>

            </div>
        `;
    };

    cargarInputImagen(titulo, nombre, clase ="",  extras){
        return `
            <label>${titulo}</label>
            <div class="form_fila">
                <input name="${nombre}" class="form_input ${clase}" type="file" ${extras}
                accept="image/*" />
                <span class="form_input_mensaje form_error ocultado"></span>
            </div>
                 `;
    };

    cargarInputMultiselect(titulo, nombre, opciones) {
        const opcionesHTML = opciones.map(op => `
            <div class="form_fila form_multiselect_opcion" data-id="${op.id}" data-nombre="${op.nombre}">
                ${op.nombre}
                <span class="check">✔</span>
            </div>
        `).join('');

        return `
            <div class="form_seccion form_multiselect_contenedor" data-nombre-campo="${nombre}">
                <label>${titulo}</label>
                <div class="form_seccion form_multiselect_input_wrapper">
                    <div class="form_fila form_multiselect_pills">
                    </div>
                    <div class="form_fila">
                        <input type="text" class="form_input form_multiselect_filtro despliega" placeholder="Buscar o seleccionar...">
                    </div>
                </div>
                <div class="form_seccion form_multiselect_opciones ocultado">${opcionesHTML}</div>
                <input type="hidden" name="${nombre}_ids" id="hidden-input-${nombre}">
            </div>`;
    }

    cargarHacerProfesorBorrar(usuario){
        const boton = usuario.rol_id == 3 ? `
        <input name="accion" value="agregar-profesor" type="hidden" />
        <button class="form_boton">Hacer profesor</button>` :`
        <input name="accion" value="quitar-profesor" type="hidden" />
        <button class="form_boton">Quitar privilegios</button>`;

        return `
            <section class="form_pie">
                <div class="form_fila rellena">
                    <form class="form_datos form_seccion" id="form-estado-profesor">
                        <input name="usuario_id" value=${usuario.usuario_id} type="hidden" />
                        ${boton}
                        <span class="form_mensaje ocultado"></span>
                    </form>
                    <form class="form_datos form_seccion" id="form-borrar-usuario">
                        <input name="accion" value="borrar-usuario" type="hidden" />
                        <input name="usuario_id" value=${usuario.usuario_id} type="hidden" />
                        <button class="form_boton">Borrar Usuario</button>
                        <span class="form_mensaje ocultado derecha "></span>
                    </form>
                </div>
            </section>`;
    }
    cargarSeccionEjemplares(ejemplares, titulo){

        let todos_ejemplares = ejemplares.map(e => this.cargarEjemplar(e, titulo)).join('');

        return `
        <div class="form_subtitulo">Ejemplares</div>
        <section class="form_seccion subrayado">
            <div class="form_fila rellena">
                <button class="form_boton"> Agregar ejemplar</button>
                <button class="form_checks_cont ocultado form_boton"> Eliminar </button>
            </div>
            ${todos_ejemplares}
        </section>
        `;
    }
    cargarEjemplar(ejemplar, titulo){
        let disponible = ejemplar.activo == 1 ?
            '<span class="form_petit rojo">No Disponible</span>' :
            '<span class="form_petit verde">Disponible</span>';

        return `
          <section class="form_datos form_desplegable">
                <input name="accion" value="editar-ejemplar" type="hidden">
                <input name="ejemplar_id" value=${ejemplar.ejemplar_id} type="hidden">
                <span class="form_mensaje ocultado"></span>
                
                <div class="form_bloque">
                    
                    <div class="form_fila rellena form_subtitulo">
                        <span>${titulo}</span>   
                    </div>

                    <div class="form_fila rellena">

                        <div class="form_seccion se_despliega">
                            <div class="form_fila">
                                <span class="form_petit">Codigo ejemplar: 100${ejemplar.libro_id} </span>
                            </div>
                            <div class="form_fila ">
                                <span class="form_petit">Disponibilidad:</span>
                                ${disponible}
                            </div>
                            
                        </div>
                        
                        <div class="form_fila base inv rellena">
    
                        <div class="form_boton base derecha despliega">✎</div> 

                            <div class="form_seccion se_despliega plegado">
                                
                                <div class="form_fila ">
                                    <input name="codigo_ejemplar" class="form_input" type="text" value=${ejemplar.ejemplar_id} required></input>
                                    <span class="form_input_mensaje"></span>
                                </div>

                                <div class="form_fila ">
                                    <span class="form_petit">Disponibilidad:</span>
                                    <span class="form_petit verde">${disponible}</span>
                                </div>
                                
                                <div class="form_fila ">
                                    <input name="codigo_topografico" class="form_input" type="text" value=${ejemplar.codigo_topografico} required></input>
                                    <span class="form_input_mensaje"></span>
                                </div>    

                            </div>

                        </div>
                    </div>
                    
                        <!--GUARDAR CAMBIOS -->

                    <div class="form_fila se_oculta ocultado rellena">
                        <span class="form_input_mensaje ocultado">
                        </span>
                        <button type="submit" class="form_boton">
                            Guardar
                        </button>
                    </div>

                </div>
                        
        </section>
        `;

    }
        
}