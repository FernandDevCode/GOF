@extends('layouts.admin')

@section('title', 'Catégories de formation')
@section('page-title', 'Gestion des catégories')
@section('page-description', 'Créez et gérez les catégories de formations')

@section('content')
<!-- En-tête avec bouton d'action -->
<div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Liste des catégories</h2>
        <p class="text-gray-600">Toutes les catégories de formations disponibles</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" 
       class="mt-4 md:mt-0 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
        <i class="fas fa-plus mr-2"></i>
        Nouvelle catégorie
    </a>
</div>

{{-- Ajouter ce formulaire de filtres après l'en-tête --}}
<form method="GET" action="{{ route('admin.categories.index') }}" class="bg-white rounded-xl shadow p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Recherche -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Nom ou description..."
                   class="w-full border border-gray-300 rounded-lg px-3 py-2">
        </div>
        
        <!-- Filtre par statut -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
            <select name="statut" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                <option value="">Tous les statuts</option>
                <option value="actif" {{ request('statut') == 'actif' ? 'selected' : '' }}>Actives</option>
                <option value="inactif" {{ request('statut') == 'inactif' ? 'selected' : '' }}>Inactives</option>
            </select>
        </div>
        
        <!-- Tri -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Trier par</label>
            <select name="sort_by" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Date de création</option>
                <option value="nom" {{ request('sort_by') == 'nom' ? 'selected' : '' }}>Nom</option>
                <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>ID</option>
            </select>
        </div>
        
        <!-- Ordre de tri -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Ordre</label>
            <select name="sort_order" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Décroissant</option>
                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Croissant</option>
            </select>
        </div>
    </div>
    
    <!-- Boutons d'action -->
    <div class="flex justify-end space-x-3 mt-4">
        <a href="{{ route('admin.categories.index') }}" 
           class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
            Réinitialiser
        </a>
        <button type="submit" 
                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
            <i class="fas fa-search mr-2"></i> Appliquer
        </button>
    </div>
</form>


<!-- Tableau des catégories -->
<div class="bg-white rounded-xl shadow overflow-hidden">
    <!-- En-tête du tableau -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <div class="mb-4 md:mb-0">
                <div class="relative">
                    <input type="text" placeholder="Rechercher une catégorie..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full md:w-64">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <select class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Tous les statuts</option>
                    <option>Actives</option>
                    <option>Inactives</option>
                </select>
            </div>
        </div>
    </div>
    
    <!-- Tableau -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nom
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Couleur
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Filières
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Statut
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        #{{ $category->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full mr-3"></div>
                            <div>
                                <div class="font-medium text-gray-900">{{ $category->nom }}</div>
                                @if($category->description)
                                <div class="text-sm text-gray-500 truncate max-w-xs">
                                    {{ Str::limit($category->description, 50) }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <div class="flex items-center">
                            <div class="w-6 h-6 rounded border border-gray-300 mr-2"></div>
                            <span>{{ $category->couleur }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                            {{ $category->filieres_count ?? 0 }} filière(s)
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($category->active)
                        <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i> Active
                        </span>
                        @else
                        <span class="px-3 py-1 text-sm rounded-full bg-red-100 text-red-800">
                            <i class="fas fa-times-circle mr-1"></i> Inactive
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               class="text-blue-600 hover:text-blue-900" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')"
                                        class="text-red-600 hover:text-red-900" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="text-gray-400">
                            <i class="fas fa-layer-group text-5xl mb-4"></i>
                            <p class="text-lg">Aucune catégorie trouvée</p>
                            <p class="mt-2">Commencez par créer votre première catégorie</p>
                            <a href="{{ route('admin.categories.create') }}" class="mt-4 inline-block text-blue-500 hover:text-blue-700">
                                <i class="fas fa-plus mr-1"></i> Créer une catégorie
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
     <!--
    @if($categories->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $categories->links() }}
    </div>
    @endif-->
</div>

@endsection