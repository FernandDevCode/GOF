@extends('layouts.admin')

@section('title', 'Nouvelle option')
@section('page-title', 'Créer une option')
@section('page-description', 'Ajoutez une nouvelle option de spécialisation')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('admin.options.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Sélection de la filière (si non définie) -->
            @if(isset($filiere) && $filiere)
                <input type="hidden" name="filiere_id" value="{{ $filiere->id }}">
                <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                        <div>
                            <p class="font-medium">Ajout d'une option pour la filière :</p>
                            <p class="text-blue-700 font-bold">{{ $filiere->nom }}</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="filiere_id">
                        Filière de rattachement *
                    </label>
                    <select id="filiere_id" 
                            name="filiere_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        <option value="">Sélectionnez une filière</option>
                        @foreach($filieres as $f)
                        <option value="{{ $f->id }}" {{ old('filiere_id') == $f->id ? 'selected' : '' }}>
                            {{ $f->nom }}
                        </option>
                        @endforeach
                    </select>
                    @error('filiere_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <!-- Nom de l'option -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="nom">
                    Nom de l'option *
                </label>
                <input type="text" 
                       id="nom" 
                       name="nom" 
                       value="{{ old('nom') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                       placeholder="Ex: Développement Web, Réseaux et Télécoms..."
                       required>
                @error('nom')
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
                          placeholder="Description de l'option...">{{ old('description') }}</textarea>
            </div>

            <!-- Brochure (visible seulement aux rôles autorisés) -->
            @if(auth()->check() && auth()->user()->role && auth()->user()->role->canUploadBrochure())
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="brochure">
                    Brochure (PDF)
                </label>
                <input type="file" 
                       id="brochure" 
                       name="brochure"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                       accept=".pdf">
            </div>
            @endif
            
            <!-- Statut -->
            <div class="mb-8">
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="statut" 
                           value="1"
                           {{ old('statut', true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-gray-700">Option active</span>
                </label>
            </div>
            
            <!-- Boutons d'action -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ isset($filiere) ? route('admin.filieres.options.index', $filiere) : route('admin.options.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i> Créer l'option
                </button>
            </div>
        </form>
    </div>
</div>
@endsection