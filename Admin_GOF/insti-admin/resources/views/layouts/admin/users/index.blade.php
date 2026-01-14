<!-- resources/views/admin/users/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Utilisateurs du système</h1>
        <p class="text-gray-600">Administrez les comptes et permissions des utilisateurs</p>
    </div>
    <a href="{{ route('admin.users.create') }}" 
       class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg inline-flex items-center shadow transition duration-200">
        <i class="fas fa-user-plus mr-2"></i> Nouvel utilisateur
    </a>
</div>

<!-- Message de succès -->
@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <i class="fas fa-check-circle text-green-500"></i>
        </div>
        <div class="ml-3">
            <p class="text-green-700">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

<!-- Tableau des utilisateurs -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center">
                            <span>Utilisateur</span>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Rôle
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Statut
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <!-- Colonne Utilisateur -->
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold shadow">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    Inscrit le {{ $user->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                    </td>
                    
                    <!-- Colonne Rôle -->
                    <td class="px-6 py-4">
                        <div class="flex flex-col space-y-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($user->role->name === 'Super Admin') bg-red-100 text-red-800
                                @elseif($user->role->name === 'Administrateur') bg-purple-100 text-purple-800
                                @elseif($user->role->name === 'Éditeur') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                <i class="fas fa-user-tag mr-1"></i>
                                {{ $user->role->name }}
                            </span>
                            @if($user->role->description)
                            <span class="text-xs text-gray-500 truncate max-w-xs">
                                {{ $user->role->description }}
                            </span>
                            @endif
                        </div>
                    </td>
                    
                    <!-- Colonne Email -->
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $user->email }}</div>
                        @if($user->email_verified_at)
                        <div class="text-xs text-green-600">
                            <i class="fas fa-check-circle mr-1"></i> Vérifié
                        </div>
                        @else
                        <div class="text-xs text-yellow-600">
                            <i class="fas fa-clock mr-1"></i> Non vérifié
                        </div>
                        @endif
                    </td>
                    
                    <!-- Colonne Statut -->
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="mr-2 h-2 w-2 rounded-full @if($user->is_active) bg-green-500 @else bg-red-500 @endif"></div>
                            <span class="text-sm @if($user->is_active) text-green-700 @else text-red-700 @endif">
                                {{ $user->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </div>
                    </td>
                    
                    <!-- Colonne Actions -->
                    <td class="px-6 py-4 text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-3">
                            <!-- Bouton Modifier -->
                            <a href="{{ route('admin.users.edit', $user) }}" 
                               class="text-blue-600 hover:text-blue-900 transition duration-150 inline-flex items-center group">
                                <i class="fas fa-edit mr-1 group-hover:scale-110 transition"></i>
                                <span class="hidden md:inline">Modifier</span>
                            </a>
                            
                            <!-- Bouton Supprimer (caché pour l'utilisateur courant) -->
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')"
                                        class="text-red-600 hover:text-red-900 transition duration-150 inline-flex items-center group">
                                    <i class="fas fa-trash mr-1 group-hover:scale-110 transition"></i>
                                    <span class="hidden md:inline">Supprimer</span>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <!-- État vide -->
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="rounded-full bg-gray-100 p-4 mb-4">
                                <i class="fas fa-users text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun utilisateur trouvé</h3>
                            <p class="text-gray-500 mb-6">Commencez par créer un nouvel utilisateur pour votre équipe.</p>
                            <a href="{{ route('admin.users.create') }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                                <i class="fas fa-user-plus mr-2"></i> Créer le premier utilisateur
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($users->hasPages())
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Affichage de <span class="font-medium">{{ $users->firstItem() }}</span>
                à <span class="font-medium">{{ $users->lastItem() }}</span>
                sur <span class="font-medium">{{ $users->total() }}</span> utilisateurs
            </div>
            <div class="flex space-x-2">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Statistiques rapides -->
<div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-4">
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-4 text-white shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-90">Total utilisateurs</p>
                <p class="text-2xl font-bold">{{ $users->total() }}</p>
            </div>
            <i class="fas fa-users text-2xl opacity-75"></i>
        </div>
    </div>
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-4 text-white shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-90">Utilisateurs actifs</p>
                <p class="text-2xl font-bold">{{ $users->where('is_active', true)->count() }}</p>
            </div>
            <i class="fas fa-user-check text-2xl opacity-75"></i>
        </div>
    </div>
    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-4 text-white shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-90">Administrateurs</p>
                <p class="text-2xl font-bold">{{ $users->where('role_id', 1)->count() }}</p>
            </div>
            <i class="fas fa-user-shield text-2xl opacity-75"></i>
        </div>
    </div>
    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl p-4 text-white shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-90">Éditeurs</p>
                <p class="text-2xl font-bold">{{ $users->where('role_id', 3)->count() }}</p>
            </div>
            <i class="fas fa-edit text-2xl opacity-75"></i>
        </div>
    </div>
</div>
@endsection