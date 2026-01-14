<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $superAdmin = Role::firstOrCreate(
            ['name' => 'Super Admin'],
            ['description' => 'Accès complet à l\'application', 'can_upload_brochure' => true]
        );

        $admin = Role::firstOrCreate(
            ['name' => 'Administrateur'],
            ['description' => 'Administrateur avec droits étendus', 'can_upload_brochure' => true]
        );

        $editor = Role::firstOrCreate(
            ['name' => 'Éditeur'],
            ['description' => 'Éditeur de contenu']
        );

        $consultant = Role::firstOrCreate(
            ['name' => 'Consultant'],
            ['description' => 'Consultant en lecture seule']
        );

        // Create Super Admin user
        User::firstOrCreate(
            ['email' => 'admin@insti.bj'],
            [
                'name' => 'Administrateur INSTI',
                'password' => Hash::make('Admin@2026'),
                'role_id' => $superAdmin->id,
                'email_verified_at' => now(),
            ]
        );

        // Create additional test users
        User::firstOrCreate(
            ['email' => 'editeur@insti.bj'],
            [
                'name' => 'Éditeur Test',
                'password' => Hash::make('Editeur@2026'),
                'role_id' => $editor->id,
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'consultant@insti.bj'],
            [
                'name' => 'Consultant Test',
                'password' => Hash::make('Consultant@2026'),
                'role_id' => $consultant->id,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Rôles et utilisateurs créés avec succès!');
        $this->command->info('');
        $this->command->info('Comptes de test:');
        $this->command->info('  Super Admin: admin@insti.bj / Admin@2026');
        $this->command->info('  Éditeur: editeur@insti.bj / Editeur@2026');
        $this->command->info('  Consultant: consultant@insti.bj / Consultant@2026');
    }
}
