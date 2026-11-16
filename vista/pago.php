<?php require_once("comunes/encabezado.php"); ?>

<!-- Menú Superior idéntico al de Rutinas -->
<nav class="navbar navbar-expand bg-white border-bottom shadow-sm sticky-top py-3">
    <div class="container">
        <span class="navbar-brand fw-bolder text-dark text-uppercase m-0">
            <i class="bi bi-lightning-charge-fill me-1"></i>Gala Gym
        </span>

        <ul class="navbar-nav ms-auto align-items-center gap-1">
            <li class="nav-item">
                <a href="?pagina=clientes_rutina" class="nav-link text-secondary text-uppercase small fw-bold px-3">
                    <i class="bi bi-lightning-charge me-1"></i>Rutinas
                </a>
            </li>
            <li class="nav-item">
                <a href="?pagina=pago" class="nav-link active fw-bold text-dark text-uppercase small px-3">
                    <i class="bi bi-credit-card me-1"></i>Pagos
                </a>
            </li>
            <li class="nav-item border-start ms-2 ps-2">
                <a href="?pagina=logout" class="nav-link text-danger text-uppercase small fw-bold px-3">
                    <i class="bi bi-box-arrow-right me-1"></i>Salir
                </a>
            </li>
        </ul>
    </div>
</nav>

<main class="bg-light min-vh-100 py-5">
    <div class="container">
        
        <!-- Encabezado alineado al nuevo estilo -->
        <header class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4 pb-4 border-bottom">
            <div>
                <p class="text-uppercase text-secondary fw-semibold small mb-1">Panel del cliente</p>
                <h1 class="h2 fw-bold text-dark text-uppercase m-0">Registrar Pago</h1>
                <p class="text-muted mb-0">Completa los datos para procesar tu membresía</p>
            </div>
        </header>

        <!-- Envolvemos ambas columnas en el formulario -->
        <form id="formPago">
            <div class="row g-4">
                
                <!-- COLUMNA IZQUIERDA: FORMULARIO -->
                <div class="col-lg-7">
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-body p-4 p-md-5 bg-white rounded-4">
                            
                            <!-- SECCIÓN 1: PEDIDO -->
                            <h2 class="h6 fw-bold text-uppercase border-bottom pb-2 mb-4 text-dark">
                                <i class="bi bi-box-seam me-2"></i>1. Tu Pedido
                            </h2>
                            
                            <div class="row mb-4">
                                <div class="col-md-8 mb-3 mb-md-0">
                                    <label class="form-label small fw-bold text-secondary text-uppercase">Membresía</label>
                                    <select class="form-select bg-light border-0 rounded-3 py-2 shadow-none" id="id_membresia" name="id_membresia" required>
                                        <option value="" disabled selected>Elige un plan...</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-secondary text-uppercase">Períodos</label>
                                    <input type="number" class="form-control bg-light border-0 rounded-3 py-2 text-center fw-bold shadow-none" id="cantidad" name="cantidad" min="1" value="1" required>
                                </div>
                            </div>

                            <!-- SECCIÓN 2: MÉTODO DE PAGO (Tarjetas) -->
                            <h2 class="h6 fw-bold text-uppercase border-bottom pb-2 mb-4 text-dark">
                                <i class="bi bi-bank me-2"></i>2. Cuentas Disponibles
                            </h2>
                            
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary text-uppercase mb-3">Selecciona dónde realizaste la transferencia</label>
                                <!-- Contenedor donde JS inyectará las tarjetas -->
                                <div class="row g-3" id="contenedorMetodos">
                                    <!-- Las tarjetas se cargarán aquí vía AJAX -->
                                </div>
                                <!-- Input oculto para almacenar el ID del método seleccionado -->
                                <input type="hidden" id="id_metodo" name="id_metodo">
                            </div>

                            <!-- SECCIÓN 3: COMPROBANTE -->
                            <h2 class="h6 fw-bold text-uppercase border-bottom pb-2 mb-4 text-dark">
                                <i class="bi bi-receipt me-2"></i>3. Comprobante
                            </h2>
                            
                            <div class="mb-2">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Número de referencia</label>
                                <input type="text" class="form-control bg-light border-0 rounded-3 py-2 fw-bold shadow-none" id="referencia" name="referencia" placeholder="Selecciona un método primero" disabled required>
                                <div class="form-text small" id="ayudaReferencia">Debes seleccionar una cuenta arriba para habilitar este campo.</div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- COLUMNA DERECHA: RESUMEN -->
                <div class="col-lg-5">
                    <div class="card shadow-sm border-0 rounded-4 bg-white position-sticky" style="top: 100px;">
                        <div class="card-body p-4 p-md-5">
                            
                            <h2 class="h6 fw-bold text-uppercase border-bottom pb-2 mb-4 text-dark">Resumen de Compra</h2>
                            
                            <!-- Bloque de Monto -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="fw-bold text-secondary small text-uppercase">Total a pagar</span>
                                <h3 class="fw-bold text-success m-0" id="textoMonto">$0.00</h3>
                                <!-- Input oculto para enviar al controlador -->
                                <input type="hidden" id="monto" name="monto">
                            </div>

                            <!-- Botón de Envío -->
                            <button type="button" class="btn btn-dark btn-lg rounded-3 py-3 fw-bold text-uppercase w-100 shadow-sm" id="btnPagar">
                                Revisar y enviar
                            </button>
                            
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</main>

<!-- MODAL: Confirmación previa al envío -->
<div class="modal fade" id="modalConfirmarPago" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header bg-dark text-white rounded-top-4 border-0">
                <h5 class="modal-title fw-bold small text-uppercase">
                    <i class="bi bi-shield-check me-2"></i>Confirmar Datos del Pago
                </h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <p class="small text-muted mb-3 text-center">Verifica que la información de tu transferencia sea correcta antes de notificarla:</p>
                
                <ul class="list-group list-group-flush rounded-3 border small mb-3 overflow-hidden shadow-sm">
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-white py-3">
                        <span class="fw-bold text-secondary">PLAN SELECCIONADO</span>
                        <span class="fw-bold text-dark" id="confPlan"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-white py-3">
                        <span class="fw-bold text-secondary">PERÍODOS / CANTIDAD</span>
                        <span class="fw-bold text-dark" id="confCantidad"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-white py-3">
                        <span class="fw-bold text-secondary">MONTO TOTAL</span>
                        <span class="fw-bold text-success fs-6" id="confMonto"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-white py-3">
                        <span class="fw-bold text-secondary">REFERENCIA INGRESADA</span>
                        <span class="fw-bold text-dark" id="confReferencia"></span>
                    </li>
                </ul>

                <div class="bg-white p-3 border rounded-3 text-center shadow-sm">
                    <span class="d-block small text-secondary fw-bold mb-1">CUENTA A DONDE TRANSFERISTE:</span>
                    <span class="small fw-bold text-dark" id="confDatosDestino"></span>
                </div>
            </div>
            <div class="modal-footer justify-content-between border-0 bg-white p-4 rounded-bottom-4">
                <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary rounded-3 small fw-bold px-4">CANCELAR</button>
                <button type="button" class="btn btn-dark rounded-3 small fw-bold px-5 shadow-sm" id="btnConfirmarEnvio">ENVIAR</button>
            </div>
        </div>
    </div>
</div>

<?php require_once("comunes/pie.php"); ?>
<script src="js/pago.js"></script>