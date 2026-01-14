<!-- Sidebar -->
<aside id="sidebar" class="sidebar w-64 bg-gray-900 text-white flex flex-col md:static fixed inset-y-0 left-0 transform md:translate-x-0 -translate-x-full z-40 transition-transform duration-300 ease-in-out">
    
    <!-- Logo -->
    <div class="p-6 border-b border-gray-800">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-graduation-cap text-xl"></i>
            </div>
            <div class="ml-3">
                <h2 class="text-xl font-bold">INSTI Admin</h2>
                <p class="text-gray-400 text-sm">Plateforme de gestion</p>
            </div>
        </div>
    </div>
    
    <!-- Navigation -->
    <nav class="flex-1 p-4 overflow-y-auto">
        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center p-3 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800' : '' }}">
                    <i class="fas fa-tachometer-alt w-6"></i>
                    <span class="ml-3 sidebar-text">Tableau de bord</span>
                </a>
            </li>
            
            <!-- Formations -->
            <li>
                <p class="text-gray-400 text-sm uppercase tracking-wider mt-6 mb-2 px-3 sidebar-text">Formations</p>
            </li>
            
            <!-- Catégories -->
            <li>
                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center p-3 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-800' : '' }}">
                    <i class="fas fa-layer-group w-6"></i>
                    <span class="ml-3 sidebar-text">Catégories</span>
                </a>
            </li>
            
            <!-- Filières -->
            <li>
                <a href="{{ route('admin.filieres.index') }}" 
                   class="flex items-center p-3 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.filieres.*') ? 'bg-gray-800' : '' }}">
                    <i class="fas fa-graduation-cap w-6"></i>
                    <span class="ml-3 sidebar-text">Filières</span>
                </a>
            </li>
            
            <!-- Options -->
            <li>
                <a href="{{ route('admin.options.index') }}" 
                   class="flex items-center p-3 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.options.index') ? 'bg-gray-800' : '' }}">
                    <i class="fas fa-list-alt w-6"></i>
                    <span class="ml-3 sidebar-text">Offres</span>
                </a>
            </li>
            
            <!-- Compétences -->
            <li>
                <a href="{{ route('admin.competences.index') }}" 
                   class="flex items-center p-3 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.competences.*') ? 'bg-gray-800' : '' }}">
                    <i class="fas fa-lightbulb w-6"></i>
                    <span class="ml-3 sidebar-text">Compétences</span>
                </a>
            </li>

            <!-- Débouchés -->
            <li>
                <a href="{{ route('admin.debouches.index') }}" 
                   class="flex items-center p-3 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.debouches.*') ? 'bg-gray-800' : '' }}">
                    <i class="fas fa-briefcase w-6"></i>
                    <span class="ml-3 sidebar-text">Débouchés</span>
                </a>
            </li>
            <!-- Administration -->
            <li>
                <p class="text-gray-400 text-sm uppercase tracking-wider mt-6 mb-2 px-3 sidebar-text">Administration</p>
            </li>
            
            <!-- Utilisateurs -->
            <li>
                <a href="{{ route('admin.users.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.users.*') ? 'bg-gray-800' : '' }}">
                    <i class="fas fa-users w-6"></i>
                    <span class="ml-3 sidebar-text">Utilisateurs</span>
                </a>
            </li>
            
            <!-- Paramètres -->
            <li>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.settings.*') ? 'bg-gray-800' : '' }}">
                    <i class="fas fa-cog w-6"></i>
                    <span class="ml-3 sidebar-text">Paramètres</span>
                </a>
            </li>
        </ul>
    </nav>
        
    
    <!-- Footer sidebar -->
    <div class="p-4 border-t border-gray-800">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                <span class="font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            </div>
            <div class="ml-3 sidebar-text">
                <p class="font-medium">{{ auth()->user()->name }}</p>
                <p class="text-gray-400 text-sm">Administrateur</p>
            </div>
        </div>
    </div>
</aside>  

<!-- Overlay pour mobile -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden" onclick="toggleSidebar()" style="display: none;"></div>

<script>
    // Gestion du responsive sidebar
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        
        // Fonction pour cacher sidebar sur mobile
        function hideSidebar() {
            if (window.innerWidth < 768) {
                sidebar.classList.add('-translate-x-full');
                overlay.style.display = 'none';
            }
        }
        
        // Afficher/cacher au clic
        window.toggleSidebar = function() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.style.display = sidebar.classList.contains('-translate-x-full') ? 'none' : 'block';
        };
        
        // Cacher sidebar au clic sur overlay
        overlay.addEventListener('click', hideSidebar);
        
        // Cacher sidebar au resize
        window.addEventListener('resize', hideSidebar);
    });
</script>  