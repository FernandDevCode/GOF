<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Option;

class Debouche extends Model
{
    use SoftDeletes;

    protected $table = 'debouches_formation';

    protected $fillable = ['titre', 'description', 'option_id', 'ordre'];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
