
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
    static API_URL = "http://localhost/Kobun/public/peticion";

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
        if(formulario){
            this.contenido = this.formulario.querySelector(".form_contenido");
            this.cant_cambios = this.formulario.querySelector("#cant-cambios");
            
            Peticion.empezar();
            this.colaPaginas.push(this.contenido.cloneNode(true));
            this.eventos();
        }
    }

    eventos() {
        this.formulario.addEventListener("click", this.gestionarClicks.bind(this));
        this.formulario.addEventListener("submit", this.gestionarEnvios.bind(this));
        this.formulario.addEventListener("input", this.gestionarCambios.bind(this));
    }

    gestionarClicks(event) {
        const target = event.target;
        if (target.matches("#btn-despliege")) {
            this.ocultar();
        } else if (target.matches("#btn-retroceso")) {
            this.retroceder();
        } else if (target.matches("#btn-guardar")) {
            this.guardarCambios();
        } else if (target.matches("#btn-cerrar")) {
            this.borrarCambios();
        } else if (target.matches(".form_boton.despliega")) {
            this.toggleDesplegable(target);
        } else if (target.matches(".form_checkbox")) {
            this.handleCheckboxClick(target);
        } else if (target.matches(".form_a")) {
            event.preventDefault();
            
            const pagina = target.getAttribute("ref");
            console.log(pagina)  
            this.gestionarPaginasInternas(pagina);
        }else if (target.closest('.form_multiselect_contenedor')) {
            this.gestionarMultiselectClick(event);
        }

        if (!target.closest('.form_multiselect_contenedor')) {
            this.cerrarTodosLosMultiselect();
        }
    }

    gestionarPaginasInternas(ultimo) {
        switch(ultimo){
            case "agregar-autor":
                this.agregarAutor();
                break;
            case "agregar-genero":
                this.agregarGenero();
                break;
            case "agregar-editorial":
                this.agregarEditorial();
                break;
            case "agregar-usuario":
                this.agregarUsuario();
                break;
            case "agregar-libro":
                this.agregarLibro();
                break;


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
        
        if (target.matches('.form_multiselect_filtro')) {
            const contenedor = target.closest('.form_multiselect_contenedor');
            const filtro = target.value.toLowerCase();
            const opciones = contenedor.querySelectorAll('.form_multiselect_opcion');
            opciones.forEach(opcion => {
                const nombre = opcion.dataset.nombre.toLowerCase();
                opcion.style.display = nombre.includes(filtro) ? '' : 'none';
            });
        } else if (target.matches('.form_input_select')) {
            // Encontrar la opción seleccionada
            const selectedOption = target.options[target.selectedIndex];
            if (selectedOption) {
                // Obtener el data-id de la opción
                const selectedId = selectedOption.dataset.id;

                // Encontrar el input oculto correspondiente para guardar el ID
                const contenedor = target.closest('.form_desplegable');
                const hiddenInput = contenedor.querySelector('input[type="hidden"]');

                if (hiddenInput) {
                    // Asignar el ID al valor del input oculto
                    hiddenInput.value = selectedId;
                    
                }
            }
        }else if (target.matches('.form_input[name="q"]')) {
            const contenedor = target.closest('.form_datos');
            contenedor.requestSubmit();
            console.log("busqueda ejemplar");
        } else if (target.matches('input[type="file"][name="portada"]')) {
            const file = target.files[0];
            if (file) {
                const contenedor = target.closest('.form_portada_libro');
                const libroId = contenedor.querySelector('input[name="libro_id"]').value;

                const formData = new FormData();
                formData.append('accion', 'cambiar-portada-libro');
                formData.append('libro_id', libroId);
                formData.append('portada', file);

                Peticion.peticion(formData)
                    .then(data => {
                        if (data.estado === 'exito') {
                            this.editarLibro(libroId); // Recargar la info del libro
                        } else {
                            console.error('Error al subir la imagen:', data.mensaje);
                        }
                    })
                    .catch(error => {
                        console.error('Error en la petición fetch:', error);
                    });
            }
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
                const multasData = await this.obtenerMultas(socio_id);
                const estadoCuentaData = await this.obtenerEstadoCuenta(socio_id);
                const disponiblesData = await this.obtenerEjemplaresDisponibles(id);

                

                this.mostrarPaginaUsuario(usuarioData.data.usuario, prestamosData.data.prestamos,
                                         multasData.data.multas, estadoCuentaData.data.estado_cuenta,
                                         disponiblesData.data.disponibles);

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

    agregarPago() {

        this.mostrarPaginaAgregarPago();
        this.mostrarPagina();
 
    }

    async editarLibro(id){
        try {
            
            const libroData = await this.obtenerLibro(id);
            var libro_id  = libroData.data.libro.id;
            
            const cantidadData = await this.obtenerEjemplaresDisponibles(libro_id);
            const ejemplaresData = await this.obtenerEjemplares(libro_id);
            console.log("la re uta", libroData.data.libro.activado)
            this.mostrarPaginaLibro(libroData.data.libro,
                                    cantidadData.data.disponibles,
                                    ejemplaresData.data.ejemplares);

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
    async agregarAutor(){

        const autoresData = await this.obtenerOpciones("autores");

        this.mostrarPaginaAgregarAutor(autoresData.data);
        this.mostrarPagina();

    }
    async agregarEditorial(){

        const editorialesData = await this.obtenerOpciones("generos");

        this.mostrarPaginaAgregarEditorial(editorialesData.data);
        this.mostrarPagina();

    }
    async agregarGenero(){

        const generosData = await this.obtenerOpciones("editoriales");

        this.mostrarPaginaAgregarGenero(generosData.data);
        this.mostrarPagina();

    }
    async agregarTaller(){

        this.mostrarPaginaAgregarTaller();
        this.mostrarPagina();
    }
    async editarTaller(id){
        try {
            
            const tallerData = await this.obtenerTaller(id);
            const profesoresDisponiblesData = await this.obtenerOtrosProfesores(id);
            
            this.mostrarPaginaTaller(tallerData.data.taller, tallerData.data.profesores, profesoresDisponiblesData.data.profesores);

            this.mostrarPagina();
        } catch (error) {
            console.error("No se pudo cargar el taller:", error);
            this.mostrarMensaje(this.contenido, "Error al cargar los datos del taller.", "form_error");
            return null;
        }
    }

    async editarPago(id){
        try {
            
            const pagoData = await this.obtenerPago(id);

            this.mostrarPaginaEditarPago(pagoData.data.pago);

            this.mostrarPagina();

        } catch (error) {
            console.error("No se pudo cargar el pago:", error);
            this.mostrarMensaje(this.contenido, "Error al cargar el pago", "form_error");
            return null;
        }
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
        const pagina = this.colaPaginas.pop();
        this.formulario.classList.remove("form_oculto");
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

    //CAMBIOS / OBTENCION DE FORMULARIOS

    async cargarCambio() {
        if (this.colaCambios.length === 0) {
            console.log("No hay cambios para cargar.");
            return;
        }
        let cantidad = this.colaCambios.length;
        //this.cant_cambios.innerText = "Cantidad de cambios: " + cantidad;

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
                    case 'registrar-libro':

                            await this.editarLibro(respuesta.data.libro_id);
                            var mensaje = nueva_seccion.querySelector(".form_mensaje");
                            this.mostrarMensaje(mensaje, "Libro agregado", "form_exito");
                        
                        break;
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
                            this.mostrarMensaje(mensaje, "Cambio de estado realizado", "form_exito");   

                        }
                    
                    break;
                    case 'registrar-usuario':
                        await this.editarUsuario(respuesta.data.usuario_id);
                        mensaje = this.formulario.querySelector(".form_mensaje");
                        this.mostrarMensaje(mensaje, "Registro exitoso", "form_exito");   
                        break;
                        
                    case 'agregar-ejemplar':
                        var titulo = cambio.formData.get('libro_titulo');
                        const nueva_seccion = await this.actualizarSeccionEjemplares(respuesta.data.libro_id, titulo);
                        var mensaje = nueva_seccion.querySelector(".form_mensaje");
                        this.mostrarMensaje(mensaje, "Ejemplar agregado", "form_exito");   
                        break;
                    case 'buscar-ejemplares':
                        
                        await this.actualizarEjemplaresDisponibles(usuario_id, respuesta.data.ejemplares);
                        //this.mostrarMensaje(cambio.mensaje, "Ejemplar obtenido", "form_exito");  

                        break;
                    case 'buscar-socio':
                        
                        await this.actualizarSociosDisponibles(respuesta.data.socios);
                        //this.mostrarMensaje(cambio.mensaje, "Ejemplar obtenido", "form_exito");  

                        break;
                    case 'prestar-libro':
                            nueva_seccion = await this.editarUsuario(usuario_id);
                            this.mostrarMensaje(cambio.mensaje, "Prestamo devuelto", "form_exito");
                        break;
                    case 'eliminar-profesor':
                    case 'asignar-profesor':
                        await this.editarTaller(cambio.formData.get('taller_id'));
                        mensaje = this.formulario.querySelector(".form_mensaje");
                        this.mostrarMensaje(mensaje, respuesta.mensaje, "form_exito");
                        break
                    case 'estado-libro':
                        await this.editarLibro(cambio.formData.get('libro_id')); 
                        mensaje = this.formulario.querySelector(".form_mensaje");
                        this.mostrarMensaje(mensaje, respuesta.mensaje, "form_exito");
                        break
                    case 'agregar-taller':
                        console.log("taller");
                        await this.editarTaller(respuesta.data.taller_id);
                        mensaje = this.formulario.querySelector(".form_mensaje");
                        this.mostrarMensaje(mensaje, respuesta.mensaje, "form_exito");
                        break;

                    default:
                        this.mostrarMensaje(cambio.mensaje, respuesta.mensaje, "form_exito");   
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

    ocultar(){
        console.log("ocultando formulario")
        formulario.classList.toggle("form_oculto");
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
                console.log("Sección de prestamos actualizada.");
            } else {
                console.error("No se consiguieron los préstamos");
            }
            return seccion;
        } catch (error) {
            console.error("Hubo un error master:", error);
            return null;
        }
    }
    async actualizarSeccionEjemplares(libro_id, titulo){
        console.log(`Actualizando sección de ejempalres...`);
        try {
            const seccion = this.formulario.querySelector('#seccion-ejemplares');
            if (!seccion) {
                console.error("No está la sección crack");
                return;
            }

            const ejemplaresData = await this.obtenerEjemplares(libro_id);

            if (ejemplaresData && ejemplaresData.data) {
                const nuevoHtml = this.cargarSeccionEjemplares(libro_id, ejemplaresData.data.ejemplares, titulo);
                seccion.innerHTML = nuevoHtml;
                console.log("Sección de ejemplares actualizada.");
            } else {
                console.error("No se consiguieron los ejemplares");
            }
            return seccion;
        } catch (error) {
            console.error("Hubo un error master:", error);
            return null;
        }

    }
    async actualizarEjemplaresDisponibles(usuario_id, disponibles){
        console.log(`Actualizando sección de ejemplares...`);
        try {
            const seccion = this.formulario.querySelector('#seccion-ejemplares-disponibles');
            if (!seccion) {
                console.error("No está la sección crack");
                return;
            }

            const nuevoHtml = this.cargarEjemplaresDisponibles(usuario_id, disponibles);
            seccion.innerHTML = nuevoHtml;
                
            return seccion;
        } catch (error) {
            console.error("Hubo un error master:", error);
            return null;
        }

    }
    async actualizarSociosDisponibles(socios){
        console.log(`Actualizando sección de socios...`);
        try {
            const seccion = this.formulario.querySelector('#seccion-socios');
            if (!seccion) {
                console.error("No está la sección crack");
                return;
            }

            const nuevoHtml = this.cargarSociosDisponibles(socios);
            seccion.innerHTML = nuevoHtml;
                
            return seccion;
        } catch (error) {
            console.error("Hubo un error master:", error);
            return null;
        }
    }
    async actualizarSeccionProfesores(taller, profesores, profesores_disponibles){
        console.log(`Actualizando sección de profesores...`);
        try {
            const seccion = this.formulario.querySelector('#seccion-profesores');
            if (!seccion) {
                console.error("No está la sección crack");
                return;
            }

            const nuevoHtml = this.cargarProfesores(taller, profesores, profesores_disponibles);
            seccion.innerHTML = nuevoHtml;
                
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
    async obtenerTaller(id) {
        const formData = new FormData();
        formData.append('accion', "taller");
        formData.append('taller_id', id);
        return Peticion.peticion(formData);
    }
    async obtenerOtrosProfesores(taller_id){
        const formData = new FormData();
        formData.append('accion', "otros-profesores");
        formData.append('taller_id', taller_id);
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
    async obtenerTodosEjemplaresDisponibles(id) {
        const formData = new FormData();
        formData.append('accion', "ejemplares-disponibles");
        formData.append('libro_id', id);
        return Peticion.peticion(formData);
    } 

    //--------------------------------------------------------------------------
    // HTML Template Generators
    //--------------------------------------------------------------------------
    mostrarPaginaUsuario(usuario, prestamos = [], multas = [], estado_cuenta = [], disponibles = []) {

        const contenido = document.createElement("div");
        contenido.classList.add("form_contenido_dinamico");

        const pie = document.createElement("div");
        pie.classList.add("form_pie");

        const paginaHTML = this.cargarPaginaUsuario(usuario, prestamos, multas, estado_cuenta, disponibles);
        
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
    async mostrarPaginaAgregarPago(){

        const contenido = document.createElement("div");
        contenido.classList.add("form_contenido_dinamico");

        const paginaHTML = await this.cargarPaginaAgregarPago();
        
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

    mostrarPaginaAgregarAutor(autores){
        const contenido = document.createElement("div");
        contenido.classList.add("form_contenido_dinamico");

        const paginaHTML = this.cargarPaginaAgregarAutor(autores);
        
        if(typeof paginaHTML === "string"){
            contenido.innerHTML = paginaHTML;
        }else{
            contenido.appendChild(paginaHTML);
        }
        this.colaPaginas.push(contenido);
    }
    mostrarPaginaTaller(taller, profesores, profesores_disponibles){
        const contenido = document.createElement("div");
        contenido.classList.add("form_contenido_dinamico");

        /*const pie = document.createElement("div");
        pie.classList.add("form_pie");*/

        const paginaHTML = this.cargarPaginaTaller(taller, profesores, profesores_disponibles);
        
        if(typeof paginaHTML === "string"){
            contenido.innerHTML = paginaHTML;
        }else{
            contenido.appendChild(paginaHTML);
        }
        this.colaPaginas.push(contenido);
    }
    mostrarPaginaAgregarTaller(taller){
        const contenido = document.createElement("div");
        contenido.classList.add("form_contenido_dinamico");

        const paginaHTML = this.cargarPaginaAgregarTaller();
        
        if(typeof paginaHTML === "string"){
            contenido.innerHTML = paginaHTML;
        }else{
            contenido.appendChild(paginaHTML);
        }
        this.colaPaginas.push(contenido);
    }
    
    cargarPaginaAgregarTaller(){

         let cont =`
            <div class="form_titulo subrayado">Nuevo Taller</div>
            <div class="form_separacion"></div>
            <form class="form_datos" id="form-agregar-taller">
                <input name="accion" value="agregar-taller" type="hidden" />
                <div class="form_seccion">
                    ${this.cargarInputNormal('Nombre:', 'nombre', '', 'text', 'required')}
                    ${this.cargarInputNormal('Descripcion:', 'descripcion', '', 'text', 'required')}
                    ${this.cargarInputNormal('Horario:', 'horario', '', 'time', 'required')}
                    ${this.cargarInputNormal('Lugar:', 'lugar', '', 'text', 'required')}
                    <div class="form_division"></div>
                    ${this.cargarInputImagen('Portada:', 'portada', '', 'required')}
                </div>
                <span class="form_mensaje ocultado"></span>
                <div class="form_separacion"></div>
                <div class="form_fila rellena">
                <button type="submit" class="form_boton derecha bt_verde">Agregar</button>
                </div
            </form>`;
            return cont;

    }

    cargarPaginaTaller(taller, profesores, profesores_disponibles){
        return `
            <div class="form_titulo subrayado">${taller.nombre}</div>

            <section class="form_seccion subrayado">
                
                <div class="form_seccion">
                    <div class="form_informacion">
                        
                        <span class="destacado">Descripción:</span>
                        <div class="form_fila">
                            <p> ${taller.descripcion}</p>
                        </div>   

                        <div class="form_division"></div>
                        <div class="form_fila">
                            <span class="destacado">Horario:</span><span>${taller.horario}</span>
                        </div>

                        <div class="form_fila">
                            <span class="destacado">Lugar:</span><span>${taller.lugar}</span>
                        </div>

                        <div class="form_fila">
                            <span class="destacado">Fecha Alta:</span><span>${taller.fecha_alta}</span>
                            
                        </div>
                        <span class="form_mensaje ocultado"></span>
                        <div class="form_division"></div>
                        <section id="seccion-profesores">
                        ${this.cargarProfesores(taller, profesores, profesores_disponibles)}
                        </section>
                    </div>
                </div>
                
            </section>
        `;

    }
    
    cargarProfesores(taller, profesores, profesores_disponibles){
        
        let profs = profesores.length > 0 ? 
        profesores.map(p => this.cargarProfesor(p, taller.taller_id)).join(" ") :
        `<span class="form_error"> No hay profesores asignados.</span>`;
        
        
        return `
           <label class="form_subtitulo">Profesor/res</label>
           <div class="form_seccion">
                ${profs}
           </div>
            <form class="form_datos" id="form-asignar-profesor">
                <input name="accion" value="asignar-profesor" type="hidden" />
                <input name="taller_id" value=${taller.taller_id} type="hidden" />
                <span class="form_mensaje ocultado"></span>
                <div class="form_seccion">
                    <span class="form_mensaje ocultado"></span>
                    <div class="form_separacion"></div>
                    ${this.cargarInputMultiselect('Agregar profesor: ', 'profesor', profesores_disponibles, 'required'
                    )}
                
                </div>
                <div class="form_separacion"></div>
                <div class="form_fila rellena">
                <button type="submit" class="form_boton derecha bt_verde">Agregar</button>
                </div
            </form>

        `;

    }
    cargarProfesor(profesor, taller_id){

        return `
            
            <form class="form_datos form_bloque rellena" id="form-eliminar-profesor">
                <input name="accion" value="eliminar-profesor" type="hidden" />
                <input name="taller_id" value=${taller_id} type="hidden" />
                <input name="usuario_id" value=${profesor.usuario_id} type="hidden" />

                 <div class="form_fila rellena">
                    <div class="form_seccion form_informacion">
                        <span>${profesor.nombre}</span>
                        <span>${profesor.mail}</span>
                    </div>
                    <button type="submit" class="form_boton eliminar derecha bt_rojo">x</button>
                </div>

                <div class="form_fila">
                    <span class="form_mensaje ocultado"></span>
                </div>
                
            </form>
        `;
    }

    cargarPaginaAgregarAutor(autores){

        let cont =`
            <div class="form_titulo subrayado">Agregar autor</div>
            <div class="form_separacion"></div>
            <form class="form_datos" id="form-agregar-autor">
                <input name="accion" value="agregar-autor" type="hidden" />
                <div class="form_seccion">
                    ${this.cargarInputNormal('Nombre:', 'nombre', '', 'text', 'required')}
                    ${this.cargarInputNormal('Apellido:', 'apellido', '', 'text', 'required')}
                    ${this.cargarInputNormal('Fecha nacimiento:', 'fecha_nacimiento', '', 'date', 'required')}
                    ${this.cargarInputNormal('Fecha muerte:', 'fecha_muerte', '', 'date')}
                </div>
                <span class="form_mensaje ocultado"></span>
                <div class="form_separacion"></div>
                <button type="submit" class="form_boton derecha bt_verde">Agregar</button>
            </form>`;
            return cont;

    }

    mostrarPaginaAgregarEditorial(editoriales){
        const contenido = document.createElement("div");
        contenido.classList.add("form_contenido_dinamico");

        const paginaHTML = this.cargarPaginaAgregarEditorial(editoriales);
        
        if(typeof paginaHTML === "string"){
            contenido.innerHTML = paginaHTML;
        }else{
            contenido.appendChild(paginaHTML);
        }
        this.colaPaginas.push(contenido);
    }

    cargarPaginaAgregarEditorial(editoriales){

        let cont =`
            <div class="form_titulo subrayado">Agregar editorial</div>
            <div class="form_separacion"></div>
            <form class="form_datos" id="form-agregar-editorial">
                <input name="accion" value="agregar-editorial" type="hidden" />
                <div class="form_seccion">
                    ${this.cargarInputNormal('Nombre:', 'nombre', '', 'text', 'required')}
                </div>
                <span class="form_mensaje ocultado"></span>
                <div class="form_separacion"></div>
                <button type="submit" class="form_boton derecha bt_verde">Agregar</button>
            </form>`;
            return cont;

    }

    mostrarPaginaAgregarGenero(generos){
        const contenido = document.createElement("div");
        contenido.classList.add("form_contenido_dinamico");

        const paginaHTML = this.cargarPaginaAgregarGenero(generos);
        
        if(typeof paginaHTML === "string"){
            contenido.innerHTML = paginaHTML;
        }else{
            contenido.appendChild(paginaHTML);
        }
        this.colaPaginas.push(contenido);
    }

    cargarPaginaAgregarGenero(generos){

        let cont =`
            <div class="form_titulo subrayado">Agregar genero</div>
            <div class="form_separacion"></div>
            <form class="form_datos" id="form-agregar-genero">
                <input name="accion" value="agregar-genero" type="hidden" />
                <div class="form_seccion">
                    ${this.cargarInputNormal('Nombre:', 'nombre', '', 'text', 'required')}
                </div>
                <span class="form_mensaje ocultado"></span>
                <div class="form_separacion"></div>
                <button type="submit" class="form_boton derecha bt_verde">Agregar</button>
            </form>`;
            return cont;

    }

    async cargarPaginaAgregarUsuario(){
         let cont =`
            <div class="form_titulo subrayado">Nuevo Usuario</div>
            <form class="form_datos" id="form-registrar-usuario">
                <input name="accion" value="registrar-usuario" type="hidden" />
                <div class="form_seccion">
                    <span class="form_mensaje ocultado"></span>
                    ${this.cargarInputNormal('Correo:', 'mail', '', 'email', 'required')}
                    ${this.cargarInputNormal('Nombre:', 'nombre', '', 'text', 'required')}
                    ${this.cargarInputNormal('Apellido:', 'apellido', '', 'text', 'required')}
                
                </div>
                <span class="form_mensaje ocultado"></span>
                <button class="form_boton derecha bt_verde">Registrar</button>
            </form>`;
            return cont;
    }


    async cargarPaginaAgregarPago(socios){
        
        socios = socios? socios : [];

         let cont =`
            <div class="form_titulo subrayado">Registrar Pago</div>

            
            <section class="form_seccion subrayado">
            <label>Buscar socio:</label
            <div class="form_fila"> 
                <form class="form_fila form_datos rellena" id="form_buscador-socio">
                    <input name="accion" value="buscar-socio" type="hidden" />
                    <input class="form_input" name="q"></input>
                    <span class="form_mensaje ocultado"></span>
                </form>
            </div>  

            <form class="form_datos" id="form-registrar-pago" id="form-registrar-pago">
                <input name="accion" value="registrar-pago" type="hidden" />
                <div class="form_seccion">
                    <span class="form_mensaje ocultado"></span>
                    ${this.cargarSociosDisponibles(socios)}

                    ${this.cargarInputNormal('Monto:', 'monto', '', 'number', 'min="0.00" placeholder="$$$" max="10000.00" step="1" required')}
                    ${this.cargarInputDesplegable('Razon:', 'razon',
                                                  this.cargarOpcion({id: "multa", nombre: "Multa"}) +
                                                  this.cargarOpcion({id: "cuota", nombre: "Cuota"}) +
                                                  this.cargarOpcion({id: "otro", nombre: "Otro"})  )}
                    ${this.cargarInputDesplegable('Medio:', 'medio',
                                                  this.cargarOpcion({id: "transferencia", nombre: "Transferencia"}) +
                                                  this.cargarOpcion({id: "efectivo", nombre: "Efectivo"}) , 'required')},
                   

                </div>
                <span class="form_mensaje ocultado"></span>
                <button class="form_boton bt_verde derecha">Registrar</button>
            </form>
            </section>`;
            
            return cont;
    }

    cargarPaginaUsuario(usuario, prestamos, multas, estado_cuenta, disponibles) {

        let cont = this.cargarEstadoUsuario(usuario);

        if (usuario.socio_id) {
            cont += this.cargarPrestamos(usuario, prestamos);
            if (estado_cuenta) {
                cont += this.cargarEstadoCuenta(estado_cuenta);
            }
            if (multas && multas.length > 0) {
                cont += this.cargarMultas(multas);
            }
            //if (usuario.socio_habilitado) {
                cont += this.cargarPrestarLibro(usuario, disponibles);
            //}
        } else {
            cont += this.cargarHacerSocio(usuario);
        }

        cont += this.cargarHacerProfesorBorrar(usuario);

        return cont
    }

    cargarPaginaAgregarLibro(autores, editoriales, generos){
        
        
        let todos_editoriales = editoriales.map(a => this.cargarOpcion(a));
        
        //${this.cargarInputNormal('Codigo Topográfico:', 'codigo_topografico', '', 'text', 'required')}

        let cont = `
            <div class="form_titulo subrayado">Nuevo Libro</div>
            <form class="form_datos" id="form-registrar-libro">
                <input name="accion" value="registrar-libro" type="hidden" />
                <span class="form_mensaje ocultado"></span>
                <div class="form_seccion">
                    <span class="form_mensaje ocultado"></span>
                    ${this.cargarInputNormal('Titulo:', 'titulo', '', 'text', 'required')}
                    ${this.cargarInputMultiselect('Autor/es:', 'autores', autores, 'required',
                          '<div class="form_boton form_a bt_beige" ref="agregar-autor">+</div>'
                    )}
                    ${this.cargarInputDesplegable('Editorial:', 'editorial',
                                                  todos_editoriales, 'required',
                        '<div class="form_boton form_a bt_beige" ref="agregar-editorial">+</div>'
                    )}
                    <div class="form_division"></div>
                    ${this.cargarInputNormal('ISBN:', 'isbn', '', 'text', 'required')}
                    
                    ${this.cargarInputNormal('Descripcion', 'descripcion', 'text', '', 'textrequired')}
                    ${this.cargarInputMultiselect('Géneros:', 'generos', generos, 'required',
                         '<div class="form_boton form_a bt_beige" ref="agregar-genero">+</div>'
                    )}
                    ${this.cargarInputImagen('Portada:', 'portada', '', 'required')}
                    ${this.cargarInputTexto('Sinopsis:', 'sinopsis', '', 'required')}
                </div>
                <button type="submit" class="form_boton bt_verde">Agregar</button>
            </form>`;
            return cont;
    }

    cargarPaginaInfoLibro(libro, disponibles, ejemplares){

        let checked = libro.activo == 1 ? 'Activado' : 'Desactivado';
        let activar = libro.activo == 0 ? 'Activar' : 'Desactivar';
        var activado = libro.activo == 1 ? 0 : 1;
        console.log("cargar pagina de libro", activado)
        return `
            <div class="form_titulo subrayado">${libro.titulo}</div>

            <section class="form_seccion subrayado">
                
                <div class="form_seccion">
                   <div class="form_fila">
                        <div class="form_informacion limitar">
                            <span class="form_subtitulo">ID: 102${libro.id}</span>
                            <div class="form_fila">
                                <span class="destacado">Autor:</span><span>${libro.autores}</span>
                            </div>   
                        
                            <div class="form_fila">
                                <span class="destacado">Editorial:</span><span>${libro.editorial}</span>
                            </div>
                            <div class="form_fila">
                                <span class="destacado">ISBN:</span><span>${libro.isbn}</span>
                            </div>
                            <div class="form_fila">
                                <span class="destacado">Descripcion:</span><span>${libro.descripcion}</span>
                                
                            </div>
                            <div class="form_fila subtitulo">
                                <span class="destacado">Cantidad de ejemplares:</span><span>${ejemplares.length}</span>
                            </div>
                            <div class="form_fila subtitulo">
                               
                                
                            </div>
                        </div>
                         <div class="form_imagen derecha form_portada_libro">
                            <label for="upload-photo-libro" class="upload-label">
                                <img src="http://localhost/Kobun/public/archivo/id/${libro.portada}" alt="portada">
                                <div class="overlay">
                                    <img src="img/icono-camara.png" class="camera-icon">
                                </div>
                            </label>
                            <input type="file" id="upload-photo-libro" name="portada" style="display: none;" accept="image/*">
                            <input type="hidden" name="libro_id" value="${libro.id}">
                         </div>
                    </div>
                    <div class="form_separacion"></div>
                    <div class="form_fila rellena">
                         <span>Disponilbles: ${disponibles.length}</span>
                         <form class="form_datos rellena" id="form-estado-libro">
                            <input name="accion" value="estado-libro" type="hidden"></input>
                            <input name="libro_id" value=${libro.id} type="hidden"></input>
                            <input name="activado" value=${activado} type="hidden"></input>
                            <div class="form_fila derecha">
                                <span >Libro ${checked}: </span>
                                
                                <button class ="form_boton derecha bt_beige" name="activo" type="submit">${activar}</button>
                                <span class="form_input_mensaje ocultado" ></span>
                            </div>
                            <span class="form_mensaje ocultado" ></span>
                        </form>
                    </div>

                </div>
                
            </section>

            ${this.cargarSeccionEjemplares(libro.id, ejemplares, libro.titulo)}

        `;

    }

    cargarEstadoUsuario(usuario) {
        return `
            <div class="form_titulo subrayado">${usuario.nombre} ${usuario.apellido}</div>
            <section class="form_seccion subrayado">
                <div class="form_informacion">
                    <div class="form_fila"><span class="form_mensaje ocultado"></span></div>
                    <div class="form_fila"><span class="destacado">Correo: </span><span>${usuario.mail}</span></div>
                    <div class="form_fila"><span class="destacado">Tipo de Usuario: </span><span class="${this.cargarColorTipoUsuario(usuario)}">${this.cargarTipoUsuario(usuario)}</span></div>
                    ${this.cargarEsSocio(usuario)}
                </div>
            </section>`;
    }

    cargarTipoUsuario(usuario) {
        const roles = { 1: "Administrador", 2: "Profesor", 3: "General" };
        return roles[usuario.rol_id] || "Desconocido";
    }
    cargarColorTipoUsuario(usuario) {
        const colores = { 1: "rol-admin", 2: "rol-profesor"};
        return colores[usuario.rol_id] || "rol-general";
    }

    cargarEsSocio(usuario) {
        if (usuario.socio_id) {
            return `
                <div class="form_fila"><span class="destacado">Socio: </span><span>Si</span></div>
                <div class="form_fila"><span class="destacado">Fecha alta: </span><span>${usuario.fecha_alta}</span></div>
                <div class="form_fila"><span class="destacado">Telefono: </span><span>${usuario.telefono}</span></div>
                <div class="form_fila"><span class="destacado">DNI: </span><span>${usuario.dni}</span></div>
                <div class="form_fila"><span class="destacado">Fecha nacimiento: </span><span>${usuario.fecha_nacimiento}</span></div>`;
        }
        return `<div class="form_fila"><span class="destacado">Socio: </span><span>No</span></div>`;
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
                            <div class ="form_fila"><span>${titulo}</span></div>
                            <div class ="form_fila"><span class="form_petit">${autor}</span></div>
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
                            <div class ="form_fila"><span>${titulo}</span></div>
                            <div class ="form_fila"><span class="form_petit">${autor}</span></div>
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
        const total_multas = multas.reduce((acc, multa) => acc + parseFloat(multa.monto || 0), 0);
        const multas_todas = multas.map(multa => this.cargarMulta(multa)).join('');

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

    cargarMulta(multa) {
        return `
            <div class="form_fila form_desplegable expande">
                <div class="form_bloque se_oculta">
                    <div class="form_fila">
                        <span>${multa.fecha_alta}:</span>
                        <span class="form_error">${multa.monto}</span>
                    </div>
                </div>
                <div class="form_boton despliega derecha">Eliminar</div>
            </div>`;
    }

    cargarEstadoCuenta(estado_cuenta) {
        console.log("estado cuenta: "+ estado_cuenta);
        /*
            data
:   
{estado_cuenta: {socio_id: 1, fecha_alta: "2025-11-13 00:00:00", activo: 1, cuota_socio: "25.00",…}}
estado_cuenta
: 
{socio_id: 1, fecha_alta: "2025-11-13 00:00:00", activo: 1, cuota_socio: "25.00",…}
activo
: 
1
cuota_al_dia
: 
1
cuota_socio
: 
"25.00"
fecha_alta
: 
"2025-11-13 00:00:00"
fecha_referencia
: 
"2025-11-13 12:05:14"
fecha_siguiente_cuota
: 
"2025-12-01"
meses_adeudados
: 
0
monto_adeudado
: 
"0.00"
socio_id
: 
1
ultimo_pago
: 
"2025-11-13 12:05:14"
estado
: 
"exito"
mensaje
: 
"Estado obtenido correctamente."
        */

        var ultimoPago = estado_cuenta.ultimo_pago?
            `<div class="form_fila">Ultimo pago registrado: ${estado_cuenta.ultimo_pago}</div>`:
            `<div class="form_fila">No hay pagos registrados</div>`;
        var proximoPago =  
            `<div class="form_fila">Proxima cuota: ${estado_cuenta.fecha_siguiente_cuota}</div>
             <div class="form_fila">Monto: <span class="form_exito">${estado_cuenta.cuota_socio}$</span></div>`;

        var cuota = estado_cuenta.cuota_al_dia == 1 ? 
        ` <div class="form_fila">Cuota: <span class="form_exito">AL DÍA</span></div>` :
        ` <div class="form_fila">Cuota: <span class="form_error">Adeudada</span></div>`;

        var info = estado_cuenta.meses_adeudados != 0 ? 
        `<div class="form_fila">Meses adeudados: ${estado_cuenta.meses_adeudados}</div>` +
        `<div class="form_fila">Monto adeudado: ${estado_cuenta.monto_adeudado}</div>`: '';
         
        
        
        return `
            <section class="form_seccion subrayado">
                <div class="form_subtitulo">Estado de Cuota</div>
                <div class="form_seccion subrayado">
                    <div class="form_fila from_subtitulo">Fecha de alta: ${estado_cuenta.fecha_alta}</div>
                </div>
                <div class="form_informacion">
                    
                    ${ultimoPago}
                    ${proximoPago}
                    ${cuota}
                    ${info}
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

    cargarPrestarLibro(usuario, disponibles) {
        /*
            ${this.cargarInputMultiselect('Géneros:', 'generos', generos, 'required',
                         '<div class="form_boton form_a" ref="agregar-genero">+</div>'
                    )}
        */
       disponibles = disponibles? disponibles : [];
        return `
            <section class="form_seccion form_desplegable subrayado" id="seccion-prestar-libro">

                
                    <div class="form_fila rellena">
                            <div class="form_boton despliega derecha">Prestar un libro</div>
                    </div>
                <div class="form_seccion se_despliega plegado">
                    <label>Buscar libro:</label>
                    <div class="form_fila"> 
                        <form class="form_fila form_datos rellena" id="form_buscador-libro">
                            <input name="accion" value="buscar-ejemplares" type="hidden" />
                            <input class="form_input" name="q"></input>
                            <span class="form_mensaje ocultado"></span>
                        </form>

                    </div>
                    <div class="form_seccion" >
                        <form class="form_datos" id="form-prestar-libro">
                            <input name="accion" value="prestar-libro" type="hidden" />
                            <input name="usuario_id" value=${usuario.usuario_id} type="hidden" />
                             ${this.cargarEjemplaresDisponibles(usuario.usuario_id, disponibles)}

                             ${this.cargarInputNormal('Fecha Límite:', 'fecha_limite', '', 'date', 'required')}

                            <div class="form_fila">
                                <button type="submit" class="form_boton derecha bt_verde">Realizar prestamo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>`;
    }
    cargarEjemplaresDisponibles(usuario_id, disponibles){

        disponibles = disponibles.map(d => {
            return `<option data-id=${d.ejemplar_id} value="${d.ejemplar_id}"> ${d.titulo}-${d.ejemplar_id}</option>`;
        }).join('');

        return `
            <div class="form_seccion" id="seccion-ejemplares-disponibles">

                ${this.cargarInputDesplegable("Ejemplares:", "ejemplar_id", disponibles, "required" )}
               
            </div>
        `;
    }
    cargarSociosDisponibles(socios){

        socios = socios.map(s => {
            return `<option data-id=${s.socio_id} value="${s.socio_id}"> ${s.usuario_nombre + " - " + s.usuario_mail}</option>`;
        }).join('');

        return `
            <div class="form_seccion" id="seccion-socios">

                ${this.cargarInputDesplegable("Socio:", "socio_id", socios, "required" )}
               
            </div>
        `;
    }

    cargarInputNormal(titulo, nombre, clase, tipo, extras ="") {
        return `
            <label>${titulo}</label>
            <div class="form_fila">
                <input name="${nombre}" class="form_input ${clase}" type="${tipo}" ${extras} />
                <span class="form_input_mensaje form_error ocultado"></span>
            </div>`;
    }
    cargarInputDesplegable(titulo, nombre, opciones, extras = "", al_lado = ""){
        return `
            <div class="form_desplegable form_seccion">
                <label>${titulo}</label>
                <div class="form_fila">
                    
                    <select name=${nombre} class="form_input_select form_input ${extras}">
                        ${opciones} 
                    </select>
                    ${al_lado}
                </div>

                <input type="hidden" name=${nombre}_id></input>
                <span class="form_input_mensaje form_error ocultado"></span>
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
    cargarInputTexto(titulo, nombre, clase ="",  extras){
        return `
            <label>${titulo}</label>
            <div class="form_fila">
                <textarea name="${nombre}" class="form_input ${clase}" type="text" ${extras}
                accept="image/*" 
                rows="5"
                cols="40"
                placeholder="Sinópsis"
                ></textarea>
                <span class="form_input_mensaje form_error ocultado"></span>
            </div>
                 `;
    };
    cargarInputMultiselect(titulo, nombre, opciones, extras, al_lado = "") {
        const opcionesHTML = opciones.map(op => `
            <div class="form_fila form_multiselect_opcion" data-id="${op.id}" data-nombre="${op.nombre}">
                ${op.nombre}
                <span class="check">✔</span>
            </div>
        `).join('');

        return `
            <label>${titulo}</label>
            <div class="form_seccion form_multiselect_contenedor" data-nombre-campo="${nombre}">
                <div class="form_seccion form_multiselect_input_wrapper">
                    <div class="form_fila form_multiselect_pills">
                    </div>
                    <div class="form_fila">
                        <input type="text" class="form_input form_multiselect_filtro despliega" placeholder="Buscar o seleccionar...">
                        ${al_lado}
                    </div>
                </div>
                <div class="form_seccion form_multiselect_opciones ocultado subrayado">${opcionesHTML}</div>
                <input ${extras} type="hidden" name="${nombre}_ids" id="hidden-input-${nombre}">
            </div>`;
    }

    cargarHacerProfesorBorrar(usuario){
        const boton = usuario.rol_id == 3 ? `
        <input name="accion" value="agregar-profesor" type="hidden" />
        <button class="form_boton">Hacer profesor</button>` :`
        <input name="accion" value="quitar-profesor" type="hidden" />
        <button class="form_boton bt_beige">Quitar Privilegios</button>`;

        return `
            <footer class="form_pie">
                <div class="form_fila rellena">
                    <form class="form_datos form_seccion" id="form-estado-profesor">
                        <input name="usuario_id" value=${usuario.usuario_id} type="hidden" />
                        ${boton}
                        <span class="form_mensaje ocultado"></span>
                    </form>
                    <form class="form_datos form_seccion" id="form-borrar-usuario">
                        <input name="accion" value="borrar-usuario" type="hidden" />
                        <input name="usuario_id" value=${usuario.usuario_id} type="hidden" />
                        <button class="form_boton bt_rojo">Borrar Usuario</button>
                        <span class="form_mensaje ocultado derecha "></span>
                    </form>
                </div>
            </footer>`;
    }
    cargarSeccionEjemplares(libro_id, ejemplares, titulo){

        let todos_ejemplares = `<span>No hay ejemplares registrados</span>`;
        if(ejemplares.length > 0){
            todos_ejemplares = ejemplares.map(e => this.cargarEjemplar(e, titulo)).join('');
        }

        return `
        <section class="form_seccion subrayado" id="seccion-ejemplares">
            <div class="form_subtitulo">Ejemplares</div>
            <form class="form_datos form_fila rellena" id="form-agregar-ejemplar">
                <input name="accion" value="agregar-ejemplar" type="hidden">
                <input name="libro_titulo" value=${titulo} type="hidden">
                
                <div class="form_seccion derecha">
                <input name="libro_id" value=${libro_id} type="hidden">
                <span class="form_mensaje ocultado derecha"></span>
                </div>
                
                <button class="form_boton derecha bt_verde"> Agregar ejemplar</button>

                <button class="form_checks_cont ocultado form_boton bt_rojo"> Eliminar </button>
            </form>
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
                    
                    <div class="form_fila rellena fuente_titulos_peq">
                        <span>${titulo}</span>   
                    </div>

                    <div class="form_fila rellena">

                        <div class="form_seccion se_despliega">
                            <div class="form_fila">
                                <span class="form_petit">Codigo ejemplar: ${ejemplar.libro_id}100-${ejemplar.ejemplar_id} </span>
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
                        <button type="submit" class="form_boton derecha bt_verde">
                            Guardar
                        </button>
                    </div>

                </div>
                        
        </section>
        `;

    }
        
}