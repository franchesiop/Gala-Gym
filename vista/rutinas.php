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
                    <li class="nav-item"><a href="?pagina=rutinas" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold bg-dark-subtle"><i class="bi bi-person-standing"></i> RUTINAS</a></li>
                </ul>
            </div>
            <div class="p-4 mt-5">
                <a href="?pagina=principal" class="btn btn-outline-danger btn-sm w-100 rounded-0 fw-bold">CERRAR SESIÓN</a>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom bg-white px-3 mt-3 shadow-sm">
                <h5 class="fw-bold text-uppercase m-0 small">Panel / Rutinas</h5>
            </div>

            <div class="bg-white p-4 shadow-sm border">
                <div class="d-flex justify-content-between mb-4">
                    <h6 class="fw-bold m-0 text-uppercase"><i class="bi bi-person"></i> Rutinas</h6>
                    <button type="button" class="btn btn-dark btn-sm rounded-0 px-3 fw-bold" id="btnNuevaRutina">REGISTRAR</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle small" id="tablaRutinas">
                        <thead class="table-light">
                            <tr class="text-muted">
                                <th><i class="bi bi-card-text"></i> NOMBRE</th>
                                <th><i class="bi bi-person-circle"></i> CREADA POR</th>
                                <th><i class="bi bi-stars"></i> NIVEL/TIPO</th>
                                <th><i class="bi bi-lungs"></i> EJERCICIOS</th>
                                <th class="text-center"><i class="bi bi-gear"></i> OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold" id="tablaRutinas">
                            <tr>
                                <td>Fuerza A</td>
                                <td>Iron Man</td>
                                <td>Avanzado</td>
                                <td class="text-center"><span class="badge bg-secondary rounded-pill">10</span></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-0 me-1 btnVerDetalles" data-id="1"><i class="bi bi-list"></i> Detalle</button>
                                    <button class="btn btn-sm btn-outline-dark rounded-0 me-1 btnEditarRutina" data-id="1"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-0 btnEliminarRutina" data-id="1"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="modalDetallesRutina" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-xl modal-dialog-centered">
     <div class="modal-content rounded-0 border-0 shadow">
       <div class="modal-header bg-dark text-white rounded-0">
         <h5 class="modal-title fw-bold small text-uppercase" id="tituloModalDetalles">Detalles de la Rutina: [NOMBRE RUTINA]</h5>
         <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body p-4">
            
            <div class="bg-light p-3 border mb-4 shadow-sm">
                <h6 class="fw-bold text-uppercase small mb-3">Añadir Ejercicio</h6>
                <form id="formAñadirDetalle" class="row gx-2 align-items-end">
                    <div class="col-md-5 mb-2 mb-md-0">
                        <label class="form-label small fw-bold">EJERCICIO</label>
                        <select id="selectEjercicio" name="id_ejercicio" class="form-select rounded-0" required>
                            <option value="" disabled selected>Seleccione...</option>
                            <option value="1">Press Banca</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2 mb-md-0">
                        <label class="form-label small fw-bold">SERIES</label>
                        <input type="number" class="form-control rounded-0" id="seriesDetalle" name="series" min="1" required>
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0">
                        <label class="form-label small fw-bold">REPETICIONES</label>
                        <input type="text" class="form-control rounded-0" id="repeticionesDetalle" name="repeticiones" placeholder="ej: 10, 8-12, al fallo" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-dark btn-sm rounded-0 fw-bold w-100" id="btnAñadirEjercicio">AÑADIR A RUTINA</button>
                    </div>
                </form>
            </div>

            <h6 class="fw-bold text-uppercase small"><i class="bi bi-body-text"></i> Ejercicios Incluidos</h6>
            <div class="table-responsive">
                <table class="table table-sm table-hover table-striped align-middle small" id="tablaDetalles">
                    <thead class="table-light">
                        <tr class="text-muted">
                            <th><i class="bi bi-lungs"> EJERCICIO</i></th>
                            <th><i class="bi bi-layers"> SERIES</i></th>
                            <th><i class="bi bi-clipboard-data"> REPETICIONES</i></th>
                            <th class="text-center"><i class="bi bi-gear"> OPCIONES</i></th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold" id="cuerpoTablaDetalles">
                        <tr>
                            <td>Press Banca</td>
                            <td>4</td>
                            <td>10</td>
                            <td class="text-center">
                                <button class="btn btn-xs btn-outline-dark rounded-0 me-1 btnEditarDetalle" data-id_detalle="1"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-xs btn-outline-danger rounded-0 btnEliminarDetalle" data-id_detalle="1"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        </tbody>
                </table>
            </div>
       </div>
       <div class="modal-footer d-flex justify-content-between">
          <div>
            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary rounded-0 small fw-bold">CERRAR DETALLES</button>
          </div>
       </div>
    </div>
   </div>
</div>

<?php 
require_once("comunes/modal.php"); 
require_once("comunes/pie.php"); 
?>
<script src="js/rutinas.js"></script>