<?php require_once("comunes/encabezado.php"); ?>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-dark text-white min-vh-100 p-0 shadow">
            <div class="p-4 border-bottom border-secondary text-center">
                <h4 class="fw-bold m-0 text-uppercase" style="letter-spacing: 2px;">GALA GYM</h4>
            </div>
            <div class="mt-2">
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="?pagina=admin" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold"><i class="bi bi-bank"></i> REPORTES</a></li>
                    <li class="nav-item"><a href="?pagina=clientes" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold"><i class="bi bi-person-standing"></i> CLIENTES</a></li>
                    <li class="nav-item"><a href="?pagina=empleados" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold"><i class="bi bi-person-lines-fill"></i> EMPLEADOS</a></li>
                    <li class="nav-item"><a href="?pagina=pagos" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold"><i class="bi bi-wallet2"></i> METODOS DE PAGO</a></li>
                    <li class="nav-item"><a href="?pagina=membresias" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold text-uppercase"><i class="bi bi-currency-dollar"></i> MEMBRESIAS</a></li>
                    <li class="nav-item"><a href="?pagina=roles" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold text-uppercase"><i class="bi bi-person-workspace"></i> ROLES</a></li>
                    <li class="nav-item"><a href="?pagina=ejercicio" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold"><i class="bi bi-lungs"></i> EJERCICIOS</a></li>
                    <li class="nav-item"><a href="?pagina=rutinas" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold"><i class="bi bi-lungs"></i> RUTINAS</a></li>
                </ul>
            </div>
            <div class="p-4 mt-5">
                <a href="?pagina=principal" class="btn btn-outline-danger btn-sm w-100 rounded-0 fw-bold">CERRAR SESIÓN</a>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light min-vh-100">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom bg-white px-3 mt-3 shadow-sm">
                <h5 class="fw-bold text-uppercase m-0 small">Panel / Roles</h5>
            </div>

            <div class="bg-white p-4 shadow-sm border">
                <div class="d-flex justify-content-between mb-4">
                    <h6 class="fw-bold m-0 text-uppercase"><i class="bi bi-person-rolodex"></i> Roles</h6>
                    <button type="button" class="btn btn-dark btn-sm rounded-0 px-3 fw-bold" id="btnNuevoRol">REGISTRAR</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle small" id="tablaRoles">
                        <thead class="table-light text-muted">
                            <tr><th style="display:none">ID</th><th><i class="bi bi-ui-checks-grid"></i>TIPO DE ROL</th><th><i class="bi bi-text-paragraph"></i> DESCRIPCION</th><th class="text-center"><i class="bi bi-gear"></i> OPCIONES</th></tr>
                        </thead>
                        <tbody class="fw-bold" id="cuerpoTablaRoles"></tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="modalRol" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content rounded-0 border-0 shadow">
       <div class="modal-header bg-dark text-white rounded-0">
         <h5 class="modal-title fw-bold small text-uppercase">Editar Rol</h5>
         <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body p-4">
            <form id="formRol">
                <input type="hidden" id="idRol"> 
                <div class="mb-3">
                    <label class="form-label small fw-bold">Tipo de Rol / Nombre</label>
                    <input type="text" class="form-control rounded-0" id="nombreRol" required>
                    <span id="snombreRol" class="text-danger small"></span>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">DESCRIPCION</label>
                        <input type="text" class="form-control rounded-0" id="descripcionRol" name="descripcionRol" required>
                        <span id="sdescripcionRol" class="text-danger small"></span>
                    </div>
                </div>
            </form>
       </div>
       <div class="modal-footer d-flex justify-content-between">
          <div>
            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary rounded-0 small fw-bold">CANCELAR</button>
            <button type="button" class="btn btn-dark rounded-0 small fw-bold px-4" id="btnGuardar">MODIFICAR</button>
          </div>
       </div>
    </div>
   </div>
</div>

<?php
require_once("comunes/modal.php"); 
 require_once("comunes/pie.php"); 
 ?>
<script src="js/roles.js"></script>