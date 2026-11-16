<!-- barra superior solo visible en móviles (menor a 768px) -->
<div class="col-12 d-md-none bg-dark text-white d-flex justify-content-between align-items-center px-3 py-2 sticky-top shadow-sm">
    <button class="btn btn-dark border-0 p-0 d-flex align-items-center" 
            type="button" 
            id="btn-toggle-sidebar" 
            data-bs-toggle="collapse" 
            data-bs-target="#sidebarMenu" 
            aria-controls="sidebarMenu" 
            aria-expanded="false" 
            aria-label="Toggle navigation">
        <i class="bi bi-list fs-1"></i>
    </button>
    <span class="fw-bold text-uppercase small" style="letter-spacing: 1px;">Gala Gym</span>
</div>

<!-- sidebar -->>
<nav class="col-md-3 col-lg-2 d-md-block bg-dark text-white min-vh-100 p-0 shadow collapse" id="sidebarMenu">
    <!-- encabezado y logo (oculto en phones) -->
    <div class="p-4 text-center mt-3 mb-2 d-none d-md-block">
        <img src="img/logo.jpg" alt="Logo Gala Gym" class="img-fluid rounded-circle shadow-lg border border-3 border-secondary border-opacity-25" style="width: 110px; height: 110px; object-fit: cover;">
    </div>

    <!-- menu principal -->
    <div class="mt-3 mt-md-2">
        <ul class="nav flex-column gap-1">
            
            <?php if($nivel == 1 || $nivel == 4): ?> <!-- se muestra el modulo segun el nivel/rol -->
            <li class="nav-item">
                <a href="?pagina=admin" class="nav-link text-white py-2 px-4 fw-bold d-flex align-items-center gap-3" style="font-size: 14px; letter-spacing: 0.5px;">
                    <i class="bi bi-bank fs-5 text-white-50"></i> <span>REPORTES</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if($nivel == 1 || $nivel == 4 || $nivel == 5): ?>
            <li class="nav-item">
                <a href="?pagina=clientes" class="nav-link text-white py-2 px-4 fw-bold d-flex align-items-center gap-3" style="font-size: 14px; letter-spacing: 0.5px;">
                    <i class="bi bi-person-standing fs-5 text-white-50"></i> <span>CLIENTES</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if($nivel == 1): ?>
            <li class="nav-item">
                <a href="?pagina=empleados" class="nav-link text-white py-2 px-4 fw-bold d-flex align-items-center gap-3" style="font-size: 14px; letter-spacing: 0.5px;">
                    <i class="bi bi-person-lines-fill fs-5 text-white-50"></i> <span>EMPLEADOS</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if($nivel == 1 || $nivel == 4): ?>
            <li class="nav-item">
                <a href="?pagina=clientes_pagos" class="nav-link text-white py-2 px-4 fw-bold d-flex align-items-center gap-3" style="font-size: 14px; letter-spacing: 0.5px;">
                    <i class="bi bi-cash-coin fs-5 text-white-50"></i> <span>PAGOS</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="?pagina=pagos" class="nav-link text-white py-2 px-4 fw-bold d-flex align-items-center gap-3" style="font-size: 14px; letter-spacing: 0.5px;">
                    <i class="bi bi-wallet2 fs-5 text-white-50"></i> <span>MÉTODOS DE PAGO</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="?pagina=membresias" class="nav-link text-white py-2 px-4 fw-bold text-uppercase d-flex align-items-center gap-3" style="font-size: 14px; letter-spacing: 0.5px;">
                    <i class="bi bi-currency-dollar fs-5 text-white-50"></i> <span>MEMBRESÍAS</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if($nivel == 1 || $nivel == 5): ?>
            <li class="nav-item">
                <a href="?pagina=ejercicio" class="nav-link text-white py-2 px-4 fw-bold d-flex align-items-center gap-3" style="font-size: 14px; letter-spacing: 0.5px;">
                    <i class="bi bi-lungs fs-5 text-white-50"></i> <span>EJERCICIOS</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="?pagina=rutinas" class="nav-link text-white py-2 px-4 fw-bold d-flex align-items-center gap-3" style="font-size: 14px; letter-spacing: 0.5px;">
                    <i class="bi bi-list-nested fs-5 text-white-50"></i> <span>RUTINAS</span>
                </a>
            </li>
            <?php endif; ?>

        </ul>
    </div>

    <!-- Botón de Salida -->
    <div class="mt-4 mt-md-5 mb-4">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="?pagina=salida" class="nav-link text-danger py-2 px-4 fw-bold d-flex align-items-center gap-3" style="font-size: 14px; letter-spacing: 0.5px;">
                    <i class="bi bi-box-arrow-left fs-5 text-danger"></i> <span>CERRAR SESIÓN</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<script src="js/menu.js"></script>