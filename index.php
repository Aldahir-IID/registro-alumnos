<?php 
session_start();
if(isset($_SESSION['role'])){
    if($_SESSION['role'] == 'admin'){
        header("Location: pages/admin/dashboard.php");
    } else {
        header("Location: pages/student/my_profile.php");
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema | Universidad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static/css/style.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border-radius: 15px;
        }
        .brand-logo {
            color: var(--color-primary);
            font-weight: bold;
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="card login-card">
        <div class="card-body">
            <div class="brand-logo">
                Sistema Escolar
            </div>

            <h5 class="card-title text-center mb-4">Iniciar Sesión</h5>

            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger text-center">
                    <?php 
                        if($_GET['error'] == 'pass') echo "Contraseña incorrecta.";
                        if($_GET['error'] == 'user') echo "El correo no existe.";
                    ?>
                </div>
            <?php endif; ?>

            <form action="actions/login.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Institucional</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="matricula@upemor.edu.mx">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>
            </form>

            <hr class="my-4">

            <div class="text-center">
                <p class="small text-muted">¿Eres alumno de nuevo ingreso?</p>
                <a href="pages/register.php" class="btn btn-secondary w-100">Registrarse como Alumno</a>
            </div>

            <div style="text-align: center; margin-top: 25px; font-size: 11px; color: #888; line-height: 1.4;">
                 <strong>Aviso:</strong> Este es un proyecto académico de prueba.<br>
                No es un portal oficial de la UPEMOR. <br>
                Por tu seguridad, <strong>no utilices datos reales</strong> ni contraseñas de uso personal.
            </div>

        </div>
    </div>

</body>
</html>