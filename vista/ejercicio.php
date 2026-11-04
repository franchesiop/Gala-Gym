<?php 
require_once("comunes/encabezado.php"); 
?>

<div class="container-fluid">
    <div class="row">
        
        <!-- Sidebar centralizado -->
        <?php require_once("comunes/menu.php"); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom bg-white px-3 mt-3 shadow-sm">
                <h5 class="fw-bold text-uppercase m-0 small">Panel / Ejercicios</h5>
            </div>
            
            <div class="bg-white p-4 shadow-sm border">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
                    <h6 class="fw-bold m-0 text-uppercase"><i class="bi bi-activity"></i> Ejercicios</h6>
                    
                    <!-- Buscador en tiempo real y botón de registro -->
                    <div class="d-flex gap-2 align-items-center" style="max-width: 450px; width: 100%;">
                        <input type="text" class="form-control form-control-sm rounded-0" id="buscar_ejercicio" placeholder="Buscar...">
                        <button type="button" class="btn btn-dark btn-sm rounded-0 px-3 fw-bold text-nowrap" id="btnNuevoEjercicio">
                            REGISTRAR
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle small">
                        <thead class="table-light">
                            <tr class="text-muted">
                                <th style="display:none">ID DEL EJERCICIO</th>
                                <th style="width: 80px;"><i class="bi bi-image"></i> FOTO</th>
                                <th><i class="bi bi-card-text"></i> NOMBRE</th>
                                <th><i class="bi bi-file-text"></i> DESCRIPCIÓN</th>
                                <th class="text-center" style="width: 120px;"><i class="bi bi-gear"></i> OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold" id="tablaEjercicios"></tbody>
                    </table>
                </div>

                <!-- Paginación dinámica (Estándar Bootstrap) -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-3 pt-3 border-top gap-2">
                    <span class="text-muted small" id="infoPaginacion">Mostrando 0 ejercicios</span>
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

<!-- Modal Ejercicios -->
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content rounded-0 border-0 shadow">
       <div class="modal-header bg-dark text-white rounded-0">
         <h5 class="modal-title fw-bold small text-uppercase">Gestión de Ejercicios</h5>
         <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body p-4">
            <form id="formEjercicios" enctype="multipart/form-data">
                <input type="hidden" id="id_ejercicio" name="id_ejercicio"> 
                
                <div class="row">
                    <!-- Nombre del Ejercicio -->
                    <div class="col-12 mb-3">
                        <label class="form-label small fw-bold">NOMBRE</label>
                        <input type="text" class="form-control rounded-0" id="nombre_ejercicio" name="nombre_ejercicio" required autocomplete="off">
                        <span id="snombre_ejercicio" class="text-danger small"></span>
                    </div>

                    <!-- Descripción técnica -->
                    <div class="col-12 mb-3">
                        <label class="form-label small fw-bold">DESCRIPCIÓN</label>
                        <textarea class="form-control rounded-0" id="descripcion_ejercicio" name="descripcion_ejercicio" rows="3" placeholder="Explicación de la técnica..."></textarea>
                        <span id="sdescripcion_ejercicio" class="text-danger small"></span>
                    </div>

                    <!-- Subida de Imagen con Vista Previa -->
                    <div class="col-12 mb-2 text-center">
                        <label class="form-label small fw-bold d-block text-start">IMAGEN ACTUAL</label>
                        <div class="mb-3 d-inline-block border p-1 bg-white shadow-sm">
                            <img src="img/default.jpg" id="vista_previa" alt="Vista previa" style="width: 120px; height: 120px; object-fit: cover;">
                        </div>

                        <label class="form-label small fw-bold d-block text-start mt-2">SUBIR NUEVA (JPG, PNG, WEBP - MÁX 2MB)</label>
                        <input type="file" class="form-control rounded-0" id="imagen_ejercicio" name="imagen_ejercicio" accept=".jpg,.jpeg,.png,.webp">
                        <span id="simagen_ejercicio" class="text-danger small"></span>
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

<?php 
require_once("comunes/modal.php");
require_once("comunes/modal_eliminar.php");
require_once("comunes/pie.php"); 
?>
<script src="js/ejercicio.js?v=<?php echo time(); ?>"></script>