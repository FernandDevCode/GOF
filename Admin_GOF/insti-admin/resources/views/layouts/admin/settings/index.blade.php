<!-- resources/views/admin/settings/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Paramètres du site')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Paramètres du site</h1>
    <p class="text-gray-600">Configurez les paramètres généraux de l'application</p>
</div>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <!-- Informations générales -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">Informations générales</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 mb-2">Nom du site *</label>
                <input type="text" name="site_title" value="{{ $settings['site_title'] ?? '' }}" 
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div>
                <label class="block text-gray-700 mb-2">Description du site *</label>
                <textarea name="site_description" rows="3" 
                          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ $settings['site_description'] ?? '' }}</textarea>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            <div>
                <label class="block text-gray-700 mb-2">Logo du site</label>
                <input type="file" name="site_logo" accept="image/*" 
                       class="w-full border rounded px-3 py-2">
                @if($settings['site_logo'] ?? false)
                    <div class="mt-2">
                        <p class="text-sm text-gray-600">Logo actuel :</p>
                        <img src="{{ asset('storage/' . $settings['site_logo']) }}" 
                             alt="Logo" class="h-16 mt-1">
                    </div>
                @endif
            </div>
            
            <div>
                <label class="block text-gray-700 mb-2">Favicon</label>
                <input type="file" name="site_favicon" accept="image/x-icon,image/png" 
                       class="w-full border rounded px-3 py-2">
                @if($settings['site_favicon'] ?? false)
                    <div class="mt-2">
                        <p class="text-sm text-gray-600">Favicon actuel :</p>
                        <img src="{{ asset('storage/' . $settings['site_favicon']) }}" 
                             alt="Favicon" class="h-8 mt-1">
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Contact -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">Informations de contact</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 mb-2">Email de contact *</label>
                <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" 
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div>
                <label class="block text-gray-700 mb-2">Téléphone *</label>
                <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" 
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="md:col-span-2">
                <label class="block text-gray-700 mb-2">Adresse *</label>
                <textarea name="contact_address" rows="2" 
                          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ $settings['contact_address'] ?? '' }}</textarea>
            </div>
        </div>
    </div>
    
    <!-- Réseaux sociaux -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">Réseaux sociaux</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-gray-700 mb-2">Facebook</label>
                <input type="url" name="facebook_url" value="{{ $settings['facebook_url'] ?? '' }}" 
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="https://facebook.com/...">
            </div>
            
            <div>
                <label class="block text-gray-700 mb-2">Twitter/X</label>
                <input type="url" name="twitter_url" value="{{ $settings['twitter_url'] ?? '' }}" 
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="https://twitter.com/...">
            </div>
            
            <div>
                <label class="block text-gray-700 mb-2">LinkedIn</label>
                <input type="url" name="linkedin_url" value="{{ $settings['linkedin_url'] ?? '' }}" 
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="https://linkedin.com/...">
            </div>
        </div>
    </div>
    
    <!-- Configuration système -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">Configuration système</h2>
        
        <div class="space-y-4">
            <div class="flex items-center">
                <input type="checkbox" name="maintenance_mode" value="1" 
                       id="maintenance_mode" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                       {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' }}>
                <label for="maintenance_mode" class="ml-2 text-gray-700">
                    Mode maintenance
                </label>
                <span class="ml-2 text-sm text-gray-500">(Le site sera inaccessible aux visiteurs)</span>
            </div>
            
            <div class="flex items-center">
                <input type="checkbox" name="registration_enabled" value="1" 
                       id="registration_enabled" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                       {{ ($settings['registration_enabled'] ?? '1') == '1' ? 'checked' : '' }}>
                <label for="registration_enabled" class="ml-2 text-gray-700">
                    Inscriptions autorisées
                </label>
                <span class="ml-2 text-sm text-gray-500">(Permettre aux nouveaux utilisateurs de s'inscrire)</span>
            </div>
        </div>
    </div>
    
    <div class="flex justify-end">
        <button type="submit" 
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg inline-flex items-center">
            <i class="fas fa-save mr-2"></i> Enregistrer les paramètres
        </button>
    </div>
</form>
@endsection