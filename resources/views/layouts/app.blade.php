<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Token de seguridad CSRF para peticiones AJAX de Laravel -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Intranet DTL PREMIER</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            background-color: #f8fafc; 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; 
            color: #0f172a;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }
        
        /* Sidebar compacto: 210px */
        .sidebar { 
            height: 100vh; 
            background-color: #090d16 !important; 
            color: #94a3b8; 
            width: 210px; 
            flex-shrink: 0; 
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            border-right: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: 4px 0 25px rgba(0, 0, 0, 0.35);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-wrapper {
            margin-left: 210px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease-in-out;
        }

        @media (max-width: 767.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-wrapper { margin-left: 0 !important; }
        }

        /* Scrollbar estilizado */
        .sidebar-menu::-webkit-scrollbar {
            width: 3px;
        }
        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
        }

        /* Área de Logotipo Tipográfico Corporativo */
        .sidebar-header {
            padding: 2.5rem 1rem 2rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            flex-shrink: 0;
            position: relative;
            background: radial-gradient(ellipse at center, rgba(16, 185, 129, 0.15) 0%, rgba(9, 13, 22, 0) 75%) !important;
            text-align: center;
        }
        .sidebar-header::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 3px;
            background: linear-gradient(90deg, #059669 0%, #10b981 50%, #34d399 100%);
            box-shadow: 0 0 12px rgba(16, 185, 129, 0.6);
        }

        /* Estructura del Logo sin icono ni formato de botón */
        .brand-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .brand-title {
            font-weight: 900;
            font-size: 15px; 
            letter-spacing: 2px;
            color: #ffffff;
            text-transform: uppercase;
            line-height: 1.1;
            margin-bottom: 6px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.8);
        }
        .brand-title .highlight-green {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 8px rgba(16, 185, 129, 0.45));
        }

        .brand-accent-line {
            width: 36px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #10b981, transparent);
            margin: 4px 0 8px 0;
            opacity: 0.85;
        }

        .brand-subtitle {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 2.2px;
            color: #10b981;
            text-transform: uppercase;
            opacity: 0.9;
        }

        /* Menú e ítems con fuente fija a 12px */
        .sidebar-menu {
            flex-grow: 1;
            overflow-y: auto;
            padding: 0.4rem 0.5rem 60px 0.5rem;
            background-color: #090d16 !important;
        }

        .sidebar-heading {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            font-weight: 700;
            padding: 0.8rem 0.5rem 0.3rem 0.5rem;
        }

        .sidebar .nav-link { 
            color: #94a3b8; 
            padding: 0.5rem 0.65rem; 
            margin: 0.12rem 0;
            font-size: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            background: transparent !important;
            border-radius: 7px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar .nav-link:hover { 
            color: #ffffff; 
            background: rgba(255, 255, 255, 0.06) !important; 
            transform: translateX(2px);
        }

        .sidebar .nav-link.active { 
            color: #ffffff !important; 
            background: linear-gradient(90deg, rgba(16, 185, 129, 0.2) 0%, rgba(16, 185, 129, 0.05) 100%) !important; 
            border-left: 3px solid #10b981;
            border-radius: 4px 7px 7px 4px;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.12);
        }

        .sidebar .nav-link i {
            width: 16px;
            text-align: center;
            font-size: 12px;
            margin-right: 0.45rem;
            color: #64748b;
            transition: color 0.2s ease;
        }

        .sidebar .nav-link:hover i { color: #cbd5e1; }
        .sidebar .nav-link.active i { color: #10b981 !important; }

        .nav-tree-symbol {
            font-family: monospace;
            font-size: 12px;
            color: #475569;
            margin-right: 0.35rem;
            font-weight: 600;
        }

        .sidebar-subitem-level-1 {
            font-size: 12px !important;
            padding-left: 0.85rem !important;
            color: #94a3b8;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0; left: 0; width: 100%;
            padding: 0.6rem 0.5rem 0.75rem 0.5rem;
            background-color: #090d16 !important;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            z-index: 10;
        }

        .btn-logout-minimal {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 7px;
            color: #94a3b8;
            font-size: 12px;
            padding: 0.45rem 0.5rem;
            width: 100%;
            transition: all 0.2s ease;
            font-weight: 500;
        }
        .btn-logout-minimal:hover { 
            color: #f87171 !important; 
            background: rgba(239, 68, 68, 0.12) !important;
            border-color: rgba(239, 68, 68, 0.25);
        }

        .mobile-topbar {
            display: none;
            background-color: #090d16;
            color: #ffffff;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #1f2937;
        }
        @media (max-width: 767.98px) {
            .mobile-topbar { display: flex; align-items: center; justify-content: space-between; }
        }

        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
        }
        .sidebar-backdrop.show { display: block; }
    </style>
</head>
<body>

    <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="toggleSidebar()"></div>

    <div class="mobile-topbar">
        <div class="d-flex align-items-center gap-2">
            <button class="btn text-white p-1 border-0" onclick="toggleSidebar()">
                <i class="fas fa-bars fs-5"></i>
            </button>
            <span class="fw-bold text-uppercase" style="font-size: 12px;">DTL <span class="text-success">PREMIER</span></span>
        </div>
        <span class="badge bg-dark border border-secondary text-success" style="font-size: 12px;">{{ strtoupper(auth()->user()->role ?? 'INVITADO') }}</span>
    </div>

    <div class="sidebar" id="appSidebar">
        <!-- Encabezado con Logotipo Tipográfico Corporativo amplio -->
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="d-block text-decoration-none">
                <div class="brand-container">
                    <div class="brand-title">DTL <span class="highlight-green">PREMIER</span></div>
                    <div class="brand-accent-line"></div>
                    <span class="brand-subtitle">SISTEMA CORPORATIVO</span>
                </div>
            </a>
        </div>

        <div class="sidebar-menu">
            <ul class="nav nav-pills flex-column">
                <li class="sidebar-heading">PANEL DE CONTROL</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <hr class="border-secondary opacity-25 mx-2 my-2">

                @if(request()->routeIs('comercial.*'))
                    <li class="nav-item">
                        <div class="nav-link fw-semibold text-light pe-none py-1 opacity-75 ps-2" style="font-size: 12px;">
                            Gestión Comercial
                        </div>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('comercial.clientes.index') }}" 
                           class="nav-link sidebar-subitem-level-1 {{ request()->routeIs('comercial.clientes.*') ? 'active' : '' }}">
                            <span class="nav-tree-symbol">└</span>
                            <span>Directorio</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('comercial.pipeline.index') }}" 
                           class="nav-link sidebar-subitem-level-1 {{ request()->routeIs('comercial.pipeline.*') ? 'active' : '' }}">
                            <span class="nav-tree-symbol">└</span>
                            <span>Pipeline</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('comercial.visitas.index') }}" 
                           class="nav-link sidebar-subitem-level-1 {{ request()->routeIs('comercial.visitas.*') ? 'active' : '' }}">
                            <span class="nav-tree-symbol">└</span>
                            <span>Inspección</span>
                        </a>
                    </li>

                    <!-- HU-05: Bitácora CRM -->
                    <li class="nav-item">
                        <a href="{{ route('comercial.bitacora.index') }}" 
                           class="nav-link sidebar-subitem-level-1 {{ request()->routeIs('comercial.bitacora.*') ? 'active' : '' }}">
                            <span class="nav-tree-symbol">└</span>
                            <span>Bitácora</span>
                        </a>
                    </li>

                    <!-- HU-06: Cotizador Express -->
                    <li class="nav-item">
                        <a href="{{ route('comercial.cotizador.index') }}" 
                           class="nav-link sidebar-subitem-level-1 {{ request()->routeIs('comercial.cotizador.*') ? 'active' : '' }}">
                            <span class="nav-tree-symbol">└</span>
                            <span>Cotización</span>
                        </a>
                    </li>
                @endif

                @if(request()->routeIs('gerencia.*'))
                    <li class="nav-item">
                        <div class="nav-link fw-semibold text-light pe-none py-1 opacity-75 ps-2" style="font-size: 12px;">Gerencia</div>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link sidebar-subitem-level-1 active">
                            <span class="nav-tree-symbol">└</span>
                            <span>Supervisión Ejecutiva</span>
                        </a>
                    </li>
                @endif

                @if(request()->routeIs('soporte.*'))
                    <li class="nav-item">
                        <div class="nav-link fw-semibold text-light pe-none py-1 opacity-75 ps-2" style="font-size: 12px;">Sistema</div>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link sidebar-subitem-level-1 active">
                            <span class="nav-tree-symbol">└</span>
                            <span>Soporte y Seguridad</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-logout-minimal d-flex align-items-center justify-content-center">
                    <i class="fas fa-right-from-bracket me-2"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </div>

    <div class="main-wrapper">
        @yield('content')
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('appSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('show');
            backdrop.classList.toggle('show');
        }
    </script>

    <!-- Renderiza todos los scripts inyectados mediante @push('scripts') desde las vistas hijas -->
    @stack('scripts')
</body>
</html>