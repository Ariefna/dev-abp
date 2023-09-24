<?php

namespace App\Http\Controllers;

use App\Models\ActionMenu;
use App\Models\MenuHalaman;
use Illuminate\Http\Request;

class MenuUserController extends Controller
{
    public function index()
    {
        $role = request('role') != '' ? request('role') : '1'; // Read the 'id' query parameter from the URL
        if ($role !== null && $role === '0') {
            // Filter by user ID if provided
            $menuuser = MenuHalaman::where('status', '1')
                ->where('isadmin', '1')
                ->orderBy('id', 'desc')
                ->get();
        } else {
            // If ID is not provided, fetch all records
            $menuuser = MenuHalaman::where('status', '1')
                ->orderBy('id', 'desc')
                ->get();
        }
        $mastermenu = MenuHalaman::where('status', '1')
            ->orderBy('id', 'desc')
            ->get();

        $actions = ActionMenu::where('status', '1')
            ->orderBy('id', 'desc')
            ->get();

        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';

        return view('pages.abp-page.menuuser', compact('title', 'breadcrumb', 'menuuser', 'role', 'mastermenu', 'actions'));
    }

    public function add(Request $request)
    {
        $id = $request->nama_menu_halaman;
        // Find the MenuHalaman by its ID
        $menuHalaman = MenuHalaman::findOrFail($id);
        $menuHalaman->isadmin = '1'; // You can adjust this value as needed

        $menuHalaman->save();

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
        foreach ($request->input('id_action', []) as $actionId) {
            $actionMenu = ActionMenu::find($actionId);
            // Update the actionMenu record if it exists
            if ($actionMenu) {
                if ($actionMenu->isadmin == '1') {
                    $actionMenu->isadmin = '0';
                } else {
                    $actionMenu->isadmin = '1';
                }
                $actionMenu->save();
            }
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
