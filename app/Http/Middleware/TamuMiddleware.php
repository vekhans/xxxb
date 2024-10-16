<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class TamuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->kategori == 'Tamu') {
            return $next($request);
        }
        elseif (Auth::check() && Auth::user()->kategori == 'Pimpinan') {
            return redirect()->route('rasapimpinan');
        } 
        elseif (Auth::check() && Auth::user()->kategori == 'Admin') {
            return redirect()->route('rasaadmin');
        }          
        else {
            return redirect()->route('login');
        }
    }
}
