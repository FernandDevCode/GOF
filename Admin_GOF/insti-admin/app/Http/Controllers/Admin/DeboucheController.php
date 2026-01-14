<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Debouche;
use App\Models\Option;
use Illuminate\Http\Request;

class DeboucheController extends Controller
{
    /**
     * Affiche les débouchés d'une option
     * GET /admin/options/{option}/debouches
     */
    public function index(Option $option)
    {
        $debouches = $option->debouches()->orderBy('ordre')->get();
        
        return view('layouts.admin.debouches.index', compact('option', 'debouches'));
    }

    /**
     * Affiche tous les débouchés (Vue globale)
     */
    public function indexAll()
    {
        $debouches = Debouche::with('option.filiere')->get();
        return view('layouts.admin.debouches.index', ['option' => null, 'debouches' => $debouches]);
    }

    /**
     * Affiche le formulaire de création global
     */
    public function createGlobal()
    {
        $options = Option::with('filiere')->where('statut', true)->get();
        return view('layouts.admin.debouches.create', ['option' => null, 'options' => $options]);
    }

    /**
     * Affiche le formulaire de création d'un débouché
     * GET /admin/options/{option}/debouches/create
     */
    public function create(Option $option)
    {
        return view('layouts.admin.debouches.create', compact('option'));
    }

    /**
     * Enregistre un nouveau débouché
     * POST /admin/options/{option}/debouches
     */
    public function store(Request $request, Option $option = null)
    {
        $rules = [
            'titre' => 'required|max:255',
            'description' => 'nullable',
        ];

        if (!$option) {
            $rules['option_id'] = 'required|exists:options,id';
        }

        $validated = $request->validate($rules);

        if (!$option) {
            $option = Option::findOrFail($validated['option_id']);
        }

        $validated['option_id'] = $option->id;
        $validated['ordre'] = $option->debouches()->count() + 1;

        Debouche::create($validated);

        return redirect()->route('admin.options.debouches.index', $option)
            ->with('success', 'Débouché ajouté avec succès!');
    }

    /**
     * Affiche le formulaire d'édition
     * GET /admin/debouches/{debouche}/edit
     */
    public function edit(Debouche $debouche)
    {
        $debouche->load('option');
        
        return view('layouts.admin.debouches.edit', compact('debouche'));
    }

    /**
     * Met à jour un débouché
     * PUT/PATCH /admin/debouches/{debouche}
     */
    public function update(Request $request, Debouche $debouche)
    {
        $validated = $request->validate([
            'titre' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $debouche->update($validated);

        return redirect()->route('admin.options.debouches.index', $debouche->option)
            ->with('success', 'Débouché mis à jour avec succès!');
    }

    /**
     * Supprime un débouché
     * DELETE /admin/debouches/{debouche}
     */
    public function destroy(Debouche $debouche)
    {
        $option = $debouche->option;
        
        // Réorganise l'ordre des débouchés restants
        $debouche->delete();
        
        $remainingDebouches = Debouche::where('option_id', $option->id)
            ->orderBy('ordre')
            ->get();
        
        foreach ($remainingDebouches as $index => $item) {
            $item->update(['ordre' => $index + 1]);
        }

        return redirect()->route('admin.options.debouches.index', $option)
            ->with('success', 'Débouché supprimé avec succès!');
    }

    /**
     * Réorganiser l'ordre des débouchés via AJAX
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:debouches_formation,id'
        ]);

        foreach ($request->order as $index => $id) {
            Debouche::where('id', $id)->update(['ordre' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Ordre mis à jour avec succès'
        ]);
    }
}