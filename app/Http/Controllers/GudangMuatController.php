<?php

namespace App\Http\Controllers;

use App\Models\GudangMuat;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;

class GudangMuatController extends Controller
{
    public function index() {
        $gudang = GudangMuat::where('status', 1)
                    ->orderBy('id_gudang', 'desc')
                    ->get();
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.mgudangmuat', compact('title', 'breadcrumb','gudang'));
    }

    public function store(Request $request) {
        GudangMuat::create([
            'nama_gudang'     => $request->nama_gd,
            'kota'     => $request->kota_gd,
            'alamat'   => $request->alamat_gd,
            'status' => '1'
        ]);
        return redirect()->back();
    }
}
