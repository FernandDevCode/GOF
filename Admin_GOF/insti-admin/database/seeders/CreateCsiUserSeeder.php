<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateCsiUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure Super Admin role exists
        $superAdmin = Role::firstOrCreate(
            ['name' => 'Super Admin'],
            ['description' => 'Accès complet à l\'application']
        );

        // Create 'csi' superuser
        User::firstOrCreate(
            ['email' => 'csi@insti.bj'],
            [
                'name' => 'csi',
                'password' => Hash::make('Csi@2026'),
                'role_id' => $superAdmin->id,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Super utilisateur "csi" (csi@insti.bj / Csi@2026) créé (ou existant).');
    }
}
