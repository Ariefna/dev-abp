<?php

namespace App\Http\Controllers;

use App\Models\Kapal;
use App\Models\CPort;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;

class KapalController extends Controller
{
    public function index()
    {
        // $kapal = Kapal::where('status', 1)
        //             ->orderBy('id', 'desc')
        //             ->get();
        // $title = 'Adhipramana Bahari Perkasa';
        // $breadcrumb = 'This Breadcrumb';
        // return view('pages.abp-page.mkapal', compact('title', 'breadcrumb','kapal'));

        $compport = CPort::where('status', 1)
                    ->orderBy('nama', 'asc')
                    ->get();
        $kapal = Kapal::select('kapals.id', 'kapals.id_company_port', 'c_ports.nama', 'c_ports.no_telp', 'c_ports.alamat', 'kapals.kode_kapal', 'kapals.nama_kapal')
                    ->join('c_ports', 'c_ports.id_company_port', '=', 'kapals.id_company_port')
                    ->where('kapals.status', 1)
                    ->get();
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.mkapal', compact('title', 'breadcrumb','kapal','compport'));        
    }

    public function store(Request $request) {
        Kapal::create([
            'id_company_port'     => $request->cport_kpl,
            'kode_kapal'     => $request->kode_kpl,
            'nama_kapal'     => $request->nama_kpl,
            'status' => '1'
        ]);
        return redirect()->back();
    }

    public function edit(Kapal $kapal) {
        return view('kapal.index', compact('kapal'));
    }

    public function update(Request $request, Kapal $kapal) {
        $kapal->update([
            'nama_kapal'     => $request->nama_kpl,
            'id_company_port'     => $request->cport_kpl,
            'kode_kapal'   => $request->kode_kpl,
            'status' => '1'
        ]);
        return redirect()->back();
    }

    public function getDetails($id)
    {
        $getdata = CPort::where('id_company_port', $id)
                        ->orderBy('nama', 'asc')
                        ->get();
        return response()->json($getdata);   
    }

    public function getEditDetails($id)
    {
        $getdata = CPort::where('id_company_port', $id)
                        ->orderBy('nama', 'asc')
                        ->get();
        return response()->json($getdata);   
    }

    public function destroy($id) {
        $kapal = Kapal::find($id);
        $kapal->update([
            'status' => '0'
        ]);
        return redirect()->back();
    }
}
