<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin INSTI - @yield('title', 'Tableau de bord')</title>
    
    <!-- Tailwind CSS via CDN (rapide pour développement) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Styles personnalisés */
        .sidebar {
            transition: all 0.3s;
        }
        .sidebar.collapsed {
            width: 70px;
        }
        .sidebar.collapsed .sidebar-text {
            display: none;
        }
        .active-menu {
            background-color: #3B82F6;
            color: white;
        }
        .active-menu:hover {
            background-color: #2563EB !important;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Conteneur principal -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('layouts.admin.partials.sidebar')
        
        <!-- Contenu principal -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            @include('layouts.admin.partials.topbar')
            
            <!-- Contenu -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                <!-- Alertes -->
                @include('layouts.admin.partials.alert')
                
                <!-- Titre de page -->
                <div class="mb-6">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">@yield('page-title')</h1>
                    <p class="text-gray-600 mt-2">@yield('page-description')</p>
                </div>
                
                <!-- Contenu spécifique -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts JavaScript -->
    <script>
        // Toggle sidebar sur mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }
        
        // Gestion des messages flash
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide les alertes après 5 secondes
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert-auto-hide');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        });
    </script>
    
    <!-- Scripts spécifiques à la page -->
    @stack('scripts')
</body>
</html>