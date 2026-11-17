<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'login_attempts',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
            'login_attempts'    => 'integer',
        ];
    }

    // =========================================================================
    // RELACIONES PARA DIRECTORIO Y GESTIÓN COMERCIAL
    // =========================================================================

    public function clientes(): HasMany
    {
        return $this->hasMany(Cliente::class, 'user_id');
    }

    public function obras(): HasMany
    {
        return $this->hasMany(Obra::class, 'user_id');
    }

    public function bitacoras(): HasMany
    {
        return $this->hasMany(Bitacora::class, 'user_id');
    }

    public function cotizaciones(): HasMany
    {
        return $this->hasMany(Cotizacion::class, 'user_id');
    }

    public function inspecciones(): HasMany
    {
        return $this->hasMany(Inspeccion::class, 'user_id');
    }

    // Helper de roles
    public function esAdmin(): bool
    {
        return $this->role === 'administrador';
    }

    public function esDirectivo(): bool
    {
        return $this->role === 'directivo';
    }

    public function esEjecutivo(): bool
    {
        return $this->role === 'ejecutivo';
    }
}