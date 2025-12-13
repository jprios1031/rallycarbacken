<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'name', // nombre del rol, ej. 'admin' o 'cliente'
        'type', // opcional, si quieres clasificar roles
    ];

    /**
     * Un rol tiene muchos usuarios.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id'); // 'role_id' es la FK en users
    }
}
