<?php require_once("comunes/encabezado.php"); ?>

<!-- Menú Superior Blanco (Fijo) -->
<nav class="bg-white border-bottom py-4 sticky-top">
    <div class="container d-flex justify-content-between align-items-center">
        <h4 class="fw-bold m-0 text-dark text-uppercase" style="letter-spacing: 3px;">GALA GYM</h4>
        
        <div class="d-flex align-items-center gap-4">
            <!-- Indicador visual de página activa: borde inferior oscuro -->
            <a href="?pagina=clientes_rutina" class="text-dark text-decoration-none text-uppercase fw-bold small pb-1 border-bottom border-2 border-dark">Rutinas</a>
            
            <!-- Enlace inactivo: texto gris -->
            <a href="?pagina=pago" class="text-secondary text-decoration-none text-uppercase fw-bold small pb-1">Pagos</a>
            
            <div class="vr text-dark opacity-25"></div>
            
        </div>
    </div>
</nav>

<!-- Contenedor Principal -->
<div class="container py-5 min-vh-100">
    
    <!-- Cabecera de la sección -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 gap-3">
        <div>
            <h2 class="fw-bold text-uppercase mb-1">Plan de Entrenamiento</h2>
            <p class="text-muted mb-0">Selecciona tu rutina asignada para visualizar los ejercicios.</p>
        </div>
        
        <!-- Buscador minimalista -->
        <div style="max-width: 300px; width: 100%;">
            <input type="text" class="form-control rounded-0 bg-light border-0 py-2 px-3 shadow-none" id="buscadorRutinaCliente" placeholder="Buscar rutina...">
        </div>
    </div>

    <!-- Grid de Rutinas -->
    <div class="row g-4" id="contenedor_rutinas">
        
        <!-- TARJETA DE EJEMPLO -->
        <div class="col-md-6 col-lg-4">
            <!-- Solo clases Bootstrap: shadow estática y border-0 -->
            <div class="card h-100 border-0 shadow rounded-4">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="mb-3">
                        <span class="badge bg-dark rounded-0 fw-normal text-uppercase" style="letter-spacing: 1px;">Hipertrofia</span>
                    </div>
                    
                    <h5 class="fw-bold text-uppercase mb-2">Tren Superior</h5>
                    <p class="text-muted small mb-4">Enfoque en pecho, espalda y brazos. Adaptado a tu nivel de resistencia actual.</p>
                    
                    <div class="d-flex align-items-center justify-content-between mt-auto pt-3 border-top">
                        <span class="small fw-bold text-secondary">8 Ejercicios</span>
                        <button class="btn btn-outline-dark btn-sm rounded-0 text-uppercase fw-bold px-3">
                            Ver detalles
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN TARJETA DE EJEMPLO -->

    </div>
</div>

<?php 
require_once("comunes/pie.php");
// require_once("comunes/modal.php"); 
?>
<script src="js/clientes_rutina.js?v=<?php echo time(); ?>"></script>