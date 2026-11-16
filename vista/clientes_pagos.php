<?php require_once("comunes/encabezado.php"); ?>

<div class="container-fluid">
    <div class="row">
        <?php require_once("comunes/menu.php"); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light min-vh-100">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom bg-white px-3 mt-3 shadow-sm">
                <h5 class="fw-bold text-uppercase m-0 small">Panel / Pagos</h5>
            </div>

            <div class="bg-white p-4 shadow-sm border">
                
                <!-- Botón de registrar suelto (DataTables inyectará su buscador y selector arriba automáticamente) -->
                <button type="button" class="btn btn-dark btn-sm rounded-0 px-3 fw-bold text-nowrap mb-3" id="btnNuevoPago">
                    REGISTRAR
                </button>

                <div class="table-responsive">
                    <table class="table table-hover align-middle small w-100" id="tablaPagos">
                        <thead class="table-light">
                            <tr class="text-muted">
                                <th class="d-none">ID PAGO</th>
                <th class="d-none">CÉDULA</th>
                
                <!-- Estas 6 columnas son las visibles en pantalla -->
                <th><i class="bi bi-calendar-event"></i> FECHA</th>
                <th><i class="bi bi-person-circle"></i> CLIENTE</th>
                <th><i class="bi bi-receipt"></i> REFERENCIA</th>
                <th><i class="bi bi-currency-dollar"></i> MONTO</th>
                <th><i class="bi bi-info-circle"></i> ESTADO</th>
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

<!-- Modal para Registro Manual -->
<div class="modal fade" id="modalPago" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content rounded-0 border-0 shadow">
       <div class="modal-header bg-dark text-white rounded-0">
         <h5 class="modal-title fw-bold small text-uppercase">Registro de Pago Manual</h5>
         <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body p-4">
            <form id="formPago">
                <div class="mb-3">
                    <label class="form-label small fw-bold">CLIENTE</label>
                    <div class="input-group">
                        <input type="hidden" id="idCliente" name="idCliente">
                        <input type="text" class="form-control rounded-0 border-end-0 bg-white" id="clienteInfo" placeholder="Seleccione un cliente..." readonly required>
                        <button class="btn btn-dark rounded-0 px-3 fw-bold text-nowrap" type="button" id="listarClienteBtn">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                    </div>
                    <span id="sCliente" class="text-danger small"></span>
                </div>
                
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label small fw-bold">MEMBRESÍA</label>
                        <select id="idMembresia" name="idMembresia" class="form-select rounded-0" required>
                            <option value="" disabled selected>Seleccione...</option>
                        </select>
                        <span id="sidMembresia" class="text-danger small"></span>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label small fw-bold">PERÍODOS</label>
                        <input type="number" class="form-control rounded-0" id="cantidadPeriodos" name="cantidadPeriodos" value="1" min="1" required>
                        <span id="scantidadPeriodos" class="text-danger small"></span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">MÉTODO DE PAGO</label>
                    <select id="idMetodo" name="idMetodo" class="form-select rounded-0" required>
                        <option value="" disabled selected>Seleccione método...</option>
                    </select>
                    <span id="sidMetodo" class="text-danger small"></span>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label small fw-bold">REFERENCIA</label>
                        <input type="text" class="form-control rounded-0" id="referencia" name="referencia" required>
                        <span id="sreferencia" class="text-danger small"></span>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label small fw-bold">MONTO ($)</label>
                        <input type="text" class="form-control rounded-0" id="monto" name="monto" required>
                        <span id="smonto" class="text-danger small"></span>
                    </div>
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

<!-- NUEVO MODAL: Detalle (Factura) -->
<div class="modal fade" id="modalDetallePago" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content rounded-0 border-0 shadow">
            <div class="modal-header bg-dark text-white rounded-0">
                <h5 class="modal-title fw-bold small text-uppercase">Detalle de Pago</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="text-center mb-4">
                    <i class="bi bi-bank fs-2 text-muted mb-2" id="iconoMetodo"></i>
                    <p class="text-muted small fw-bold mb-1" style="font-size: 0.75rem;">PAGO ACREDITADO EN:</p>
                    <h5 class="fw-bold m-0 text-uppercase text-dark" id="detMetodo"></h5>
                    
                    <div class="mt-2 text-muted small" style="font-size: 0.8rem;">
                        <div id="lblMetodo1">Cédula/RIF: <span class="fw-bold text-dark" id="detMetodoCedula"></span></div>
                        <div id="lblMetodo2">Teléfono: <span class="fw-bold text-dark" id="detMetodoTelefono"></span></div>
                    </div>
                </div>
                
                <div class="border-top border-dark border-2 border-dashed my-3" style="border-style: dashed !important; opacity: 0.2;"></div>

                <ul class="list-group list-group-flush rounded-0 bg-transparent">
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent small px-0">
                        <span class="fw-bold text-muted">FECHA</span>
                        <span id="detFecha"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent small px-0">
                        <span class="fw-bold text-muted">CÉDULA CLIENTE</span>
                        <span id="detCedula"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent small px-0">
                        <span class="fw-bold text-muted">CLIENTE</span>
                        <span id="detCliente"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent small px-0">
                        <span class="fw-bold text-muted">REFERENCIA</span>
                        <span id="detReferencia"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent small px-0 mt-2">
                        <span class="fw-bold text-dark">MONTO TOTAL</span>
                        <span id="detMonto" class="fw-bold fs-5 text-success"></span>
                    </li>
                </ul>
            </div>
            <div class="modal-footer justify-content-center border-0 bg-light">
                <button type="button" data-bs-dismiss="modal" class="btn btn-dark rounded-0 small fw-bold px-5">CERRAR</button>
            </div>
        </div>
    </div>
</div>

<?php 
require_once("comunes/modal.php"); 
require_once("comunes/modal_confirmar.php"); 
require_once("comunes/modal_rechazar.php");  
require_once("comunes/pie.php"); 
?>
<script src="js/clientes_pagos.js?v="></script>