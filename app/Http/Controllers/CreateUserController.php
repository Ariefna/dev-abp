<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AksesGroup;
use Illuminate\Support\Facades\DB; // Ubah ini
use Illuminate\Http\Request;

class CreateUserController extends Controller
{
    public function index()
    {
        $aksesgroup = AksesGroup::orderBy('akses_group_id', 'desc')
        ->get();
        $users = User::select('users.*', 'akses_group.nama as nama_role')
            ->leftjoin('akses_group', 'users.role', '=', 'akses_group.akses_group_id')->orderBy('id', 'desc')->get();
    
            
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.user', compact('title', 'breadcrumb', 'users', 'aksesgroup'));
    }

    public function store(Request $request)
    {
        // Buat pengguna baru
        $user = new User([
            'name' => $request->input('nama'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
        ]);

        $user->save();

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        // Temukan pengguna yang ingin diubah
        $user = User::findOrFail($id);

        // Update data pengguna
        $user->name = $request->input('edit_nama');
        $user->email = $request->input('edit_email');

        // Jika ada perubahan pada password, maka update password
        if ($request->has('edit_password')) {
            $user->password = bcrypt($request->input('edit_password'));
        }

        $user->role = $request->input('edit_role');

        $user->save();
        return redirect()->back();
    }

    public function destroy($id)
    {
        // Temukan pengguna yang ingin dihapus
        $user = User::findOrFail($id);

        // Hapus pengguna
        $user->delete();

        // return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');

        return redirect()->back();
    }
}
