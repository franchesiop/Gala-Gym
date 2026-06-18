<?php require_once("comunes/encabezado.php"); ?>
<?php require_once("comunes/modal.php"); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-uppercase" style="letter-spacing: 2px;">REGISTRARSE</h3>
                <p class="small text-secondary text-uppercase">Crea tu cuenta</p>
            </div>

            <div class="card border-0 shadow-sm rounded-0 p-4 p-md-5">
                <form id="f" autocomplete="off">
                    <input type="text" name="accion" id="accion" style="display:none">
                    
                    <div class="mb-3">
                        <label class="fw-bold small text-uppercase mb-1">Cédula</label>
                        <input type="text" id="cedula" name="cedula" class="form-control rounded-0 border-dark">
                        <span id="scedula" class="text-danger small"></span>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="fw-bold small text-uppercase mb-1">Nombre</label>
                            <input type="text" id="nombres" name="nombre" class="form-control rounded-0 border-dark">
                            <span id="snombres" class="text-danger small"></span>
                        </div>
                        <div class="col-6">
                            <label class="fw-bold small text-uppercase mb-1">Apellido</label>
                            <input type="text" id="apellidos" name="apellido" class="form-control rounded-0 border-dark">
                            <span id="sapellidos" class="text-danger small"></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold small text-uppercase mb-1">Teléfono</label>
                        <input type="text" id="telefono" name="telefono" class="form-control rounded-0 border-dark">
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold small text-uppercase mb-1">Correo Electrónico</label>
                        <input type="email" id="correo" name="correo" class="form-control rounded-0 border-dark">
                        <span id="scorreo" class="text-danger small"></span>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold small text-uppercase mb-1">Contraseña</label>
                        <input type="password" id="contrasena" name="contrasena" class="form-control rounded-0 border-dark">
                    </div>

                    <div class="d-grid mb-4">
                        <button type="button" id="incluir" class="btn btn-dark rounded-0 fw-bold text-uppercase py-2" style="letter-spacing: 1px;">
                            Registrarme
                        </button>
                    </div>
                    
                    <button type="button" id="consultar" style="display:none"></button>

                    <div class="text-center">
                        <a href="?pagina=login" class="text-secondary small fw-bold text-decoration-none text-uppercase">
                             Volver al inicio de sesión
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="js/registro.js"></script>
<?php require_once("comunes/pie.php"); ?>