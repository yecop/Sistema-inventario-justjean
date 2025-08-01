<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Creaciones Justean</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>
<body>

    <div class="card login-card shadow-sm">
        <div class="card-body p-5">
            <h3 class="card-title text-center mb-4">Sistema de Inventarios</h3>
            <h5 class="card-subtitle mb-4 text-center text-muted">Creaciones Justean</h5>
            
            <form action="<?php echo URLROOT; ?>auth/login" method="POST">
                
                <?php if(isset($data['error'])) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $data['error']; ?>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="login" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="login" name="login" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>