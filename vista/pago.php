<?php require_once("comunes/encabezado.php"); ?>

<nav class="navbar navbar-expand-lg bg-white py-3 shadow-sm mb-5">
    <div class="container">
        <span class="navbar-brand fw-bold text-dark fs-4 text-uppercase">BIENVENIDO</span>
        <div class="d-flex ms-auto align-items-center gap-4">
            <a href="?pagina=principal_cliente" class="text-decoration-none text-dark fw-bold small">RUTINA</a>
            <a href="?pagina=pago" class="text-decoration-none text-primary fw-bold small">PAGOS</a>
            <a href="?pagina=logout" class="text-decoration-none text-danger fw-bold small">CERRAR SESIÓN</a>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold mb-1">REGISTRAR PAGO</h4>
                        <span class="text-muted small">Selecciona el plan y la cantidad a pagar</span>
                    </div>
                    
                    <form id="formPago">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Membresía</label>
                            <select class="form-select bg-light border-0 rounded-pill py-2 px-3 shadow-none" id="id_membresia" name="id_membresia" required>
                                <option value="" disabled selected>Elige un plan</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Cantidad a pagar</label>
                            <input type="number" class="form-control bg-light border-0 rounded-pill py-2 px-3 shadow-none text-center" id="cantidad" name="cantidad" min="1" value="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Banco</label>
                            <select class="form-select bg-light border-0 rounded-pill py-2 px-3 shadow-none" id="id_metodo" name="id_metodo" required>
                                <option value="" disabled selected>Selecciona el banco</placeholder>
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label small fw-bold text-dark">Monto Total ($)</label>
                                <input type="number" class="form-control bg-light border-0 rounded-pill py-2 px-3 shadow-none text-center fw-bold" id="monto" name="monto" readonly required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-dark">Referencia</label>
                                <input type="text" class="form-control bg-light border-0 rounded-pill py-2 px-3 shadow-none text-center" id="referencia" name="referencia" maxlength="12" placeholder="12 dígitos" required>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-3 mt-4 text-center">
                            <button type="button" class="btn btn-dark rounded-pill py-2 fw-bold w-100" id="btnPagar">ENVIAR</button>
                            <a href="?pagina=principal_cliente" class="text-muted text-decoration-none small fw-bold">Regresar a inicio</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once("comunes/pie.php"); ?>
<script src="js/pago.js"></script>