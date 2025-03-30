<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level === 'admin') {
            return $next($request);
        }
        return redirect('/login')->with('error', 'Akses ditolak!');
    }
}
