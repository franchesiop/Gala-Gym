<?php require_once("comunes/encabezado.php"); ?>

<div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
    
    <div class="card border-0 shadow-lg rounded-4 p-4" style="max-width: 450px; width: 100%;">
        <div class="card-body">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-uppercase">Bienvenido</h3>
                <p class="text-muted small">Inicia sesión para continuar</p>
            </div>

            <form action="?pagina=login" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Correo Electrónico</label>
                    <input type="email" name="correo" class="form-control rounded-pill border-light bg-light py-2 px-3" 
                           placeholder="nombre@ejemplo.com" required>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold">Contraseña</label>
                    <input type="password" name="contrasena" class="form-control rounded-pill border-light bg-light py-2 px-3" 
                           placeholder="••••••••" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-dark rounded-pill py-2 fw-bold text-uppercase">
                        Entrar
                    </button>
                </div>
            </form>

            <div class="text-center mt-3">
                <a href="?pagina=registro" class="text-decoration-none text-muted small fw-bold">¿No tienes cuenta? Regístrate</a>
            </div>
        </div>
    </div>
</div>

<?php require_once("comunes/pie.php"); ?>
<script src="js/login.js"></script>