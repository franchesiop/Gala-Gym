<?php require_once("comunes/encabezado.php"); ?>

<div class="container-fluid">
    <div class="row">
        <?php require_once("comunes/menu.php"); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light min-vh-100">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom bg-white px-3 mt-3 shadow-sm">
                <h5 class="fw-bold text-uppercase m-0 small">Panel / Rutinas</h5>
            </div>

            <div class="bg-white p-4 shadow-sm border">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
                    <h6 class="fw-bold m-0 text-uppercase"><i class="bi bi-clipboard2-pulse"></i> Rutinas</h6>
                    <div class="d-flex gap-2 align-items-center" style="max-width: 450px; width: 100%;">
                        <input type="text" class="form-control form-control-sm rounded-0" id="buscar_rutina" placeholder="Buscar...">
                        <button type="button" class="btn btn-dark btn-sm rounded-0 px-3 fw-bold text-nowrap" id="btnNuevaRutina">
                            REGISTRAR
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle small" id="tablaRutinas">
                        <thead class="table-light">
                            <tr class="text-muted">
                                <th style="display:none">ID</th>
                                <th><i class="bi bi-card-text"></i> NOMBRE DE RUTINA</th>
                                <th><i class="bi bi-person-badge"></i> ENTRENADOR</th>
                                <th><i class="bi bi-person-check"></i> CLIENTE ASIGNADO</th>
                                <th class="text-center"><i class="bi bi-gear"></i> OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold" id="cuerpoTablaRutinas"></tbody>
                    </table>
                </div>

                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-3 pt-3 border-top gap-2">
                    <span class="text-muted small" id="infoPaginacion">Mostrando 0 rutinas</span>
                    <nav>
                        <ul class="pagination pagination-sm m-0" id="contenedorPaginacion"></ul>
                    </nav>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modal Gestión de Rutina -->
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
   <div class="modal-dialog modal-lg modal-dialog-centered"> 
     <div class="modal-content rounded-0 border-0 shadow">
       <div class="modal-header bg-dark text-white rounded-0">
         <h5 class="modal-title fw-bold small text-uppercase">Gestión de Rutina</h5>
         <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body p-4">
            <form id="formRutina">
                <input type="hidden" id="idRutina" name="idRutina">
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">NOMBRE DE LA RUTINA</label>
                        <input type="text" class="form-control rounded-0" id="nombreRutina" name="nombreRutina" placeholder="Ej: HIPERMAXHULKGOLku" required>
                        <span id="snombreRutina" class="text-danger small"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">ASIGNAR A CLIENTE</label>
                        <div class="input-group">
                            <input type="hidden" id="idCliente" name="idCliente">
                            <input type="text" class="form-control rounded-0 border-end-0 bg-white" id="clienteInfo" placeholder="Seleccione un cliente..." readonly required>
                            <button class="btn btn-dark rounded-0 px-3 fw-bold text-nowrap" type="button" id="listarClienteBtn">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                        </div>
                        <span id="sCliente" class="text-danger small"></span>
                    </div>
                </div>

                <hr>
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold small m-0"><i class="bi bi-activity"></i> EJERCICIOS DE LA RUTINA</h6>
                    <button type="button" class="btn btn-outline-dark btn-sm rounded-0 fw-bold" id="btnAgregarEjercicio">
                        <i class="bi bi-plus-lg"></i> AÑADIR EJERCICIO
                    </button>
                </div>

                <div class="row mb-1 text-muted border-bottom pb-1">
                    <div class="col-5"><label class="form-label small fw-bold m-0">EJERCICIO</label></div>
                    <div class="col-3"><label class="form-label small fw-bold m-0">SERIES</label></div>
                    <div class="col-3"><label class="form-label small fw-bold m-0">REPS</label></div>
                    <div class="col-1"></div>
                </div>

                <div id="contenedorEjercicios" class="mt-2"></div>
                <span id="sEjercicios" class="text-danger small"></span>
            </form>
       </div>
       <div class="modal-footer d-flex justify-content-between bg-light">
          <div class="ms-auto">
            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary rounded-0 small fw-bold me-2">CANCELAR</button>
            <button type="button" class="btn btn-dark rounded-0 small fw-bold px-4 text-uppercase" id="btnGuardar">INCLUIR</button>
          </div>
       </div>
    </div>
   </div>
</div>

<!-- Modal Listado de Clientes -->
<div class="modal fade" id="modal_clientes" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-0 border-0 shadow">
            <div class="modal-header bg-dark text-white rounded-0">
                <h5 class="modal-title fw-bold small text-uppercase">Listado de Clientes</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <input type="text" class="form-control form-control-sm rounded-0" id="filtrarClientesModal" placeholder="Filtrar por cédula, nombre o apellido...">
                </div>
                <div class="table-responsive rounded-0 border" style="height: 350px; overflow-y: auto;">
                    <table class="table table-hover text-center align-middle mb-0 small w-100">
                        <thead class="table-light text-muted sticky-top">
                            <tr>
                                <th style="display:none">ID</th>
                                <th>Cédula</th>
                                <th>Nombre y Apellido</th>
                                <th>Teléfono</th>
                            </tr>
                        </thead>
                        <tbody id="listaClientesModal" class="fw-bold"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Listado de Ejercicios -->
<div class="modal fade" id="modal_ejercicios" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-0 border-0 shadow">
            <div class="modal-header bg-dark text-white rounded-0">
                <h5 class="modal-title fw-bold small text-uppercase">Catálogo de Ejercicios</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <input type="hidden" id="filaEjercicioActual">
                    <input type="text" class="form-control form-control-sm rounded-0" id="filtrarEjerciciosModal" placeholder="Filtrar por nombre de ejercicio...">
                </div>
                <div class="table-responsive rounded-0 border" style="height: 350px; overflow-y: auto;">
                     <table class="table table-hover align-middle mb-0 small w-100">
                        <thead class="table-light text-muted sticky-top">
                            <tr>
                                <th style="display:none">ID</th>
                                <th class="text-center" style="width: 80px;">Imagen</th>
                                <th>Nombre del Ejercicio</th>
                            </tr>
                        </thead>
                        <tbody id="listaEjerciciosModal" class="fw-bold"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once("comunes/modal.php"); ?>
<?php require_once("comunes/modal_eliminar.php"); ?>
<?php require_once("comunes/pie.php"); ?>
<script src="js/rutinas.js?v=<?php echo time(); ?>"></script>