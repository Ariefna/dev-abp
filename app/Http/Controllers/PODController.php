<?php

namespace App\Http\Controllers;

use App\Models\PortOfDestination;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;

class PODController extends Controller
{
    public function index() {
        $pod = PortOfDestination::where('status', 1)
                    ->orderBy('id', 'desc')
                    ->get();
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.mpod', compact('title', 'breadcrumb','pod'));
    }

    public function store(Request $request) {
        PortOfDestination::create([
            'nama_pod'     => $request->nama_pod,
            'status' => '1'
        ]);
        return redirect()->back();
    }
    public function update(Request $request, PortOfDestination $pod) {
        $pod->update([
            'nama_pod'     => $request->nama_pod,
            'status' => '1'
        ]);
        return redirect()->back();
    }
    
    public function destroy($id) {
        $barang = PortOfDestination::find($id);
        $barang->update([
            'status' => '0'
        ]);
        return redirect()->back();
    }    
}
