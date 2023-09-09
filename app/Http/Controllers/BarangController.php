<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index() {
        $barang = Barang::where('status', 1)
                    ->orderBy('id', 'desc')
                    ->get();
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.mbarang', compact('title', 'breadcrumb','barang'));
    }

    public function store(Request $request) {
        Barang::create([
            'nama_barang'     => $request->nama_brg,
            'jenis_barang'     => $request->jenis_brg,
            'status' => '1'
        ]);
        return redirect()->back();
    }
    
    public function update(Request $request, Barang $barang) {
        $barang->update([
            'nama_barang'     => $request->nama_brg,
            'jenis_barang'     => $request->jenis_brg,
            'status' => '1'
        ]);
        return redirect()->back();
    }
    
    public function destroy($id) {
        $barang = Barang::find($id);
        $barang->update([
            'status' => '0'
        ]);
        return redirect()->back();
    }
}
