<?php 
require_once("comunes/encabezado.php"); 
?>

<div class="container-fluid">
    <div class="row">
        
        <!-- Sidebar centralizado -->
        <?php require_once("comunes/menu.php"); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light min-vh-100">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom bg-white px-3 mt-3 shadow-sm">
                <h5 class="fw-bold text-uppercase m-0 small">Panel / Membresías</h5>
            </div>

            <div class="bg-white p-4 shadow-sm border">
                
                <!-- Botón de registrar suelto (DataTables inyectará su buscador y selector arriba automáticamente) -->
                <button type="button" class="btn btn-dark btn-sm rounded-0 px-3 fw-bold text-nowrap mb-3" id="btnNuevoPlan">
                    REGISTRAR
                </button>

                <div class="table-responsive">
                    <table class="table table-hover align-middle small w-100" id="tablaMembresias">
                        <thead class="table-light text-muted">
                            <tr>
                                <!-- Columna oculta para el ID -->
                                <th class="d-none">ID</th>
                                
                                <!-- Columnas visibles -->
                                <th><i class="bi bi-briefcase-fill"></i> TIPO DE PLAN</th>
                                <th><i class="bi bi-cash-coin"></i> COSTO</th>
                                <th class="text-center"><i class="bi bi-gear"></i> OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold"></tbody>
                    </table>
                </div>

            </div>
        </main>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalMembresia" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content rounded-0 border-0 shadow">
       <div class="modal-header bg-dark text-white rounded-0">
         <h5 class="modal-title fw-bold small text-uppercase">Gestión de Membresía</h5>
         <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body p-4">
            <form id="formMembresia">
                <input type="hidden" id="idMembresia"> 
                
                <div class="mb-3">
                    <label class="form-label small fw-bold">TIPO DE PLAN</label>
                    <input type="text" class="form-control rounded-0" id="nombrePlan" required>
                    <!-- SPAN PARA EL ERROR DEL NOMBRE -->
                    <span id="snombrePlan" class="text-danger small"></span>
                </div>
                
                <div class="mb-3">
                    <label class="form-label small fw-bold">COSTO ($)</label>
                    <input type="text" class="form-control rounded-0" id="costoPlan" required>
                    <!-- SPAN PARA EL ERROR DEL COSTO -->
                    <span id="scostoPlan" class="text-danger small"></span>
                </div>
            </form>
       </div>
       <div class="modal-footer d-flex justify-content-between">
          <div class="ms-auto">
            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary rounded-0 small fw-bold me-2">CANCELAR</button>
            <button type="button" class="btn btn-dark rounded-0 small fw-bold px-4" id="btnGuardar">MODIFICAR</button>
          </div>
       </div>
    </div>
   </div>
</div>

<?php 
require_once("comunes/pie.php"); 
?>
<script src="js/membresias.js"></script>