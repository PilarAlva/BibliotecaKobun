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
    static #API_URL = "http://localhost/BibliotecaKobun/public/peticion";

    /**
     * Performs a fetch request.
     * @param {FormData} formData - The data to be sent.
     * @returns {Promise<any>} - The JSON response from the server.
     */
    static async #doRequest(formData) {
        try {
            const response = await fetch(this.#API_URL, {
                method: 'POST',
                body: formData
            });
            const resultText = await response.text();
            try {
                return JSON.parse(resultText);
            } catch (e) {
                console.warn("Response was not valid JSON:", resultText);
                return resultText;
            }
        } catch (error) {
            console.error('Error in Peticion:', error);
            throw error;
        }
    }

    /**
     * Sends a generic petition.
     * @param {FormData} formData - The form data for the request.
     * @returns {Promise<any>}
     */
    static peticion(formData) {
        return this.#doRequest(formData);
    }

    static #transaccion(accion) {
        const formData = new FormData();
        formData.append('accion', accion);
        return this.#doRequest(formData);
    }

    static empezar() {
        return this.#transaccion("empezar-transaccion");
    }

    static cerrar() {
        return this.#transaccion("cerrar-transaccion");
    }

    static aceptar() {
        return this.#transaccion("commit-transaccion");
    }
}

/**
 * Manages form interactions, state, and dynamic content updates.
 */
export class Formulario {
    #formulario;
    #contenido;
    #colaPaginas = [];
    #colaCambios = [];

    constructor(formulario) {
        this.#formulario = formulario;
        this.#contenido = this.#formulario.querySelector(".form_contenido");

        if (!this.#contenido) {
            throw new Error("Formulario content area (.form_contenido) not found.");
        }

        Peticion.empezar();
        this.#colaPaginas.push(this.#contenido.cloneNode(true));
        this.#initEventListeners();
    }

    //--------------------------------------------------------------------------
    // Event Handling (using Event Delegation)
    //--------------------------------------------------------------------------

    #initEventListeners() {
        this.#formulario.addEventListener("click", this.#handleFormClick.bind(this));
        this.#formulario.addEventListener("submit", this.#handleFormSubmit.bind(this));
        this.#formulario.addEventListener("change", this.#handleFormChange.bind(this));
    }

    #handleFormClick(event) {
        const target = event.target;

        if (target.matches("#btn-retroceso")) {
            this.retroceder();
        } else if (target.matches("#btn-guardar")) {
            this.guardarCambios();
        } else if (target.matches("#btn-cerrar")) {
            this.borrarCambios();
        } else if (target.matches(".form_boton.despliega")) {
            this.#toggleDesplegable(target);
        } else if (target.matches(".form_checkbox")) {
            this.#handleCheckboxClick(target);
        }
    }

    #handleFormSubmit(event) {
        event.preventDefault();
        const form = event.target;
        if (form.matches(".form_datos") && this.#validar(form)) {
            this.#insertarCambio(form);
            this.#cargarCambio();
        }
    }

    #handleFormChange(event) {
        const target = event.target;
        if (target.matches('input, select, textarea')) {
            const form = target.closest('form.form_datos');
            if (form && this.#validarCampo(target)) {
                this.#insertarCambio(form);
            }
        }
    }

    #toggleDesplegable(boton) {
        const seccion = boton.closest(".form_desplegable, .seccion_formulario");
        if (!seccion) return;

        seccion.querySelectorAll(".se_oculta").forEach(node => node.classList.toggle("ocultado"));
        seccion.querySelectorAll(".se_despliega").forEach(node => {
            node.classList.toggle("desplegado");
            node.classList.toggle("plegado");
        });
    }

    #handleCheckboxClick(check) {
        const seccion = check.closest(".form_checks");
        if (!seccion) return;

        const seccionVisible = seccion.querySelector(".form_checks_cont");
        const checks = seccion.querySelectorAll(".form_checkbox");
        const isAnyChecked = Array.from(checks).some(c => c.checked);

        seccionVisible?.classList.toggle("ocultado", !isAnyChecked);
    }


    //--------------------------------------------------------------------------
    // Public API
    //--------------------------------------------------------------------------

    async editarUsuario(id) {
        try {
            const usuarioData = await this.#getUsuario(id);
            this.#mostrarPaginaUsuario(usuarioData.data);
            this.#mostrarPagina();
        } catch (error) {
            console.error("Failed to edit user:", error);
            this.mostrarMensaje(this.#contenido, "Error al cargar los datos del usuario.", "form_error");
        }
    }

    //--------------------------------------------------------------------------
    // Page and State Management
    //--------------------------------------------------------------------------

    retroceder() {
        if (this.#colaPaginas.length > 1) {
            this.#colaPaginas.pop();
            this.#mostrarPagina();
        }
    }

    #mostrarPagina() {
        const pagina = this.#colaPaginas[this.#colaPaginas.length - 1];
        if (pagina) {
            this.#contenido.innerHTML = ''; // Clear existing content
            this.#contenido.appendChild(pagina);
        }
    }

    borrarCambios() {
        console.log("Borrando cambios:", this.#colaCambios);
        this.#colaCambios = [];
        Peticion.cerrar().then(() => Peticion.empezar()); // Reset transaction
        // Optionally, provide user feedback
    }

    async #cargarCambio() {
        if (this.#colaCambios.length === 0) {
            console.log("No hay cambios para cargar.");
            return;
        }

        const cambio = this.#colaCambios.pop();
        console.log("Procesando cambio:", cambio);

        try {
            const respuesta = await Peticion.peticion(cambio.formData);
            if (respuesta.estado === "exito") {
                this.mostrarMensaje(cambio.mensaje, respuesta.mensaje, "form_exito");
                // Optionally re-render part of the UI
                // e.g., cambio.target.innerHTML = cambio.plantilla();
            } else {
                this.mostrarMensaje(cambio.mensaje, respuesta.mensaje || "Ocurrió un error.", "form_error");
            }
        } catch (error) {
            this.mostrarMensaje(cambio.mensaje, "Error de conexión al procesar el cambio.", "form_error");
        }
    }

    async guardarCambios() {
        if (this.#colaCambios.length === 0) {
            console.log("No hay cambios para guardar.");
            return;
        }

        const peticiones = this.#colaCambios.map(cambio =>
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
            this.#colaCambios = [];
            console.log("Todos los cambios han sido procesados.");
        } catch (error) {
            console.error("Error al guardar cambios:", error);
        }
    }

    #insertarCambio(form) {
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

        const index = this.#colaCambios.findIndex(c => c.id === id);
        if (index !== -1) {
            this.#colaCambios[index] = { id, cambio };
        } else {
            this.#colaCambios.push({ id, cambio });
        }
        console.log("Cambio insertado/actualizado. Cola:", this.#colaCambios);
    }

    //--------------------------------------------------------------------------
    // Validation
    //--------------------------------------------------------------------------

    #validar(form) {
        let esValido = true;
        form.querySelectorAll('input[required], select[required], textarea[required]').forEach(campo => {
            if (!this.#validarCampo(campo)) {
                esValido = false;
            }
        });
        return esValido;
    }

    #validarCampo(campo) {
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
        contenedor.className = "form_mensaje"; // Reset classes
        contenedor.classList.add(tipo);
    }

    //--------------------------------------------------------------------------
    // Data Fetching
    //--------------------------------------------------------------------------

    async #getUsuario(id) {
        const formData = new FormData();
        formData.append('accion', "usuario");
        formData.append('usuario_id', id);
        return Peticion.peticion(formData);
    }

    //--------------------------------------------------------------------------
    // HTML Template Generators
    //--------------------------------------------------------------------------
    #mostrarPaginaUsuario(data) {
        const contenido = document.createElement("div");
        contenido.classList.add("form_contenido_dinamico");

        const paginaHTML = this.#cargarPaginaUsuario(data);
        if (typeof paginaHTML === 'string') {
            contenido.innerHTML = paginaHTML;
        } else {
            contenido.appendChild(paginaHTML);
        }


        this.#colaPaginas.push(contenido);
    }

    #cargarPaginaUsuario(data) {
        let cont = this.#cargarEstadoUsuario(data.usuario);

        if (data.usuario.socio_id) {
            cont += this.#cargarPrestamos(data.prestamos);
            if (data.estado_cuenta) {
                cont += this.#cargarEstadoCuenta(data.estado_cuenta);
            }
            if (data.multas && data.multas.length > 0) {
                cont += this.#cargarMultas(data.multas);
            }
            if (data.socio_habilitado) {
                cont += this.#cargarPrestarLibro(data.usuario);
            }
        } else {
            cont += this.#cargarHacerSocio(data.usuario);
        }
        return cont;
    }

    #cargarEstadoUsuario(usuario) {
        return `
            <div class="form_titulo subrayado">${usuario.nombre} ${usuario.apellido}</div>
            <section class="form_seccion subrayado">
                <div class="form_informacion">
                    <div class="form_fila"><span>Correo: ${usuario.mail}</span></div>
                    <div class="form_fila"><span>Tipo de Usuario: ${this.#cargarTipoUsuario(usuario)}</span></div>
                    ${this.#cargarEsSocio(usuario)}
                </div>
            </section>`;
    }

    #cargarTipoUsuario(usuario) {
        const roles = { 1: "Admin", 2: "Profesor", 3: "General" };
        return roles[usuario.rol_id] || "Desconocido";
    }

    #cargarEsSocio(usuario) {
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

    #cargarPrestamos(prestamos) {
        const activos = prestamos?.filter(p => p.activo == 1) || [];
        const devueltos = prestamos?.filter(p => p.activo != 1) || [];

        const prestamos_activos = activos.length > 0
            ? activos.map(p => this.#cargarLibroPrestamo(p.id, p.titulo, p.autores, p.fecha_prestamo, p.fecha_vencimiento)).join('')
            : "<div class='form_informacion'>No tiene préstamos activos</div>";

        const prestamos_devueltos = devueltos.length > 0
            ? devueltos.map(p => this.#cargarLibroDevuelto(p.id, p.titulo, p.autores, p.fecha_prestamo, p.fecha_devolucion)).join('')
            : "<div class='form_petit'>No tiene historial de devoluciones</div>";

        return `
            <span class="form_subtitulo">Libros en préstamo</span>
            <form class="form_datos form_seccion subrayado" id="devolver-prestamos">
                <div class="form_fila"><span class="form_mensaje ocultado"></span></div>
                <input name="accion" value="devolver-prestamo" type="hidden" />
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
            </form>`;
    }

    #cargarLibroPrestamo(id, titulo, autor, fecha1, fecha2) {
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
                        <input class="form_checkbox derecha" name="prestamo_id[]" value=${id} type="checkbox">
                        <span class="form_input_mensaje form_error ocultado">error</span>
                        <span class="form_petit derecha">Prestado: ${fecha1}</span>
                        <span class="form_petit derecha">Hasta: ${fecha2}</span>
                    </div>
                </div>
            </div>`;
    }

    #cargarLibroDevuelto(id, titulo, autor, fecha1, fecha2) {
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

    #cargarMultas(multas) {
        const total_multas = multas.reduce((acc, multa) => acc + parseFloat(multa.total_multa || 0), 0);
        const multas_todas = multas.map(multa => this.#cargarMulta(multa.titulo, multa.total_multa)).join('');

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

    #cargarMulta(titulo, monto) {
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

    #cargarEstadoCuenta(estado_cuenta) {
        return `
            <section class="form_seccion subrayado">
                <div class="form_subtitulo">Estado de Cuota</div>
                <div class="form_informacion">
                    <div class="form_fila">Cuota: <span class="form_exito">AL DÍA</span></div>
                    <div class="form_fila">Ultimo pago registrado: ${estado_cuenta.ultimo_pago}</div>
                </div>
            </section>`;
    }

    #cargarHacerSocio(usuario) {
        return `
            <div class="form_desplegable">
                <button class="form_boton despliega">Hacer Socio</button>
                <div class="form_desplegable_cont se_despliega plegado">
                    <form class="form_datos" id="form-agregar-socio">
                        <input name="accion" value="agregar-socio" type="hidden" />
                        <input name="usuario_id" value=${usuario.id} type="hidden" />
                        <span class="form_mensaje ocultado"></span>
                        ${this.#cargarInputNormal('Teléfono:', 'telefono', '', 'number', 'required')}
                        ${this.#cargarInputNormal('DNI:', 'dni', '', 'text', 'required')}
                        ${this.#cargarInputNormal('Fecha de Nacimiento:', 'fecha_nacimiento', '', 'date', 'required')}
                        <button type="submit" class="form_boton verde">Confirmar</button>
                    </form>
                </div>
            </div>`;
    }

    #cargarPrestarLibro(usuario) {
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
                        ${this.#cargarInputNormal('Identificador del ejemplar:', 'ejemplar_id', '', 'number', 'required')}
                        <div class="form_informacion" data-libro-info></div>
                        ${this.#cargarInputNormal('Fecha Límite:', 'fecha_limite', '', 'date', 'required')}
                        <div class="form_fila">
                            <button type="submit" class="form_boton derecha verde">Realizar prestamo</button>
                        </div>
                    </div>
                </form>
            </section>`;
    }

    #cargarInputNormal(titulo, nombre, clase, tipo, extras) {
        return `
            <label>${titulo}</label>
            <div class="form_fila">
                <input name="${nombre}" class="form_input ${clase}" type="${tipo}" ${extras} />
                <span class="form_input_mensaje form_error ocultado"></span>
            </div>`;
    }
}

