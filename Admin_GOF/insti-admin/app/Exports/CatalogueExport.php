<?php

namespace App\Exports;

use App\Models\Filiere;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class CatalogueExport implements FromCollection, WithHeadings
{
    /**
     * Retourne une collection de lignes pour l'export
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $rows = collect();

        $filieres = Filiere::with('categorie')->get();

        foreach ($filieres as $f) {
            $rows->push([
                'categorie' => $f->categorie->nom ?? 'Sans catégorie',
                'filiere'   => $f->nom,
                'niveau'    => $f->niveau,
                'statut'    => $f->statut ? 'Active' : 'Inactive',
                'duree'     => $f->duree,
            ]);
        }

        return $rows;
    }

    /**
     * En-têtes du fichier Excel
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Catégorie',
            'Filière',
            'Niveau',
            'Statut',
            'Durée',
        ];
    }
}
