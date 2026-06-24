<?php require_once("comunes/encabezado.php"); ?>

<div class="container d-flex align-items-center justify-content-center" style="min-height: 85vh;">
    <div class="card border-0 shadow-lg rounded-0" style="max-width: 450px; width: 100%;">
        <div class="card-body p-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-uppercase" style="letter-spacing: 2px;">INICIO SESION</h2>
                <p class="text-muted small text-uppercase">Ingresa tus datos</p>
            </div>

            <form action="?pagina=login" method="POST">
                <div class="mb-4">
                    <label class="form-label fw-bold small text-uppercase">Correo Electrónico</label>
                    <input type="email" name="correo" class="form-control rounded-0 border-dark py-2" 
                           placeholder="ejemplo@gmail .com" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small text-uppercase">Contraseña</label>
                    <input type="password" name="contrasena" class="form-control rounded-0 border-dark py-2" 
                           required>
                </div>

                <div class="d-grid gap-2 mt-5">
                    <button type="submit" class="btn btn-dark rounded-0 py-2 fw-bold text-uppercase">
                        Entrar
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <a href="?pagina=registro" class="text-decoration-none text-muted small fw-bold">REGISTRARSE</a>
            </div>
        </div>
    </div>
</div>

<?php
 require_once("comunes/pie.php");
?>
<script src="js/login.js"></script>