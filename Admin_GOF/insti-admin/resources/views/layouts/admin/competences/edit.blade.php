@extends('layouts.admin')

@section('title', 'Modifier la compétence')
@section('page-title', 'Modifier la compétence')
@section('page-description', 'Modifiez cette compétence')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Bouton de suppression -->
    <div class="flex justify-start mb-4">
        <form action="{{ route('admin.competences.destroy', $competence) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette compétence ?')"
                    class="px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600">
                <i class="fas fa-trash mr-2"></i> Supprimer
            </button>
        </form>
    </div>

    <form action="{{ route('admin.competences.update', $competence) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <!-- Informations sur l'option parente -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                    <div>
                        <p class="font-medium">Compétence de :</p>
                        <p class="text-blue-700">{{ $competence->option->nom }}</p>
                        <p class="text-sm text-gray-600 mt-1">Filière : {{ $competence->option->filiere->nom }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Description de la compétence -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="description">
                    Description de la compétence *
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                          required>{{ old('description', $competence->description) }}</textarea>
            </div>

            <!-- Type de compétence -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="type">
                    Type de compétence *
                </label>
                <select id="type" name="type" class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                    <option value="technique" {{ (old('type', $competence->type) == 'technique') ? 'selected' : '' }}>Techniques</option>
                    <option value="manageriale" {{ (old('type', $competence->type) == 'manageriale') ? 'selected' : '' }}>Managériales</option>
                    <option value="scientifique" {{ (old('type', $competence->type) == 'scientifique') ? 'selected' : '' }}>Scientifiques</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Ordre géré automatiquement côté serveur -->
            <div class="mb-6">
                <p class="text-gray-500 text-sm">L'ordre d'affichage est géré automatiquement. Utilisez la fonctionnalité de réorganisation pour modifier l'ordre.</p>
            </div>
        </div>
        
        <!-- Boutons d'action -->
        <div class="flex justify-end">
            <div class="flex space-x-4">
                <a href="{{ route('admin.options.competences.index', $competence->option) }}" 
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