<?php
// app/Http/Controllers/Admin/ExportController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Services\ExportService;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    protected $exportService;
    
    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }
    
    /**
     * Export PDF d'une filière
     */
    public function exportFilierePDF(Filiere $filiere)
    {
        return $this->exportService->exportFilierePDF($filiere);
    }
    
    /**
     * Export Excel du catalogue
     */
    public function exportCatalogueExcel()
    {
        return $this->exportService->exportCatalogueExcel();
    }
    
    /**
     * Export CSV des statistiques
     */
    public function exportStatsCSV()
    {
        return $this->exportService->exportStatsCSV();
    }
    
    /**
     * Page d'export
     */
    public function index()
    {
        $filieres = Filiere::all();
        return view('admin.exports.index', compact('filieres'));
    }
}
