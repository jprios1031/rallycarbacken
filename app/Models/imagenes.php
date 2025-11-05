<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Novedad;

class Imagenes extends Model
{
    protected $fillable = ['ruta', 'novedad_id'];

    public function novedad()
    {
        return $this->belongsTo(Novedad::class);
    }
}
