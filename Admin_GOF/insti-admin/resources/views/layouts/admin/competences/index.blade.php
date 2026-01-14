@extends('layouts.admin')

@section('title', $option ? 'Compétences de l\'option' : 'Toutes les compétences')
@section('page-title', 'Compétences')
@section('page-description', $option ? 'Gérez les compétences de l\'option ' . $option->nom : 'Liste globale des compétences')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">{{ $option ? 'Compétences acquises' : 'Liste des compétences' }}</h2>
        @if($option)
        <div class="flex items-center mt-2">
            <span class="text-gray-600">Option :</span>
            <a href="{{ route('admin.options.show', $option) }}" 
               class="ml-2 text-blue-600 hover:text-blue-800">
                {{ $option->nom }}
            </a>
            <span class="mx-2">•</span>
            <span class="text-gray-600">Filière :</span>
            <a href="{{ route('admin.filieres.show', $option->filiere) }}" 
               class="ml-2 text-blue-600 hover:text-blue-800">
                {{ $option->filiere->nom }}
            </a>
        </div>
        @endif
    </div>
    <a href="{{ $option ? route('admin.options.competences.create', $option) : route('admin.competences.create') }}" 
       class="mt-4 md:mt-0 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
        <i class="fas fa-plus mr-2"></i>
        Ajouter une compétence
    </a>
</div>

<!-- Liste des compétences -->
<div class="bg-white rounded-xl shadow overflow-hidden">
    @if($competences->count() > 0)
        <div class="divide-y divide-gray-200">
            @foreach($competences as $competence)
            <div class="p-6 hover:bg-gray-50 flex justify-between items-center {{ $option ? 'draggable-item' : '' }}" 
                 data-id="{{ $competence->id }}">
                <div class="flex items-center {{ $option ? 'cursor-move' : '' }}">
                    <div class="mr-4 text-gray-400 {{ $option ? 'drag-handle' : '' }}">
                        <i class="fas {{ $option ? 'fa-arrows-alt-v' : 'fa-circle text-xs' }}"></i>
                    </div>
                    <div>
                        <p class="text-gray-900">{{ $competence->description }}</p>

                        {{-- Badge affichant le type de compétence --}}
                        <div class="mt-2">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $competence->type === 'technique' ? 'bg-green-100 text-green-800' : ($competence->type === 'manageriale' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ $competence->type === 'technique' ? 'Techniques' : ($competence->type === 'manageriale' ? 'Managériales' : 'Scientifiques') }}
                            </span>
                        </div>

                        @if(!$option && $competence->option)
                        <div class="mt-1 text-sm text-blue-600">
                            Option : {{ $competence->option->nom }}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.competences.edit', $competence) }}" 
                       class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.competences.destroy', $competence) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette compétence ?')"
                                class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="p-12 text-center">
            <div class="text-gray-400">
                <i class="fas fa-tools text-5xl mb-4"></i>
                <p class="text-lg">Aucune compétence définie</p>
                <p class="mt-2">Ajoutez les compétences acquises dans cette option</p>
                <a href="{{ $option ? route('admin.options.competences.create', $option) : route('admin.competences.create') }}" class="mt-4 inline-block text-blue-500 hover:text-blue-700">
                    <i class="fas fa-plus mr-1"></i> Ajouter une compétence
                </a>
            </div>
        </div>
    @endif
</div>


<!-- Bouton de sauvegarde -->
@if($option)
<div class="p-4 border-t border-gray-200 bg-gray-50">
    <button id="save-order" 
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 disabled:opacity-50">
        <i class="fas fa-save mr-2"></i> Enregistrer l'ordre
    </button>
</div>
@endif

@push('scripts')
@if($option)
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    // Code JavaScript similaire à celui des débouchés
</script>
@endif
@endpush

<!-- Retour -->
@if($option)
<div class="mt-6 flex justify-between">
    <a href="{{ route('admin.options.show', $option) }}" 
       class="inline-flex items-center text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left mr-2"></i>
        Retour à l'option
    </a>
</div>
@endif
@endsection