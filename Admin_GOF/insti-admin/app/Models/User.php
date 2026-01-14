<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'service_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
    
    /**
     * Vérifier si l'utilisateur a une permission
     */
    public function hasPermission($permission): bool
    {
        // Vérifier que le rôle existe
        if (!$this->role) {
            return false;
        }

        // Super Admin a toutes les permissions
        if ($this->role->name === 'Super Admin') {
            return true;
        }
        
        return $this->role->hasPermission($permission);
    }
    
    /**
     * Vérifier si l'utilisateur est admin
     */
    public function isAdmin(): bool
    {
        if (!$this->role) {
            return false;
        }

        return in_array($this->role->name, ['Super Admin', 'Administrateur']);
    }

    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }

    public function hasService($serviceName)
    {
        if (!$this->role) {
            return false;
        }
        return $this->role->hasService($serviceName);
    }
}