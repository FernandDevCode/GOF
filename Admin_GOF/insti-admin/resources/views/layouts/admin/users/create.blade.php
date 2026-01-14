<!-- resources/views/admin/users/create.blade.php -->
@extends('layouts.admin')

@section('title', 'Créer un utilisateur')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- En-tête avec breadcrumb -->
    <div class="mb-6">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-2"></i>
                        Tableau de bord
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <a href="{{ route('admin.users.index') }}" class="ml-1 text-gray-700 hover:text-blue-600">
                            Utilisateurs
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="ml-1 text-blue-600 font-medium">Nouvel utilisateur</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Créer un nouvel utilisateur</h1>
                <p class="text-gray-600 mt-2">Ajoutez un nouveau membre à votre équipe administrative</p>
            </div>
            <div class="rounded-full bg-blue-100 p-3">
                <i class="fas fa-user-plus text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <!-- Formulaire -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <!-- En-tête du formulaire -->
            <div class="px-6 py-4 bg-gray-50 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Informations de l'utilisateur</h2>
                <p class="text-sm text-gray-600">Renseignez les informations de base du nouvel utilisateur</p>
            </div>
            
            <!-- Corps du formulaire -->
            <div class="p-6 space-y-6">
                <!-- Informations personnelles -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center">
                                <i class="fas fa-user mr-2 text-blue-500"></i>
                                Nom complet *
                            </span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name"
                               value="{{ old('name') }}" 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="John Doe"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center">
                                <i class="fas fa-envelope mr-2 text-blue-500"></i>
                                Adresse email *
                            </span>
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email"
                               value="{{ old('email') }}" 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="john.doe@insti.bj"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                
                <!-- Mot de passe -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center">
                                <i class="fas fa-lock mr-2 text-blue-500"></i>
                                Mot de passe *
                            </span>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   name="password" 
                                   id="password"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 pr-10"
                                   placeholder="●●●●●●●●"
                                   required>
                            <button type="button" 
                                    onclick="togglePassword('password')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            Minimum 8 caractères avec lettres et chiffres
                        </p>
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center">
                                <i class="fas fa-lock mr-2 text-blue-500"></i>
                                Confirmer le mot de passe *
                            </span>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 pr-10"
                                   placeholder="●●●●●●●●"
                                   required>
                            <button type="button" 
                                    onclick="togglePassword('password_confirmation')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Rôle -->
                <div>
                    <label for="role_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <span class="flex items-center">
                            <i class="fas fa-user-tag mr-2 text-blue-500"></i>
                            Rôle de l'utilisateur *
                        </span>
                    </label>
                    <select name="role_id" 
                            id="role_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            required>
                        <option value="">Sélectionner un rôle...</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" 
                                    {{ old('role_id') == $role->id ? 'selected' : '' }}
                                    class="@if($role->name === 'Super Admin') text-red-700 @endif">
                                {{ $role->name }}
                                @if($role->description)
                                    - {{ $role->description }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                    
                    <!-- Explication des rôles -->
                    <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center mb-2">
                                <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
                                <span class="text-sm font-medium">Super Admin</span>
                            </div>
                            <p class="text-xs text-gray-600">Accès complet à toutes les fonctionnalités</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center mb-2">
                                <div class="w-3 h-3 rounded-full bg-purple-500 mr-2"></div>
                                <span class="text-sm font-medium">Administrateur</span>
                            </div>
                            <p class="text-xs text-gray-600">Gestion des formations et utilisateurs</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center mb-2">
                                <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                                <span class="text-sm font-medium">Éditeur</span>
                            </div>
                            <p class="text-xs text-gray-600">Gestion des contenus uniquement</p>
                        </div>
                    </div>
                </div>
                
                <!-- Statut -->
                <div>
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <input type="checkbox" 
                               name="is_active" 
                               id="is_active"
                               value="1" 
                               class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                               checked>
                        <label for="is_active" class="ml-3">
                            <span class="text-sm font-medium text-gray-700">Activer le compte immédiatement</span>
                            <p class="text-xs text-gray-500">L'utilisateur pourra se connecter dès la création</p>
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Pied du formulaire -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-between items-center">
                <a href="{{ route('admin.users.index') }}" 
                   class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
                <div class="flex space-x-3">
                    <button type="reset" 
                            class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                        <i class="fas fa-redo mr-2"></i>
                        Réinitialiser
                    </button>
                    <button type="submit" 
                            class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition duration-200">
                        <i class="fas fa-save mr-2"></i>
                        Créer l'utilisateur
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Script pour afficher/masquer le mot de passe -->
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
    field.setAttribute('type', type);
    
    // Changer l'icône
    const button = field.nextElementSibling;
    button.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
}

// Validation en temps réel du mot de passe
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const confirmation = document.getElementById('password_confirmation');
    const errorElement = this.nextElementSibling.nextElementSibling;
    
    if (password.length > 0 && password.length < 8) {
        if (!errorElement || !errorElement.classList.contains('text-red-600')) {
            const error = document.createElement('p');
            error.className = 'mt-1 text-sm text-red-600 flex items-center';
            error.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i> Le mot de passe doit contenir au moins 8 caractères';
            
            const existingError = this.nextElementSibling.nextElementSibling;
            if (existingError && existingError.classList.contains('text-red-600')) {
                existingError.remove();
            }
            
            this.parentNode.insertBefore(error, this.nextElementSibling.nextElementSibling);
        }
    } else if (errorElement && errorElement.classList.contains('text-red-600')) {
        errorElement.remove();
    }
});
</script>
@endsection