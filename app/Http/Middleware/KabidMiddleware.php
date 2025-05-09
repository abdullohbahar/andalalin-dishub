<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KabidMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        if (Auth::check() && Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } else if (Auth::check() && Auth::user()->role == 'pemohon' || Auth::user()->role == 'pemrakarsa') {
            return redirect()->route('pemohon.dashboard');
        } else if (Auth::check() && Auth::user()->role == 'konsultan') {
            return redirect()->route('konsultan.dashboard');
        } else if (Auth::check() && Auth::user()->role == 'penilai' || Auth::user()->role == 'penilai1' || Auth::user()->role == 'penilai2' || Auth::user()->role == 'penilai3') {
            return redirect()->route('penilai.dashboard');
        } else if (Auth::check() && Auth::user()->role == 'kasi') {
            return redirect()->route('kasi.dashboard');
        } else if (Auth::check() && Auth::user()->role == 'kabid') {
            return $next($request);
        } else if (Auth::check() && Auth::user()->role == 'kadis') {
            return redirect()->route('kadis.dashboard');
        }

        return redirect('/');
    }
}
