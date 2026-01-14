<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryFormation;
use Illuminate\Http\Request;


class CategoryFormationController extends Controller
{
    // app/Http\Controllers/Admin/CategoryFormationController.php

public function index(Request $request)
{
    $query = CategoryFormation::query();
    
    // Filtre par recherche
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nom', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }
    
    // Filtre par statut
    if ($request->has('statut') && in_array($request->statut, ['actif', 'inactif'])) {
        $query->where('active', $request->statut == 'actif');
    }
    
    // Tri
    $sortBy = $request->get('sort_by', 'created_at');
    $sortOrder = $request->get('sort_order', 'desc');
    $query->orderBy($sortBy, $sortOrder);
    
    $categories = $query->paginate(10)->withQueryString();
    
    return view('layouts.admin.categories.index', compact('categories'));
}

    public function create()
    {
        return view('layouts.admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'couleur' => 'nullable|string|max:7',
            'description' => 'nullable|string',
            'active' => 'boolean',
        ]);

        CategoryFormation::create($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryFormation $category)
    {
        return view('layouts.admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryFormation $category)
    {
        return view('layouts.admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryFormation $category)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'couleur' => 'nullable|string|max:7',
            'description' => 'nullable|string',
            'active' => 'boolean',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryFormation $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}
