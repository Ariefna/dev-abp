<?php

namespace App\Http\Controllers;

use App\Models\ActionMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index()
    {
        $menuuser = ActionMenu::where('status', 1)
            ->orderBy('id', 'desc')
            ->get();
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.menuuser', compact('title', 'breadcrumb', 'menuuser'));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Jika autentikasi berhasil
            $user = Auth::user();
            $menus = DB::table('menu_halaman')
                ->where('isadmin', 1)
                ->pluck('nama_menu_halaman')
                ->toArray();
            // Simpan hasil query dalam session
            Session::put('admin_menus', $menus);

            $nama_action = DB::table('action_menu as am')
                ->join('menu_halaman as mh', 'am.menu_halaman_id', '=', 'mh.id')
                ->select(DB::raw('CONCAT(mh.nama_menu_halaman, "-", am.nama_action) as nama_action'))
                ->where('am.isadmin', '1')
                ->pluck('nama_action')
                ->toArray();
            Session::put('nama_action', $nama_action);
            Session::put('id',$user->id);
            Session::put('nama', $user->name);
            if ($user->role == '0') {
                Session::put('role', 'admin');
            } else {
                Session::put('role', 'superadmin');
            }

            return redirect()->intended('/horizontal-dark-menu/dashboard/analytics'); // Redirect ke halaman home
        }
        session()->flash('error', 'Email atau password salah.');
        // Jika autentikasi gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    // Proses logout
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/horizontal-dark-menu/login');
    }
}
