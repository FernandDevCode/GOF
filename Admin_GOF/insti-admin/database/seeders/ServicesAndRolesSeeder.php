<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesAndRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Services
        $serviceDirection = Service::firstOrCreate(['nom_service' => 'Direction']);
        $serviceDepartement = Service::firstOrCreate(['nom_service' => 'Département']);
        $serviceInformatique = Service::firstOrCreate(['nom_service' => 'Informatique']);

        // Create Roles
        $roleDirecteur = Role::firstOrCreate(['name' => 'Directeur'], ['description' => 'Directeur de l\'établissement']);
        $roleDirectriceAdjointe = Role::firstOrCreate(['name' => 'Directrice adjointe'], ['description' => 'Directrice adjointe de l\'établissement']);
        $roleChefDepartement = Role::firstOrCreate(['name' => 'Chef de département'], ['description' => 'Chef de département']);
        $roleChefInfo = Role::firstOrCreate(['name' => 'Chef du service informatique'], ['description' => 'Chef du service informatique']);

        // Attach services to roles
        $roleDirecteur->services()->syncWithoutDetaching([$serviceDirection->id]);
        $roleDirectriceAdjointe->services()->syncWithoutDetaching([$serviceDirection->id]);
        $roleChefDepartement->services()->syncWithoutDetaching([$serviceDepartement->id]);
        $roleChefInfo->services()->syncWithoutDetaching([$serviceInformatique->id]);

        $this->command->info('Services, Rôles et associations créés avec succès!');
    }
}
