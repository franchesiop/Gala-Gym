<?php 
require_once("comunes/encabezado.php"); 
?>

<div class="container-fluid">
    <div class="row">
        
        <?php require_once("comunes/menu.php"); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light min-vh-100">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom bg-white px-3 mt-3 shadow-sm">
                
                <div class="d-flex align-items-center">
                   
                    <h5 class="fw-bold text-uppercase m-0 small">Panel / Dashboard</h5>
                </div>
                <div class="d-flex align-items-center">
                    <span class="small fw-bold me-3 text-muted">Hola, <?php echo $_SESSION['nombre']; ?></span>
                    <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 35px; height: 35px; font-size: 0.8rem;">
                        <?php echo substr($_SESSION['nombre'], 0, 2); ?>
                    </div>
                </div>
            </div>

            <div class="p-2">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-0 bg-white p-3 border-start border-dark border-4">
                            <h6 class="text-muted small fw-bold text-uppercase">Clientes</h6>
                            <h2 class="fw-bold m-0">0</h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-0 bg-white p-3 border-start border-primary border-4">
                            <h6 class="text-muted small fw-bold text-uppercase">Ingresos Mensuales</h6>
                            <h2 class="fw-bold m-0">$0</h2>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
    </div>
</div>

<?php require_once("comunes/pie.php"); ?>
<script src="js/admin.js"></script>