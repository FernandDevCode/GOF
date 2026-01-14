@extends('layouts.admin')

@section('title', $option ? 'Débouchés professionnels' : 'Tous les débouchés')
@section('page-title', 'Débouchés professionnels')
@section('page-description', $option ? 'Gérez les débouchés de l\'option ' . $option->nom : 'Liste globale des débouchés')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">{{ $option ? 'Débouchés professionnels' : 'Liste des débouchés' }}</h2>
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
    <a href="{{ $option ? route('admin.options.debouches.create', $option) : route('admin.debouches.create') }}" 
       class="mt-4 md:mt-0 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
        <i class="fas fa-plus mr-2"></i>
        Ajouter un débouché
    </a>
</div>

<!-- Liste des débouchés avec drag & drop -->
<div class="bg-white rounded-xl shadow overflow-hidden">
    @if($debouches->count() > 0)
        <div id="debouches-list" class="divide-y divide-gray-200">
            @foreach($debouches as $debouche)
            <div class="p-6 hover:bg-gray-50 flex justify-between items-center {{ $option ? 'draggable-item' : '' }}" 
                 data-id="{{ $debouche->id }}">
                <div class="flex items-center {{ $option ? 'cursor-move' : '' }}">
                    <div class="mr-4 text-gray-400 {{ $option ? 'drag-handle' : '' }}">
                        <i class="fas {{ $option ? 'fa-arrows-alt-v' : 'fa-circle text-xs' }}"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $debouche->titre }}</p>
                        @if(!$option && $debouche->option)
                        <p class="text-xs text-blue-600 mt-1">
                            Option : {{ $debouche->option->nom }}
                        </p>
                        @endif
                        @if($debouche->description)
                        <p class="text-sm text-gray-600 mt-1">{{ $debouche->description }}</p>
                        @endif
                        <div class="mt-2">
                            <span class="text-xs text-gray-500">Ordre : {{ $debouche->ordre }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.debouches.edit', $debouche) }}" 
                       class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.debouches.destroy', $debouche) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce débouché ?')"
                                class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Message d'ordre sauvegardé -->
        @if($option)
        <div id="order-success" class="hidden p-4 bg-green-100 text-green-800 border-t border-green-200">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>Ordre sauvegardé avec succès</span>
            </div>
        </div>
        
        <!-- Bouton de sauvegarde de l'ordre -->
        <div class="p-4 border-t border-gray-200 bg-gray-50">
            <button id="save-order" 
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="fas fa-save mr-2"></i> Enregistrer l'ordre
            </button>
            <span id="order-saving" class="hidden ml-3 text-gray-600">
                <i class="fas fa-spinner fa-spin mr-1"></i> Sauvegarde en cours...
            </span>
        </div>
        @endif
    @else
        <div class="p-12 text-center">
            <div class="text-gray-400">
                <i class="fas fa-briefcase text-5xl mb-4"></i>
                <p class="text-lg">Aucun débouché défini</p>
                <p class="mt-2">Ajoutez les débouchés professionnels de cette option</p>
                <a href="{{ $option ? route('admin.options.debouches.create', $option) : route('admin.debouches.create') }}" class="mt-4 inline-block text-blue-500 hover:text-blue-700">
                    <i class="fas fa-plus mr-1"></i> Ajouter un débouché
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Retour -->
@if($option)
<div class="mt-6">
    <a href="{{ route('admin.options.show', $option) }}" 
       class="inline-flex items-center text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left mr-2"></i>
        Retour à l'option
    </a>
</div>
@endif

@push('scripts')
@if($option)
<!-- Sortable.js pour le drag & drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const list = document.getElementById('debouches-list');
        if (list) {
            const sortable = Sortable.create(list, {
                animation: 150,
                handle: '.drag-handle',
                ghostClass: 'bg-blue-50',
                onUpdate: function() {
                    document.getElementById('save-order').disabled = false;
                }
            });
            
            // Sauvegarde de l'ordre
            document.getElementById('save-order').addEventListener('click', function() {
                const btn = this;
                const savingSpan = document.getElementById('order-saving');
                const successDiv = document.getElementById('order-success');
                
                btn.disabled = true;
                savingSpan.classList.remove('hidden');
                
                // Récupérer le nouvel ordre
                const order = [];
                document.querySelectorAll('.draggable-item').forEach(function(item, index) {
                    order.push({
                        id: item.dataset.id,
                        position: index + 1
                    });
                });
                
                // Envoyer la requête AJAX
                fetch('{{ route("admin.debouches.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order.map(item => item.id) })
                })
                .then(response => response.json())
                .then(data => {
                    savingSpan.classList.add('hidden');
                    successDiv.classList.remove('hidden');
                    
                    // Mettre à jour les numéros d'ordre
                    document.querySelectorAll('.draggable-item').forEach((item, index) => {
                        const orderSpan = item.querySelector('.order-number');
                        if (orderSpan) {
                            orderSpan.textContent = `Ordre : ${index + 1}`;
                        }
                    });
                    
                    // Cacher le message de succès après 3 secondes
                    setTimeout(() => {
                        successDiv.classList.add('hidden');
                    }, 3000);
                })
                .catch(error => {
                    savingSpan.classList.add('hidden');
                    btn.disabled = false;
                    alert('Erreur lors de la sauvegarde de l\'ordre');
                });
            });
        }
    });
</script>
@endif
@endpush
@endsection