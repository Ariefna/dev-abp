<?php

namespace App\Http\Controllers;

use App\Models\ActionMenu;
use App\Models\User;
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
            $user = User::select('users.*', 'akses_group.nama as nama_role')
            ->leftjoin('akses_group', 'users.role', '=', 'akses_group.akses_group_id')
            ->where('users.id', Auth::user()->id)->first();
            $menus = DB::table('menu_halaman')
                ->join('akses_user_menu', 'menu_halaman.id', '=', 'akses_user_menu.menu_halaman_id')
                ->where('akses_user_menu.akses_group_id', $user->role)
                ->pluck('nama_menu_halaman')
                ->toArray();
            // Simpan hasil query dalam session
            Session::put('admin_menus', $menus);

           
          
            Session::put('id',$user->id);
            Session::put('nama', $user->name);
            $nama_action = "";
            if ($user->role == '0') {
                $nama_action = DB::table('action_menu as am')
                ->join('menu_halaman as mh', 'am.menu_halaman_id', '=', 'mh.id')
                ->join('akses_user_detail', 'am.id', '=', 'akses_user_detail.action_menu_id')
                ->select(DB::raw('CONCAT(mh.nama_menu_halaman, "-", am.nama_action) as nama_action'))
                ->pluck('nama_action')
                ->toArray();
                Session::put('role', 'superadmin');
            } else {
                $nama_action = DB::table('action_menu as am')
                ->join('menu_halaman as mh', 'am.menu_halaman_id', '=', 'mh.id')
                ->join('akses_user_detail', 'am.id', '=', 'akses_user_detail.action_menu_id')
                ->where('akses_user_detail.akses_group_id', $user->role)
                ->select(DB::raw('CONCAT(mh.nama_menu_halaman, "-", am.nama_action) as nama_action'))
                ->pluck('nama_action')
                ->toArray();
                Session::put('role', $user->nama_role);
            }
            Session::put('nama_action', $nama_action);

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
