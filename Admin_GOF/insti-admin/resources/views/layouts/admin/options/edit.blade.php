@extends('layouts.admin')

@section('title', 'Modifier l\'option')
@section('page-title', 'Modifier l\'option')
@section('page-description', 'Modifiez les informations de cette option')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Bouton de suppression -->
    <div class="flex justify-start mb-4">
        <form action="{{ route('admin.options.destroy', $option) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette option ?')"
                    class="px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600">
                <i class="fas fa-trash mr-2"></i> Supprimer
            </button>
        </form>
    </div>

    <form action="{{ route('admin.options.update', $option) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <!-- Informations sur la filière parente -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                    <div>
                        <p class="font-medium">Option de la filière :</p>
                        <p class="text-blue-700">{{ $option->filiere->nom }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Nom de l'option -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="nom">
                    Nom de l'option *
                </label>
                <input type="text" 
                       id="nom" 
                       name="nom" 
                       value="{{ old('nom', $option->nom) }}"
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
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg">{{ old('description', $option->description) }}</textarea>
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
                @if ($option->brochure)
                    <div class="mt-2 text-sm text-gray-600">
                        Fichier actuel : <a href="{{ Storage::url($option->brochure) }}" target="_blank" class="text-blue-500 hover:underline">{{ $option->brochure }}</a>
                    </div>
                @endif
            </div>
            @endif

            <!-- Statut -->
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="statut" 
                           value="1"
                           {{ (old('statut') ?? $option->statut) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-gray-700">Option active</span>
                </label>
            </div>
        </div>
        
        <!-- Boutons d'action -->
        <div class="flex justify-end">
            <div class="flex space-x-4">
                <a href="{{ route('admin.filieres.options.index', $option->filiere) }}" 
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