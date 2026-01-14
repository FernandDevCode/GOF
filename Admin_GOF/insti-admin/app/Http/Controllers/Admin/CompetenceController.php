<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use App\Models\Option;
use Illuminate\Http\Request;

class CompetenceController extends Controller
{
    /**
     * Affiche les compétences d'une option
     * GET /admin/options/{option}/competences
     */
    public function index(Option $option)
    {
        $competences = $option->competences()->orderBy('ordre')->get();
        
        return view('layouts.admin.competences.index', compact('option', 'competences'));
    }

    /**
     * Affiche toutes les compétences (Vue globale)
     */
    public function indexAll()
    {
        $competences = Competence::with('option.filiere')->get();
        return view('layouts.admin.competences.index', ['option' => null, 'competences' => $competences]);
    }

    /**
     * Affiche le formulaire de création global
     */
    public function createGlobal()
    {
        $options = Option::with('filiere')->where('statut', true)->get();
        return view('layouts.admin.competences.create', ['option' => null, 'options' => $options]);
    }

    /**
     * Affiche le formulaire de création d'une compétence
     * GET /admin/options/{option}/competences/create
     */
    public function create(Option $option)
    {
        return view('layouts.admin.competences.create', compact('option'));
    }

    /**
     * Enregistre une nouvelle compétence
     * POST /admin/options/{option}/competences
     */
    public function store(Request $request, Option $option = null)
    {
        $rules = ['description' => 'required|max:500',
                  'type' => 'required|in:technique,manageriale,scientifique'];
        
        // Si l'option n'est pas passée dans l'URL, elle doit être dans le formulaire
        if (!$option) {
            $rules['option_id'] = 'required|exists:options,id';
        }

        $validated = $request->validate($rules);

        if (!$option) {
            $option = Option::findOrFail($validated['option_id']);
        }

        // Détermine l'ordre (dernière position)
        $validated['option_id'] = $option->id;
        $validated['ordre'] = $option->competences()->count() + 1;

        Competence::create($validated);

        return redirect()->route('admin.options.competences.index', $option)
            ->with('success', 'Compétence ajoutée avec succès!');
    }

    /**
     * Affiche le formulaire d'édition
     * GET /admin/competences/{competence}/edit
     */
    public function edit(Competence $competence)
    {
        $competence->load('option');
        
        return view('layouts.admin.competences.edit', compact('competence'));
    }

    /**
     * Met à jour une compétence
     * PUT/PATCH /admin/competences/{competence}
     */
    public function update(Request $request, Competence $competence)
    {

        $validated = $request->validate([
            'description' => 'required|max:500',
            'type' => 'required|in:technique,manageriale,scientifique',
        ]);

        $competence->update($validated);

        return redirect()->route('admin.options.competences.index', $competence->option)
            ->with('success', 'Compétence mise à jour avec succès!');
    }

    /**
     * Supprime une compétence
     * DELETE /admin/competences/{competence}
     */
    public function destroy(Competence $competence)
    {
        $option = $competence->option;
        
        // Réorganise l'ordre des compétences restantes
        $competence->delete();
        
        $remainingCompetences = Competence::where('option_id', $option->id)
            ->orderBy('ordre')
            ->get();
        
        foreach ($remainingCompetences as $index => $item) {
            $item->update(['ordre' => $index + 1]);
        }

        return redirect()->route('admin.options.competences.index', $option)
            ->with('success', 'Compétence supprimée avec succès!');
    }


    // app/Http/Controllers/Admin/CompetenceController.php

    /**
     * Réorganiser l'ordre des compétences via AJAX
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:competences_formation,id'
        ]);

        foreach ($request->order as $index => $id) {
            Competence::where('id', $id)->update(['ordre' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Ordre mis à jour avec succès'
        ]);
    }


}