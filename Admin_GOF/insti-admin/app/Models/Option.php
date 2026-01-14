<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Filiere;
use App\Models\Competence;
use App\Models\Debouche;

class Option extends Model
{
    use SoftDeletes;

    protected $fillable = ['nom', 'description', 'statut', 'filiere_id', 'brochure'];

    protected $casts = [
        'statut' => 'boolean',
    ];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function competences()
    {
        return $this->hasMany(Competence::class);
    }

    public function debouches()
    {
        return $this->hasMany(Debouche::class);
    }
}
