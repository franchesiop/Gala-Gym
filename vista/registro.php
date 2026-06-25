<?php require_once("comunes/encabezado.php"); ?>
<?php require_once("comunes/modal.php"); ?>

<div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
    
    <div class="card border-0 shadow-lg rounded-4 p-4" style="max-width: 450px; width: 100%;">
        <div class="card-body p-0">
            
            <div class="text-center mb-3">
                <h3 class="fw-bold text-uppercase">Nueva cuenta</h3>
                <p class="text-muted small">Crea tu cuenta ahora</p>
            </div>

            <form id="f" autocomplete="off">
                <input type="text" name="accion" id="accion" style="display:none">
                
                <!-- Usamos mb-2 para apretar los campos verticalmente -->
                <div class="mb-2">
                    <label class="form-label small fw-bold">Cédula</label>
                    <input type="text" id="cedula" name="cedula" class="form-control rounded-pill border-light bg-light py-2 px-3">
                    <span id="scedula" class="text-danger small"></span>
                </div>

                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Nombre</label>
                        <input type="text" id="nombres" name="nombre" class="form-control rounded-pill border-light bg-light py-2 px-3">
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Apellido</label>
                        <input type="text" id="apellidos" name="apellido" class="form-control rounded-pill border-light bg-light py-2 px-3">
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label small fw-bold">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" class="form-control rounded-pill border-light bg-light py-2 px-3">
                </div>

                <div class="mb-2">
                    <label class="form-label small fw-bold">Correo Electrónico</label>
                    <input type="email" id="correo" name="correo" class="form-control rounded-pill border-light bg-light py-2 px-3">
                    <span id="scorreo" class="text-danger small"></span>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" class="form-control rounded-pill border-light bg-light py-2 px-3">
                </div>

                <div class="d-grid">
                    <button type="button" id="incluir" class="btn btn-dark rounded-pill py-2 fw-bold text-uppercase">
                        Registrarse
                    </button>
                </div>
                
                <button type="button" id="consultar" style="display:none"></button>

                <div class="text-center mt-2">
                    <a href="?pagina=login" class="text-decoration-none text-muted small fw-bold">¿Ya tienes cuenta? Inicia sesión</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="js/registro.js"></script>
<?php require_once("comunes/pie.php"); ?>