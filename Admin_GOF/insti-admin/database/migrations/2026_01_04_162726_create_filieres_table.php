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
        Schema::create('filieres', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->enum('niveau', ['Licence', 'Master', 'Doctorat']);
            $table->integer('duree'); // en années
            $table->text('bac_requis');
            $table->text('conditions')->nullable();
            $table->string('couleur')->nullable();
            $table->boolean('statut')->default(true);
            $table->foreignId('category_formation_id')->constrained('category_formations')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filieres');
    }
};
