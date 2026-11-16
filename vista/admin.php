<?php require_once("comunes/encabezado.php"); ?>

<div class="container-fluid">
    <div class="row">
        <!-- sidebar centralizado -->
        <?php require_once("comunes/menu.php"); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light" style="min-height: 100vh;">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom bg-white px-3 mt-3 shadow-sm">
                <h5 class="fw-bold text-uppercase m-0 small">Panel / Reportes</h5>
            </div>

            <!-- CONTADORES DEL DASHBOARD (CLIENTES Y STAFF) -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-0 bg-dark text-white h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">Clientes Activos</h6>
                                <h3 class="mb-0 fw-bold"><?php echo $total_clientes; ?></h3>
                            </div>
                            <i class="bi bi-people-fill fs-1 text-secondary"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-0 bg-dark text-white h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">Staff Activo</h6>
                                <h3 class="mb-0 fw-bold"><?php echo $total_empleados; ?></h3>
                            </div>
                            <i class="bi bi-person-badge-fill fs-1 text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ESTADÍSTICAS FINANCIERAS PRINCIPALES -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-0 bg-white h-100">
                        <div class="card-body">
                            <h6 class="text-uppercase mb-1 small fw-bold text-muted">Ganancias</h6>
                            <h3 class="mb-0 fw-bold text-success">$<?php echo number_format($stats_pagos['total_ingresos'], 2); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-0 bg-white h-100">
                        <div class="card-body">
                            <h6 class="text-uppercase mb-1 small fw-bold text-muted">Promedio de Pagos</h6>
                            <h3 class="mb-0 fw-bold text-success">$<?php echo number_format($stats_pagos['promedio_ingresos'], 2); ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ESTADO DE TRANSACCIONES -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-0 bg-white border-start border-4 border-success h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-1 small fw-bold text-muted">Aprobados</h6>
                                <h4 class="mb-0 fw-bold text-dark"><?php echo $stats_pagos['aprobados']; ?></h4>
                            </div>
                            <i class="bi bi-check-circle-fill fs-2 text-success opacity-75"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-0 bg-white border-start border-4 border-warning h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-1 small fw-bold text-muted">Pendientes</h6>
                                <h4 class="mb-0 fw-bold text-dark"><?php echo $stats_pagos['pendientes']; ?></h4>
                            </div>
                            <i class="bi bi-clock-fill fs-2 text-warning opacity-75"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-0 bg-white border-start border-4 border-danger h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-1 small fw-bold text-muted">Rechazados</h6>
                                <h4 class="mb-0 fw-bold text-dark"><?php echo $stats_pagos['rechazados']; ?></h4>
                            </div>
                            <i class="bi bi-x-circle-fill fs-2 text-danger opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- REPORTE DE PAGOS -->
            <div class="bg-white p-4 shadow-sm border mb-4">
                <h6 class="fw-bold m-0 text-uppercase mb-3"><i class="bi bi-cash-coin text-dark"></i> Generar Reporte de Pagos</h6>
                <p class="text-muted small mb-4">Filtra los pagos aprobados registrados en el sistema por rango de fechas para exportar un PDF.</p>
                
                <form method="post" action="index.php?pagina=admin" id="form_pagos" target="_blank">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="fecha_inicio" class="form-label small fw-bold">Desde</label>
                            <input type="date" class="form-control rounded-0 form-control-sm" id="fecha_inicio" name="fecha_inicio" required>
                        </div>
                        <div class="col-md-3">
                            <label for="fecha_fin" class="form-label small fw-bold">Hasta</label>
                            <input type="date" class="form-control rounded-0 form-control-sm" id="fecha_fin" name="fecha_fin" required>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-dark btn-sm rounded-0 px-4 fw-bold w-100 text-nowrap" name="accion" value="pdf_pagos">
                                <i class="bi bi-file-earmark-pdf"></i> GENERAR PDF
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </main>
    </div>
</div>

<?php require_once("comunes/pie.php"); ?>