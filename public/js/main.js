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