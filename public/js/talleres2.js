/* JavaScript vinculado a talleres.php para el ocultamiento o visualización de "Todos los Talleres" y "Mis Talleres" */

window.addEventListener("DOMContentLoaded", function() {

    // Obtener los botones
    const btnTodosTalleres = document.getElementById('btn_todos_talleres');
    const btnMisTalleres = document.getElementById('btn_mis_talleres');

    // Obtener las secciones
    const sectionTodosTalleres = document.getElementById('talleres_section_todos_los_talleres');
    const sectionMisTalleres = document.getElementById('talleres_section_mis_talleres');

    // Verificar que todos los elementos existan para evitar errores
    if (btnTodosTalleres && btnMisTalleres && sectionTodosTalleres && sectionMisTalleres) {

        // Event listener para el botón "Todos los talleres"
        btnTodosTalleres.addEventListener('click', function() {
            // Gestionar estilos de los botones
            btnTodosTalleres.classList.add('selected');
            btnMisTalleres.classList.remove('selected');

            // Gestionar visibilidad de las secciones
            sectionTodosTalleres.removeAttribute('hidden');
            sectionMisTalleres.setAttribute('hidden', '');
        });

        // Event listener para el botón "Mis talleres"
        btnMisTalleres.addEventListener('click', function() {
            // Gestionar estilos de los botones
            btnMisTalleres.classList.add('selected');
            btnTodosTalleres.classList.remove('selected');

            // Gestionar visibilidad de las secciones
            sectionMisTalleres.removeAttribute('hidden');
            sectionTodosTalleres.setAttribute('hidden', '');
        });
    }
});
