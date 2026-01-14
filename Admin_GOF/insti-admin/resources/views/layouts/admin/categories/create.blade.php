@extends('layouts.admin')

@section('title', 'Nouvelle catégorie')
@section('page-title', 'Créer une catégorie')
@section('page-description', 'Ajoutez une nouvelle catégorie de formation')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <!-- Nom de la catégorie -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="nom">
                    Nom de la catégorie *
                </label>
                <input type="text" 
                       id="nom" 
                       name="nom" 
                       value="{{ old('nom') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                       placeholder="Ex: Informatique, Génie Civil, Management..."
                       required>
                @error('nom')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
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
                           value="{{ old('couleur', '#3B82F6') }}"
                           class="w-16 h-16 cursor-pointer"
                           onchange="document.getElementById('couleur-text').value = this.value">
                    <div class="flex-1">
                        <input type="text" 
                               id="couleur-text" 
                               value="{{ old('couleur', '#3B82F6') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg font-mono"
                               placeholder="#3B82F6"
                               pattern="^#[0-9A-F]{6}$"
                               oninput="document.getElementById('couleur').value = this.value">
                        <p class="text-gray-500 text-sm mt-1">Format hexadécimal (#FFFFFF)</p>
                    </div>
                </div>
                @error('couleur')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Description -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="description">
                    Description
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                          placeholder="Décrivez brièvement cette catégorie...">{{ old('description') }}</textarea>
                <p class="text-gray-500 text-sm mt-1">Cette description sera visible par les visiteurs</p>
            </div>
            
            <!-- Statut -->
            <div class="mb-8">
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="active" 
                           value="1"
                           {{ old('active', true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-gray-700">Catégorie active</span>
                </label>
                <p class="text-gray-500 text-sm mt-1">Une catégorie inactive ne sera pas visible sur le site public</p>
            </div>
            
            <!-- Boutons d'action -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.categories.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i> Créer la catégorie
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Validation en temps réel de la couleur
    document.getElementById('couleur-text').addEventListener('input', function(e) {
        const colorRegex = /^#[0-9A-F]{6}$/i;
        if (!colorRegex.test(e.target.value)) {
            e.target.classList.add('border-red-500');
        } else {
            e.target.classList.remove('border-red-500');
        }
    });
</script>
@endpush
@endsection