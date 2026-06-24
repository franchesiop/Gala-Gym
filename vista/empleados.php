<?php 
require_once("comunes/encabezado.php"); 
?>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-dark text-white min-vh-100 p-0 shadow">
            <div class="p-4 border-bottom border-secondary text-center">
                <h4 class="fw-bold m-0 text-uppercase" style="letter-spacing: 2px;">Admin</h4>
            </div>
            
            <div class="mt-2">
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="?pagina=admin" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold">REPORTES</a></li>
                    <li class="nav-item"><a href="?pagina=clientes" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold">CLIENTES</a></li>
                    <li class="nav-item"><a href="?pagina=empleados" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold">EMPLEADOS</a></li>
                    <li class="nav-item"><a href="?pagina=pagos" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold">METODOS DE PAGO</a></li>
                    <li class="nav-item"><a href="?pagina=membresias" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold text-uppercase">MEMBRESIAS</a></li>
                    <li class="nav-item"><a href="?pagina=roles" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold text-uppercase">ROLES</a></li>
                    <li class="nav-item"><a href="?pagina=ejercicio" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold">EJERCICIOS</a></li>
                </ul>
            </div>

            <div class="p-4 mt-5">
                <a href="?pagina=principal" class="btn btn-outline-danger btn-sm w-100 rounded-0 fw-bold">CERRAR SESIÓN</a>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom bg-white px-3 mt-3 shadow-sm">
                <h5 class="fw-bold text-uppercase m-0 small">Panel / Empleados</h5>
            </div>

            <div class="bg-white p-4 shadow-sm border">
                <div class="d-flex justify-content-between mb-4">
                    <h6 class="fw-bold m-0 text-uppercase">Empleados</h6>
                    <button type="button" class="btn btn-dark btn-sm rounded-0 px-3 fw-bold" 
                            data-bs-toggle="modal" data-bs-target="#modalUsuario" id="btnNuevoEmpleado"><i class="bi bi-person"></i>
                        REGISTRAR
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle small" id="tablaEmpleados">
                        <thead class="table-light">
                            <tr class="text-muted">
                                <th>CÉDULA <i class="bi bi-person-badge"></i></th><th>NOMBRE <i class="bi bi-person-circle"></th><th>APELLIDO <i class="bi bi-person-circle"></th><th>CARGO</th><th>TELÉFONO <i class="bi bi-telephone"></th><th class="text-center">OPCIONES <i class="bi bi-gear"></i></th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold" id="cuerpoTablaEmpleados"></tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true">
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
    <label class="form-label small fw-bold">CARGO</label>
    <select id="cargoEmpleado" name="cargoEmpleado" class="form-select rounded-0">
        <option value="" disabled selected>Seleccione un cargo...</option>
    </select>
    <span id="scargoEmpleado" class="text-danger small"></span>
</div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">CONTRASEÑA</label>
                    <input type="password" class="form-control rounded-0" id="contraEmpleado" name="contraEmpleado" required>
                    <span id="scontraEmpleado" class="text-danger small"></span>
                </div>
            </form>
       </div>
       <div class="modal-footer d-flex justify-content-between">
        
          <div>
            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary rounded-0 small fw-bold">CANCELAR</button>
            <button type="button" class="btn btn-dark rounded-0 small fw-bold px-4" id="btnGuardar">INCLUIR</button>
          </div>
       </div>
    </div>
   </div>
</div>

<?php 
require_once("comunes/modal.php"); 
require_once("comunes/pie.php"); 
?>
<script src="js/empleados.js"></script>