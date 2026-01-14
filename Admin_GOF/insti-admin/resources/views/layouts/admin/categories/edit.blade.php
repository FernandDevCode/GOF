@extends('layouts.admin')

@section('title', 'Modifier la catégorie')
@section('page-title', 'Modifier la catégorie')
@section('page-description', 'Modifiez les informations de cette catégorie')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Bouton de suppression -->
    <div class="flex justify-start mb-4">
        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')"
                    class="px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                <i class="fas fa-trash mr-2"></i> Supprimer
            </button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Nom de la catégorie -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="nom">
                    Nom de la catégorie *
                </label>
                <input type="text" 
                       id="nom" 
                       name="nom" 
                       value="{{ old('nom', $category->nom) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
            </div>
            
            <!-- Couleur -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="couleur">
                    Couleur d'identification *
                </label>
                <div class="flex items-center space-x-4">
                    <input type="color" 
                           id="couleur" 
                           name="couleur" 
                           value="{{ old('couleur', $category->couleur) }}"
                           class="w-16 h-16 cursor-pointer"
                           onchange="document.getElementById('couleur-text').value = this.value">
                    <div class="flex-1">
                        <input type="text" 
                               id="couleur-text" 
                               name="couleur"
                               value="{{ old('couleur', $category->couleur) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg font-mono"
                               pattern="^#[0-9A-F]{6}$">
                    </div>
                </div>
            </div>
            
            <!-- Description -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="description">
                    Description
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg">{{ old('description', $category->description) }}</textarea>
            </div>
            
            <!-- Statut -->
            <div class="mb-8">
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="active" 
                           value="1"
                           {{ old('active', $category->active) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-gray-700">Catégorie active</span>
                </label>
            </div>
            
            <!-- Boutons d'action -->
            <div class="flex justify-end pt-6 border-t border-gray-200">
                <div class="flex space-x-4">
                    <a href="{{ route('admin.categories.index') }}" 
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
</div>
@endsection