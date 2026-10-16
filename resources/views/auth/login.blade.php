<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet Obras Civiles - Acceso Corporativo</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 420px;
            width: 100%;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            background: #ffffff;
        }
        .btn-primary-custom {
            background-color: #0d6efd;
            border: none;
        }
        .btn-primary-custom:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-dark">Intranet Obras Civiles</h3>
            <p class="text-muted small">Módulo de Control de Acceso (HU-01)</p>
        </div>

        <!-- Mensajes de Error -->
        @if ($errors->any())
            <div class="alert alert-danger py-2 small">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold small">Correo Corporativo</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="ejemplo@obras.com">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold small">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label small" for="remember">Recordar sesión</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-primary-custom w-100 py-2 fw-semibold">Iniciar Sesión</button>
        </form>

        <div class="text-center mt-4">
            <span class="text-muted" style="font-size: 0.75rem;">© 2026 Sistema de Gestión de Obras Civiles</span>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>