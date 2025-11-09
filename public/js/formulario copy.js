export class Cambio {

    constructor(target, form, formData, mensaje, plantilla, data) {
        this.target = target,
            this.form = form;
        this.formData = formData;
        this.mensaje = mensaje;
        this.plantilla = plantilla;
        this.data = data;
    }

}
export class Peticion {

    static async peticion(formData) {

        return new Promise((resolve, reject) => {

            fetch("http://localhost/BibliotecaKobun/public/peticion", {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(result => {
                    try {
                        resolve(JSON.parse(result));
                    } catch (e) {
                        reject(e);
                    }
                })
                .catch(error => {
                    console.error('Error en la peticion', error);
                    reject(error);
                });
        });

    }
    static async empezar() {

        return new Promise((resolve, reject) => {

            const formData = new FormData();
            formData.append('accion', "empezar-transaccion");

            fetch("http://localhost/BibliotecaKobun/public/peticion", {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(result => {
                    try {
                        resolve(JSON.parse(result));
                    } catch (e) {
                        reject(e);
                    }
                })
                .catch(error => {
                    console.error('Error en la peticion', error);
                    reject(error);
                });
        });

    }
    static async cerrar() {

        return new Promise((resolve, reject) => {

            formData = new FormData();
            formData.append('accion', "cerrar-transaccion");

            fetch("http://localhost/BibliotecaKobun/public/peticion", {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(result => {
                    try {
                        resolve(JSON.parse(result));
                    } catch (e) {
                        reject(e);
                    }
                })
                .catch(error => {
                    console.error('Error en la peticion', error);
                    reject(error);
                });
        });

    }
    static async aceptar() {

        return new Promise((resolve, reject) => {

            formData = new FormData();
            formData.append('accion', "commit-transaccion");

            fetch("http://localhost/BibliotecaKobun/public/peticion", {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(result => {
                    try {
                        resolve(JSON.parse(result));
                    } catch (e) {
                        reject(e);
                    }
                })
                .catch(error => {
                    console.error('Error en la peticion', error);
                    reject(error);
                });
        });

    }

}

export class Formulario {
    constructor(formulario) {

        //Empieza la transaccion
        Peticion.empezar();
        this.cola_cambios = [{}];

        this.colaPaginas = [formulario.querySelector(".form_contenido")];
        this.formulario = formulario;

        //BOTONES FUNCIONALES
        const btn_retroceso = formulario.querySelector("#btn-retroceso");
        const btn_guardar = formulario.querySelector("#btn-guardar");
        const btn_cerrar = formulario.querySelector("#btn-cerrar");

        //BOTONES
        const btn = formulario.querySelectorAll(".form_boton.despliega");

        //FORMULARIOS


        btn_guardar.addEventListener("click", () => {

            this.guardarCambios();
            //this.limpiarFormulario();
        });
        btn_cerrar.addEventListener("click", () => {
            //this.limpiarFormulario();
        });

        btn_retroceso.addEventListener("click", () => {
            this.retroceder();
        });
        btn_cerrar.addEventListener("click", () => {
            this.borrarCambios();
        });

        btn.forEach((boton) => {
            //console.log(boton);
            boton.addEventListener("click", () => {

                //this.usuarios();

                var seccion = boton.closest(".seccion_formulario");
                var ocultar = seccion.querySelectorAll(".se_oculta");
                var plegar = seccion.querySelectorAll(".se_despliega");

                if (ocultar) {
                    ocultar.forEach((node) => {
                        node.classList.toggle("ocultado")
                    });
                }
                if (plegar) {
                    plegar.forEach((node) => {
                        node.classList.toggle("desplegado");
                        node.classList.toggle("plegado");
                    });
                }


            });
        })



    }

    /*--------Esto lo llama la página de perfil -------------------*/

    async editarUsuario(id) {

        const usuarioData = await this.getUsuario(id);

        this.mostrarPaginaUsuario(usuarioData.data);

        this.mostrarPagina();


        /*
        console.log(usuarioData);
        const formTitle = this.formulario.querySelector(".form_titulo");
        if (formTitle) {
        formTitle.innerHTML = `${usuarioData.data.usuario.nombre} ${usuarioData.data.usuario.apellido}`;
        } else {
        console.error("Elemento '.form_titulo' no encontrado.");
        }

        */



    }

    /*-------------Manejo de la inforamcion----------------------------*/

    retroceder() {
        //TODO: falta chquear que no esté vacia la cola
        //TODO: falta chquear que no se cargue dos veces la misma página
        this.colaPaginas.pop();
        this.mostrarPagina();
    }

    mostrarPagina() {

        const contenido = this.formulario.querySelector(".form_contenido");
        console.log("paginas: " + this.colaPaginas)
        console.log("contendio: " + contenido)
        //Muestra la última página en la cola
        const pagina = this.colaPaginas.slice(-1)[0];
        contenido.innerHTML = pagina.innerHTML;

        const btn = this.formulario.querySelectorAll(".form_boton.despliega");
        const forms = formulario.querySelectorAll(".form_datos");
        const btn_check = formulario.querySelectorAll(".form_checkbox");


        btn_check.forEach((check) => {

            check.addEventListener("click", () => {


                var seccion = check.closest(".form_checks");
                var seccion_visible = seccion.querySelector(".form_checks_cont");
                var checks = seccion.querySelectorAll(".form_checkbox");


                let activar = false;

                checks.forEach((c) => {
                    if (c.checked) {
                        activar = true
                    }
                })

                if (activar) {
                    seccion_visible.classList.remove("ocultado");
                } else {
                    seccion_visible.classList.add("ocultado");
                }

                console.log(checks, seccion_visible);

            });

        });

        forms.forEach((form) => {

            form.addEventListener("submit", (event) => {
                event.preventDefault();
                if (this.validar(form)) {
                    this.insertarCambio(form);
                    this.cargarCambio();
                }
            });

            form.addEventListener('change', (event) => {

                if (event.target.matches('input, select, textarea')) {
                    console.log('An input value changed:', event.target.name, event.target.value);
                    if (this.validarCampo(event.target))
                        this.insertarCambio(form);
                    else {

                    }
                    console.log(event);
                }
            });
            form.addEventListener('input', (event) => {

                if (event.target.matches('input, select, textarea')) {
                    console.log('An input value changed:', event.target.name, event.target.value);

                }
            });

        });

        btn.forEach((boton) => {
            //console.log(boton);
            boton.addEventListener("click", () => {

                //this.usuarios();

                var seccion = boton.closest(".form_desplegable");
                var ocultar = seccion.querySelectorAll(".se_oculta");
                //Tendría que ser solo un nivel de búsqueda
                var plegar = seccion.querySelectorAll(".se_despliega");

                if (ocultar) {
                    ocultar.forEach((node) => {
                        node.classList.toggle("ocultado")
                    });
                }
                if (plegar) {
                    plegar.forEach((node) => {
                        node.classList.toggle("desplegado");
                        node.classList.toggle("plegado");
                    });
                }


            });
        })

        // if (formTitle) {
        // formTitle.innerHTML = `${usuarioData.data.usuario.nombre} ${usuarioData.data.usuario.apellido}`;
        // } else {
        // console.error("Elemento '.form_titulo' no encontrado.");
        // }
    }
    borrarCambios() {
        console.log(this.cola_cambios);
        //Peti
        // cion.rechazar();
    }

    async cargarCambio() {
        if (this.cola_cambios.length > 0) {

            var cambio = this.cola_cambios.pop();

            console.log("Commit");
            var respuesta = await Peticion.peticion(cambio.formData);
            if (respuesta.estado == "error")
                this.mostrarMensaje(cambio.mensaje, respuesta.mensaje, "form_error");
            else if (respuesta.estado == "exito") {
                this.mostrarMensaje(cambio.mensaje, respuesta.mensaje, "form_exito");

                data = Peticion.peticion(cambio.formData);
                cambio.target.innerHTML = cambio.plantilla();
            }

        } else {
            console.log("no hay cambios");
        }
    }

    async guardarCambios() {

        console.log(this.cola_cambios);
        //Peticion.aceptar();

        if (this.cola_cambios.length > 0) {
            this.cola_cambios.forEach(async (cambio) => {

                console.log("Acá se hacen los commits");
                var respuesta = await Peticion.peticion(cambio.formData);
                if (respuesta.estado == "error")
                    this.mostrarMensaje(cambio.mensaje, respuesta.mensaje, "form_error");
                else if (respuesta.estado == "exito")
                    this.mostrarMensaje(cambio.mensaje, respuesta.mensaje, "form_exito");


            })

        } else {
            console.log("no hay cambios");
        }

    }
    validar(form) {


        var campos = form.getElementsByTagName("input");

        console.log(campos);
        campos = Array.from(campos);

        var aceptado = true;

        campos.forEach((campo) => {

            if (!this.validarCampo(campo)) aceptado = false;

        });

        return aceptado;

    }
    validarCampo(campo) {


        var err = "";
        var name = campo.name;
        var value = campo.value;
        console.log(name + ": " + value);

        if (value == null || value == "") {
            err = name + " es requerido";

        } else if (name == "mail") {
            var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (!emailRegex.test(value)) {
                err = "Email invalido"
            }
        }


        //Despues de todas las comprobaciones se muestra o no el error de cada input

        var span_error = campo.parentNode.querySelector(".form_input_mensaje");
        span_error.innerText = "";
        span_error.classList.add("ocultado");
        if (err != "") {
            span_error.innerText = err;
            span_error.classList.remove("ocultado");

            return false;
        }
        return true;





    }
    insertarCambio(form) {

        const index = this.cola_cambios.findIndex(form => form.id === id);
        console.log(form);
        console.log("tipo del cambio: " + typeof(form));

        const formData = new FormData(form);

        const cambio = new Cambio(form, form, formData, form.querySelector(".form_mensaje"), this.cargarPrestamos(), peticion());

        //chequea si el cambio no estaba registrado
        if (index !== -1) {
            this.cola_cambios[index] = cambio;
        } else {

            var id = form.id;
            this.cola_cambios.push({
                id,
                cambio
            });
        }

        //console.log(cola_cambios);
        //form_datos.dispatchEvent(new Event('submit'));
    }
    mostrarMensaje(contenedor, mensaje, tipo = 'form_error') {

        contenedor.innerText = mensaje;
        contenedor.classList.add("ocultado");

        contenedor.classList.remove("ocultado");
        contenedor.classList.add("form_exito");
        contenedor.classList.add("form_error");
        contenedor.classList.remove("form_error");
        contenedor.classList.remove("form_exito");

        contenedor.classList.add(tipo);




    }

    /*------------------DIVS------------------------------------- */
    actualizar(div, func) {

        div.innerHTML = func()

    }

    cargarInputNormal(titulo, nombre, clase, tipo, cosas) {

        return /*html*/ `<label>${titulo}</label>
<div class="form_fila">
    <input name=${nombre} class="form_input ${clase}" type=${tipo} ${cosas} />
    <span class="form_input_mensaje form_error ocultado"></span>
</div>`;

    }
    cargarLibroPrestamo(id, titulo, autor, fecha1, fecha2) {
        return /*html*/ `


<div class="form_bloque">

    <div class="form_fila rellena">
        <div class="form_seccion">
            <div class="form_informacion">
                <span>${titulo}</span>
                <span class="form_petit">${autor}</span>
            </div>

        </div>
        <div class="form_seccion">

            <input class="form_checkbox derecha" name="prestamo_id" value=${id} type="checkbox"></input>
            <span class="form_input_mensaje form_error ocultado">error</span>
            <span class="form_petit derecha">Prestado: ${fecha1}</span>
            <span class="form_petit derecha">Hasta: ${fecha2}</span>

        </div>
    </div>
</div>
`;

    }
    cargarLibroDevuelto(id, titulo, autor, fecha1, fecha2) {
        return /*html*/ `
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
</div>
`;
    }
    cargarMulta(titulo, monto) {

        return /*html*/ `
<div class="form_fila form_desplegable  expande">

    <div class="form_bloque se_oculta">
        <div class="form_fila">
            <span>${titulo}:</span>
            <span class="form_error"> ${monto} </span>

        </div>
    </div>

    <div class="form_bloque se_oculta ocultado cancelado">
        <div class="form_fila">
            <span>${titulo}:</span>
            <span class="form_error"> ${monto} </span>

        </div>
    </div>

    <div class="form_boton despliega derecha">
        Eliminar
    </div>

</div>
`;

    }

    cargarEsSocio(usuario) {
        if (usuario.socio_id) {
            return /*html*/ `
<div class="form_fila">
    <span>Socio: Si</span>
</div>
<div class="form_fila">
    <span>Fecha alta: ${usuario.fecha_alta} </span>
</div>
<div class="form_fila">
    <span>Telefono: ${usuario.telefono} </span>
</div>
<div class="form_fila">
    <span>DNI: ${usuario.dni} </span>
</div>
<div class="form_fila">
    <span>Fecha nacimiento: ${usuario.fecha_nacimiento} </span>
</div>
`;
        }
        return /*html*/ `
<div class="form_fila">
    <span>Socio: no</span>
</div>
`;

    }
    cargarTipoUsuario(usuario) {

        switch (usuario.rol_id) {
            case 1:
                return "Admin";
            case 2:
                return "Profesor";
            case 3:
                return "General";
            default:
                return "";
        }
    }

    cargarPrestamos(prestamos) {

        var prestamos_activos = '';
        var prestamos_devueltos = '';
        console.log("prestamos " + prestamos);
        //var cont = /*html*/ `<span class="form_subtitulo">prestamos:${prestamos.length} </span>`;
        if (prestamos) {
            prestamos.forEach((prestamo) => {

                if (prestamo.activo == 1) {
                    prestamos_activos += this.cargarLibroPrestamo(prestamo.id, prestamo.titulo, prestamo.autores, prestamo.fecha_prestamo, prestamo.fecha_vencimiento);

                } else {
                    prestamos_devueltos += this.cargarLibroDevuelto(prestamo.id, prestamo.titulo, prestamo.autores, prestamo.fecha_prestamo, prestamo.fecha_devolucion)
                }

            })
        };
        if (prestamos_activos == '') prestamos_activos = "<div class='form_informacion'> No tiene préstamos activos</div>";
        if (prestamos_devueltos == '') prestamos_devueltos = "<div class='form_petit'> No tiene libros devueltos</div>";

        var cont = /*html*/ `
        
        <span class="form_subtitulo">
            Libros en préstamo
        </span>
        <form class="form_datos form_seccion subrayado" id="devolver-prestamos">
        
            <div class="form_fila">
                <span class="form_mensaje ocultado"></span>
            </div>
        
            <input name="accion" class="form_input" value="devolver-prestamo" type="hidden" />
        
            <div class="form_checks form_seccion" id="form-prestamos">
        
                ${prestamos_activos}
        
                <div class="form_checks_cont form_fila rellena ocultado">
        
                    <button type="submit" class="form_boton derecha">Devolver</button>
        
                </div>
        
            </div>
        
            <div class="form_desplegable form_seccion ">
                <div class="form_fila rellena">
                    <span class="form_subtitulo se_oculta ocultado">
                        Libros devueltos:
                    </span>
                    <div class="form_boton despliega derecha">
                        Libros devueltos
                    </div>
        
                </div>
        
                <div class="form_seccion se_despliega plegado">
        
                    ${prestamos_devueltos}
        
                </div>
        
        
            </div>
        
        
        </form>
        
        `;

        return cont;

    }

    cargarMultas(multas) {

        var multas_todas = '';
        var total_multas = '';
        console.log("multas " + multas);

        multas.forEach((multa) => {

            total_multas += multa.total_multa;
            multas_todas += this.cargarMulta(multa.titulo, multa.total_multa);

        });

        var cont = /*html*/ `
        
        <span class="form_subtitulo">Multas</span>
        
        <section class="form_seccion subrayado">
        
            <div class="form_fila rellena">
                <span>Multa por libro:</span>
            </div>
        
            ${multas_todas}
        
            </div>
        
            <div class="form_fila">
                Total de multas: <span class="form_error"> ${total_multas}</span>
                <div class="form_boton derecha"> Cancelar multa</div>
            </div>
        
        </section>
        
        `;
        return cont;

    }

    cargarEstadoUsuario(usuario) {

        return /*html*/ `
<div class="form_titulo subrayado">${usuario.nombre + " " + usuario.apellido}</div>

<section class="form_seccion subrayado">

    <div class="form_informacion">

        <div class="form_fila">
            <span>Correo: ${usuario.mail}</span>
        </div>
        <div class="form_fila">
            <span>Tipo de Usuario: ${this.cargarTipoUsuario(usuario)} </span>
        </div>

        ${this.cargarEsSocio(usuario)}

    </div>

</section>
`;

    }
    cargarEstadoCuenta(estado_cuenta) {




        return /*html*/ `
<section class="form_seccion subrayado">
    <div class="form_subtitulo">Estado de Cuota</div>
    <div class="form_informacion">
        <div class="form_fila">
            Cuota: <span class="form_exito"> $$$</span>
        </div>
        <div class="form_fila">
            Ultimo pago registrado: ${estado_cuenta.ultimo_pago};
        </div>
    </div>

</section>`;
    }

    cargarHacerSocio(usuario) {

        return /*html*/ `
<div class="form_fila">

    <div class="form_desplegable  ">

        <button class="form_boton despliega">Hacer Socio</button>

        <div class="form_desplegable_cont se_despliega plegado">
            <form class="form_datos" id="form-agregar-socio">

                <input name="accion" class="form_input" value="agregar-socio" type="hidden" />
                <input name="usuario_id" class="form_input" value=${usuario.id} type="hidden" />

                <label>Teléfono:</label>
                <div class="form_fila">
                    <input name="nombre" class="form_input" type="number" required />
                    <span class="form_input_mensaje form_error ocultado"></span>
                </div>
                <label>DNI:</label>
                <div class="form_fila">
                    <input name="apellido" class="form_input" type="text" required />
                    <span class="form_input_mensaje form_error ocultado"></span>
                </div>
                <label>Fecha de Nacimiento: </label>
                <div class="form_fila">
                    <input name="mail" class="form_input" type="date" required />
                    <span class="form_input_mensaje form_error ocultado"></span>
                </div>
                <div class="form_fila">
                    <span class="form_mensaje ocultado"></span>
                </div>


            </form>
            <div>

            </div>

        </div>

    </div>
    `;

    }
    cargarPrestarLibro(usuario) {

        return /*html*/ `
    <section class="form_seccion">
        <form class="form_datos form_desplegable form_seccion subrayado">
            <div class="form_fila rellena">
                <div class="form_boton despliega derecha">
                    Prestar un libro
                </div>

            </div>

            <div class="form_seccion se_despliega plegado">
                <label>Identificador del ejemplar:</label>
                <div class="form_fila">
                    <input name="nombre" class="form_input" type="number" required />
                    <span class="form_input_mensaje form_error ocultado"></span>
                </div>

                <div class="form_informacion">
                    <div class="form_subtitulo">Titulo del libro</div>


                </div>

                <label>Fecha Limite:</label>
                <div class="form_fila">
                    <input name="nombre" class="form_input" type="date" required />
                    <span class="form_input_mensaje form_error ocultado"></span>
                </div>

                <div class="form_fila">
                    <button class="form_boton derecha verde">Realizar prestamo</button>
                    <span class="form_input_mensaje form_error ocultado"></span>
                </div>

            </div>

        </form>
    </section>`;

    }

    cargarPaginaUsuario(data) {

        const pagina_prestamos = document.createElement("div");
        pagina_prestamos.innerHTML = this.cargarPrestamos(data.prestamos);

        const cont = document.createElement("div");
        cont.appendChild(pagina_prestamos);


        // var cont = /*html*/ `
        //         // // // // // // // // // // // // // // // // // // // // // // // // // ${this.cargarEstadoUsuario(data.usuario)}
        //         // // // // // // // // // // // // // // // // // // // // // // // // // `
        // if (data.usuario.socio_id) {

        // cont += /*html*/ `${this.cargarPrestamos(data.prestamos)}`;

        // if (data.estado_cuenta) {
        // cont += /*html*/ `${this.cargarEstadoCuenta(data.estado_cuenta)}`;
        // }
        // if (data.multas) {
        // cont += /*html*/ `${this.cargarMultas(data.multas)}`;
        // }
        // if (data.socio_habilitado) {
        // cont += /*html*/ `${this.cargarPrestarLibro(data.usuario)}`;
        // }
        // } else {

        // cont += this.cargarHacerSocio(data.usuario);
        // }

        return cont;

    }





    mostrarPaginaUsuario(data) {

        const contenido = document.createElement("div");
        contenido.classList.add("form_contendido");

        contenido.appendChild(this.cargarPaginaUsuario(data));

        this.colaPaginas.push(contenido);
    };



    async getUsuario(id) {
        const formData = new FormData();
        formData.append('accion', "usuario");
        formData.append('usuario_id', id);
        return Peticion.peticion(formData);
    }
    getForm() {
        return this.formulario;
    }
}