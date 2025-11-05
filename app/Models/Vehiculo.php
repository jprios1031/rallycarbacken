<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Novedad;
use App\Models\user;

class Vehiculo extends Model
{
    protected $fillable = ['placa', 'marca', 'modelo','user_id'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function novedades()
    {
        return $this->hasMany(Novedad::class);
    }
}
