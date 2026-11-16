document.addEventListener('DOMContentLoaded', function () {
    const sidebarMenu = document.getElementById('sidebarMenu');
    const btnToggle = document.getElementById('btn-toggle-sidebar');

    if (!sidebarMenu || !btnToggle) return;

    function ocultarMenuMovil() {
        const bsCollapse = bootstrap.Collapse.getOrCreateInstance(sidebarMenu, { toggle: false });
        bsCollapse.hide();
    }

    // Cerrar el menú si se hace clic fuera de él o del botón
    document.addEventListener('click', function (event) {
        if (sidebarMenu.classList.contains('show')) {
            if (!sidebarMenu.contains(event.target) && !btnToggle.contains(event.target)) {
                ocultarMenuMovil();
            }
        }
    });

    // Cerrar el menú al tocar cualquiera de los enlaces
    sidebarMenu.querySelectorAll('.nav-link').forEach(function (link) {
        link.addEventListener('click', function () {
            if (sidebarMenu.classList.contains('show')) {
                ocultarMenuMovil();
            }
        });
    });
});