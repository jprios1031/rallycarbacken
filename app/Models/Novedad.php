<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Imagenes;
use App\Models\Vehiculo;

class Novedad extends Model
{
    protected $table = 'novedades';

    protected $fillable = [
        'titulo',
        'descripcion',
        'vehiculo_id',
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    public function imagenes()
    {
        return $this->hasMany(Imagenes::class);
    }
}
