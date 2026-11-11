<nav class="col-md-3 col-lg-2 d-md-block bg-dark text-white min-vh-100 p-0 shadow" id="sidebarMenu">
    <!-- encabezado y Logo -->
    <div class="p-4 text-center mt-3 mb-2">
        <img src="img/logo.jpg" alt="Logo Gala Gym" class="img-fluid rounded-circle shadow-lg border border-3 border-secondary border-opacity-25" style="width: 120px; height: 120px; object-fit: cover;">
    </div>

    <!-- menu principal sin -->
    <div class="mt-2">
        <ul class="nav flex-column gap-1">
            
            <?php if($nivel == 1 || $nivel == 4): ?>
            <li class="nav-item">
                <a href="?pagina=admin" class="nav-link text-white py-3 px-4 small fw-bold d-flex align-items-center gap-3">
                    <i class="bi bi-bank fs-5 text-white-50"></i> <span>REPORTES</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if($nivel == 1 || $nivel == 4 || $nivel == 5): ?>
            <li class="nav-item">
                <a href="?pagina=clientes" class="nav-link text-white py-3 px-4 small fw-bold d-flex align-items-center gap-3">
                    <i class="bi bi-person-standing fs-5 text-white-50"></i> <span>CLIENTES</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if($nivel == 1): ?>
            <li class="nav-item">
                <a href="?pagina=empleados" class="nav-link text-white py-3 px-4 small fw-bold d-flex align-items-center gap-3">
                    <i class="bi bi-person-lines-fill fs-5 text-white-50"></i> <span>EMPLEADOS</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if($nivel == 1 || $nivel == 4): ?>
            <li class="nav-item">
                <a href="?pagina=clientes_pagos" class="nav-link text-white py-3 px-4 small fw-bold d-flex align-items-center gap-3">
                    <i class="bi bi-cash-coin fs-5 text-white-50"></i> <span>PAGOS</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="?pagina=pagos" class="nav-link text-white py-3 px-4 small fw-bold d-flex align-items-center gap-3">
                    <i class="bi bi-wallet2 fs-5 text-white-50"></i> <span>MÉTODOS DE PAGO</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="?pagina=membresias" class="nav-link text-white py-3 px-4 small fw-bold text-uppercase d-flex align-items-center gap-3">
                    <i class="bi bi-currency-dollar fs-5 text-white-50"></i> <span>MEMBRESÍAS</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if($nivel == 1 || $nivel == 5): ?>
            <li class="nav-item">
                <a href="?pagina=ejercicio" class="nav-link text-white py-3 px-4 small fw-bold d-flex align-items-center gap-3">
                    <i class="bi bi-lungs fs-5 text-white-50"></i> <span>EJERCICIOS</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="?pagina=rutinas" class="nav-link text-white py-3 px-4 small fw-bold d-flex align-items-center gap-3">
                    <i class="bi bi-list-nested fs-5 text-white-50"></i> <span>RUTINAS</span>
                </a>
            </li>
            <?php endif; ?>

        </ul>
    </div>

    <!-- boton de Salida -->
    <div class="px-4 mt-5 mb-4">
        <a href="?pagina=salida" class="btn btn-outline-danger w-100 rounded-3 py-2 fw-bold small">CERRAR SESIÓN</a>
    </div>
</nav>