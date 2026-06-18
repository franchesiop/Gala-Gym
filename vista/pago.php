<?php require_once("comunes/encabezado.php"); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-0">
                <div class="card-header bg-dark text-white rounded-0 py-3">
                    <h5 class="fw-bold m-0 text-uppercase small">Registrar Nuevo Pago</h5>
                </div>
                <div class="card-body p-4">
                    <form id="formPago">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">SELECCIONAR MEMBRESÍA</label>
                            <select class="form-select rounded-0" id="id_membresia" name="id_membresia" required>
                                <option value="" disabled selected>Elige un plan</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">SELECCIONAR BANCO</label>
                            <select class="form-select rounded-0" id="id_metodo" name="id_metodo" required>
                                <option value="" disabled selected>Selecciona el banco</option>
                            </select>
                            
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">MONTO ($)</label>
                                <input type="number" class="form-control rounded-0 bg-light" id="monto" name="monto" readonly required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">NÚMERO DE REFERENCIA</label>
                                <input type="text" class="form-control rounded-0" id="referencia" name="referencia" maxlength="12" placeholder="12 dígitos" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-white border-0 text-end py-3">
                    <a href="?pagina=principal_cliente" class="btn btn-secondary fw-bold">REGRESAR</a>
                    <button type="button" class="btn btn-dark rounded-0 px-4 fw-bold" id="btnPagar">ENVIAR</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
require_once("comunes/pie.php"); 
?>
<script src="js/pago.js"></script>