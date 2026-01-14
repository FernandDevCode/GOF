@extends('layouts.admin')

@section('title', 'Nouveau débouché')
@section('page-title', 'Ajouter un débouché')
@section('page-description', $option ? 'Ajoutez un débouché professionnel à l\'option ' . $option->nom : 'Ajouter un nouveau débouché')

@section('content')
<div class="max-w-2xl mx-auto">
    <form action="{{ $option ? route('admin.options.debouches.store', $option) : route('admin.debouches.store') }}" method="POST">
        @csrf
        
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <!-- Informations sur l'option parente -->
            @if($option)
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                    <div>
                        <p class="font-medium">Vous ajoutez un débouché à :</p>
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
            
            <!-- Titre du débouché -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="titre">
                    Titre du débouché *
                </label>
                <input type="text" 
                       id="titre" 
                       name="titre" 
                       value="{{ old('titre') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                       placeholder="Ex: Développeur logiciel, Ingénieur réseau..."
                       required>
                @error('titre')
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
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                          placeholder="Description détaillée du débouché professionnel...">{{ old('description') }}</textarea>
                @error('description')
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
            <a href="{{ $option ? route('admin.options.debouches.index', $option) : route('admin.debouches.index') }}" 
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                Annuler
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                <i class="fas fa-save mr-2"></i> Ajouter le débouché
            </button>
        </div>
    </form>
</div>
@endsection