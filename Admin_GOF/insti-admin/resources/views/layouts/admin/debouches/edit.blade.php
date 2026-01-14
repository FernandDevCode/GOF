@extends('layouts.admin')

@section('title', 'Modifier le débouché')
@section('page-title', 'Modifier le débouché')
@section('page-description', 'Modifiez ce débouché professionnel')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Bouton de suppression -->
    <div class="flex justify-start mb-4">
        <form action="{{ route('admin.debouches.destroy', $debouche) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce débouché ?')"
                    class="px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600">
                <i class="fas fa-trash mr-2"></i> Supprimer
            </button>
        </form>
    </div>

    <form action="{{ route('admin.debouches.update', $debouche) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <!-- Informations sur l'option parente -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                    <div>
                        <p class="font-medium">Débouché de :</p>
                        <p class="text-blue-700">{{ $debouche->option->nom }}</p>
                        <p class="text-sm text-gray-600 mt-1">Filière : {{ $debouche->option->filiere->nom }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Titre du débouché -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="titre">
                    Titre du débouché *
                </label>
                <input type="text" 
                       id="titre" 
                       name="titre" 
                       value="{{ old('titre', $debouche->titre) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                       required>
            </div>
            
            <!-- Description -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="description">
                    Description
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg">{{ old('description', $debouche->description) }}</textarea>
            </div>
            
            <!-- Ordre géré automatiquement côté serveur -->
            <div class="mb-6">
                <p class="text-gray-500 text-sm">L'ordre d'affichage est géré automatiquement. Utilisez la fonctionnalité de réorganisation pour modifier l'ordre.</p>
            </div>
        </div>
        
        <!-- Boutons d'action -->
        <div class="flex justify-end">
            <div class="flex space-x-4">
                <a href="{{ route('admin.options.debouches.index', $debouche->option) }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    <i class="fas fa-save mr-2"></i> Enregistrer
                </button>
            </div>
        </div>
    </form>
</div>
@endsection