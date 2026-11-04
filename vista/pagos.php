<?php 
require_once("comunes/encabezado.php"); 
?>

<div class="container-fluid">
    <div class="row">
        
        <!-- Sidebar centralizado -->
        <?php require_once("comunes/menu.php"); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom bg-white px-3 mt-3 shadow-sm">
                <h5 class="fw-bold text-uppercase m-0 small">Panel / Pagos</h5>
            </div>

            <div class="bg-white p-4 shadow-sm border">
                
                <!-- Buscador en tiempo real y botón de registro -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
                    <h6 class="fw-bold m-0 text-uppercase"><i class="bi bi-credit-card-2-front"></i> Métodos de Pago</h6>
                    
                    <div class="d-flex gap-2 align-items-center" style="max-width: 450px; width: 100%;">
                        <input type="text" class="form-control form-control-sm rounded-0" id="buscar_pago" placeholder="Buscar...">
                        <button type="button" class="btn btn-dark btn-sm rounded-0 px-3 fw-bold text-nowrap" id="btnNuevoPago" data-bs-toggle="modal" data-bs-target="#modalPago">
                            REGISTRAR
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle small" id="tablaPagos">
                        <thead class="table-light">
                            <tr class="text-muted">
                                <th><i class="bi bi-currency-euro"></i> TIPO</th>
                                <th><i class="bi bi-coin"></i> BANCO / NOMBRE</th>
                                <th class="text-center"><i class="bi bi-gear"></i> OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold" id="cuerpoTablaPagos"></tbody>
                    </table>
                </div>

                <!-- Paginación dinámica (Estándar Bootstrap) -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-3 pt-3 border-top gap-2">
                    <span class="text-muted small" id="infoPaginacion">Mostrando 0 métodos de pago</span>
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

<!-- Modal Pagos -->
<div class="modal fade" id="modalPago" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content rounded-0 border-0 shadow">
       <div class="modal-header bg-dark text-white rounded-0">
         <h5 class="modal-title fw-bold small text-uppercase">Método de Pago - Gala Gym</h5>
         <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body p-4">
            <form id="formPago">
                <input type="hidden" id="accion" name="accion"> 
                <input type="hidden" id="id_metodo" name="id_metodo">
                
                <div class="mb-3">
                    <label class="form-label small fw-bold">MÉTODO DE PAGO</label>
                    <select class="form-select rounded-0" id="banco" name="banco" required>
                        <option value="Pago Móvil" selected>Pago Móvil</option>
                        <option value="Zelle">Zelle</option>
                    </select>
                </div>

                <!-- Contenedor único dinámico -->
                <div id="contenedor_campos">
                    <div class="mb-3" id="contenedor_dato_1">
                         <label class="form-label small fw-bold" id="label_dato_1">BANCO</label>
                         <input type="text" class="form-control rounded-0" id="input_dato_1" name="input_dato_1" placeholder="Ej: Banesco, Mercantil...">
                         <span id="sinput_dato_1" class="text-danger small"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold" id="label_dato_2">CÉDULA</label>
                        <input type="text" class="form-control rounded-0" id="input_dato_2" name="input_dato_2">
                        <span id="sinput_dato_2" class="text-danger small"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold" id="label_dato_3">TELÉFONO</label>
                        <input type="text" class="form-control rounded-0" id="input_dato_3" name="input_dato_3">
                        <span id="sinput_dato_3" class="text-danger small"></span>
                    </div>
                </div>
            </form>
       </div>
       <div class="modal-footer d-flex justify-content-between">
          <div class="ms-auto">
            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary rounded-0 small fw-bold me-2">CANCELAR</button>
            <button type="button" class="btn btn-dark rounded-0 small fw-bold px-4" id="btnGuardar">GUARDAR</button>
          </div>
       </div>
    </div>
   </div>
</div>

<?php 
require_once("comunes/pie.php"); 
require_once("comunes/modal.php"); 
require_once("comunes/modal_eliminar.php"); 
?>
<script src="js/pagos.js?v=<?php echo time(); ?>"></script>