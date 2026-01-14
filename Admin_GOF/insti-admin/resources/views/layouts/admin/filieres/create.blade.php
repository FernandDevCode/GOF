@extends('layouts.admin')

@section('title', 'Nouvelle filière')
@section('page-title', 'Créer une filière')
@section('page-description', 'Ajoutez une nouvelle filière de formation')

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.filieres.store') }}" method="POST">
        @csrf
        
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
                       value="{{ old('nom') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Ex: Génie Électrique et Informatique"
                       required>
                @error('nom')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Catégorie -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="category_formation_id">
                    Catégorie *
                </label>
                <select id="category_formation_id" 
                        name="category_formation_id" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="">Sélectionnez une catégorie</option>
                    @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ old('category_formation_id') == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                    </option>
                    @endforeach
                </select>
                @error('category_formation_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Niveau -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="niveau">
                        Niveau *
                    </label>
                    <select id="niveau" 
                            name="niveau" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        <option value="">Sélectionnez un niveau</option>
                        @foreach($niveaux as $niveau)
                        <option value="{{ $niveau }}" {{ old('niveau') == $niveau ? 'selected' : '' }}>
                            {{ $niveau }}
                        </option>
                        @endforeach
                    </select>
                    @error('niveau')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Durée -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="duree">
                        Durée (années) *
                    </label>
                    <input type="number" 
                           id="duree" 
                           name="duree" 
                           value="{{ old('duree') }}"
                           min="1" 
                           max="5"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('duree')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
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
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Décrivez cette filière de formation..."
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
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
                       value="{{ old('bac_requis') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Ex: Bac C, D, E, F..."
                       required>
                @error('bac_requis')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Conditions supplémentaires -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="conditions">
                    Conditions supplémentaires
                </label>
                <textarea id="conditions" 
                          name="conditions" 
                          rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Ex: Test d'entrée, entretien, dossier...">{{ old('conditions') }}</textarea>
                @error('conditions')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
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
                               value="{{ old('couleur', '#3B82F6') }}"
                               class="w-12 h-12 cursor-pointer">
                        <input type="text" 
                               value="{{ old('couleur', '#3B82F6') }}"
                               class="w-32 px-3 py-2 border border-gray-300 rounded-lg font-mono"
                               readonly>
                    </div>
                    @error('couleur')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Statut -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Statut de la filière</label>
                    <div class="mt-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                   name="statut" 
                                   value="1"
                                   {{ old('statut', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-gray-700">Filière active</span>
                        </label>
                        <p class="text-gray-500 text-sm mt-1">Une filière inactive ne sera pas visible sur le site public</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Boutons d'action -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.filieres.index') }}" 
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                Annuler
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="fas fa-save mr-2"></i> Créer la filière
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Gestion de la couleur
    const colorInput = document.getElementById('couleur');
    const colorText = colorInput.nextElementSibling;
    
    colorInput.addEventListener('input', function() {
        colorText.value = this.value;
    });
    
    colorText.addEventListener('input', function() {
        if (this.value.match(/^#[0-9A-F]{6}$/i)) {
            colorInput.value = this.value;
        }
    });
</script>
@endpush
@endsection