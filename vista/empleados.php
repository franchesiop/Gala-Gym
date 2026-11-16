<?php 
require_once("comunes/encabezado.php"); 
?>

<div class="container-fluid">
    <div class="row">
        
        <!-- Sidebar centralizado -->
        <?php require_once("comunes/menu.php"); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom bg-white px-3 mt-3 shadow-sm">
                <h5 class="fw-bold text-uppercase m-0 small">Panel / Empleados</h5>
            </div>

            <div class="bg-white p-4 shadow-sm border">
                
                <!-- Botón de registrar suelto (DataTables pondrá su buscador y selector arriba automáticamente) -->
                <button type="button" class="btn btn-dark btn-sm rounded-0 px-3 fw-bold text-nowrap mb-3" id="btnNuevoEmpleado">
                    REGISTRAR
                </button>

                <div class="table-responsive">
                    <table class="table table-hover align-middle small w-100" id="tablaEmpleados">
                        <thead class="table-light">
                            <tr class="text-muted">
                                <th><i class="bi bi-person-badge"></i> CÉDULA</th>
                                <th><i class="bi bi-person-circle"></i> NOMBRE</th>
                                <th><i class="bi bi-person-circle"></i> APELLIDO</th>
                                <th><i class="bi bi-briefcase"></i> ROL</th>
                                <th><i class="bi bi-telephone"></i> TELÉFONO</th>
                                <!-- Columnas ocultas necesarias para que el JS lea correo e id_rol al editar -->
                                <th class="d-none">CORREO</th>
                                <th class="d-none">ID_ROL</th>
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

<div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content rounded-0 border-0 shadow">
       <div class="modal-header bg-dark text-white rounded-0">
         <h5 class="modal-title fw-bold small text-uppercase">Gestión de Empleado</h5>
         <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body p-4">
            <form id="formEmpleado">
                <div class="mb-3">
                    <label class="form-label small fw-bold">CÉDULA</label>
                    <input type="text" class="form-control rounded-0" id="cedulaEmpleado" name="cedulaEmpleado" required>
                    <span id="scedulaEmpleado" class="text-danger small"></span>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label small fw-bold">NOMBRE</label>
                        <input type="text" class="form-control rounded-0" id="nombreEmpleado" name="nombreEmpleado" required>
                        <span id="snombreEmpleado" class="text-danger small"></span>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label small fw-bold">APELLIDO</label>
                        <input type="text" class="form-control rounded-0" id="apellidoEmpleado" name="apellidoEmpleado" required>
                        <span id="sapellidoEmpleado" class="text-danger small"></span>
                    </div>
                </div>
               
                <div class="mb-3">
                    <label class="form-label small fw-bold">TELÉFONO</label>
                    <input type="text" class="form-control rounded-0" id="tlfEmpleado" name="tlfEmpleado" required>
                    <span id="stlfEmpleado" class="text-danger small"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">CORREO</label>
                    <input type="email" class="form-control rounded-0" id="correoEmpleado" name="correoEmpleado" required>
                    <span id="scorreoEmpleado" class="text-danger small"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">ROL</label>
                    <select id="rolEmpleado" name="rolEmpleado" class="form-select rounded-0">
                        <option value="" disabled selected>Seleccione un rol...</option>
                    </select>
                    <span id="srolEmpleado" class="text-danger small"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">CONTRASEÑA</label>
                    <input type="password" class="form-control rounded-0" id="contraEmpleado" name="contraEmpleado" required>
                    <span id="scontraEmpleado" class="text-danger small"></span>
                </div>
            </form>
       </div>
       <div class="modal-footer d-flex justify-content-between">
          <div class="ms-auto">
            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary rounded-0 small fw-bold me-2">CANCELAR</button>
            <button type="button" class="btn btn-dark rounded-0 small fw-bold px-4 text-uppercase" id="btnGuardar">INCLUIR</button>
          </div>
       </div>
    </div>
   </div>
</div>

<?php 
require_once("comunes/pie.php"); 
?>
<script src="js/empleados.js"></script>