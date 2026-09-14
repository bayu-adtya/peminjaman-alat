<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        //cek apakah user sudah login dan apakah rolenya ada didalam parameter yang diizinkan
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            return $next($request);
        }
        return $next($request);
    }
}
