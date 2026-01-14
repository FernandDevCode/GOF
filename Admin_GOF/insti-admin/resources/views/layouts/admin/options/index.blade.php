@extends('layouts.admin')

@section('title', $filiere ? 'Options de la filière' : 'Toutes les offres')
@section('page-title', 'Offres de spécialisation')
@section('page-description', $filiere ? 'Gérez les offres de la filière ' . $filiere->nom : 'Liste complète des offres de spécialisation')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Offres de spécialisation</h2>
        @if($filiere)
        <div class="flex items-center mt-2">
            <span class="text-gray-600">Filière :</span>
            <a href="{{ route('admin.filieres.show', $filiere) }}" 
               class="ml-2 text-blue-600 hover:text-blue-800">
                {{ $filiere->nom }}
            </a>
        </div>
        @endif
    </div>
    <a href="{{ $filiere ? route('admin.filieres.options.create', $filiere) : route('admin.options.create') }}" 
       class="mt-4 md:mt-0 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
        <i class="fas fa-plus mr-2"></i>
        Nouvelle offre
    </a>
</div>

<!-- Tableau des options -->
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    @if(!$filiere)
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Filière</th>
                    @endif
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Compétences</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Débouchés</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($options as $option)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        #{{ $option->id }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $option->nom }}</div>
                    </td>
                    @if(!$filiere)
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.filieres.show', $option->filiere) }}" class="text-blue-600 hover:underline">
                            {{ $option->filiere->nom }}
                        </a>
                    </td>
                    @endif
                    <td class="px-6 py-4">
                        @if($option->description)
                        <div class="text-sm text-gray-500 truncate max-w-xs">
                            {{ Str::limit($option->description, 60) }}
                        </div>
                        @else
                        <span class="text-gray-400 text-sm">Aucune description</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($option->statut)
                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800">
                            Active
                        </span>
                        @else
                        <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-800">
                            Inactive
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                            {{ $option->competences_count ?? 0 }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                            {{ $option->debouches_count ?? 0 }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.options.show', $option) }}" 
                               class="text-green-600 hover:text-green-900" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.options.edit', $option) }}" 
                               class="text-blue-600 hover:text-blue-900" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.options.destroy', $option) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette option ?')"
                                        class="text-red-600 hover:text-red-900" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ $filiere ? 7 : 8 }}" class="px-6 py-12 text-center">
                        <div class="text-gray-400">
                            <i class="fas fa-list-alt text-5xl mb-4"></i>
                            <p class="text-lg">Aucune option trouvée</p>
                            @if($filiere)
                            <p class="mt-2">Commencez par créer votre première option</p>
                            <a href="{{ route('admin.filieres.options.create', $filiere) }}" class="mt-4 inline-block text-blue-500 hover:text-blue-700">
                                <i class="fas fa-plus mr-1"></i> Créer une option
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Retour à la filière -->
@if($filiere)
<div class="mt-6">
    <a href="{{ route('admin.filieres.show', $filiere) }}" 
       class="inline-flex items-center text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left mr-2"></i>
        Retour à la filière
    </a>
</div>
@endif
@endsection