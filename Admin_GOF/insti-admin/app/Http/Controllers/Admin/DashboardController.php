<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryFormation;
use App\Models\Filiere;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord admin
     * GET /admin/dashboard
     */
    public function index()
    {
        // 1. Récupère les statistiques depuis la base de données
        $stats = [
            'categories' => CategoryFormation::count(), // Nombre total de catégories
            'filieres' => Filiere::count(), // Nombre total de filières
            'filieres_actives' => Filiere::where('statut', true)->count(), // Filières actives seulement
        ];
        
        // 2. Retourne la vue avec les données
        return view('layouts.admin.dashboard', compact('stats'));
        // 'compact()' transforme la variable $stats en ['stats' => $stats]
        // La vue pourra utiliser $stats
    }
}
