<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class CheckNamaSession
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
        if (Session::has('nama')) {
            // Session 'nama' telah diatur, lanjutkan permintaan
            return $next($request);
        }

        // Jika session 'nama' tidak ada, Anda bisa mengarahkan pengguna ke halaman tertentu atau memberikan respons sesuai kebijakan Anda.
        // Contoh: Mengarahkan pengguna ke halaman login dengan pesan flash
        Session::flash('error', 'Anda harus masuk terlebih dahulu.');
        return redirect()->route('login');
    }
}
