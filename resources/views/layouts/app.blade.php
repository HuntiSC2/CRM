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
        /* Fondo principal de la aplicación */
        body { 
            background-color: #f8fafc; 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; 
            color: #0f172a;
        }
        
        /* Sidebar Principal DTL PREMIER (Negro Absoluto) */
        .sidebar { 
            height: 100vh; 
            background-color: #000000 !important; 
            color: #94a3b8; 
            width: 260px; 
            flex-shrink: 0; 
            display: flex;
            flex-direction: column;
            position: relative;
            border-right: 1px solid #1f2937;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.4);
        }

        /* HEADER DTL PREMIER ESPECIAL Y ELEGANTE */
        .sidebar-header {
            padding: 1.5rem 1rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            flex-shrink: 0;
            position: relative;
            background-color: #000000 !important;
            text-align: center;
        }
        /* Línea Superior de Acento Neón */
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

        /* Contenedor del Brand con Interacción */
        .brand-container {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: inline-flex;
            flex-direction: column;
            align-items: center;
        }
        .sidebar-header:hover .brand-container {
            transform: scale(1.03);
        }

        /* Insignia / Isotipo Tipográfico "DTL" */
        .brand-badge {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: #ffffff;
            font-weight: 900;
            font-size: 0.75rem;
            letter-spacing: 2px;
            padding: 3px 10px;
            border-radius: 6px;
            box-shadow: 0 0 12px rgba(5, 150, 105, 0.4);
            border: 1px solid rgba(52, 211, 153, 0.3);
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        /* Texto de Marca Principal con Gradiente y Resplandor */
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

        /* Subtítulo Corporativo Estilizado */
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

        /* Área de Navegación Dinámica con Scroll Independiente */
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

        /* Títulos de sección */
        .sidebar-heading {
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #64748b;
            font-weight: 700;
            padding: 1rem 1.25rem 0.4rem 1.25rem;
        }

        /* Enlaces de navegación */
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

        /* Estado Activo: Verde Corporativo */
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

        /* Indicador sutil de jerarquía tree-symbol */
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

        /* Indentación ajustada */
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

        /* FOOTER FLOTANTE / SIEMPRE VISIBLE EN LA PARTE INFERIOR */
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

        /* Botón de Cerrar Sesión Minimalista */
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
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar DTL PREMIER -->
        <div class="sidebar">
            
            <!-- HEADER DE MARCA DESTACADO Y CENTRADO -->
            <div class="sidebar-header">
                <a href="{{ route('dashboard') }}" class="d-block text-decoration-none">
                    <div class="brand-container">
                        <!-- Isotipo / Insignia Corporativa DTL -->
                        
                        
                        <!-- Nombre del Sistema con Gradiente de Texto -->
                        <div class="brand-title">
                            DTL <span class="highlight-green">PREMIER</span>
                        </div>
                        
                        <!-- Subtítulo con Tracking Amplio -->
                        <span class="brand-subtitle">SISTEMA CORPORATIVO</span>
                    </div>
                </a>
            </div>

            <!-- NAVEGACIÓN DINÁMICA DE RUTA -->
            <div class="sidebar-menu">
                <ul class="nav nav-pills flex-column">
                    
                    <li class="sidebar-heading">PANEL DE CONTROL</li>

                    <!-- Nivel Base: Dashboard -->
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-chart-pie"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <hr class="border-secondary opacity-25 mx-3 my-2">

                    <!-- Navegación según el Módulo Activo -->
                    @if(request()->routeIs('comercial.*'))
                        <!-- Nivel 1: Título del Módulo Activo -->
                        <li class="nav-item">
                            <div class="nav-link fw-semibold text-light pe-none py-1 opacity-75 ps-3" style="font-size: 0.85rem;">
                                Gestión Comercial
                            </div>
                        </li>

                        <!-- Nivel 2: Directorio de Clientes -->
                        <li class="nav-item">
                            <a href="{{ route('comercial.clientes.index') }}" 
                               class="nav-link sidebar-subitem-level-1 {{ request()->routeIs('comercial.clientes.index') ? 'active' : '' }}">
                                <span class="nav-tree-symbol">└</span>
                                <span>Directorio de Clientes</span>
                            </a>
                        </li>

                        <!-- Nivel 3: Ficha de Registro -->
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
        <div class="flex-grow-1 p-4 overflow-auto" style="height: 100vh; background-color: #f8fafc;">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>