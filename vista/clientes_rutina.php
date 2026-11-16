<?php require_once("comunes/encabezado.php"); ?>

<nav class="navbar navbar-expand bg-white border-bottom shadow-sm sticky-top py-3">
    <div class="container">
        <span class="navbar-brand fw-bolder text-dark text-uppercase m-0">
            <i class="bi bi-lightning-charge-fill me-1"></i>Gala Gym
        </span>

        <ul class="navbar-nav ms-auto align-items-center gap-1">
            <li class="nav-item">
                <a href="?pagina=clientes_rutina" class="nav-link active fw-bold text-dark text-uppercase small px-3">
                    <i class="bi bi-lightning-charge me-1"></i>Rutinas
                </a>
            </li>
            <li class="nav-item">
                <a href="?pagina=pago" class="nav-link text-secondary text-uppercase small fw-bold px-3">
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

        <!-- Encabezado -->
        <header class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4 pb-4 border-bottom">
            <div>
                <p class="text-uppercase text-secondary fw-semibold small mb-1">Bienvenido</p>
                <h1 class="h2 fw-bold text-dark text-uppercase m-0">Mis Rutinas</h1>
                <p class="text-muted mb-0">Gestiona tus entrenamientos o inicia el modo interactivo</p>
            </div>
            <button type="button" class="btn btn-dark btn-lg rounded-3 px-4 fw-bold shadow-sm" id="btnNuevaRutina">
                <i class="bi bi-plus-lg me-2"></i>Nueva rutina
            </button>
        </header>

        <!-- Historial de Racha -->
        <section id="contenedor_racha" class="mb-5 d-none">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header bg-white border-0 rounded-top-4 px-4 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h2 class="h6 fw-bold text-uppercase text-dark m-0">
                        <i class="bi bi-calendar-check me-2"></i>Historial reciente
                    </h2>
                    <span class="badge text-bg-dark rounded-pill px-3 py-2 fs-6" id="badgeRachaGlobal">
                        🔥 0 días seguidos
                    </span>
                </div>
                <div class="card-body px-4 pb-4 pt-3">
                    <div class="d-flex justify-content-between text-center px-0 px-md-4" id="calendarioRacha">
                    </div>
                </div>
            </div>
        </section>

        <!-- Listado de rutinas -->
        <section>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h6 fw-bold text-uppercase text-dark m-0">
                    <i class="bi bi-collection me-2"></i>Entrenamientos
                </h2>
            </div>
            <div class="row g-4" id="contenedor_rutinas">
            </div>
        </section>

    </div>
</main>

<!-- Modal Modo Entrenamiento -->
<div class="modal fade" id="modalEntrenamiento" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow-lg bg-light">
            <div class="modal-header bg-white border-bottom px-4 py-3">
                <div>
                    <span class="d-block text-uppercase text-secondary small fw-semibold">Modo entrenamiento</span>
                    <h5 class="modal-title fw-bold text-uppercase m-0 text-dark" id="offcanvasRutinaLabel">Nombre de la Rutina</h5>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden flex-shrink-0">
                    <div class="position-relative bg-secondary-subtle">
                        <div class="ratio ratio-16x9">
                            <img id="detalleImagen" src="img/default.jpg" class="object-fit-cover" alt="Ejercicio">
                        </div>

                        <button type="button" class="btn btn-dark border-0 position-absolute top-50 start-0 translate-middle-y ms-2 rounded-circle shadow p-0" id="btnPrevEjercicio">
                            <i class="bi bi-chevron-left fs-5 px-2 py-1 d-block"></i>
                        </button>

                        <button type="button" class="btn btn-dark border-0 position-absolute top-50 end-0 translate-middle-y me-2 rounded-circle shadow p-0" id="btnNextEjercicio">
                            <i class="bi bi-chevron-right fs-5 px-2 py-1 d-block"></i>
                        </button>

                       <span id="detalleSeriesRepsBadge" class="position-absolute bottom-0 start-0 m-3 badge bg-dark text-white border-0 px-3 py-2 fs-6 rounded-pill shadow">-- Series x -- Reps</span>
                    </div>
                    <div class="card-body p-4 bg-white">
                        <h5 id="detalleNombreEjercicio" class="fw-bold text-uppercase mb-2 text-dark">Selecciona un ejercicio</h5>
                        <p id="detalleDescripcionEjercicio" class="text-muted small mb-0">La descripción técnica del movimiento se mostrará aquí...</p>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3 px-1">
                    <h6 class="fw-bold text-uppercase text-dark small m-0">Lista de ejercicios</h6>
                    <span class="badge text-bg-secondary rounded-pill px-3" id="contadorPlaylist">0 items</span>
                </div>

                <div id="playlistEjerciciosContainer" class="d-flex flex-column gap-2 pb-2">
                </div>
            </div>

            <div class="modal-footer px-4 py-3 bg-white border-top d-flex justify-content-between align-items-center">
                <div id="mensaje-racha" class="small fw-bold"></div>
                <button type="button" class="btn btn-success rounded-3 px-4 py-2 fw-bold shadow-sm" id="btnMarcarHecha">
                    <i class="bi bi-check-circle-fill me-2"></i>Rutina completada
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva/Editar Rutina -->
<div class="modal fade" id="modalRutina" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
     <div class="modal-content rounded-4 border-0 shadow-lg">
       <div class="modal-header bg-white border-bottom px-4 py-3">
         <div>
             <h5 class="modal-title fw-bold text-dark text-uppercase mb-0" id="tituloModalRutina">NUEVA RUTINA</h5>
             <span class="text-muted small">Configura los ejercicios de tu plan</span>
         </div>
         <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body p-4 bg-white">
            <form id="formRutina">
                <input type="hidden" id="id_rutina" name="id_rutina">
                <input type="hidden" id="accionRutina" name="accionRutina" value="incluir">

                <div class="mb-4">
                    <label class="form-label small fw-bold text-secondary text-uppercase">Nombre de la rutina</label>
                    <input type="text" class="form-control form-control-lg bg-light border-0 rounded-3" id="nombre_rutina" name="nombre_rutina" placeholder="Ej. Piernas y Glúteos" required autocomplete="off">
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <label class="form-label small fw-bold text-secondary text-uppercase m-0">Ejercicios</label>
                    <button type="button" class="btn btn-outline-dark btn-sm rounded-3 px-3 fw-bold" id="btnAgregarEjercicio">
                        <i class="bi bi-plus-lg me-1"></i>Añadir
                    </button>
                </div>

                <div class="row g-2 px-2 text-muted small fw-bold text-uppercase mb-2">
                    <div class="col-md-5">Ejercicio</div>
                    <div class="col-md-3 text-center">Series</div>
                    <div class="col-md-3 text-center">Reps</div>
                    <div class="col-md-1 text-center"></div>
                </div>

                <div id="contenedorEjercicios" class="d-flex flex-column gap-2 overflow-x-hidden">
                </div>
            </form>
       </div>
       <div class="modal-footer px-4 py-3 bg-light border-top">
            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary rounded-3 px-4 fw-bold">Cancelar</button>
            <button type="button" class="btn btn-dark rounded-3 px-4 fw-bold shadow-sm" id="btnGuardarRutina">Guardar rutina</button>
       </div>
    </div>
   </div>
</div>

<!-- Modal Eliminar Rutina -->
<div class="modal fade" id="modalEliminarRutina" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-body text-center p-4">
                <input type="hidden" id="id_eliminar_rutina">
                <div class="d-inline-flex rounded-circle bg-danger-subtle text-danger p-3 mb-3">
                    <i class="bi bi-trash3 fs-3"></i>
                </div>
                <h5 class="fw-bold mb-1 text-dark">¿Eliminar rutina?</h5>
                <p class="text-muted small mb-4">Esta acción no se puede deshacer.</p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light border rounded-3 px-4 fw-bold text-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger rounded-3 px-4 fw-bold shadow-sm" id="btnConfirmarEliminarRutina">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Listado de Ejercicios -->
<div class="modal fade" id="modal_ejercicios" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-dark text-white border-0">
                <h5 class="modal-title fw-bold small text-uppercase">Catálogo de ejercicios</h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="input-group mb-3 shadow-sm">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control border-0" id="filtrarEjerciciosModal" placeholder="Filtrar por nombre de ejercicio...">
                </div>
                <div class="table-responsive bg-white rounded-3 shadow-sm">
                    <table class="table table-hover align-middle mb-0 small w-100">
                        <thead class="table-light text-muted sticky-top">
                            <tr>
                                <th style="display:none">ID</th>
                                <th class="text-center">Imagen</th>
                                <th>Nombre del ejercicio</th>
                            </tr>
                        </thead>
                        <tbody id="listaEjerciciosModal" class="fw-bold"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once("comunes/modal.php");
require_once("comunes/pie.php");
?>
<script src="js/clientes_rutina.js?v="></script>