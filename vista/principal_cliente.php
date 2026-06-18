<?php require_once("comunes/encabezado.php"); ?>

<div class="bg-white border-bottom py-3 mb-4 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <h4 class="fw-bold m-0 text-uppercase" style="letter-spacing: 1px;">Bienvenido</h4>
        
        <nav class="d-flex align-items-center gap-4">
            <a href="?pagina=rutina" class="text-dark fw-bold small text-decoration-none text-uppercase">Rutina</a>
            <a href="?pagina=pago" class="text-dark fw-bold small text-decoration-none text-uppercase">Pagos</a>
            <div class="vr"></div>
            <a href="?pagina=principal" class="text-danger fw-bold small text-decoration-none text-uppercase">Cerrar Sesión</a>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row align-items-center g-5">
        <div class="col-lg-6">
            <img src="img/imagengimnasio.jpg" alt="Gimnasio" class="img-fluid rounded shadow-lg">
        </div>

        <div class="col-lg-6">
            <h2 class="fw-bold text-uppercase mb-3">Gala Gym</h2>
            <p class="text-muted">
                Bienvenido a tu plataforma de entrenamiento. Aquí podrás gestionar tus rutinas personalizadas, 
                revisar tus pagos pendientes y mantenerte al tanto de tus objetivos fitness.
            </p>
            <ul class="list-unstyled mt-4">
                <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Rutinas exclusivas para ti.</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Historial de pagos simplificado.</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Acceso 24/7 a tu cronograma.</li>
            </ul>
            <div class="mt-4">
                <a href="?pagina=rutina" class="btn btn-dark btn-lg rounded-0 px-4">Ver mi rutina</a>
            </div>
        </div>
    </div>
</div>

<?php require_once("comunes/pie.php"); ?>