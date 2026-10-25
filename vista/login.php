<?php require_once("comunes/encabezado.php"); ?>

<!-- Contenedor Principal a pantalla completa -->
<div class="position-relative min-vh-100 w-100 overflow-hidden d-flex align-items-center justify-content-center">
    
    <!-- Imagen de fondo natural, sin capa oscura -->
    <img src="img/pesas.webp" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover z-0" alt="Fondo Login">

    <!-- Contenedor relativo para que la tarjeta flote sobre el fondo (z-2) -->
    <div class="position-relative z-2 w-100 px-3 d-flex justify-content-center">
        
        <div class="card border-0 rounded-4 p-4" style="max-width: 450px; width: 100%; box-shadow: 0px 25px 40px rgba(0,0,0,0.6);">
            <div class="card-body">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-uppercase">Bienvenido</h3>
                    <p class="text-muted small">Inicia sesión para continuar</p>
                </div>

                <form id="formLogin">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Correo Electrónico</label>
                        <input type="email" name="correo" id="correo" class="form-control rounded-pill border-light bg-light py-2 px-3" 
                               placeholder="nombre@ejemplo.com" required>
                        <span id="scorreo" class="text-danger small fw-bold"></span>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Contraseña</label>
                        <input type="password" name="contrasena" id="contrasena" class="form-control rounded-pill border-light bg-light py-2 px-3" 
                               placeholder="••••••••" required>
                        <span id="scontrasena" class="text-danger small fw-bold"></span>
                    </div>

                    <div class="d-grid">
                        <button type="submit" id="btnEntrar" class="btn btn-dark rounded-pill py-2 fw-bold text-uppercase">
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
</div>

<?php 
require_once("comunes/pie.php");
require_once("comunes/modal.php");
?>
<script src="js/login.js?v=<?php echo time(); ?>"></script>