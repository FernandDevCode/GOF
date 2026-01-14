<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OptionController extends Controller
{
    /**
     * Affiche les options d'une filière spécifique
     * GET /admin/filieres/{filiere}/options
     */
    public function index(Filiere $filiere)
    {
        $options = $filiere->options()->withCount(['competences', 'debouches'])->get();
        
        return view('layouts.admin.options.index', compact('filiere', 'options'));
    }

    /**
     * Affiche toutes les options (Vue globale pour la sidebar)
     * GET /admin/options
     */
    public function indexAll()
    {
        $options = Option::with('filiere')->withCount(['competences', 'debouches'])->get();
        // On passe 'filiere' à null pour indiquer à la vue qu'on est en mode liste globale
        return view('layouts.admin.options.index', ['filiere' => null, 'options' => $options]);
    }

    /**
     * Affiche le formulaire de création d'une option (Mode global)
     * GET /admin/options/create
     */
    public function createGlobal()
    {
        $filieres = Filiere::where('statut', true)->get();
        return view('layouts.admin.options.create', ['filiere' => null, 'filieres' => $filieres]);
    }

    /**
     * Affiche le formulaire de création d'une option
     * GET /admin/filieres/{filiere}/options/create
     */
    public function create(Filiere $filiere)
    {
        return view('layouts.admin.options.create', compact('filiere'));
    }

    /**
     * Enregistre une nouvelle option
     * POST /admin/options
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|max:255',
            'description' => 'nullable',
            'filiere_id' => 'required|exists:filieres,id',
            'brochure' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $validated['statut'] = $request->has('statut');

        if ($request->hasFile('brochure')) {
            $path = $request->file('brochure')->store('brochures', 'public');
            $validated['brochure'] = $path;
        }

        Option::create($validated);

        return redirect()->route('admin.filieres.options.index', $validated['filiere_id'])
            ->with('success', 'Option créée avec succès!');
    }

    /**
     * Affiche les détails d'une option
     * GET /admin/options/{option}
     */
    public function show(Option $option)
    {
        $option->load(['filiere', 'competences', 'debouches']);
        
        return view('layouts.admin.options.show', compact('option'));
    }

    /**
     * Affiche le formulaire d'édition d'une option
     * GET /admin/options/{option}/edit
     */
    public function edit(Option $option)
    {
        $option->load('filiere');
        
        return view('layouts.admin.options.edit', compact('option'));
    }

    /**
     * Met à jour une option existante
     * PUT/PATCH /admin/options/{option}
     */
    public function update(Request $request, Option $option)
    {
        $validated = $request->validate([
            'nom' => 'required|max:255',
            'description' => 'nullable',
            'brochure' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $validated['statut'] = $request->has('statut');

        if ($request->hasFile('brochure')) {
            // Delete old brochure if it exists
            if ($option->brochure) {
                Storage::disk('public')->delete($option->brochure);
            }
            $path = $request->file('brochure')->store('brochures', 'public');
            $validated['brochure'] = $path;
        }

        $option->update($validated);

        return redirect()->route('admin.filieres.options.index', $option->filiere)
            ->with('success', 'Option mise à jour avec succès!');
    }

    /**
     * Supprime une option
     * DELETE /admin/options/{option}
     */
    public function destroy(Option $option)
    {
        // Supprimer la brochure si elle existe
        if ($option->brochure) {
            Storage::disk('public')->delete($option->brochure);
        }

        $filiereId = $option->filiere_id;
        $option->delete();

        return redirect()->route('admin.filieres.options.index', $filiereId)
            ->with('success', 'Option supprimée avec succès!');
    }
}