<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('competences_formation', function (Blueprint $table) {
            if (!Schema::hasColumn('competences_formation', 'type')) {
                $table->enum('type', ['technique', 'manageriale', 'scientifique'])
                      ->default('technique')
                      ->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('competences_formation', function (Blueprint $table) {
            if (Schema::hasColumn('competences_formation', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
};
