<!-- Topbar -->
<header class="bg-white border-b border-gray-200 px-4 py-3 md:px-6">
    <div class="flex items-center justify-between">
        <!-- Left: Menu button et recherche -->
        <div class="flex items-center space-x-4">
            <!-- Menu button (mobile) -->
            <button onclick="toggleSidebar()" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
                <i class="fas fa-bars text-gray-700"></i>
            </button>
            
            <!-- Recherche -->
            <div class="relative hidden md:block">
                <input type="text" placeholder="Rechercher..." 
                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-64">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>
        
        <!-- Right: Notifications et profil -->
        <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <button class="relative p-2 rounded-lg hover:bg-gray-100">
                <i class="fas fa-bell text-gray-700"></i>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            
            <!-- Séparateur -->
            <div class="h-6 w-px bg-gray-300"></div>
            
            <!-- Profil dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <span class="font-bold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                    <div class="hidden md:block text-left">
                        <p class="font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-gray-500">Administrateur</p>
                    </div>
                    <i class="fas fa-chevron-down text-gray-500"></i>
                </button>
                
                <!-- Dropdown menu -->
                <div x-show="open" @click.away="open = false" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
                     style="display: none;">
                    <div class="py-1">
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i>Mon profil
                        </a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-2"></i>Paramètres
                        </a>
                        <div class="border-t border-gray-200"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Alpine.js pour les dropdowns -->
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>