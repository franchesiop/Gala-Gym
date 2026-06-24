<?php require_once("comunes/encabezado.php"); ?>

<nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-uppercase" href="index.php" style="letter-spacing: 1px; font-size: 1.4rem;">GALA GYM</a>
        <div class="ms-auto">
            <a class="btn btn-outline-dark fw-bold small px-4 rounded-0" href="?pagina=login">INICIAR SESIÓN</a>
        </div>
    </div>
</nav>

<main class="container mt-5 pt-lg-4">
    <div class="row align-items-center">
        <div class="col-lg-6 pe-lg-5 mb-5 mb-lg-0">
            <h1 class="display-3 fw-bold mb-4" style="line-height: 1.1; color: #111;">
                Estamos aquí para ayudarte a alcanzar tu meta.
            </h1>
            <p class="text-muted mb-5 fw-bold" style="letter-spacing: 0.5px; font-size: 0.85rem; opacity: 0.8;">
                UN DEDICADO GRUPO DE ENTRENADORES DISPUESTOS A GUIARTE.
            </p>
            <a href="?pagina=registro" class="btn btn-dark rounded-0 px-5 py-3 fw-bold shadow-sm text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
                EMPEZAR AHORA
            </a>
        </div>

        <div class="col-lg-6">
            <div class="position-relative">
                <img src="img/pico_entrenamiento.original.jpg" 
                     alt="Entrenamiento Gala Gym" 
                     class="img-fluid rounded-3 shadow-lg w-100" 
                     style="object-fit: cover;">
            </div>
        </div>
    </div>
</main>

<?php require_once("comunes/pie.php"); ?>