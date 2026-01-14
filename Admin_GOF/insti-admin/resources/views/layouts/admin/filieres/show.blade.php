@extends('layouts.admin')

@section('title', 'Détails de la filière')
@section('page-title', 'Détails de la filière')
@section('page-description', 'Informations complètes sur cette filière')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- En-tête avec actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $filiere->nom }}</h2>
            <div class="flex items-center mt-2 space-x-4">
                <span class="px-3 py-1 text-sm rounded-full 
                    {{ $filiere->niveau == 'Licence' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $filiere->niveau == 'Master' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $filiere->niveau == 'Doctorat' ? 'bg-purple-100 text-purple-800' : '' }}">
                    {{ $filiere->niveau }}
                </span>
                <span class="text-gray-600">{{ $filiere->duree }} an(s)</span>
                @if($filiere->statut)
                <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800">
                    <i class="fas fa-check-circle mr-1"></i> Active
                </span>
                @else
                <span class="px-3 py-1 text-sm rounded-full bg-red-100 text-red-800">
                    <i class="fas fa-times-circle mr-1"></i> Inactive
                </span>
                @endif
            </div>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="{{ route('admin.filieres.edit', $filiere) }}" 
               class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                <i class="fas fa-edit mr-2"></i> Modifier
            </a>
            <a href="{{ route('admin.filieres.index') }}" 
               class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Colonne gauche -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Description -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Description</h3>
                <div class="prose max-w-none">
                    <p class="text-gray-700">{{ $filiere->description }}</p>
                </div>
            </div>
            
            <!-- Options de spécialisation -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Options de spécialisation</h3>
                    <button class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-plus mr-1"></i> Ajouter une option
                    </button>
                </div>
                
                @if($filiere->options && $filiere->options->count() > 0)
                    <div class="space-y-4">
                        @foreach($filiere->options as $option)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $option->nom }}</h4>
                                    @if($option->description)
                                    <p class="text-gray-600 text-sm mt-1">{{ $option->description }}</p>
                                    @endif
                                </div>
                                <div class="flex space-x-2">
                                    <button class="text-blue-500 hover:text-blue-700">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Compétences de cette option -->
                            @if($option->competences && $option->competences->count() > 0)
                            <div class="mt-3">
                                <h5 class="text-sm font-medium text-gray-700 mb-2">Compétences acquises :</h5>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($option->competences as $competence)
                                    <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">
                                        {{ $competence->description }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            <!-- Débouchés de cette option -->
                            @if($option->debouches && $option->debouches->count() > 0)
                            <div class="mt-3">
                                <h5 class="text-sm font-medium text-gray-700 mb-2">Débouchés professionnels :</h5>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($option->debouches as $debouche)
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded">
                                        {{ $debouche->titre }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-400">
                        <i class="fas fa-list-alt text-4xl mb-4"></i>
                        <p>Aucune option définie</p>
                        <p class="text-sm mt-2">Ajoutez des options de spécialisation</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Colonne droite -->
        <div class="space-y-6">
            <!-- Informations générales -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Catégorie</p>
                        <div class="flex items-center mt-1">
                            @if($filiere->categorie)
                            <div class="w-3 h-3 rounded-full mr-2"></div>
                            <p class="font-medium">{{ $filiere->categorie->nom }}</p>
                            @else
                            <p class="text-gray-400">Non catégorisée</p>
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Bac requis</p>
                        <p class="font-medium mt-1">{{ $filiere->bac_requis }}</p>
                    </div>
                    
                    @if($filiere->conditions)
                    <div>
                        <p class="text-sm text-gray-500">Conditions supplémentaires</p>
                        <p class="mt-1">{{ $filiere->conditions }}</p>
                    </div>
                    @endif
                    
                    <div>
                        <p class="text-sm text-gray-500">Créée le</p>
                        <p class="mt-1">{{ $filiere->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    @if($filiere->updated_at != $filiere->created_at)
                    <div>
                        <p class="text-sm text-gray-500">Dernière modification</p>
                        <p class="mt-1">{{ $filiere->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Statistiques -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistiques</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Nombre d'options</p>
                        <p class="text-2xl font-bold mt-1">{{ $filiere->options->count() }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Total compétences</p>
                        @php
                            $totalCompetences = 0;
                            foreach ($filiere->options as $option) {
                                $totalCompetences += $option->competences->count();
                            }
                        @endphp
                        <p class="text-2xl font-bold mt-1">{{ $totalCompetences }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Total débouchés</p>
                        @php
                            $totalDebouches = 0;
                            foreach ($filiere->options as $option) {
                                $totalDebouches += $option->debouches->count();
                            }
                        @endphp
                        <p class="text-2xl font-bold mt-1">{{ $totalDebouches }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Actions rapides -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.filieres.edit', $filiere) }}" 
                       class="w-full text-center block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        <i class="fas fa-edit mr-2"></i> Modifier
                    </a>
                    <form action="{{ route('admin.filieres.duplicate', $filiere) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                            <i class="fas fa-copy mr-2"></i> Dupliquer
                        </button>
                    </form>
                    <form action="{{ route('admin.filieres.toggle-status', $filiere) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="w-full px-4 py-2 {{ $filiere->statut ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded-lg">
                            <i class="fas {{ $filiere->statut ? 'fa-pause' : 'fa-play' }} mr-2"></i>
                            {{ $filiere->statut ? 'Désactiver' : 'Activer' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection