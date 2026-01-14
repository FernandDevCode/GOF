<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryFormationController;
use App\Http\Controllers\Admin\FiliereController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\CompetenceController;
use App\Http\Controllers\Admin\DeboucheController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

Route::get('/', function () {
    return view('welcome');
});

// Routes Breeze (authentification)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ============================================
// ROUTES ADMINISTRATION INSTI
// ============================================

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Catégories
    Route::resource('/categories', CategoryFormationController::class);
    
    // Filieres
    Route::resource('/filieres', FiliereController::class);
    
    // Fonctionnalités avancées filières
    Route::post('/filieres/{filiere}/duplicate', [FiliereController::class, 'duplicate'])
         ->name('filieres.duplicate');
    Route::patch('/filieres/{filiere}/toggle-status', [FiliereController::class, 'toggleStatus'])
         ->name('filieres.toggle-status');
    
    // Route globale pour afficher toutes les options
    Route::get('/options', [OptionController::class, 'indexAll'])->name('options.index');
    // Route globale pour créer une option
    Route::get('/options/create', [OptionController::class, 'createGlobal'])->name('options.create');
    
    // Options
    Route::resource('options', OptionController::class)->except(['index', 'create']);
    
    // Compétences
    Route::get('/competences', [CompetenceController::class, 'indexAll'])->name('competences.index');
    Route::get('/competences/create', [CompetenceController::class, 'createGlobal'])->name('competences.create');
    Route::post('/competences/reorder', [CompetenceController::class, 'reorder'])->name('competences.reorder');
    Route::resource('competences', CompetenceController::class)->except(['index', 'create']);
    
    // Débouchés
    Route::get('/debouches', [DeboucheController::class, 'indexAll'])->name('debouches.index');
    Route::get('/debouches/create', [DeboucheController::class, 'createGlobal'])->name('debouches.create');
    Route::post('/debouches/reorder', [DeboucheController::class, 'reorder'])->name('debouches.reorder');
    // Force parameter name to 'debouche' (singular) to match controller/view variables
    Route::resource('debouches', DeboucheController::class)
         ->parameters(['debouches' => 'debouche'])
         ->except(['index', 'create']);
    
    // Routes imbriquées
    Route::get('/filieres/{filiere}/options', [OptionController::class, 'index'])
         ->name('filieres.options.index');
    Route::get('/filieres/{filiere}/options/create', [OptionController::class, 'create'])
         ->name('filieres.options.create');
    
    Route::get('/options/{option}/competences', [CompetenceController::class, 'index'])
         ->name('options.competences.index');
    Route::get('/options/{option}/competences/create', [CompetenceController::class, 'create'])
         ->name('options.competences.create');
    
    Route::get('/options/{option}/debouches', [DeboucheController::class, 'index'])
         ->name('options.debouches.index');
    Route::get('/options/{option}/debouches/create', [DeboucheController::class, 'create'])
         ->name('options.debouches.create');


         // Utilisateurs
    Route::resource('/users', UserController::class);
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
        ->name('users.toggle-status');
    
    // Paramètres
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    
    // Profil
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
});

// Redirection pour éviter la confusion avec le dashboard Breeze
Route::middleware(['auth'])->get('/dashboard', function () {
     return redirect()->route('admin.dashboard');
})->name('dashboard');


// Routes d'export
Route::prefix('exports')->name('exports.')->group(function () {
    Route::get('/', [ExportController::class, 'index'])->name('index');
    Route::get('/filiere/{filiere}/pdf', [ExportController::class, 'exportFilierePDF'])->name('filiere.pdf');
    Route::get('/catalogue/excel', [ExportController::class, 'exportCatalogueExcel'])->name('catalogue.excel');
    Route::get('/stats/csv', [ExportController::class, 'exportStatsCSV'])->name('stats.csv');
});

