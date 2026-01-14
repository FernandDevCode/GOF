@extends('layouts.admin')

@section('title', 'Gestion des filières')
@section('page-title', 'Filières de formation')
@section('page-description', 'Gérez les filières de l\'INSTI')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Liste des filières</h2>
        <p class="text-gray-600">Toutes les filières de formation disponibles</p>
    </div>
    <a href="{{ route('admin.filieres.create') }}" 
       class="mt-4 md:mt-0 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
        <i class="fas fa-plus mr-2"></i>
        Nouvelle filière
    </a>
</div>

<!-- Filtres et recherche -->
<div class="bg-white rounded-xl shadow mb-6 p-4">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Recherche -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
            <input type="text" placeholder="Nom de la filière..." 
                   class="w-full border border-gray-300 rounded-lg px-3 py-2">
        </div>
        
        <!-- Filtre par catégorie -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
            <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                <option value="">Toutes les catégories</option>
                @foreach(App\Models\CategoryFormation::all() as $categorie)
                <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                @endforeach
            </select>
        </div>
        
        <!-- Filtre par niveau -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Niveau</label>
            <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                <option value="">Tous les niveaux</option>
                <option value="Licence">Licence</option>
                <option value="Master">Master</option>
                <option value="Doctorat">Doctorat</option>
            </select>
        </div>
        
        <!-- Filtre par statut -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
            <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                <option value="">Tous les statuts</option>
                <option value="1">Actives</option>
                <option value="0">Inactives</option>
            </select>
        </div>
    </div>
</div>

<!-- Tableau des filières -->
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Niveau</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durée</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($filieres as $filiere)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        #{{ $filiere->id }}
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <div class="font-medium text-gray-900">{{ $filiere->nom }}</div>
                            @if($filiere->description)
                            <div class="text-sm text-gray-500 truncate max-w-xs">
                                {{ Str::limit($filiere->description, 60) }}
                            </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($filiere->categorie)
                            <div class="w-3 h-3 rounded-full mr-2"></div>
                            <span class="text-sm">{{ $filiere->categorie->nom }}</span>
                            @else
                            <span class="text-gray-400 text-sm">Non catégorisée</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs rounded-full 
                            {{ $filiere->niveau == 'Licence' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $filiere->niveau == 'Master' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $filiere->niveau == 'Doctorat' ? 'bg-purple-100 text-purple-800' : '' }}">
                            {{ $filiere->niveau }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $filiere->duree }} an(s)
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($filiere->statut)
                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i> Active
                        </span>
                        @else
                        <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-800">
                            <i class="fas fa-times-circle mr-1"></i> Inactive
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.filieres.show', $filiere) }}" 
                               class="text-green-600 hover:text-green-900" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.filieres.edit', $filiere) }}" 
                               class="text-blue-600 hover:text-blue-900" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.filieres.destroy', $filiere) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette filière ?')"
                                        class="text-red-600 hover:text-red-900" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="text-gray-400">
                            <i class="fas fa-graduation-cap text-5xl mb-4"></i>
                            <p class="text-lg">Aucune filière trouvée</p>
                            <p class="mt-2">Commencez par créer votre première filière</p>
                            <a href="{{ route('admin.filieres.create') }}" class="mt-4 inline-block text-blue-500 hover:text-blue-700">
                                <i class="fas fa-plus mr-1"></i> Créer une filière
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($filieres->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $filieres->links() }}
    </div>
    @endif
</div>
@endsection