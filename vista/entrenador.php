<?php require_once("comunes/encabezado.php"); ?>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-dark text-white min-vh-100 p-0 shadow">
            <div class="p-4 border-bottom border-secondary text-center">
                <h4 class="fw-bold m-0 text-uppercase" style="letter-spacing: 2px;">Coach</h4>
            </div>
            <div class="mt-2">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="?pagina=entrenador&seccion=atletas" class="nav-link text-white py-3 px-4 border-bottom border-secondary small fw-bold">MIS ATLETAS</a>
                    </li>
                </ul>
            </div>
            <div class="p-4 mt-5">
                <a href="?pagina=principal" class="btn btn-outline-danger btn-sm w-100 rounded-0 fw-bold">SALIR</a>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom bg-white px-3 mt-3 shadow-sm">
                <h5 class="fw-bold text-uppercase m-0 small">Gestión de Entrenamiento</h5>
                <div class="d-flex align-items-center">
                    <span class="small fw-bold me-3 text-muted">Coach: Jesus Cordero</span>
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 35px; height: 35px; font-size: 0.8rem;">JC</div>
                </div>
            </div>

            <div class="p-2">
                <?php 
                $seccion = isset($_GET['seccion']) ? $_GET['seccion'] : 'atletas'; 
                if ($seccion == 'atletas'): 
                ?>
                    <div class="bg-white p-4 shadow-sm border">
                        <h6 class="fw-bold mb-4 text-uppercase">Atletas Asignados</h6>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle small">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th>NOMBRE DEL ATLETA</th>
                                        <th>OBJETIVO</th>
                                        <th class="text-center">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold">
                                    <tr>
                                        <td>Juanita Juanites</td>
                                        <td>Pérdida de Peso / Tonificación</td>
                                        <td class="text-center">
                                            <button class="btn btn-info btn-sm text-white rounded-0 fw-bold px-3 shadow-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalEditarRutina">
                                                CONSULTAR / EDITAR
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="modalEditarRutina" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content rounded-0 border-0 shadow-lg">
            <div class="modal-header bg-dark text-white rounded-0">
                <h6 class="modal-title fw-bold text-uppercase">Plan de Juanita Juanites</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-light p-4">
                <form>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">RUTINA LUNES (PECHO/BRAZOS)</label>
                        <textarea class="form-control rounded-0 border-dark small" rows="2">Press banca 4x12, Curl de bíceps 3x15</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">RUTINA MIÉRCOLES (PIERNAS)</label>
                        <textarea class="form-control rounded-0 border-dark small" rows="2">Sentadillas 4x10, Prensa 4x12</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">NOTAS DEL COACH</label>
                        <textarea class="form-control rounded-0 border-dark small" rows="2" placeholder="Añadir observaciones..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-white border-0">
                <button type="button" class="btn btn-outline-dark btn-sm rounded-0 px-3 fw-bold" data-bs-dismiss="modal">CANCELAR</button>
                <button type="button" class="btn btn-primary btn-sm rounded-0 px-3 fw-bold">GUARDAR CAMBIOS</button>
            </div>
        </div>
    </div>
</div>

<?php require_once("comunes/pie.php"); ?>