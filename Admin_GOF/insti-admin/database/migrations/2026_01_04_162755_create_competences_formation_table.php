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
        Schema::create('competences_formation', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->foreignId('option_id')->constrained('options')->onDelete('cascade');
            $table->integer('ordre')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competences_formation');
    }
};
