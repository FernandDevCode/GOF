<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class CheckPermission
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param string $permission
     * @return Response
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        // Use the Gate facade which checks the current authenticated user's abilities
        if (Auth::check() && Gate::allows($permission)) {
            return $next($request);
        }
        
        abort(403, 'Accès non autorisé.');
    }
}