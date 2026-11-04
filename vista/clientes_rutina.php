<?php require_once("comunes/encabezado.php"); ?>


<nav class="bg-white border-bottom py-4 sticky-top">
    <div class="container d-flex justify-content-between align-items-center">
        <h4 class="fw-bold m-0 text-dark text-uppercase" style="letter-spacing: 3px;">GALA GYM</h4>
        
        <div class="d-flex align-items-center gap-4">
            <!-- indicador visual de página activa: borde inferior oscuro -->
            <a href="?pagina=clientes_rutina" class="text-dark text-decoration-none text-uppercase fw-bold small pb-1 border-bottom border-2 border-dark">Rutinas</a>
            
            <!-- enlace inactivo: texto gris -->
            <a href="?pagina=pago" class="text-secondary text-decoration-none text-uppercase fw-bold small pb-1">Pagos</a>
            
            <div class="vr text-dark opacity-25"></div>
            
            <a href="?pagina=logout" class="text-danger text-decoration-none text-uppercase fw-bold small pb-1">Salir</a>
        </div>
    </div>
</nav>

<div class="container py-5 min-vh-100">
    <!-- Encabezado de la Sección -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h4 class="fw-bold text-uppercase m-0 text-dark">Mis Rutinas</h4>
            <span class="text-muted small">Gestiona tus entrenamientos o inicia el modo interactivo</span>
        </div>
        <button type="button" class="btn btn-dark rounded-3 px-4 py-2 fw-bold shadow-sm" id="btnNuevaRutina">
            <i class="bi bi-plus-lg me-2"></i> NUEVA RUTINA
        </button>
    </div>

    <!-- CALENDARIO DE RACHA DE 7 DÍAS -->
    <div id="contenedor_racha" class="mb-5 d-none">
        <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-uppercase m-0 text-dark">Historial Reciente</h6>
                    <span class="badge bg-danger rounded-pill px-3 py-2 fs-6 shadow-sm" id="badgeRachaGlobal">
                        🔥 0 días seguidos
                    </span>
                </div>
                <div class="d-flex justify-content-between text-center mt-4 px-2 px-md-5" id="calendarioRacha">
                    <!-- El JS inyectará los 7 círculos aquí -->
                </div>
            </div>
        </div>
    </div>
    
    <!-- Contenedor de Tarjetas de Rutinas del Cliente -->
    <div class="row g-4" id="contenedor_rutinas">
        <!-- Las tarjetas se cargan dinámicamente mediante AJAX -->
    </div>
</div>

<!-- MODAL ENTRENAMIENTO -->

<div class="modal fade" id="modalEntrenamiento" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow-lg bg-light">
            <div class="modal-header bg-white border-bottom p-4">
                <div>
                    <span class="text-muted text-uppercase mb-1 small fw-bold" style="letter-spacing: 1px;">Modo Entrenamiento</span>
                    <h5 class="modal-title fw-bold text-uppercase m-0 text-dark" id="offcanvasRutinaLabel">Nombre de la Rutina</h5>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <!-- Visor Principal del Ejercicio Actual -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden bg-white flex-shrink-0">
                    <div class="position-relative" style="height: 240px; background: #f8f9fa;">
                        <img id="detalleImagen" src="img/default.jpg" class="w-100 h-100 object-fit-cover" alt="Ejercicio">
                        
                        <!-- Flecha Anterior  -->
                        <button type="button" class="btn border-0 position-absolute top-50 start-0 translate-middle-y ms-2 d-flex justify-content-center align-items-center rounded-circle" id="btnPrevEjercicio" style="width: 38px; height: 38px; background: rgba(0,0,0,0.5); z-index: 10;">
                            <i class="bi bi-chevron-left text-white fs-5"></i>
                        </button>

                        <!-- Flecha Siguiente  -->
                        <button type="button" class="btn border-0 position-absolute top-50 end-0 translate-middle-y me-2 d-flex justify-content-center align-items-center rounded-circle" id="btnNextEjercicio" style="width: 38px; height: 38px; background: rgba(0,0,0,0.5); z-index: 10;">
                            <i class="bi bi-chevron-right text-white fs-5"></i>
                        </button>

                        <span id="detalleSeriesRepsBadge" class="position-absolute bottom-0 start-0 m-3 badge bg-white text-dark border px-3 py-2 fs-6 rounded-pill shadow-sm" style="z-index: 10;">-- Series x -- Reps</span>
                    </div>
                    <div class="card-body p-4">
                        <h5 id="detalleNombreEjercicio" class="fw-bold text-uppercase mb-2 text-dark">Selecciona un ejercicio</h5>
                        <p id="detalleDescripcionEjercicio" class="text-muted small mb-0" style="line-height: 1.6;">La descripción técnica del movimiento se mostrará aquí...</p>
                    </div>
                </div>

                <!-- Lista Inferior Estilo Playlist -->
                <div class="d-flex justify-content-between align-items-center mb-3 px-1 mt-2">
                    <h6 class="fw-bold text-uppercase text-dark small m-0">Lista de Ejercicios</h6>
                    <span class="small fw-bold text-muted" id="contadorPlaylist">0 items</span>
                </div>
                
                <div id="playlistEjerciciosContainer" class="d-flex flex-column gap-2 pb-2">
                    <!-- Las mini-tarjetas de la playlist se inyectan por JS aquí -->
                </div>
            </div>
            
            <!-- NUEVO FOOTER PARA LA RACHA -->
            <div class="modal-footer px-4 py-3 bg-white border-top rounded-bottom-4 d-flex justify-content-between align-items-center">
                <div id="mensaje-racha" class="small fw-bold"></div>
                <button type="button" class="btn btn-success rounded-3 px-4 py-2 fw-bold shadow-sm" id="btnMarcarHecha">
                    <i class="bi bi-check-circle-fill me-2"></i> RUTINA COMPLETADA
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL: CREAR / EDITAR RUTINA -->

<div class="modal fade" id="modalRutina" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered modal-lg">
     <div class="modal-content rounded-4 border-0 shadow-lg">
       <div class="modal-header bg-white border-bottom px-4 py-4">
         <div>
             <h5 class="modal-title fw-bold text-dark text-uppercase mb-1" id="tituloModalRutina">NUEVA RUTINA</h5>
             <span class="text-muted small">Configura los ejercicios de tu plan</span>
         </div>
         <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body p-4 bg-white">
            <form id="formRutina">
                <input type="hidden" id="id_rutina" name="id_rutina">
                <input type="hidden" id="accionRutina" name="accionRutina" value="incluir"> 
                
                <div class="mb-4">
                    <label class="form-label small fw-bold text-dark text-uppercase">Nombre de la Rutina</label>
                    <input type="text" class="form-control bg-light border-0 rounded-3 py-2 px-3 shadow-none" id="nombre_rutina" name="nombre_rutina" placeholder="Ej. Piernas y Glúteos" required autocomplete="off">
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                    <label class="form-label small fw-bold text-dark text-uppercase m-0">Ejercicios</label>
                    <button type="button" class="btn btn-light border rounded-3 px-3 py-1 text-dark fw-bold small" id="btnAgregarEjercicio">
                        <i class="bi bi-plus me-1"></i> Añadir
                    </button>
                </div>

                <!-- Cabeceras de etiquetas para los campos dinámicos -->
                <div class="row g-2 px-2 text-muted small fw-bold text-uppercase mb-2">
                    <div class="col-md-5">Ejercicio</div>
                    <div class="col-md-3 text-center">Series</div>
                    <div class="col-md-3 text-center">Reps</div>
                    <div class="col-md-1 text-center"></div>
                </div>

                <!-- Contenedor donde el JS inyectará las filas dinámicas -->
                <div id="contenedorEjercicios" class="d-flex flex-column gap-2" style="max-height: 280px; overflow-y: auto; overflow-x: hidden;">
                    <!-- Las filas dinámicas se inyectan aquí -->
                </div>
            </form>
       </div>
       <div class="modal-footer px-4 py-3 bg-white border-top rounded-bottom-4">
            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary rounded-3 px-4 py-2 fw-bold">CANCELAR</button>
            <button type="button" class="btn btn-dark rounded-3 px-4 py-2 fw-bold shadow-sm" id="btnGuardarRutina">GUARDAR RUTINA</button>
       </div>
    </div>
   </div>
</div>

<!-- MODAL: ELIMINAR RUTINA -->

<div class="modal fade" id="modalEliminarRutina" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-body text-center p-4">
                <input type="hidden" id="id_eliminar_rutina">
                <div class="text-danger mb-3 mt-2"><i class="bi bi-trash3 fs-1"></i></div>
                <h5 class="fw-bold mb-1 text-dark">¿Eliminar rutina?</h5>
                <p class="text-muted small mb-4">Esta acción no se puede deshacer.</p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light border rounded-3 py-2 px-4 fw-bold text-muted" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="button" class="btn btn-danger rounded-3 py-2 px-4 fw-bold" id="btnConfirmarEliminarRutina">ELIMINAR</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
require_once("comunes/modal.php");
require_once("comunes/pie.php"); 
?>

<script src="js/clientes_rutina.js?v=<?php echo time(); ?>"></script>