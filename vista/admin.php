<?php require_once("comunes/encabezado.php"); ?>

<div class="container-fluid">
    <div class="row">
        <!-- sidebar centralizado -->
        <?php require_once("comunes/menu.php"); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light" style="min-height: 100vh;">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom bg-white px-3 mt-3 shadow-sm">
                <h5 class="fw-bold text-uppercase m-0 small">Panel / Reportes Generales</h5>
            </div>

            <!-- CONTADORES DEL DASHBOARD -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-0 bg-dark text-white">
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
                    <div class="card shadow-sm border-0 rounded-0 bg-dark text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">Staff Activo</h6>
                                <h3 class="mb-0 fw-bold"><?php echo $total_empleados; ?></h3>
                            </div>
                            <i class="bi bi-person-badge-fill fs-1 text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div> <!-- Fin de la fila de contadores -->

            <!-- REPORTE DE CLIENTES ACTIVOS -->
            <div class="bg-white p-4 shadow-sm border mb-4">
                <h6 class="fw-bold m-0 text-uppercase mb-3"><i class="bi bi-people-fill text-dark"></i> Clientes</h6>
                <p class="text-muted small mb-4">Genera un listado en PDF de todos los clientes registrados y activos.</p>
                
                <form method="post" action="index.php?pagina=admin" id="form_clientes" target="_blank">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="filtro_membresia" class="form-label small fw-bold">Membresía (Opcional)</label>
                            <select class="form-select rounded-0 form-select-sm" id="filtro_membresia" name="filtro_membresia">
                                <option value="">Todas</option>
                                <option value="1">Mensualidad Estándar</option>
                                <option value="2">Semanal Estándar</option>
                                <option value="3">Diario Estándar</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-dark btn-sm rounded-0 px-4 fw-bold w-100 text-nowrap" name="accion" value="pdf_clientes">
                                <i class="bi bi-file-earmark-pdf"></i> GENERAR PDF
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- REPORTE DE EMPLEADOS -->
            <div class="bg-white p-4 shadow-sm border mb-4">
                <h6 class="fw-bold m-0 text-uppercase mb-3"><i class="bi bi-person-badge text-dark"></i> Personal (Staff)</h6>
                <p class="text-muted small mb-4">Listado del personal de Gala Gym y sus respectivos roles de acceso.</p>
                
                <form method="post" action="index.php?pagina=admin" id="form_empleados" target="_blank">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="filtro_rol" class="form-label small fw-bold">Rol (Opcional)</label>
                            <select class="form-select rounded-0 form-select-sm" id="filtro_rol" name="filtro_rol">
                                <option value="">Todos</option>
                                <option value="1">Administradores</option>
                                <option value="2">Usuarios</option>
                                <option value="4">Recepcionistas</option>
                                <option value="5">Entrenadores</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-dark btn-sm rounded-0 px-4 fw-bold w-100 text-nowrap" name="accion" value="pdf_empleados">
                                <i class="bi bi-file-earmark-pdf"></i> GENERAR PDF
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- REPORTE DE PAGOS -->
            <div class="bg-white p-4 shadow-sm border mb-4">
                <h6 class="fw-bold m-0 text-uppercase mb-3"><i class="bi bi-cash-coin text-dark"></i> Pagos e Ingresos</h6>
                <p class="text-muted small mb-4">Filtra los pagos registrados en el sistema por rango de fechas.</p>
                
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