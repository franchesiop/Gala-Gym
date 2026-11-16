const customClassBase = {
    popup: 'rounded-0 border-0 shadow',
    title: 'fw-bold text-uppercase small text-dark',
    htmlContainer: 'text-muted small',
    actions: 'w-100 px-4 pb-3 d-flex justify-content-between gap-2',
    cancelButton: 'btn btn-outline-secondary rounded-0 small fw-bold px-4'
};

const swalGalaBase = Swal.mixin({
    buttonsStyling: false,
    reverseButtons: true,
    customClass: customClassBase
});

// Reemplaza a modal.php (#mostrarModal)
function mostrarMensaje(mensaje, icono = 'info') {
    Swal.fire({
        title: '<span class="text-uppercase fw-bolder text-secondary fs-6">Gala Gym</span>',
        html: mensaje,
        icon: icono,
        timer: 4000,
        timerProgressBar: true,
        showConfirmButton: false,
        showCloseButton: true,
        customClass: {
            popup: 'shadow-lg border-0 rounded-4'
        }
    });
}

// Reemplaza a modal_eliminar.php (#modal_eliminar)
function alertaEliminar(callbackConfirmar) {
    swalGalaBase.fire({
        title: '¿Seguro que deseas eliminar este registro?',
        text: 'Esta acción no se puede deshacer y los datos se perderán.',
        icon: 'warning',
        iconColor: '#dc3545',
        showCancelButton: true,
        confirmButtonText: 'ELIMINAR',
        cancelButtonText: 'CANCELAR',
        customClass: {
            ...customClassBase,
            confirmButton: 'btn btn-danger rounded-0 small fw-bold px-4'
        }
    }).then((result) => {
        if (result.isConfirmed && typeof callbackConfirmar === 'function') {
            callbackConfirmar();
        }
    });
}

// Reemplaza a modal_confirmar.php (Aprobar pago)
function alertaAprobarPago(callbackConfirmar) {
    swalGalaBase.fire({
        title: '¿Estás seguro de que deseas APROBAR este pago?',
        text: 'El pago pasará a estado aprobado y no podrá revertirse fácilmente.',
        icon: 'question',
        iconColor: '#198754',
        showCancelButton: true,
        confirmButtonText: 'APROBAR',
        cancelButtonText: 'CANCELAR',
        customClass: {
            ...customClassBase,
            confirmButton: 'btn btn-success rounded-0 small fw-bold px-5 text-white'
        }
    }).then((result) => {
        if (result.isConfirmed && typeof callbackConfirmar === 'function') {
            callbackConfirmar();
        }
    });
}

// Reemplaza a modal_rechazar.php (Rechazar pago)
function alertaRechazarPago(callbackConfirmar) {
    swalGalaBase.fire({
        title: '¿Estás seguro de que deseas RECHAZAR este pago?',
        text: 'Esta acción registrará el pago como inválido.',
        icon: 'error',
        iconColor: '#dc3545',
        showCancelButton: true,
        confirmButtonText: 'RECHAZAR',
        cancelButtonText: 'CANCELAR',
        customClass: {
            ...customClassBase,
            confirmButton: 'btn btn-danger rounded-0 small fw-bold px-5 text-white'
        }
    }).then((result) => {
        if (result.isConfirmed && typeof callbackConfirmar === 'function') {
            callbackConfirmar();
        }
    });
}