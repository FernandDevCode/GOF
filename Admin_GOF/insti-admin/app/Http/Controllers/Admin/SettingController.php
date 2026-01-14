<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage_settings');
    }
    
    public function index()
    {
        // Récupérer tous les paramètres
        $settings = Setting::all()->pluck('value', 'key');
        
        // Paramètres par défaut si non existants
        $defaultSettings = [
            'site_title' => 'INSTI - Institut National Supérieur de Technologie Industrielle',
            'site_description' => 'Formation d\'excellence en technologie industrielle',
            'site_logo' => null,
            'site_favicon' => null,
            'contact_email' => 'contact@insti.bj',
            'contact_phone' => '+229 XX XX XX XX',
            'contact_address' => 'Lokossa, Bénin',
            'facebook_url' => null,
            'twitter_url' => null,
            'linkedin_url' => null,
            'maintenance_mode' => '0',
            'registration_enabled' => '1',
            'default_role_id' => '3', // Éditeur par défaut
        ];
        
        // Fusionner avec les valeurs existantes
        foreach ($defaultSettings as $key => $value) {
            if (!isset($settings[$key])) {
                $settings[$key] = $value;
            }
        }
        
        return view('admin.settings.index', compact('settings'));
    }
    
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_title' => 'required|string|max:255',
            'site_description' => 'required|string|max:500',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'contact_address' => 'required|string|max:255',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'maintenance_mode' => 'boolean',
            'registration_enabled' => 'boolean',
        ]);
        
        foreach ($validated as $key => $value) {
            Setting::setValue($key, $value);
        }
        
        // Gestion du logo (si upload)
        if ($request->hasFile('site_logo')) {
            $logoPath = $request->file('site_logo')->store('settings', 'public');
            Setting::setValue('site_logo', $logoPath);
        }
        
        // Gestion du favicon (si upload)
        if ($request->hasFile('site_favicon')) {
            $faviconPath = $request->file('site_favicon')->store('settings', 'public');
            Setting::setValue('site_favicon', $faviconPath);
        }
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Paramètres mis à jour avec succès!');
    }
}
