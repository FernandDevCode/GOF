@extends('layouts.admin')

@section('title', 'Nouvelle compétence')
@section('page-title', 'Ajouter une compétence')
@section('page-description', $option ? 'Ajoutez une compétence à l\'option ' . $option->nom : 'Ajouter une nouvelle compétence')

@section('content')
<div class="max-w-2xl mx-auto">
    <form action="{{ $option ? route('admin.options.competences.store', $option) : route('admin.competences.store') }}" method="POST">
        @csrf
        
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <!-- Informations sur l'option parente -->
            @if($option)
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                    <div>
                        <p class="font-medium">Vous ajoutez une compétence à :</p>
                        <p class="text-blue-700">{{ $option->nom }}</p>
                        <p class="text-sm text-gray-600 mt-1">Filière : {{ $option->filiere->nom }}</p>
                    </div>
                </div>
            </div>
            @else
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Option concernée *</label>
                <select name="option_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                    <option value="">Choisir une option...</option>
                    @foreach($options as $opt)
                    <option value="{{ $opt->id }}">{{ $opt->nom }} ({{ $opt->filiere->nom ?? '?' }})</option>
                    @endforeach
                </select>
                @error('option_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            @endif
            
            <!-- Description de la compétence -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="description">
                    Description de la compétence *
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                          placeholder="Ex: Maîtrise des langages de programmation (Java, Python, C++)"
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type de compétence -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="type">
                    Type de compétence *
                </label>
                <select id="type" name="type" class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                    <option value="technique" {{ old('type') == 'technique' ? 'selected' : '' }}>Techniques</option>
                    <option value="manageriale" {{ old('type') == 'manageriale' ? 'selected' : '' }}>Managériales</option>
                    <option value="scientifique" {{ old('type') == 'scientifique' ? 'selected' : '' }}>Scientifiques</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Ordre géré automatiquement côté serveur -->
            <div class="mb-6">
                <p class="text-gray-500 text-sm">L'ordre d'affichage est attribué automatiquement lors de la création. Utilisez la fonctionnalité de réorganisation pour modifier l'ordre.</p>
            </div>
        </div>
        
        <!-- Boutons d'action -->
        <div class="flex justify-end space-x-4">
            <a href="{{ $option ? route('admin.options.competences.index', $option) : route('admin.competences.index') }}" 
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                Annuler
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                <i class="fas fa-save mr-2"></i> Ajouter la compétence
            </button>
        </div>
    </form>
</div>
@endsection