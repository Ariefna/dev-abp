<?php

namespace App\Http\Controllers;

use App\Models\ActionMenu;
use App\Models\MenuHalaman;
use App\Models\AksesGroup;
use App\Models\AksesUserMenu;
use App\Models\AksesUserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuUserController extends Controller
{
    public function index()
    {
        $role = request('role') != '' ? request('role') : '0'; // Read the 'id' query parameter from the URL
        if ($role !== null && $role !== '0') {
            // Filter by user ID if provided
            $menuuser = MenuHalaman::where('status', '1')
                ->orderBy('id', 'desc')
                ->join('akses_user_menu', 'menu_halaman.id', '=', 'akses_user_menu.menu_halaman_id')
                ->where('akses_user_menu.akses_group_id', $role)
                ->get();
            $mastermenu = MenuHalaman::where('status', '1')
                ->whereNotIn('id', function ($query) use ($role) {
                    $query->select('menu_halaman_id')
                        ->from('akses_user_menu')
                        ->where('akses_group_id', $role);
                })
                ->orderBy('id', 'desc')
                ->get();
        } else {
            // If ID is not provided, fetch all records
            $menuuser = MenuHalaman::where('status', '1')
                ->orderBy('id', 'desc')
                ->get();
            $mastermenu = MenuHalaman::where('status', '1')
                ->orderBy('id', 'desc')
                ->get();
        }
        $aksesgroup = AksesGroup::orderBy('akses_group_id', 'desc')
            ->get();

        $actions = ActionMenu::select('action_menu.*')
            ->leftJoin('akses_user_detail', function ($query) use ($role) {
                $query->on('action_menu.id', '=', 'akses_user_detail.action_menu_id')
                    ->where('akses_user_detail.akses_group_id', '=', $role);
            })
            ->selectRaw('IF(akses_user_detail.akses_user_detail_id IS NOT NULL, 1, 0) AS akses')
            ->get();

        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';

        return view('pages.abp-page.menuuser', compact('title', 'breadcrumb', 'menuuser', 'role', 'mastermenu', 'actions', 'aksesgroup'));
    }

    public function add(Request $request)
    {
        $akses_user_menu = new AksesUserMenu();
        $akses_user_menu->akses_group_id = $request->akses_group_id;
        $akses_user_menu->menu_halaman_id = $request->nama_menu_halaman;
        $akses_user_menu->save();

        return redirect()->back();
    }

    public function store(Request $request)
    {
        MenuHalaman::create([
            'nama_menu_halaman'     => $request->nama_menu_halaman,
            'status'     => '1',
        ]);
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $idActions = $request->input('id_action', []);
        $satuidaction = $idActions[0];
        $aksesGroupId = $request->akses_group_id;
        AksesUserDetail::whereIn('action_menu_id', function ($query) use ($satuidaction) {
            $query->select('f.id')
                ->from('action_menu as f')
                ->join(DB::raw('(select b.menu_halaman_id from akses_user_detail a join action_menu b on a.action_menu_id = b.id where a.action_menu_id = '.$satuidaction.') as g'), 'f.menu_halaman_id', '=', 'g.menu_halaman_id');
        })
            ->where('akses_group_id', $aksesGroupId)
            ->delete();
        foreach ($request->input('id_action', []) as $actionId) {
            $aksesUserDetail = new AksesUserDetail();
            $aksesUserDetail->akses_group_id = $request->akses_group_id; // Menggunakan nilai akses_group_id dari permintaan
            $aksesUserDetail->action_menu_id = $actionId; // Menggunakan nilai action_id dari array input
            $aksesUserDetail->save();
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        $barang = MenuHalaman::find($id);
        $barang->update([
            'isadmin' => '0'
        ]);
        return redirect()->back();
    }
}
