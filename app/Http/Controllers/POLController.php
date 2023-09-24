<?php

namespace App\Http\Controllers;

use App\Models\PortOfLoading;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;

class POLController extends Controller
{
    public function index() {
        $pol = PortOfLoading::where('status', 1)
                    ->orderBy('id', 'desc')
                    ->get();
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.mpol', compact('title', 'breadcrumb','pol'));
    }

    public function store(Request $request) {
        PortOfLoading::create([
            'nama_pol'     => $request->nama_pol,
            'status' => '1'
        ]);
        return redirect()->back();
    }
    public function destroy($id) {
        $pol = PortOfLoading::find($id);
        $pol->update([
            'status' => '0'
        ]);
        return redirect()->back();
    } 
}
