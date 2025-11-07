class Formulario {
    constructor(formulario) {
        
    this.colaPaginas = [formulario.querySelector(".form_contenido")];
    this.formulario = formulario;
    const btn = document.querySelectorAll(".form_boton.despliega");
    const btn_retroceso = formulario.querySelector("#btn-retroceso");
    const btn_cerrar = formulario.querySelector("#btn-cerrar");

    btn_retroceso.addEventListener("click", ()=>{ 
        this.retroceder();
    });
    btn_cerrar.addEventListener("click", ()=>{} );





    btn.forEach((boton)=>{
        //console.log(boton);
        boton.addEventListener("click",()=>{
            
            //this.usuarios();

            var seccion = boton.closest(".seccion_formulario");
            var ocultar = seccion.querySelectorAll(".se_oculta");
            var plegar = seccion.querySelectorAll(".se_despliega");

            if(ocultar){
                ocultar.forEach((node)=>{ node.classList.toggle("ocultado") });
            }
            if(plegar){
                plegar.forEach((node)=>{ 
                    node.classList.toggle("desplegado");
                    node.classList.toggle("plegado");
                });
            }


        });
    })
    

    }

    async editarUsuario(id) {
        
            const usuarioData = await this.getUsuario(id);
            
            this.cargarPaginaUsuario(usuarioData.data.usuario);
            
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

    retroceder(){
        //TODO: falta chquear que no esté vacia la cola
        //TODO: falta chquear que no se cargue dos veces la misma página
        this.colaPaginas.pop();
        this.mostrarPagina();
    }

    mostrarPagina(){

        const contenido = this.formulario.querySelector(".form_contenido");
        console.log("paginas: " + this.colaPaginas)
        console.log("contendio: " + contenido)
        //Muestra la última página en la cola
        const pagina = this.colaPaginas.slice(-1)[0];
        contenido.innerHTML = pagina.innerHTML;

        const btn = document.querySelectorAll(".form_boton.despliega");



        btn.forEach((boton)=>{
            //console.log(boton);
            boton.addEventListener("click",()=>{
                
                //this.usuarios();

                var seccion = boton.closest(".seccion_formulario");
                var ocultar = seccion.querySelectorAll(".se_oculta");
                var plegar = seccion.querySelectorAll(".se_despliega");

                if(ocultar){
                    ocultar.forEach((node)=>{ node.classList.toggle("ocultado") });
                }
                if(plegar){
                    plegar.forEach((node)=>{ 
                        node.classList.toggle("desplegado");
                        node.classList.toggle("plegado");
                    });
                }


            });
        })

        // if (formTitle) {
        //     formTitle.innerHTML = `${usuarioData.data.usuario.nombre} ${usuarioData.data.usuario.apellido}`;
        // } else {
        //     console.error("Elemento '.form_titulo' no encontrado.");
        // }
    }   
    cargarPaginaUsuario(usuario){

        const contenido = document.createElement("div");
        contenido.classList.add("form_contendido");
        
        contenido.innerHTML = `
           <div class="form_titulo subrayado">${usuario.nombre} ${usuario.apellido}</div>

                    <section class="form_seccion subrayado">

                        <div class="form_informacion">
                            
                            <div class="form_fila">
                                <span>Correo: ${usuario.mail}</span>
                            </div>
                            <div class="form_fila">
                                <span>Tipo de Usuario: General </span>
                            </div>
                            <div class="form_fila">
                                <span>Socio: No </span>
                            </div>
                        </div>
                        
                    </section>

                    <section class="form_seccion">

                        <div class="form_fila">
                            
                            <div class="form_error">
                                Acá iria un error
                            </div>

                        </div>

                        <div class="form_fila">

                                <div class="seccion_formulario form_desplegable">
            
                                    <button class="form_boton despliega">Hacer Socio</button> 

                                    <div class="form_desplegable_cont se_despliega plegado">
                                        <form class="form_datos"> 
                                            <label>Nombre</label>
                                            <input class="form_input" type="text" value="${usuario.nombre}"/>
                                            <label>Apellido</label>
                                            <input class="form_input" type="text" value="${usuario.apellido}/>
                                            <label>DNI</label>
                                            <input class="form_input" type="text" value="${usuario.dni}/>
                                            wtf
                                        </form>
                                    <div>
                                
                                </div>
                                
                            </div>
                            
                        </div>

                    </section>
        `;
        
        this.colaPaginas.push(contenido);


    }

    async getUsuario(id){
        const formData = new FormData();
        formData.append('accion', "usuario");
        formData.append('usuario_id', id);

        return this.peticion(formData);
    }

    async peticion(formData){
        
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

   

  getForm() {
    return this.formulario;
  }
}

    /*ACA HACE TODAS LAS PETICIONES */

document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.nav-perfil .nav-link');
    const tabContents = document.querySelectorAll('.contenido-perfil .tab-content');

    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
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


window.addEventListener("load", ()=>{

    console.log("Cargado");
    
    /*Esta es la clase que se va a encargar de manejar la edicion de la informacion */
    console.log(document.getElementById("formulario"));
    const formulario = new Formulario(document.getElementById("formulario"));
    console.log("nothing changed?" + formulario.getForm());

    console.log(formulario.getForm() instanceof HTMLFormElement); // true
    //console.log(formulario.getForm().tagName); // FORM
    /*BOTONES*/

    btn_mas_info_usuarios = document.querySelectorAll("#bt-mas-info-usuario");
    

    /*SUS 4millones de events */

    btn_mas_info_usuarios.forEach((boton)=>{ 

        //console.log(boton);
        
        boton.addEventListener("click", 
            function (event){
                
                usuarioID = boton.dataset.usuario;
                masInfoUsuario(usuarioID);

            })});


    
    function masInfoUsuario(id){
        
        formulario.editarUsuario(id);
        
    }    
   

    
});    






