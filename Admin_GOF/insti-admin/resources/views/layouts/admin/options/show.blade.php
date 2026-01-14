@extends('layouts.admin')

@section('title', 'Détails de l\'option')
@section('page-title', 'Détails de l\'option')
@section('page-description', 'Informations complètes sur cette option')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $option->nom }}</h2>
            <div class="flex items-center mt-2">
                <span class="text-gray-600">Filière :</span>
                <a href="{{ route('admin.filieres.show', $option->filiere) }}" 
                   class="ml-2 text-blue-600 hover:text-blue-800">
                    {{ $option->filiere->nom }}
                </a>
            </div>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="{{ route('admin.options.edit', $option) }}" 
               class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                <i class="fas fa-edit mr-2"></i> Modifier
            </a>
            <a href="{{ route('admin.filieres.options.index', $option->filiere) }}" 
               class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Colonne gauche -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Description -->
            @if($option->description)
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Description</h3>
                <p class="text-gray-700">{{ $option->description }}</p>
            </div>
            @endif
            
            <!-- Compétences -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Compétences acquises</h3>
                    <a href="{{ route('admin.options.competences.create', $option) }}" 
                       class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-plus mr-1"></i> Ajouter
                    </a>
                </div>
                
                @if($option->competences && $option->competences->count() > 0)
                    <div class="space-y-3">
                        @foreach($option->competences as $competence)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <span class="text-gray-500 mr-3">#{{ $loop->iteration }}</span>
                                <span>{{ $competence->description }}</span>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.competences.edit', $competence) }}" 
                                   class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.competences.destroy', $competence) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette compétence ?')"
                                            class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-400">
                        <i class="fas fa-tools text-4xl mb-4"></i>
                        <p>Aucune compétence définie</p>
                        <p class="text-sm mt-2">Ajoutez les compétences acquises dans cette option</p>
                    </div>
                @endif
            </div>
            
            <!-- Débouchés -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Débouchés professionnels</h3>
                    <a href="{{ route('admin.options.debouches.create', $option) }}" 
                       class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-plus mr-1"></i> Ajouter
                    </a>
                </div>
                
                @if($option->debouches && $option->debouches->count() > 0)
                    <div class="space-y-3">
                        @foreach($option->debouches as $debouche)
                        <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                            <div>
                                <div class="font-medium">{{ $debouche->titre }}</div>
                                @if($debouche->description)
                                <div class="text-sm text-gray-600 mt-1">{{ $debouche->description }}</div>
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.debouches.edit', $debouche) }}" 
                                   class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.debouches.destroy', $debouche) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce débouché ?')"
                                            class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-400">
                        <i class="fas fa-briefcase text-4xl mb-4"></i>
                        <p>Aucun débouché défini</p>
                        <p class="text-sm mt-2">Ajoutez les débouchés professionnels de cette option</p>
                    </div>
                @endif
            </div>
        </div>
     
        <!-- Colonne droite -->
        <div class="space-y-6">
            <!-- Informations -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Statut</p>
                        @if($option->statut)
                        <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800">
                            Active
                        </span>
                        @else
                        <span class="px-3 py-1 text-sm rounded-full bg-red-100 text-red-800">
                            Inactive
                        </span>
                        @endif
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Nombre de compétences</p>
                        <p class="text-2xl font-bold mt-1">{{ $option->competences->count() }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Nombre de débouchés</p>
                        <p class="text-2xl font-bold mt-1">{{ $option->debouches->count() }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Créée le</p>
                        <p class="mt-1">{{ $option->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    @if($option->updated_at != $option->created_at)
                    <div>
                        <p class="text-sm text-gray-500">Dernière modification</p>
                        <p class="mt-1">{{ $option->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Actions -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.options.edit', $option) }}" 
                       class="w-full text-center block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        <i class="fas fa-edit mr-2"></i> Modifier
                    </a>
                    
                    <!-- Toggle statut -->
                    <form action="{{ route('admin.options.update', $option) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="statut" value="{{ $option->statut ? '0' : '1' }}">
                        <button type="submit" 
                                class="w-full px-4 py-2 {{ $option->statut ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded-lg">
                            <i class="fas {{ $option->statut ? 'fa-pause' : 'fa-play' }} mr-2"></i>
                            {{ $option->statut ? 'Désactiver' : 'Activer' }}
                        </button>
                    </form>
                    
                    <a href="{{ route('admin.filieres.options.index', $option->filiere) }}" 
                       class="w-full text-center block px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-arrow-left mr-2"></i> Retour aux options
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection