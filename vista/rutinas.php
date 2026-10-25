<?php 
require_once("comunes/encabezado.php"); 
?>

<div class="container-fluid">
    <div class="row">
        
        <!-- Sidebar centralizado -->
        <?php require_once("comunes/menu.php"); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom bg-white px-3 mt-3 shadow-sm">
                <h5 class="fw-bold text-uppercase m-0 small">Panel / Rutinas</h5>
            </div>

            <div class="bg-white p-4 shadow-sm border">
                <div class="d-flex justify-content-between mb-4">
                    <h6 class="fw-bold m-0 text-uppercase"><i class="bi bi-clipboard2-pulse"></i> Rutinas</h6>
                    <button type="button" class="btn btn-dark btn-sm rounded-0 px-3 fw-bold" id="btnNuevaRutina">REGISTRAR</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle small" id="tablaRutinas">
                        <thead class="table-light">
                            <tr class="text-muted">
                                <th style="display:none">ID</th>
                                <th><i class="bi bi-card-text"></i> NOMBRE DE RUTINA</th>
                                <th><i class="bi bi-person-badge"></i> ENTRENADOR</th>
                                <th><i class="bi bi-person-check"></i> CLIENTE ASIGNADO</th>
                                <th class="text-center"><i class="bi bi-gear"></i> OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold" id="cuerpoTablaRutinas"></tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered"> 
     <div class="modal-content rounded-0 border-0 shadow">
       <div class="modal-header bg-dark text-white rounded-0">
         <h5 class="modal-title fw-bold small text-uppercase">Gestión de Rutina</h5>
         <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body p-4">
            <form id="formRutina">
                <input type="hidden" id="idRutina" name="idRutina">
                
                <div class="row mb-4">
                    <!-- Nombre de la rutina -->
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">NOMBRE DE LA RUTINA</label>
                        <input type="text" class="form-control rounded-0" id="nombreRutina" name="nombreRutina" placeholder="Ej: HIPERMAXHULKGOLku" required>
                        <span id="snombreRutina" class="text-danger small"></span>
                    </div>

                    <!-- Buscador de Cliente con AJAX -->
                    <div class="col-md-6 position-relative">
                        <label class="form-label small fw-bold">ASIGNAR A CLIENTE</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light rounded-0 border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control rounded-0 border-start-0" id="buscarCliente" placeholder="Buscar cédula o nombre..." autocomplete="off">
                            <!-- Este input oculto es el que guarda el ID real para la base de datos -->
                            <input type="hidden" id="idCliente" name="idCliente">
                        </div>
                        
                        <!-- Contenedor flotante para los resultados de la búsqueda -->
                        <div class="list-group position-absolute w-100 shadow mt-1 d-none" id="listaClientes" style="z-index: 1050; max-height: 200px; overflow-y: auto;">
                            <!-- JS inyectará aquí los <button> o <a> con los clientes encontrados -->
                        </div>
                        <span id="sCliente" class="text-danger small"></span>
                    </div>
                </div>

                <hr>
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold small m-0"><i class="bi bi-activity"></i> EJERCICIOS DE LA RUTINA</h6>
                    <button type="button" class="btn btn-outline-dark btn-sm rounded-0 fw-bold" id="btnAgregarEjercicio">
                        <i class="bi bi-plus-lg"></i> AÑADIR EJERCICIO
                    </button>
                </div>

                <!-- Encabezados fijos para las columnas -->
                <div class="row mb-1 text-muted border-bottom pb-1">
                    <div class="col-5">
                        <label class="form-label small fw-bold m-0">EJERCICIO</label>
                    </div>
                    <div class="col-3">
                        <label class="form-label small fw-bold m-0">SERIES</label>
                    </div>
                    <div class="col-3">
                        <label class="form-label small fw-bold m-0">REPS</label>
                    </div>
                    <div class="col-1">
                        <!-- Espacio vacío para la columna del botón de eliminar -->
                    </div>
                </div>

                <!-- Contenedor donde JS inyectará solo los inputs limpios -->
                <div id="contenedorEjercicios" class="mt-2">
                    <!-- Aquí caerán los selects y los inputs de series/repeticiones -->
                </div>
                <span id="sEjercicios" class="text-danger small"></span>
                
            </form>
       </div>
       <div class="modal-footer d-flex justify-content-between bg-light">
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
<script src="js/rutinas.js?v=<?php echo time(); ?>"></script>