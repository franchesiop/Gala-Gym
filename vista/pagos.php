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
                    <li class="nav-item"><a href="?pagina=roles" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold text-uppercase">GESTIONAR ROLES</a></li>
                </ul>
            </div>
            <div class="p-4 mt-5">
                <a href="?pagina=principal" class="btn btn-outline-danger btn-sm w-100 rounded-0 fw-bold">CERRAR SESIÓN</a>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom bg-white px-3 mt-3 shadow-sm">
                <h5 class="fw-bold text-uppercase m-0 small">Panel / Pagos</h5>
            </div>

            <div class="bg-white p-4 shadow-sm border">
                <div class="d-flex justify-content-between mb-4">
                    <h6 class="fw-bold m-0 text-uppercase">Gestión de Métodos de Pago</h6>
                    <button type="button" class="btn btn-dark btn-sm rounded-0 px-3 fw-bold" id="btnNuevoPago" data-bs-toggle="modal" data-bs-target="#modalPago">
                        NUEVO MÉTODO
                    </button>
                </div>
                <table class="table table-hover align-middle small" id="tablaPagos">
                    <thead class="table-light">
                        <tr class="text-muted">
                            <th>ID</th><th>MÉTODO DE PAGO</th><th>CÉDULA</th><th>TELÉFONO</th><th class="text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold" id="cuerpoTablaPagos"></tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="modalPago" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content rounded-0 border-0 shadow">
       <div class="modal-header bg-dark text-white rounded-0">
         <h5 class="modal-title fw-bold small text-uppercase">Método de Pago - Gala Gym</h5>
         <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body p-4">
            <form id="formPago">
                <input type="hidden" id="accion" name="accion"> <input type="hidden" id="id_metodo" name="id_metodo">
                
                <div class="mb-3">
				<label class="form-label small fw-bold">MÉTODO DE PAGO / BANCO</label>
					<select class="form-select rounded-0" id="banco" name="banco" required>
						<option value="" selected disabled>Seleccione una opción...</option>
						<option value="Pago Móvil - Mercantil">Pago Móvil - Mercantil</option>
						<option value="Pago Móvil - Banesco">Pago Móvil - Banesco</option>
						<option value="Pago Móvil - Venezuela">Pago Móvil - Venezuela</option>
						<option value="Transferencia Bancaria">Transferencia Bancaria</option>
						<option value="Efectivo / Divisas">Efectivo / Divisas</option>
					</select>
				</div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">CÉDULA</label>
                    <input type="text" class="form-control rounded-0" id="cedula" name="cedula" required>
                    <span id="scedula" class="text-danger small"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">TELÉFONO</label>
                    <input type="text" class="form-control rounded-0" id="telefono" name="telefono" required>
                </div>
            </form>
       </div>
       <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-danger rounded-0 small fw-bold" id="eliminar" style="display:none;">ELIMINAR</button>
          <div>
            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary rounded-0 small fw-bold">CANCELAR</button>
            <button type="button" class="btn btn-dark rounded-0 small fw-bold px-4" id="btnGuardar">GUARDAR</button>
          </div>
       </div>
    </div>
   </div>
</div>

<?php require_once("comunes/pie.php"); ?>
<script src="js/pagos.js"></script>
