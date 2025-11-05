<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'placa',
        'vehiculo_id',
        'role_id',
    ];

    /**
     * Atributos ocultos para serialización.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts de atributos.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Comprobar si el usuario es admin.
     */
    // public function isAdmin()
    // {
    //     return $this->role && $this->role->nombre === 'admin';
    // }

    /**
     * Comprobar si el usuario es cliente.
     */
    // public function isCliente()
    // {
    //     return $this->role && $this->role->nombre === 'cliente';
    // }

    /**
     * Relación con Role.
     */
    // public function role()
    // {
    //     return $this->belongsTo(Role::class, 'role_id');
    // }

    /**
     * Relación con Vehículo (un usuario puede tener un vehículo).
     */
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }

    /**
     * Relación con Novedades (un usuario puede tener muchas novedades).
     */
    public function novedades()
    {
        return $this->hasMany(Novedad::class);
    }
}
