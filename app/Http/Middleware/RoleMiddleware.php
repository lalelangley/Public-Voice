<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Cek apakah role_id user sesuai dengan yang diharapkan
        if (Auth::user()->role_id !== (int) $role) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
