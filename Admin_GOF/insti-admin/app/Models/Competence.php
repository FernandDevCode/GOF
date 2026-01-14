<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Option;

class Competence extends Model
{
    use SoftDeletes;

    // Table name differs from Laravel's pluralization (migration uses 'competences_formation')
    protected $table = 'competences_formation';

    protected $fillable = ['description', 'option_id', 'ordre', 'type'];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
