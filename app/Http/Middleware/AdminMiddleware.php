<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Règles :
     *  1. Non connecté        → redirige vers /login
     *  2. Connecté, pas admin → redirige vers l'accueil avec message d'erreur
     *  3. Admin confirmé      → accès accordé
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Pas connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Connecté mais pas admin
        if (Auth::user()->role !== 'admin') {
            return redirect()
                ->route('rooms.index')
                ->with('error', 'Accès refusé. Cette zone est réservée aux administrateurs.');
        }

        // 3. Admin confirmé → on laisse passer
        return $next($request);
    }
}