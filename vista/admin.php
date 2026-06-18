<?php require_once("comunes/encabezado.php"); ?>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-dark text-white min-vh-100 p-0 shadow">
            <div class="p-4 border-bottom border-secondary text-center">
                <h4 class="fw-bold m-0 text-uppercase" style="letter-spacing: 2px;">Admin</h4>
            </div>
            
            <div class="mt-2">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="?pagina=admin" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold">DASHBOARD</a>
                    </li>
                    <li class="nav-item">
                        <a href="?pagina=clientes" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold">GESTIONAR CLIENTES</a>
                    </li>
                    <li class="nav-item">
                        <a href="?pagina=empleados" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold">GESTIONAR EMPLEADOS</a>
                    </li>
                    <li class="nav-item">
                        <a href="?pagina=pagos" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold">GESTIONAR METODOS DE PAGO</a>
                    </li>
                    <li class="nav-item">
                        <a href="?pagina=membresias" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold text-uppercase">Gestionar Membresias</a>
                    </li>
                </ul>
            </div>

            <div class="p-4 mt-5">
                <a href="?pagina=principal" class="btn btn-outline-danger btn-sm w-100 rounded-0 fw-bold">CERRAR SESIÓN</a>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom bg-white px-3 mt-3 shadow-sm">
                <h5 class="fw-bold text-uppercase m-0 small">Panel / Dashboard</h5>
                <div class="d-flex align-items-center">
                    <span class="small fw-bold me-3 text-muted">Hola, Admin</span>
                    <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 35px; height: 35px; font-size: 0.8rem;">
                        CE
                    </div>
                </div>
            </div>

            <div class="p-2">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-0 bg-white p-3 border-start border-dark border-4">
                            <h6 class="text-muted small fw-bold text-uppercase">Clientes</h6>
                            <h2 class="fw-bold m-0">0</h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-0 bg-white p-3 border-start border-primary border-4">
                            <h6 class="text-muted small fw-bold text-uppercase">Ingresos Mensuales</h6>
                            <h2 class="fw-bold m-0">$0</h2>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once("comunes/pie.php"); ?>