<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CategoryFormation;



class Filiere extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nom', 'description', 'niveau', 'duree', 'bac_requis', 'conditions',
        'couleur', 'statut', 'category_formation_id'
    ];

    protected $casts = [
        'statut' => 'boolean',
    ];

    /**
     * Relation vers la catégorie (nom de colonne conforme à la migration)
     */
    public function categoryFormation()
    {
        return $this->belongsTo(CategoryFormation::class, 'category_formation_id');
    }

    /**
     * Alias en français pour compatibilité avec les vues existantes
     */
    public function categorie()
    {
        return $this->categoryFormation();
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
