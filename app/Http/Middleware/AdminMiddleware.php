<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->is_admin()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        return $next($request);
    }
}
