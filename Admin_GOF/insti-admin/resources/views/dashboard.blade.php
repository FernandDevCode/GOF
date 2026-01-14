@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('page-description', 'Vue d\'ensemble de la plateforme de gestion des formations')

@section('content')
<!-- Cartes de statistiques -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total catégories -->
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                <i class="fas fa-layer-group text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Catégories</p>
                <p class="text-3xl font-bold mt-1">{{ $stats['categories'] ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <!-- Total filières -->
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                <i class="fas fa-graduation-cap text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Filières totales</p>
                <p class="text-3xl font-bold mt-1">{{ $stats['filieres'] ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <!-- Filières actives -->
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-purple-500">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-purple-100 text-purple-600 mr-4">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Filières actives</p>
                <p class="text-3xl font-bold mt-1">{{ $stats['filieres_actives'] ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <!-- Filières inactives -->
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-gray-500">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-gray-100 text-gray-600 mr-4">
                <i class="fas fa-pause-circle text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Filières inactives</p>
                @php
                    $inactives = ($stats['filieres'] ?? 0) - ($stats['filieres_actives'] ?? 0);
                @endphp
                <p class="text-3xl font-bold mt-1">{{ $inactives }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Actions rapides -->
<div class="bg-white rounded-xl shadow mb-8">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-800">Actions rapides</h2>
        <p class="text-gray-600">Accédez rapidement aux fonctionnalités principales</p>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.categories.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg flex items-center justify-center transition-colors duration-200">
                <i class="fas fa-plus mr-3"></i>
                <span>Nouvelle catégorie</span>
            </a>
            
            <a href="{{ route('admin.filieres.create') }}" 
               class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-lg flex items-center justify-center transition-colors duration-200">
                <i class="fas fa-plus mr-3"></i>
                <span>Nouvelle filière</span>
            </a>
            
            <a href="{{ route('admin.categories.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white p-4 rounded-lg flex items-center justify-center transition-colors duration-200">
                <i class="fas fa-layer-group mr-3"></i>
                <span>Voir catégories</span>
            </a>
            
            <a href="{{ route('admin.filieres.index') }}" 
               class="bg-purple-500 hover:bg-purple-600 text-white p-4 rounded-lg flex items-center justify-center transition-colors duration-200">
                <i class="fas fa-graduation-cap mr-3"></i>
                <span>Voir filières</span>
            </a>
        </div>
    </div>
</div>

<!-- Dernières filières ajoutées -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Dernières catégories -->
    <div class="bg-white rounded-xl shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Catégories récentes</h2>
        </div>
        <div class="p-6">
            @php
                $recentCategories = App\Models\CategoryFormation::latest()->take(5)->get();
            @endphp
            
            @if($recentCategories->count() > 0)
                <div class="space-y-4">
                    @foreach($recentCategories as $category)
                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full mr-3"></div>
                            <div>
                                <p class="font-medium">{{ $category->nom }}</p>
                                <p class="text-sm text-gray-500">{{ $category->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-layer-group text-4xl mb-4 text-gray-300"></i>
                    <p>Aucune catégorie créée</p>
                    <a href="{{ route('admin.categories.create') }}" class="text-blue-500 hover:text-blue-700 mt-2 inline-block">
                        Créer la première catégorie
                    </a>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Dernières filières -->
    <div class="bg-white rounded-xl shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Filières récentes</h2>
        </div>
        <div class="p-6">
            @php
                $recentFilieres = App\Models\Filiere::with('categorie')->latest()->take(5)->get();
            @endphp
            
            @if($recentFilieres->count() > 0)
                <div class="space-y-4">
                    @foreach($recentFilieres as $filiere)
                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium">{{ $filiere->nom }}</p>
                            <div class="flex items-center mt-1">
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 mr-2">
                                    {{ $filiere->niveau }}
                                </span>
                                <span class="text-sm text-gray-500">{{ $filiere->categorie->nom ?? 'Sans catégorie' }}</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.filieres.edit', $filiere) }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-graduation-cap text-4xl mb-4 text-gray-300"></i>
                    <p>Aucune filière créée</p>
                    <a href="{{ route('admin.filieres.create') }}" class="text-blue-500 hover:text-blue-700 mt-2 inline-block">
                        Créer la première filière
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection