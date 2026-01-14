<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
     /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'site_title',
                'value' => 'INSTI - Institut National Supérieur de Technologie Industrielle',
                'description' => 'Titre du site web'
            ],
            [
                'key' => 'site_description',
                'value' => 'Formation d\'excellence en technologie industrielle au Bénin',
                'description' => 'Description du site web'
            ],
            [
                'key' => 'contact_email',
                'value' => 'contact@insti.bj',
                'description' => 'Email de contact principal'
            ],
            [
                'key' => 'contact_phone',
                'value' => '+229 XX XX XX XX',
                'description' => 'Numéro de téléphone de contact'
            ],
            [
                'key' => 'contact_address',
                'value' => 'Lokossa, Bénin',
                'description' => 'Adresse physique de l\'institut'
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'description' => 'Activer/désactiver le mode maintenance'
            ],
            [
                'key' => 'registration_enabled',
                'value' => '1',
                'description' => 'Autoriser les nouvelles inscriptions'
            ],
        ];
        
        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}

