<div class="modal fade" id="modal_eliminar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0 border-0 shadow">
            <div class="modal-header bg-danger text-white rounded-0 border-0">
                <h5 class="modal-title fw-bold small text-uppercase">Confirmar Eliminación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <i class="bi bi-exclamation-triangle text-danger mb-3" style="font-size: 3rem;"></i>
                <h6 class="fw-bold text-uppercase">¿Seguro que deseas eliminar este registro?</h6>
                <p class="text-muted small mb-0">Esta acción no se puede deshacer y los datos se perderán.</p>
                <!-- input oculto para guardar el id de lo que se va a eliminar -->
                <input type="hidden" id="id_eliminar_global">
            </div>
            <div class="modal-footer d-flex justify-content-between border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary rounded-0 small fw-bold" data-bs-dismiss="modal">CANCELAR</button>
                <button type="button" class="btn btn-danger rounded-0 small fw-bold px-4" id="btnConfirmarEliminar">ELIMINAR</button>
            </div>
        </div>
    </div>
</div>