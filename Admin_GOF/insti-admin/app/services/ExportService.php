<?php 
// app/Services/ExportService.php

namespace App\Services;

use App\Models\Filiere;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CatalogueExport;
use App\Models\CategoryFormation;


class ExportService
{
    /**
     * Export PDF d'une filière
     */
    public function exportFilierePDF(Filiere $filiere)
    {
        $filiere->load(['categorie', 'options.competences', 'options.debouches']);
        
        $pdf = PDF::loadView('exports.filiere-pdf', compact('filiere'));
        
        return $pdf->stream("filiere-{$filiere->id}.pdf");
    }
    
    /**
     * Export Excel du catalogue
     */
    public function exportCatalogueExcel()
    {
        return Excel::download(new CatalogueExport(), 'catalogue-formations.xlsx');
    }
    
    /**
     * Export CSV des statistiques
     */
    public function exportStatsCSV()
    {
        $stats = [
            ['Type', 'Nombre'],
            ['Catégories', CategoryFormation::count()],
            ['Filières totales', Filiere::count()],
            ['Filières actives', Filiere::where('statut', true)->count()],
            ['Filières inactives', Filiere::where('statut', false)->count()],
        ];
        
        $filename = 'statistiques-' . date('Y-m-d') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        foreach ($stats as $row) {
            fputcsv($output, $row);
        }
        
        fclose($output);
        exit;
    }
}