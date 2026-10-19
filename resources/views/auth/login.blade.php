<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DTL PREMIER S.A.C. - Acceso Corporativo</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome para Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Fondo General Pulido */
        body {
            background-color: #f1f5f9;
            background-image: radial-gradient(#cbd5e1 0.75px, transparent 0.75px);
            background-size: 20px 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            margin: 0;
            padding: 1.5rem;
        }

        /* Contenedor Flotante de Doble Panel */
        .login-split-card {
            max-width: 920px;
            width: 100%;
            border-radius: 1.25rem;
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.12), 0 8px 16px -6px rgba(15, 23, 42, 0.04);
            background: #ffffff;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            display: flex;
            min-height: 540px;
        }

        /* Panel Izquierdo: Distribución Proporcional de Arriba hacia Abajo */
        .login-banner-side {
            flex: 1.1;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Distribución natural arriba, centro y abajo */
            align-items: flex-start;       /* Alineado estéticamente a la izquierda */
            text-align: left;
            position: relative;
            border-end-style: solid;
            border-end-width: 1px;
            border-end-color: #e2e8f0;
        }

        /* Línea Lateral de Acento Verde Corporativo DTL */
        .banner-accent-line {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 5px;
            background-color: #059669;
        }

        /* Panel Derecho: Formulario de Login */
        .login-form-side {
            flex: 1;
            padding: 45px 42px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #ffffff;
        }

        /* Botón Principal Verde Corporativo DTL */
        .btn-dtl-primary {
            background-color: #059669 !important;
            border-color: #059669 !important;
            color: #ffffff !important;
            height: 48px;
            font-size: 0.95rem;
            transition: all 0.25s ease;
        }
        .btn-dtl-primary:hover {
            background-color: #047857 !important;
            border-color: #047857 !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -4px rgba(5, 150, 105, 0.35) !important;
        }

        /* Estilos e Interacción de los Campos */
        .dtl-input-group .input-group-text {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            color: #059669;
            height: 46px;
            padding-left: 16px;
            padding-right: 14px;
        }

        .dtl-input {
            border-color: #cbd5e1 !important;
            font-size: 0.92rem;
            color: #0f172a;
            transition: all 0.2s ease;
            height: 46px;
            padding-left: 18px !important; /* Espacio cómodo entre el icono y el texto */
        }

        .dtl-input:focus {
            border-color: #059669 !important;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15) !important;
            background-color: #ffffff !important;
            z-index: 3;
        }

        .dtl-input::placeholder {
            color: #94a3b8 !important;
            font-size: 0.88rem;
        }

        /* Botón Ojo Toggle Contraseña */
        .btn-toggle-password {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            color: #64748b;
            transition: all 0.2s ease;
            height: 46px;
            padding-left: 14px;
            padding-right: 14px;
        }
        .btn-toggle-password:hover {
            color: #059669;
            background-color: #f1f5f9;
        }

        /* Adaptabilidad Responsiva */
        @media (max-width: 820px) {
            .login-split-card {
                flex-direction: column;
                max-width: 450px;
            }
            .login-banner-side {
                padding: 35px 25px;
                align-items: center;
                text-align: center;
                border-end-style: none;
                border-bottom: 1px solid #e2e8f0;
            }
            .login-form-side {
                padding: 35px 25px;
            }
        }
    </style>
</head>
<body>

    <div class="login-split-card">
        
        <!-- PANEL IZQUIERDO: DISTRIBUCIÓN VERTICAL PROPORCIONAL DE ARRIBA HACIA ABAJO -->
        <div class="login-banner-side">
            <div class="banner-accent-line"></div>
            
            <!-- 1. Parte Superior: Logo Oficial con excelente respiro -->
            <div class="w-100 mb-4">
                <img src="{{ asset('images/logo-dtl.png') }}" alt="DTL PREMIER S.A.C." style="max-height: 85px; width: auto; object-fit: contain;">
            </div>

            <!-- 2. Parte Central: Textos con jerarquía y espaciado vertical armónico -->
            <div class="w-100 my-auto py-2">
                <h3 class="fw-bold mb-3" style="color: #0f172a; font-size: 1.85rem; letter-spacing: -0.5px; line-height: 1.2;">
                    Bienvenido a ...
                </h3>
                
                <p class="mb-0 text-muted" style="line-height: 1.65; font-size: 0.92rem; color: #475569 !important; max-width: 330px;">
                    Empresa con experiencia solida que brinda servicios de ejecución de obras, consultoría y otros servicios en general.
                </p>
            </div>

            <!-- 3. Parte Inferior: Copyright con separación limpia -->
            <div class="w-100 pt-3 mt-3 border-top" style="border-color: #e2e8f0 !important;">
                <span class="small" style="color: #94a3b8; font-size: 0.73rem;">DTL PREMIER S.A.C. © 2026</span>
            </div>
        </div>

        <!-- PANEL DERECHO: FORMULARIO DE ACCESO -->
        <div class="login-form-side">

            <div class="mb-4">
                <h4 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.35rem; letter-spacing: -0.3px;">Iniciar Sesión</h4>
                <p class="text-muted small mb-0" style="color: #64748b !important; font-size: 0.82rem;">
                    Ingrese su correo corporativo y contraseña autorizada
                </p>
            </div>

            <!-- MENSAJES DE ERROR DE AUTH -->
            @if ($errors->any())
                <div class="alert border-0 rounded-3 shadow-sm mb-3 p-3 text-start" style="background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca !important; font-size: 0.85rem;">
                    <div class="d-flex align-items-center mb-1 fw-bold">
                        <i class="fas fa-circle-exclamation me-2"></i> Error de Autenticación
                    </div>
                    @foreach ($errors->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- FORMULARIO DE ACCESO -->
            <form method="POST" action="{{ route('login') }}" id="login-form">
                @csrf

                <!-- Correo Corporativo -->
                <div class="mb-3 text-start">
                    <label for="email" class="form-label fw-semibold small mb-1" style="color: #0f172a !important;">Correo Corporativo</label>
                    <div class="input-group dtl-input-group">
                        <span class="input-group-text border-end-0">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" class="form-control border-start-0 dtl-input" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="ejemplo@dtl.premier">
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="mb-3 text-start">
                    <label for="password" class="form-label fw-semibold small mb-1" style="color: #0f172a !important;">Contraseña</label>
                    <div class="input-group dtl-input-group">
                        <span class="input-group-text border-end-0">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" class="form-control border-start-0 border-end-0 dtl-input" id="password" name="password" required placeholder="••••••••">
                        <button class="btn btn-toggle-password border-start-0" type="button" id="togglePassword">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Recordar Sesión -->
                <div class="d-flex justify-content-between align-items-center mb-4 text-start">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember" style="border-color: #cbd5e1; cursor: pointer;">
                        <label class="form-check-label small" for="remember" style="cursor: pointer; color: #64748b !important; font-size: 0.82rem;">Recordar sesión</label>
                    </div>
                </div>

                <!-- Botón de Envío -->
                <button type="submit" id="btn-submit" class="btn btn-dtl-primary w-100 fw-bold rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                    <i class="fas fa-right-to-bracket" id="btn-icon"></i>
                    <span id="btn-text">Iniciar Sesión</span>
                </button>
            </form>

            <!-- Pie del Formulario -->
            <div class="text-center mt-4 border-top pt-2.5" style="border-color: #f1f5f9 !important;">
                <span class="text-muted" style="font-size: 0.73rem; color: #94a3b8 !important;">© 2026 DTL PREMIER S.A.C. — Todos los derechos reservados</span>
            </div>

        </div>

    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Alternar visibilidad de contraseña
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if(togglePassword && passwordInput && eyeIcon) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    eyeIcon.classList.toggle('fa-eye');
                    eyeIcon.classList.toggle('fa-eye-slash');
                });
            }

            // Spinner de Carga al Enviar Formulario
            const loginForm = document.getElementById('login-form');
            const btnSubmit = document.getElementById('btn-submit');
            const btnText = document.getElementById('btn-text');
            const btnIcon = document.getElementById('btn-icon');

            if(loginForm && btnSubmit) {
                loginForm.addEventListener('submit', function() {
                    btnSubmit.disabled = true;
                    btnText.textContent = 'Autenticando...';
                    btnIcon.className = 'fas fa-circle-notch fa-spin';
                });
            }
        });
    </script>
</body>
</html>