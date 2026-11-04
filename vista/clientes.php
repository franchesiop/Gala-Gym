<?php 
require_once("comunes/encabezado.php"); 
?>

<div class="container-fluid">
    <div class="row">
        
        <!-- Sidebar centralizado -->
        <?php require_once("comunes/menu.php"); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom bg-white px-3 mt-3 shadow-sm">
                <h5 class="fw-bold text-uppercase m-0 small">Panel / Clientes</h5>
            </div>

            <div class="bg-white p-4 shadow-sm border">
                
                <!-- Buscador en tiempo real y botón de registro -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
                    <h6 class="fw-bold m-0 text-uppercase"><i class="bi bi-person"></i> Clientes</h6>
                    
                    <div class="d-flex gap-2 align-items-center" style="max-width: 450px; width: 100%;">
                        <input type="text" class="form-control form-control-sm rounded-0" id="buscar_cliente" placeholder="Buscar...">
                        <button type="button" class="btn btn-dark btn-sm rounded-0 px-3 fw-bold text-nowrap" id="btnNuevoCliente">
                            REGISTRAR
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle small" id="tablaClientes">
                        <thead class="table-light">
                            <tr class="text-muted">
                                <th><i class="bi bi-person-badge"></i> CÉDULA</th>
                                <th><i class="bi bi-person-circle"></i> NOMBRE</th>
                                <th><i class="bi bi-person-circle"></i> APELLIDO</th>
                                <th><i class="bi bi-telephone"></i> TELÉFONO</th>
                                <th style="display:none">CORREO</th>
                                <th class="text-center"><i class="bi bi-gear"></i> OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold" id="cuerpoTablaClientes"></tbody>
                    </table>
                </div>

                <!-- Paginación dinámica (Estándar Bootstrap) -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-3 pt-3 border-top gap-2">
                    <span class="text-muted small" id="infoPaginacion">Mostrando 0 clientes</span>
                    <nav>
                        <ul class="pagination pagination-sm m-0" id="contenedorPaginacion">
                            <!-- Los botones se generan dinámicamente por JS -->
                        </ul>
                    </nav>
                </div>

            </div>
        </main>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content rounded-0 border-0 shadow">
       <div class="modal-header bg-dark text-white rounded-0">
         <h5 class="modal-title fw-bold small text-uppercase">Gestión de Cliente</h5>
         <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body p-4">
            <form id="formCliente">
                <div class="mb-3">
                    <label class="form-label small fw-bold">CÉDULA</label>
                    <input type="text" class="form-control rounded-0" id="cedulaCliente" name="cedulaCliente" required>
                    <span id="scedulaCliente" class="text-danger small"></span>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label small fw-bold">NOMBRE</label>
                        <input type="text" class="form-control rounded-0" id="nombreCliente" name="nombreCliente" required>
                        <span id="snombreCliente" class="text-danger small"></span>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label small fw-bold">APELLIDO</label>
                        <input type="text" class="form-control rounded-0" id="apellidoCliente" name="apellidoCliente" required>
                        <span id="sapellidoCliente" class="text-danger small"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">TELÉFONO</label>
                    <input type="text" class="form-control rounded-0" id="tlfCliente" name="tlfCliente" required>
                    <span id="stlfCliente" class="text-danger small"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">CORREO</label>
                    <input type="email" class="form-control rounded-0" id="correoCliente" name="correoCliente" required>
                    <span id="scorreoCliente" class="text-danger small"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">MEMBRESÍA</label>
                    <!-- Select nativo intacto -->
                    <select id="membresiaCliente" name="membresiaCliente" class="form-select rounded-0">
                        <option value="" disabled selected>Seleccione una membresía...</option>
                    </select>
                    <span id="smembresiaCliente" class="text-danger small"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">CONTRASEÑA</label>
                    <input type="password" class="form-control rounded-0" id="contraCliente" name="contraCliente" required>
                    <span id="scontraCliente" class="text-danger small"></span>
                </div>
            </form>
       </div>
       <div class="modal-footer d-flex justify-content-between">
          <div class="ms-auto">
            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary rounded-0 small fw-bold me-2">CANCELAR</button>
            <button type="button" class="btn btn-dark rounded-0 small fw-bold px-4" id="btnGuardar">INCLUIR</button>
          </div>
       </div>
    </div>
   </div>
</div>

<?php 
require_once("comunes/modal.php"); 
require_once("comunes/modal_eliminar.php");
require_once("comunes/pie.php"); 
?>
<script src="js/clientes.js?v=<?php echo time(); ?>"></script>