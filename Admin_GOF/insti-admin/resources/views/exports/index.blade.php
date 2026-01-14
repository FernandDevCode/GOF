{{-- resources/views/admin/exports/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Exports')
@section('page-title', 'Exports de données')
@section('page-description', 'Exportez les données au format PDF, Excel ou CSV')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Cartes d'export -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Export PDF -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-lg bg-red-100 text-red-600 mr-4">
                    <i class="fas fa-file-pdf text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">Export PDF</h3>
                    <p class="text-gray-600">Fiches formation détaillées</p>
                </div>
            </div>
            
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Sélectionner une filière</label>
                <select id="filiere-pdf-select" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Choisir une filière...</option>
                    @foreach($filieres as $filiere)
                    <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                    @endforeach
                </select>
            </div>
            
            <button id="export-pdf-btn" 
                    class="mt-4 w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled>
                <i class="fas fa-download mr-2"></i> Télécharger PDF
            </button>
        </div>
        
        <!-- Export Excel -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-file-excel text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">Export Excel</h3>
                    <p class="text-gray-600">Catalogue complet</p>
                </div>
            </div>
            
            <p class="text-gray-600 mb-4">Exportez l'ensemble du catalogue des formations au format Excel.</p>
            
            <a href="{{ route('admin.exports.catalogue.excel') }}" 
               class="mt-4 w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center justify-center">
                <i class="fas fa-download mr-2"></i> Télécharger Excel
            </a>
        </div>
        
        <!-- Export CSV -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-file-csv text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">Export CSV</h3>
                    <p class="text-gray-600">Statistiques et rapports</p>
                </div>
            </div>
            
            <p class="text-gray-600 mb-4">Exportez les statistiques globales au format CSV.</p>
            
            <a href="{{ route('admin.exports.stats.csv') }}" 
               class="mt-4 w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center justify-center">
                <i class="fas fa-download mr-2"></i> Télécharger CSV
            </a>
        </div>
    </div>
    
    <!-- Instructions -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Instructions</h3>
        <div class="space-y-3">
            <div class="flex items-start">
                <i class="fas fa-file-pdf text-red-500 mt-1 mr-3"></i>
                <div>
                    <p class="font-medium">PDF</p>
                    <p class="text-gray-600 text-sm">Générez des fiches formation professionnelles pour impression ou partage.</p>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-file-excel text-green-500 mt-1 mr-3"></i>
                <div>
                    <p class="font-medium">Excel</p>
                    <p class="text-gray-600 text-sm">Exportez toutes les données pour analyse ou archivage.</p>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-file-csv text-blue-500 mt-1 mr-3"></i>
                <div>
                    <p class="font-medium">CSV</p>
                    <p class="text-gray-600 text-sm">Format léger pour intégration dans d'autres systèmes.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('filiere-pdf-select');
        const btn = document.getElementById('export-pdf-btn');
        
        select.addEventListener('change', function() {
            btn.disabled = !this.value;
        });
        
        btn.addEventListener('click', function() {
            if (select.value) {
                window.location.href = "{{ route('admin.exports.filiere.pdf', '') }}/" + select.value;
            }
        });
    });
</script>
@endpush
@endsection