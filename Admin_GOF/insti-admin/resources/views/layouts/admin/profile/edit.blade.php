<!-- resources/views/admin/profile/edit.blade.php -->
@extends('layouts.admin')

@section('title', 'Mon profil')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Mon profil</h1>
    
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    <form action="{{ route('admin.profile.update') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Nom complet *</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Adresse email *</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Changer le mot de passe</h3>
            <p class="text-gray-600 text-sm mb-4">Laissez vide si vous ne souhaitez pas modifier le mot de passe.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 mb-2">Mot de passe actuel</label>
                    <input type="password" name="current_password" 
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('current_password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 mb-2">Nouveau mot de passe</label>
                    <input type="password" name="password" 
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 mb-2">Confirmer le nouveau mot de passe</label>
                    <input type="password" name="password_confirmation" 
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>
        
        <div class="flex justify-end gap-3 pt-4 border-t">
            <a href="{{ route('admin.dashboard') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Annuler
            </a>
            <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Mettre à jour le profil
            </button>
        </div>
    </form>
</div>
@endsection