<?php

namespace App\Http\Controllers;

use App\Models\DetailPH;
use App\Models\Penerima;
use App\Models\Customer;
use App\Models\PenawaranHarga;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;
use PDF;

class PHController extends Controller
{
    public function index() {
        $penerima = Penerima::join('pt_penerima', 'penerimas.id_pt_penerima', '=', 'pt_penerima.id_pt_penerima')
                    ->join('grups', 'penerimas.id_grup', '=', 'grups.id_grup')
                    ->select('pt_penerima.nama_penerima','pt_penerima.id_pt_penerima')
                    ->where('penerimas.status', 1)
                    ->groupBy('pt_penerima.nama_penerima','pt_penerima.id_pt_penerima')
                    ->get();
        $estate = Penerima::join('pt_penerima', 'penerimas.id_pt_penerima', '=', 'pt_penerima.id_pt_penerima')
                    ->join('grups', 'penerimas.id_grup', '=', 'grups.id_grup')
                    ->select('pt_penerima.nama_penerima','pt_penerima.id_pt_penerima','penerimas.estate')
                    ->where('penerimas.status', 1)
                    ->groupBy('pt_penerima.nama_penerima','pt_penerima.id_pt_penerima','penerimas.estate')
                    ->get();                    
        $detail = PenawaranHarga::where('status', 1)
                    ->orderBy('id_penawaran', 'desc')
                    ->get();
        $customer = Customer::where('status', 1)
                    ->orderBy('id', 'desc')
                    ->get();
        $detailph = DetailPH::select('*')
                    ->join('penerimas','penerimas.id_penerima','=','detail_p_h_s.id_penerima')
                    ->where('detail_p_h_s.status', 1)
                    ->orderBy('id_detail_ph', 'desc')
                    ->get();                    
        $ph = PenawaranHarga::select('penawaran_hargas.id_penawaran', 'penawaran_hargas.nama_pic', 
                    'customers.nama_customer', 'customers.alamat', 'customers.id', 'penawaran_hargas.id_customer',
                    'penawaran_hargas.ketentuan','penawaran_hargas.status')
                    ->join('customers', 'penawaran_hargas.id_customer', '=', 'customers.id')
                    ->where('penawaran_hargas.status', 1)
                    ->get();
        $phtbl = PenawaranHarga::select('penawaran_hargas.id_penawaran', 'penawaran_hargas.id_customer',
                    'penawaran_hargas.nama_pic', 'customers.nama_customer', 
                    'customers.alamat','penawaran_hargas.ketentuan',
                    'penawaran_hargas.status')
                    ->join('customers', 'penawaran_hargas.id_customer', '=', 'customers.id')
                    ->where('penawaran_hargas.status', 2)
                    ->orWhere('penawaran_hargas.status', 3)
                    ->get();
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.dph', compact('title', 'breadcrumb','detail', 'estate','customer','ph','phtbl','penerima','detailph'));
    }

    public function generatepdf($id)
    {
        set_time_limit(5);
        $penawaranHargas = PenawaranHarga::select('nama_customer', 'nama_pic', 'ketentuan', 'kota', 'penawaran_hargas.updated_at')
            ->join('customers', 'penawaran_hargas.id_customer', '=', 'customers.id')
            ->where('id_penawaran', $id)
            ->get();

        if ($penawaranHargas->isEmpty()) {
            return redirect()->back()->with('error', 'Data not found.');
        }

        $data = $penawaranHargas->first()->toArray();

        $dataDetailPH = DetailPH::join('penerimas', 'detail_p_h_s.id_penerima', '=', 'penerimas.id_penerima')
            ->where('id_penawaran', $id)
            ->select('detail_p_h_s.oa_container', 'detail_p_h_s.oa_kpl_kayu', 'penerimas.estate')
            ->get()->toArray();


        // return ['data' => $data];
        $pdf = PDF::loadView('pdf.example', ['data1' => $data, 'data2' => $dataDetailPH]);

        return $pdf->download('surat_pesanawaran.pdf');
    }

    public function getDetails($id)
    {
        $getdata = Customer::where('id', $id)->get();
        return response()->json($getdata);   
    }

    public function getPenDetails($id)
    {
        $getdata = Penerima::where('id_pt_penerima', $id)->get();
        return response()->json($getdata);   
    }

    public function store(Request $request) {
        DetailPH::create([
            'id_penawaran'     => $request->id_ph,
            'id_penerima'     => $request->id_pen,
            'oa_kpl_kayu'     => $request->oa_kk,
            'oa_container'   => $request->oa_cont,
            'status' => '1'
        ]);
        return redirect()->back();
    }

    public function save(Request $request) {
        PenawaranHarga::create([
            'nama_pic'     => $request->nama_pic,
            'id_customer'   => $request->cst_id,
            'ketentuan' =>$request->kt,
            'status' => '1'
        ]);

        return redirect()->back();
    }

    public function destroy($id) {
        PenawaranHarga::where('id_penawaran', $id)->update([
            'status' => '3'
        ]);
        DetailPH::where('id_penawaran', $id)->update([
            'status' => '3'
        ]);
        return redirect()->back();
    }
    
    public function approve(Request $request, $id_penawaran) {
        PenawaranHarga::where('id_penawaran', $id_penawaran)->update([
            'status' => '2'
        ]);
        DetailPH::where('id_penawaran', $id_penawaran)->update([
            'status' => '2'
        ]);
        return redirect()->back();
    }
    public function edit(Request $request, $id_penawaran) {
        PenawaranHarga::where('id_penawaran', $id_penawaran)->update([
            'status' => '1'
        ]);
        DetailPH::where('id_penawaran', $id_penawaran)->update([
            'status' => '1'
        ]);
        return redirect()->back();
    }
    public function updateph(Request $request, $id_penawaran) {
        PenawaranHarga::where('id_penawaran', $id_penawaran)->update([
            'nama_pic'     => $request->nama_pic,
            'id_customer'     => $request->cst_id,
            'ketentuan'   => $request->kt,
            'status' => '1'
        ]);
        return redirect()->back();
    }
    public function removedph(Request $request, $id_penawaran) {
        PenawaranHarga::where('id_penawaran', $id_penawaran)->update([
            'status' => '0'
        ]);
        return redirect()->back();
    }    
    public function updatephd(Request $request, $id_detail_ph) {
        DetailPH::where('id_detail_ph', $id_detail_ph)->update([
            'id_penawaran'     => $request->id_ph,
            // 'id_penerima'     => $request->id_pen,
            'oa_kpl_kayu'     => $request->oa_kk,
            'oa_container'   => $request->oa_cont,
            'status' => '1'
        ]);
        return redirect()->back();
    }        
    public function removedphd(Request $request, $id_detail_ph) {
        DetailPH::where('id_detail_ph', $id_detail_ph)->update([
            'status' => '0'
        ]);
        return redirect()->back();
    }    
}
