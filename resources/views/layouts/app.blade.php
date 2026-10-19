<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        }
        
        /* Sidebar Principal DTL PREMIER responsivo */
        .sidebar { 
            height: 100vh; 
            background-color: #000000 !important; 
            color: #94a3b8; 
            width: 260px; 
            flex-shrink: 0; 
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            border-right: 1px solid #1f2937;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease-in-out;
        }

        @media (min-width: 768px) {
            .sidebar {
                position: relative !important;
                transform: translateX(0) !important;
            }
        }

        /* Ocultar sidebar en móviles por defecto */
        @media (max-width: 767.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
        }

        /* HEADER DTL PREMIER */
        .sidebar-header {
            padding: 1.5rem 1rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            flex-shrink: 0;
            position: relative;
            background-color: #000000 !important;
            text-align: center;
        }
        .sidebar-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #059669 0%, #10b981 50%, #34d399 100%);
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);
        }

        .brand-container {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: inline-flex;
            flex-direction: column;
            align-items: center;
        }
        .sidebar-header:hover .brand-container {
            transform: scale(1.03);
        }

        .brand-title {
            font-weight: 900;
            font-size: 1.45rem;
            letter-spacing: 1.2px;
            color: #ffffff;
            text-transform: uppercase;
            line-height: 1;
            margin-bottom: 4px;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.15);
        }
        .brand-title .highlight-green {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 900;
        }

        .brand-subtitle {
            font-size: 0.65rem;
            font-weight: 800;
            letter-spacing: 2.2px;
            color: #10b981;
            text-transform: uppercase;
            opacity: 0.9;
            background: linear-gradient(90deg, #059669, #34d399, #059669);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-menu {
            flex-grow: 1;
            overflow-y: auto;
            padding-bottom: 75px;
            background-color: #000000 !important;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-menu::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
        }

        .sidebar-heading {
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #64748b;
            font-weight: 700;
            padding: 1rem 1.25rem 0.4rem 1.25rem;
        }

        .sidebar .nav-link { 
            color: #94a3b8; 
            padding: 0.65rem 1.25rem; 
            margin: 0.1rem 0;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
            display: flex;
            align-items: center;
            background: transparent !important;
            border-radius: 0 !important;
            border-left: 3px solid transparent;
        }

        .sidebar .nav-link:hover { 
            color: #ffffff; 
            background: rgba(255, 255, 255, 0.05) !important; 
        }

        .sidebar .nav-link.active { 
            color: #ffffff !important; 
            background: rgba(5, 150, 105, 0.18) !important; 
            border-left-color: #059669;
            font-weight: 600;
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 0.9rem;
            margin-right: 0.75rem;
            color: #64748b;
            transition: color 0.2s ease;
        }

        .sidebar .nav-link.active i {
            color: #10b981 !important;
        }

        .nav-tree-symbol {
            font-family: monospace;
            font-size: 0.85rem;
            color: #64748b;
            margin-right: 0.5rem;
            user-select: none;
        }

        .sidebar .nav-link.active .nav-tree-symbol {
            color: #10b981;
            font-weight: bold;
        }

        .sidebar-subitem-level-1 {
            font-size: 0.85rem !important;
            padding-left: 1.5rem !important;
            color: #94a3b8;
        }

        .sidebar-subitem-level-2 {
            font-size: 0.82rem !important;
            padding-left: 2.3rem !important;
            color: #94a3b8;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 0.85rem 1.25rem 1.1rem 1.25rem;
            background-color: #000000 !important;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            z-index: 10;
            box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.4);
        }

        .btn-logout-minimal {
            background: transparent;
            border: none;
            color: #94a3b8;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.3rem 0;
            transition: all 0.2s ease-in-out;
            width: 100%;
        }

        .btn-logout-minimal:hover {
            color: #ef4444 !important;
            background: transparent;
        }

        .btn-logout-minimal:hover i {
            color: #ef4444 !important;
        }

        /* Barra superior móvil */
        .mobile-topbar {
            display: none;
            background-color: #000000;
            color: #ffffff;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #1f2937;
        }
        @media (max-width: 767.98px) {
            .mobile-topbar {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
        }

        /* Fondo oscuro móvil cuando el sidebar está abierto */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
        }
        .sidebar-backdrop.show {
            display: block;
        }
    </style>
</head>
<body>

    <!-- Backdrop para móviles -->
    <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="toggleSidebar()"></div>

    <!-- Topbar exclusiva para dispositivos móviles -->
    <div class="mobile-topbar">
        <div class="d-flex align-items-center gap-2">
            <button class="btn text-white p-1 border-0" onclick="toggleSidebar()">
                <i class="fas fa-bars fs-5"></i>
            </button>
            <span class="fw-bold tracking-wider text-uppercase" style="font-size: 0.9rem;">DTL <span class="text-success">PREMIER</span></span>
        </div>
        <span class="badge bg-dark border border-secondary text-success" style="font-size: 0.65rem;">{{ strtoupper(auth()->user()->role ?? 'INVITADO') }}</span>
    </div>

    <div class="d-flex">
        <!-- Sidebar DTL PREMIER -->
        <div class="sidebar" id="appSidebar">
            
            <!-- HEADER DE MARCA DESTACADO Y CENTRADO -->
            <div class="sidebar-header">
                <a href="{{ route('dashboard') }}" class="d-block text-decoration-none">
                    <div class="brand-container">
                        <div class="brand-title">
                            DTL <span class="highlight-green">PREMIER</span>
                        </div>
                        <span class="brand-subtitle">SISTEMA CORPORATIVO</span>
                    </div>
                </a>
            </div>

            <!-- NAVEGACIÓN DINÁMICA DE RUTA -->
            <div class="sidebar-menu">
                <ul class="nav nav-pills flex-column">
                    
                    <li class="sidebar-heading">PANEL DE CONTROL</li>

                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-chart-pie"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <hr class="border-secondary opacity-25 mx-3 my-2">

                    @if(request()->routeIs('comercial.*'))
                        <li class="nav-item">
                            <div class="nav-link fw-semibold text-light pe-none py-1 opacity-75 ps-3" style="font-size: 0.85rem;">
                                Gestión Comercial
                            </div>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('comercial.clientes.index') }}" 
                               class="nav-link sidebar-subitem-level-1 {{ request()->routeIs('comercial.clientes.index') ? 'active' : '' }}">
                                <span class="nav-tree-symbol">└</span>
                                <span>Directorio de Clientes</span>
                            </a>
                        </li>

                        @if(request()->routeIs('comercial.clientes.create'))
                            <li class="nav-item">
                                <a href="{{ route('comercial.clientes.create') }}" 
                                   class="nav-link sidebar-subitem-level-2 active">
                                    <span class="nav-tree-symbol">└</span>
                                    <span>Ficha de Registro</span>
                                </a>
                            </li>
                        @endif
                    @endif

                    @if(request()->routeIs('gerencia.*'))
                        <li class="nav-item">
                            <div class="nav-link fw-semibold text-light pe-none py-1 opacity-75 ps-3" style="font-size: 0.85rem;">
                                Gerencia
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link sidebar-subitem-level-1 active">
                                <span class="nav-tree-symbol">└</span>
                                <span>Supervisión Ejecutiva</span>
                            </a>
                        </li>
                    @endif

                    @if(request()->routeIs('sistema.*') || request()->routeIs('soporte.*'))
                        <li class="nav-item">
                            <div class="nav-link fw-semibold text-light pe-none py-1 opacity-75 ps-3" style="font-size: 0.85rem;">
                                Sistema
                            </div>
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

            <!-- BOTÓN CERRAR SESIÓN -->
            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-logout-minimal d-flex align-items-center justify-content-center">
                        <i class="fas fa-right-from-bracket me-2"></i> Cerrar Sesión
                    </button>
                </form>
            </div>

        </div>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="flex-grow-1 overflow-auto" style="min-height: 100vh; background-color: #f8fafc;">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 JS y script para toggle móvil -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('appSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('show');
            backdrop.classList.toggle('show');
        }
    </script>
</body>
</html>