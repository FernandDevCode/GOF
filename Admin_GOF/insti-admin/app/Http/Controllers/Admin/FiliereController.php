<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Models\CategoryFormation;
use App\Models\Option;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    /**
     * Affiche la liste des filières avec pagination
     * GET /admin/filieres
     */
    // app/Http\Controllers/Admin\FiliereController.php

public function index(Request $request)
{
    $query = Filiere::with('categorie');
    
    // Filtre par recherche
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nom', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('bac_requis', 'like', "%{$search}%")
              ->orWhereHas('categorie', function($q) use ($search) {
                  $q->where('nom', 'like', "%{$search}%");
              });
        });
    }
    
    // Filtre par catégorie
    if ($request->has('categorie_id') && $request->categorie_id != '') {
        $query->where('category_formation_id', $request->categorie_id);
    }
    
    // Filtre par niveau
    if ($request->has('niveau') && in_array($request->niveau, ['Licence', 'Master', 'Doctorat'])) {
        $query->where('niveau', $request->niveau);
    }
    
    // Filtre par statut
    if ($request->has('statut') && in_array($request->statut, ['actif', 'inactif'])) {
        $query->where('statut', $request->statut == 'actif');
    }
    
    // Filtre par durée
    if ($request->has('duree_min') && is_numeric($request->duree_min)) {
        $query->where('duree', '>=', $request->duree_min);
    }
    if ($request->has('duree_max') && is_numeric($request->duree_max)) {
        $query->where('duree', '<=', $request->duree_max);
    }
    
    // Tri
    $sortBy = $request->get('sort_by', 'created_at');
    $sortOrder = $request->get('sort_order', 'desc');
    $query->orderBy($sortBy, $sortOrder);
    
    $filieres = $query->paginate(10)->withQueryString();
    $categories = CategoryFormation::all();
    
    return view('layouts.admin.filieres.index', compact('filieres', 'categories'));
}

    /**
     * Affiche le formulaire de création d'une filière
     * GET /admin/filieres/create
     */
    public function create()
    {
        // Récupère les catégories actives pour le select
        $categories = CategoryFormation::where('active', true)->get();
        
        // Définit les niveaux disponibles
        $niveaux = ['Licence', 'Master', 'Doctorat'];
        
        return view('layouts.admin.filieres.create', compact('categories', 'niveaux'));
    }

    /**
     * Enregistre une nouvelle filière dans la base de données
     * POST /admin/filieres
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'nom' => 'required|max:255',
            'description' => 'required|min:20',
            'niveau' => 'required|in:Licence,Master,Doctorat',
            'duree' => 'required|integer|min:1|max:5',
            'bac_requis' => 'required',
            'conditions' => 'nullable',
            'category_formation_id' => 'required|exists:categories_formation,id',
            'couleur' => 'nullable|regex:/^#[0-9A-F]{6}$/i',
        ]);

        // Ajout du statut (checkbox)
        $validated['statut'] = $request->has('statut');

        // Création de la filière
        $filiere = Filiere::create($validated);

        return redirect()->route('admin.filieres.index')
            ->with('success', 'Filière créée avec succès!');
    }

    /**
     * Affiche les détails d'une filière spécifique
     * GET /admin/filieres/{filiere}
     */
    public function show(Filiere $filiere)
    {
        // Charge les relations pour éviter les requêtes N+1
        $filiere->load(['categorie', 'options.competences', 'options.debouches']);
        
        return view('layouts.admin.filieres.show', compact('filiere'));
    }

    /**
     * Affiche le formulaire d'édition d'une filière
     * GET /admin/filieres/{filiere}/edit
     */
    public function edit(Filiere $filiere)
    {
        $categories = CategoryFormation::where('active', true)->get();
        $niveaux = ['Licence', 'Master', 'Doctorat'];
        
        return view('layouts.admin.filieres.edit', compact('filiere', 'categories', 'niveaux'));
    }

    /**
     * Met à jour une filière existante
     * PUT/PATCH /admin/filieres/{filiere}
     */
    public function update(Request $request, Filiere $filiere)
    {
        // Validation (même que pour store)
        $validated = $request->validate([
            'nom' => 'required|max:255',
            'description' => 'required|min:20',
            'niveau' => 'required|in:Licence,Master,Doctorat',
            'duree' => 'required|integer|min:1|max:5',
            'bac_requis' => 'required',
            'conditions' => 'nullable',
            'category_formation_id' => 'required|exists:categories_formation,id',
            'couleur' => 'nullable|regex:/^#[0-9A-F]{6}$/i',
        ]);

        $validated['statut'] = $request->has('statut');

        // Mise à jour
        $filiere->update($validated);

        return redirect()->route('admin.filieres.index')
            ->with('success', 'Filière mise à jour avec succès!');
    }

    /**
     * Supprime une filière
     * DELETE /admin/filieres/{filiere}
     */
    public function destroy(Filiere $filiere)
    {
        // La suppression en cascade est gérée par la base de données
        $filiere->delete();

        return redirect()->route('admin.filieres.index')
            ->with('success', 'Filière supprimée avec succès!');
    }

    /**
     * Duplique une filière existante
     * POST /admin/filieres/{filiere}/duplicate
     */
    public function duplicate(Filiere $filiere)
    {
        // Duplique la filière
        $nouvelleFiliere = $filiere->replicate();
        $nouvelleFiliere->nom = $filiere->nom . ' (Copie)';
        $nouvelleFiliere->statut = false;
        $nouvelleFiliere->save();

        // Duplique les options
        foreach ($filiere->options as $option) {
            $nouvelleOption = $option->replicate();
            $nouvelleOption->filiere_id = $nouvelleFiliere->id;
            $nouvelleOption->save();

            // Duplique les compétences
            foreach ($option->competences as $competence) {
                $nouvelleCompetence = $competence->replicate();
                $nouvelleCompetence->option_id = $nouvelleOption->id;
                $nouvelleCompetence->save();
            }

            // Duplique les débouchés
            foreach ($option->debouches as $debouche) {
                $nouveauDebouche = $debouche->replicate();
                $nouveauDebouche->option_id = $nouvelleOption->id;
                $nouveauDebouche->save();
            }
        }

        return redirect()->route('admin.filieres.edit', $nouvelleFiliere)
            ->with('success', 'Filière dupliquée avec succès!');
    }

    /**
     * Change le statut (actif/inactif) d'une filière
     * PATCH /admin/filieres/{filiere}/toggle-status
     */
    public function toggleStatus(Filiere $filiere)
    {
        $filiere->statut = !$filiere->statut;
        $filiere->save();

        $status = $filiere->statut ? 'activée' : 'désactivée';
        
        return redirect()->back()
            ->with('success', "Filière $status avec succès!");
    }
}