<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Obras Civiles</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Intranet Obras Civiles (Admin)</a>
            <div class="d-flex">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4 p-md-5 text-center">
                        <span class="badge bg-danger mb-3 px-3 py-2 fs-6">Control Total / Soporte Técnico</span>
                        <h1 class="fw-bold text-dark mb-3">¡Panel de Administración Activo!</h1>
                        <p class="text-muted lead mb-4">
                            Has iniciado sesión con privilegios de administrador general en el sistema de gestión de obras civiles.
                        </p>
                        <hr class="my-4">
                        <div class="text-start bg-light p-3 rounded border">
                            <h5 class="fw-bold text-secondary mb-2">Credenciales de Sesión:</h5>
                            <p class="mb-1"><strong>Nombre:</strong> {{ Auth::user()->name ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Correo:</strong> {{ Auth::user()->email ?? 'N/A' }}</p>
                            <p class="mb-0"><strong>Rol en Sistema:</strong> <span class="badge bg-danger text-uppercase">{{ Auth::user()->role ?? 'N/A' }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>