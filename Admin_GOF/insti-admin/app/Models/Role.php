<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'can_upload_brochure'];
    
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
    
    /**
     * Vérifier si le rôle a certaines permissions
     */
    public function hasPermission($permission)
    {
        $permissions = $this->getPermissions();
        return in_array($permission, $permissions);
    }
    
    /**
     * Récupérer les permissions du rôle
     */
    private function getPermissions()
    {
        $rolePermissions = [
            'Super Admin' => ['*'],
            'Administrateur' => [
                'view_dashboard',
                'manage_categories',
                'manage_filieres',
                'manage_users',
                'manage_settings',
                'export_data',
            ],
            'Éditeur' => [
                'view_dashboard',
                'manage_categories',
                'manage_filieres',
            ],
            'Consultant' => [
                'view_dashboard',
            ],
        ];
        
        return $rolePermissions[$this->name] ?? [];
    }

    public function hasService($serviceName)
    {
        return $this->services()->where('nom_service', $serviceName)->exists();
    }

    /**
     * Retourne vrai si le rôle permet d'uploader une brochure
     */
    public function canUploadBrochure()
    {
        if ($this->name === 'Super Admin') {
            return true;
        }

        return (bool) ($this->can_upload_brochure ?? false);
    }
}