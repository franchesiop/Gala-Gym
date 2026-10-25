<?php require_once("comunes/encabezado.php"); ?>

<!-- Contenedor Principal a pantalla completa -->
<div class="position-relative min-vh-100 overflow-hidden w-100 d-flex flex-column">
    
    <!-- Imagen actuando como fondo -->
    <img src="img/imagengimnasio.webp" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover z-0" alt="Fondo Gimnasio">

    <!-- Menú en el flujo natural superior (z-3) -->
    <nav class="position-relative w-100 py-4 z-3" style="background: linear-gradient(to bottom, rgba(0,0,0,0.8) 0%, transparent 100%);">
        <div class="container d-flex justify-content-between align-items-center">
            <h4 class="fw-bold m-0 text-white text-uppercase" style="letter-spacing: 3px; text-shadow: 1px 1px 3px rgba(0,0,0,0.9);">GALA GYM</h4>
            
            <div class="d-flex align-items-center gap-4">
                <a href="?pagina=clientes_rutina" class="text-white text-decoration-none text-uppercase fw-bold small" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.9);">Rutinas</a>
                <a href="?pagina=pago" class="text-white text-decoration-none text-uppercase fw-bold small" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.9);">Pagos</a>
            </div>
        </div>
    </nav>

    <!-- Contenido Central ocupando el resto de la altura (flex-grow-1) -->
    <div class="container position-relative z-2 flex-grow-1 d-flex align-items-center py-4">
        <div class="row w-100 align-items-center g-5">
            
            <!-- Izquierda: Tarjeta Principal -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg rounded-4 p-5">
                    <div class="card-body p-0">
                        <h1 class="fw-bold text-uppercase mb-3">TU MEJOR LUGAR DE ENTRENO</h1>
                        <p class="text-muted mb-4 fs-6">
                            Bienvenido a tu plataforma de entrenamiento. Aquí podrás gestionar tus rutinas personalizadas, 
                            revisar tus pagos y mantenerte al tanto de tus objetivos fitness.
                        </p>
                        <div class="d-flex align-items-center gap-4 mt-2">
                            <a href="?pagina=pago" class="btn btn-dark rounded-0 px-4 py-2 text-uppercase fw-bold">
                                Registrar Pago
                            </a>
                            <!-- Botón de Cerrar Sesión reubicado -->
                            <a href="?pagina=logout" class="text-danger fw-bold text-decoration-none small text-uppercase">
                                Cerrar Sesión
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Derecha: Tarjetas de Beneficios -->
            <div class="col-lg-6 d-flex flex-column gap-3">
                
                <div class="card border-0 shadow rounded-4 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-dark text-white rounded-circle d-flex justify-content-center align-items-center flex-shrink-0" style="width: 50px; height: 50px;">
                            <i class="bi bi-lightning-charge-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 text-uppercase">Energía al Máximo</h6>
                            <p class="text-muted small mb-0">Aumenta tu resistencia y vitalidad para el día a día con entrenamientos guiados.</p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow rounded-4 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-dark text-white rounded-circle d-flex justify-content-center align-items-center flex-shrink-0" style="width: 50px; height: 50px;">
                            <i class="bi bi-shield-fill-check fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 text-uppercase">Salud y Bienestar</h6>
                            <p class="text-muted small mb-0">Mejora tu condición física, fortalece tu sistema inmunológico y previene lesiones.</p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow rounded-4 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-dark text-white rounded-circle d-flex justify-content-center align-items-center flex-shrink-0" style="width: 50px; height: 50px;">
                            <i class="bi bi-graph-up-arrow fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 text-uppercase">Progresión Continua</h6>
                            <p class="text-muted small mb-0">Supera tus límites de fuerza e hipertrofia mediante una sobrecarga progresiva.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php require_once("comunes/pie.php"); ?>