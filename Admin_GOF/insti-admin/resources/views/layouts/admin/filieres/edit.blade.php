@extends('layouts.admin')

@section('title', 'Modifier la filière')
@section('page-title', 'Modifier la filière')
@section('page-description', 'Modifiez les informations de cette filière')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Bouton de suppression -->
    <div class="flex justify-start mb-4">
        <form action="{{ route('admin.filieres.destroy', $filiere) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette filière ?')"
                    class="px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600">
                <i class="fas fa-trash mr-2"></i> Supprimer
            </button>
        </form>
    </div>

    <form action="{{ route('admin.filieres.update', $filiere) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b">Informations générales</h3>
            
            <!-- Nom de la filière -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="nom">
                    Nom de la filière *
                </label>
                <input type="text" 
                       id="nom" 
                       name="nom" 
                       value="{{ old('nom', $filiere->nom) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                       required>
            </div>
            
            <!-- Catégorie -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="category_formation_id">
                    Catégorie *
                </label>
                <select id="category_formation_id" 
                        name="category_formation_id" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                        required>
                    <option value="">Sélectionnez une catégorie</option>
                    @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ (old('category_formation_id') ?? $filiere->category_formation_id) == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Niveau -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="niveau">
                        Niveau *
                    </label>
                    <select id="niveau" 
                            name="niveau" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                            required>
                        <option value="">Sélectionnez un niveau</option>
                        @foreach($niveaux as $niveau)
                        <option value="{{ $niveau }}" {{ (old('niveau') ?? $filiere->niveau) == $niveau ? 'selected' : '' }}>
                            {{ $niveau }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Durée -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="duree">
                        Durée (années) *
                    </label>
                    <input type="number" 
                           id="duree" 
                           name="duree" 
                           value="{{ old('duree', $filiere->duree) }}"
                           min="1" 
                           max="5"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                           required>
                </div>
            </div>
            
            <!-- Description -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="description">
                    Description *
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                          required>{{ old('description', $filiere->description) }}</textarea>
            </div>
        </div>
        
        <!-- Informations d'admission -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b">Conditions d'admission</h3>
            
            <!-- Bac requis -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="bac_requis">
                    Baccalauréat(s) requis *
                </label>
                <input type="text" 
                       id="bac_requis" 
                       name="bac_requis" 
                       value="{{ old('bac_requis', $filiere->bac_requis) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                       required>
            </div>
            
            <!-- Conditions supplémentaires -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="conditions">
                    Conditions supplémentaires
                </label>
                <textarea id="conditions" 
                          name="conditions" 
                          rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg">{{ old('conditions', $filiere->conditions) }}</textarea>
            </div>
        </div>
        
        <!-- Options et statut -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b">Configuration</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Couleur -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="couleur">
                        Couleur personnalisée
                    </label>
                    <div class="flex items-center space-x-4">
                        <input type="color" 
                               id="couleur" 
                               name="couleur" 
                               value="{{ old('couleur', $filiere->couleur ?: '#3B82F6') }}"
                               class="w-12 h-12 cursor-pointer">
                        <input type="text" 
                               name="couleur"
                               value="{{ old('couleur', $filiere->couleur ?: '#3B82F6') }}"
                               class="w-32 px-3 py-2 border border-gray-300 rounded-lg font-mono">
                    </div>
                </div>
                
                <!-- Statut -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Statut de la filière</label>
                    <div class="mt-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                   name="statut" 
                                   value="1"
                                   {{ (old('statut') ?? $filiere->statut) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-gray-700">Filière active</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Boutons d'action -->
        <div class="flex justify-end">
            <div class="flex space-x-4">
                <a href="{{ route('admin.filieres.index') }}" 
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