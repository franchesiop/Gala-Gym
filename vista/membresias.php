<?php require_once("comunes/encabezado.php"); ?>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-dark text-white min-vh-100 p-0 shadow">
            <div class="p-4 border-bottom border-secondary text-center">
                <h4 class="fw-bold m-0 text-uppercase" style="letter-spacing: 2px;">Admin</h4>
            </div>
            <div class="mt-2">
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="?pagina=admin" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold">REPORTES</a></li>
                    <li class="nav-item"><a href="?pagina=clientes" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold">GESTIONAR CLIENTES</a></li>
                    <li class="nav-item"><a href="?pagina=empleados" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold">GESTIONAR EMPLEADOS</a></li>
                    <li class="nav-item"><a href="?pagina=pagos" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold">GESTIONAR METODOS DE PAGO</a></li>
                    <li class="nav-item"><a href="?pagina=membresias" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold text-uppercase">Gestionar Membresias</a></li>
                    <li class="nav-item"><a href="?pagina=membresias" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold text-uppercase">GESTIONAR ROLES</a></li>
                </ul>
            </div>
            <div class="p-4 mt-5">
                <a href="?pagina=principal" class="btn btn-outline-danger btn-sm w-100 rounded-0 fw-bold">CERRAR SESIÓN</a>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light min-vh-100">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom bg-white px-3 mt-3 shadow-sm">
                <h5 class="fw-bold text-uppercase m-0 small">Panel / Membresías</h5>
            </div>

            <div class="bg-white p-4 shadow-sm border">
                <div class="d-flex justify-content-between mb-4">
                    <h6 class="fw-bold m-0 text-uppercase">Tipos de Membresía</h6>
                    <button type="button" class="btn btn-dark btn-sm rounded-0 px-3 fw-bold" id="btnNuevoPlan">NUEVO PLAN</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle small" id="tablaMembresias">
                        <thead class="table-light text-muted">
                            <tr><th>ID</th><th>TIPO DE PLAN</th><th>COSTO</th><th class="text-center">ACCIONES</th></tr>
                        </thead>
                        <tbody class="fw-bold" id="cuerpoTablaMembresias"></tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="modalMembresia" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content rounded-0 border-0 shadow">
       <div class="modal-header bg-dark text-white rounded-0">
         <h5 class="modal-title fw-bold small text-uppercase">Editar Membresía</h5>
         <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body p-4">
            <form id="formMembresia">
                <input type="hidden" id="idMembresia"> 
                <div class="mb-3">
                    <label class="form-label small fw-bold">Tipo de Plan / Nombre</label>
                    <input type="text" class="form-control rounded-0" id="nombrePlan" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Costo ($)</label>
                    <input type="number" step="0.01" class="form-control rounded-0" id="costoPlan" required>
                </div>
            </form>
       </div>
       <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-danger rounded-0 small fw-bold" id="eliminar">ELIMINAR</button>
          <div>
            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary rounded-0 small fw-bold">CANCELAR</button>
            <button type="button" class="btn btn-dark rounded-0 small fw-bold px-4" id="btnGuardar">MODIFICAR</button>
          </div>
       </div>
    </div>
   </div>
</div>

<?php require_once("comunes/pie.php"); ?>
<script src="js/membresias.js"></script>