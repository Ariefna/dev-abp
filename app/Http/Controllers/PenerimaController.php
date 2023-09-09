<?php

namespace App\Http\Controllers;

use App\Models\Penerima;
use App\Models\PTpenerima;
use App\Models\Grup;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;

class PenerimaController extends Controller
{
    public function index() {
        $pen = PTpenerima::where('status', 1)
                    ->orderBy('id_pt_penerima', 'desc')
                    ->get();
        $grup = Grup::where('status', 1)
                    ->orderBy('id_grup', 'asc')
                    ->get();                    
        $penerima = Penerima::join('pt_penerima', 'penerimas.id_pt_penerima', '=', 'pt_penerima.id_pt_penerima')
                    ->join('grups', 'penerimas.id_grup', '=', 'grups.id_grup')
                    ->select('pt_penerima.nama_penerima', 'grups.nama_grup', 'penerimas.estate')
                    ->where('penerimas.status', 1)
                    ->get();                
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.mpenerima', compact('title', 'breadcrumb','pen' , 'penerima','grup'));
    }

    public function store(Request $request) {
        Penerima::create([
            'id_pt_penerima'     => $request->id_pt,
            'id_grup'     => $request->id_gr,
            'estate'     => $request->estate_pen,
            'alamat'     => $request->alamat_pen,
            'status' => '1'
        ]);
        return redirect()->back();
    }
    
}
