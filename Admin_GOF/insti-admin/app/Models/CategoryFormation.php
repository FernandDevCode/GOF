<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryFormation extends Model
{
    use HasFactory;

    protected $table = 'categories_formation';
    
    protected $fillable = ['nom', 'couleur', 'description', 'active'];
    
    public function filieres()
    {
        return $this->hasMany(Filiere::class, 'categorie_formation_id');
    }
}
