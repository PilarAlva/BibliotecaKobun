// Archivo JavaScript principal.

/* Menú hamburguesa */
document.addEventListener("DOMContentLoaded", function() {
    
    const hamburgerButton = document.querySelector(".hamburger-menu");
    const mainNav = document.querySelector(".main-nav"); // Corregido: de ID a clase

    if (hamburgerButton && mainNav) {
        hamburgerButton.addEventListener("click", function() {
            mainNav.classList.toggle("is-active");
            const isExpanded = mainNav.classList.contains("is-active");
            hamburgerButton.setAttribute("aria-expanded", isExpanded);
        });
    }
});

/* Menú hamburguesa para PERFIL */
document.addEventListener('DOMContentLoaded', function () {
    const perfilNavToggle = document.querySelector('#perfil-nav-toggle');
    const navPerfil = document.querySelector('.nav-perfil');

    if (perfilNavToggle && navPerfil) {
        perfilNavToggle.addEventListener('click', function () {
            navPerfil.classList.toggle('is-active');
            const isExpanded = navPerfil.classList.contains('is-active');
            this.setAttribute('aria-expanded', isExpanded);
        });
    }
});
