
export class DomUpdater {

  
    static update(contenedor, contenidoHtml) {
        const elemento = document.querySelector(selector);
        if (elemento) {
            elemento.innerHTML = contenidoHtml;
        } else {
            console.warn(`DomUpdater: No se encontró ningún elemento con el selector "${selector}".`);
        }
    }

    static render(contenedor, datos, funcionPlantilla) {
        
        if (!contenedor) {
            console.warn(`DomUpdater: No se encontró el contenedor con el selector`);
            return;
        }

        if (!Array.isArray(datos)) {
            console.error(`DomUpdater: Los datos proporcionados deben ser un array.`);
            return;
        }

        if (typeof funcionPlantilla !== 'function') {
            console.error(`DomUpdater: La plantilla proporcionada debe ser una función.`);
            return;
        }

        // Mapea cada objeto de dato a un string de HTML usando la plantilla y los une.
        const todoElHtml = datos.map(funcionPlantilla).join('');
        contenedor.innerHTML = todoElHtml;
    }
}


/*
// ---------------- CÓMO USARLO ----------------

// 1. Asegúrate de incluir este script en tu archivo HTML:
//    <script src="js/test.js"></script>


// 2. EJEMPLO DE USO PARA `DomUpdater.update`:
//    Supongamos que tienes un <h1> en tu HTML: <h1 id="titulo-principal">Hola Mundo</h1>

//    Para cambiar su contenido desde otro script, simplemente llamas a:
//    DomUpdater.update('#titulo-principal', '¡Título actualizado desde JS!');


// 3. EJEMPLO DE USO PARA `DomUpdater.render`:
//    Supongamos que tienes una lista vacía en tu HTML: <ul id="lista-de-usuarios"></ul>
//    Y tienes un array de usuarios:
const usuarios = [
    { id: 1, nombre: 'Ana', email: 'ana@correo.com' },
    { id: 2, nombre: 'Luis', email: 'luis@correo.com' },
    { id: 3, nombre: 'Carla', email: 'carla@correo.com' }
];

//    Primero, crea una función que defina la plantilla para UN SOLO usuario:
const plantillaDeUsuario = (usuario) => {
    return `
        <li data-id="${usuario.id}">
            <strong>${usuario.nombre}</strong>
            <span>(${usuario.email})</span>
        </li>
    `;
};

//    Finalmente, llama a `render` para poblar la lista con tus datos y tu plantilla:
//    DomUpdater.render('#lista-de-usuarios', usuarios, plantillaDeUsuario);

//    Esto generará dinámicamente el HTML para cada usuario y lo insertará en el <ul>.

*/
