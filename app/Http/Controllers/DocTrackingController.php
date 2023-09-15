<?php

namespace App\Http\Controllers;

use App\Models\DetailPH;
use App\Models\PortOfLoading;
use App\Models\PortOfDestination;
use App\Models\GudangMuat;
use App\Models\Kapal;
use App\Models\CPort;
use App\Models\PenawaranHarga;
use App\Models\Barang;
use App\Models\PurchaseOrder;
use App\Models\PtPenerima;
use App\Models\DocTracking;
use App\Models\DetailTracking;
use App\Models\DetailTrackingSisa;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocTrackingController extends Controller
{
    public function index() {
        $gudang = GudangMuat::where('status', 1)
                ->orderBy('id_gudang', 'desc')
                ->get();
        $pol = PortOfLoading::where('status', 1)
                ->orderBy('id', 'desc')
                ->get();
        $pod = PortOfDestination::where('status', 1)
                ->orderBy('id', 'desc')
                ->get();
        $kapal = Kapal::select('kapals.id', 'kapals.id_company_port', 'c_ports.nama', 'c_ports.no_telp', 'c_ports.alamat', 'kapals.kode_kapal', 'kapals.nama_kapal')
                ->join('c_ports', 'c_ports.id_company_port', '=', 'kapals.id_company_port')
                ->where('kapals.status', 1)
                ->get();                                        
        $po = PurchaseOrder::select('purchase_orders.po_muat', 'purchase_orders.po_kebun', 'customers.nama_customer', 'purchase_orders.status')
                ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                ->join('penawaran_hargas', 'penawaran_hargas.id_penawaran', '=', 'detail_p_h_s.id_penawaran')
                ->join('customers', 'customers.id', '=', 'penawaran_hargas.id_customer')
                ->join('penerimas', 'detail_p_h_s.id_penerima', '=', 'penerimas.id_penerima')
                ->join('pt_penerima', 'pt_penerima.id_pt_penerima', '=', 'penerimas.id_pt_penerima')
                ->join('barangs', 'purchase_orders.id', '=', 'barangs.id')
                ->where('purchase_orders.status', '=', 2)
                ->get();
        $track = DocTracking::select('*', 'doc_tracking.status', 'doc_tracking.id_track')
                ->selectSub(function ($query) {
                    $query->selectRaw('SUM(qty_tonase_sisa)')
                        ->from('detail_tracking_sisa')
                        ->whereColumn('detail_tracking_sisa.id_track', 'doc_tracking.id_track')
                        ->groupBy('detail_tracking.id_track');
                }, 'total_all_sisa')
                ->selectSub(function ($query) {
                    $query->selectRaw('SUM(qty_tonase)')
                        ->from('detail_tracking')
                        ->whereColumn('detail_tracking.id_track', 'doc_tracking.id_track')
                        ->where('detail_tracking.status', 1)
                        ->whereNull('no_container')
                        ->groupBy('detail_tracking.id_track');
                }, 'muat_curah')
                ->selectSub(function ($query) {
                    $query->selectRaw('SUM(qty_tonase)')
                        ->from('detail_tracking')
                        ->whereColumn('detail_tracking.id_track', 'doc_tracking.id_track')
                        ->where('detail_tracking.status', 1)
                        ->whereNotNull('no_container')
                        ->groupBy('detail_tracking.id_track');
                }, 'muat_container')
                ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                ->join('detail_tracking', 'detail_tracking.id_track', '=', 'doc_tracking.id_track')
                ->join('detail_tracking_sisa','detail_tracking_sisa.id_track','=','doc_tracking.id_track')
                ->where('doc_tracking.status', 1)
                ->groupBy('doc_tracking.id_track')
                ->orderBy('doc_tracking.id_track', 'desc')
                ->get();
        $trackzero = DocTracking::select('*', 'doc_tracking.status', 'doc_tracking.id_track')
                    ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                    ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                    ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                    ->join('detail_tracking_sisa','detail_tracking_sisa.id_track','=','doc_tracking.id_track')
                    ->where('doc_tracking.status', 1)
                    ->groupBy('doc_tracking.id_track')
                    ->orderBy('doc_tracking.id_track', 'desc')
                    ->get();
        $getcurahqty = DocTracking::select('*', 'doc_tracking.status', 'doc_tracking.id_track')
                    ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                    ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                    ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                    ->join('detail_tracking', 'detail_tracking.id_track', '=', 'doc_tracking.id_track')
                    ->join('detail_tracking_sisa','detail_tracking_sisa.id_track','=','doc_tracking.id_track')
                    ->where('doc_tracking.status', 1)
                    ->where('detail_tracking_sisa.tipe', 'Curah')
                    ->groupBy('doc_tracking.id_track')
                    ->orderBy('doc_tracking.id_track', 'desc')
                    ->get();
        $getcontqty = DocTracking::select('*', 'doc_tracking.status', 'doc_tracking.id_track')
                    ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                    ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                    ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                    ->join('detail_tracking', 'detail_tracking.id_track', '=', 'doc_tracking.id_track')
                    ->join('detail_tracking_sisa','detail_tracking_sisa.id_track','=','doc_tracking.id_track')
                    ->where('doc_tracking.status', 1)
                    ->where('detail_tracking_sisa.tipe', 'Container')
                    ->groupBy('doc_tracking.id_track')
                    ->orderBy('doc_tracking.id_track', 'desc')
                    ->get();                    
        $details = DocTracking::select('*', 'doc_tracking.status', 'doc_tracking.id_track')
                ->selectSub(function ($query) {
                    $query->selectRaw('SUM(qty_tonase)')
                        ->from('detail_tracking')
                        ->whereColumn('detail_tracking.id_track', 'doc_tracking.id_track')
                        ->groupBy('detail_tracking.id_track');
                }, 'total_qty_tonase')
                ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                ->join('detail_tracking', 'detail_tracking.id_track', '=', 'doc_tracking.id_track')
                ->where('doc_tracking.status', 1)
                ->where('detail_tracking.status', 1)
                ->groupBy('doc_tracking.id_track')
                ->orderBy('doc_tracking.id_track', 'desc')
                ->count();
        $dtrack = DetailTracking::select('*')
                ->join('gudang_muats', 'gudang_muats.id_gudang', '=', 'detail_tracking.id_gudang')
                ->join('kapals', 'kapals.id', '=', 'detail_tracking.id_kapal')
                ->where('detail_tracking.status', 1)
                ->orderBy('detail_tracking.id_detail_track', 'desc')
                ->get();    
        $lastcont = DetailTracking::where('status', 1)->whereNotNull('no_container')->latest()->first();
        $lastcurah = DetailTracking::where('status', 1)->whereNull('no_container')->latest()->first();
        $zerocurah = DocTracking::select('*')
                    ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                    ->where('doc_tracking.status',1)
                    ->get();
        $zerocont = DocTracking::select('*')
                    ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                    ->where('doc_tracking.status',1)
                    ->get();                    
        // $tbl_po = Tracking::select('purchase_orders.po_muat', 'purchase_orders.po_kebun', 
        //         'purchase_orders.total_qty', 'port_of_loading.nama_pol', 'port_of_destination.nama_pod',
        //         'trackings.status', 'kapals.kode_kapal','kapals.nama_kapal','pt_penerima.nama_penerima',
        //         'gudang_muats.nama_gudang', 'barangs.nama_barang','purchase_orders.no_pl', 'trackings.tgl_muat',
        //         'purchase_orders.po_kebun','trackings.qty_muat', 'trackings.qty_timbang','trackings.jml_bag',
        //         'trackings.nopol','trackings.no_container','trackings.voyage','trackings.td','trackings.td_jkt',
        //         'trackings.eta','customers.nama_customer')
        //         ->join('gudang_muats', 'gudang_muats.id_gudang', '=', 'trackings.id_gudang')
        //         ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'trackings.no_po')
        //         ->join('port_of_loading', 'port_of_loading.id', '=', 'trackings.id_pol')
        //         ->join('port_of_destination', 'port_of_destination.id', '=', 'trackings.id_pod')
        //         ->join('kapals', 'kapals.id', '=', 'trackings.id_kapal')
        //         ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
        //         ->join('penawaran_hargas', 'penawaran_hargas.id_penawaran', '=', 'detail_p_h_s.id_penawaran')
        //         ->join('customers', 'customers.id', '=', 'penawaran_hargas.id_customer')
        //         ->join('penerimas', 'detail_p_h_s.id_penerima', '=', 'penerimas.id_penerima')
        //         ->join('pt_penerima', 'pt_penerima.id_pt_penerima', '=', 'penerimas.id_pt_penerima')
        //         ->join('barangs', 'purchase_orders.id', '=', 'barangs.id')
        //         ->where('trackings.status', '=', 1)
        //         ->get();
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.tra', compact('title', 'breadcrumb','po','details','getcurahqty','getcontqty','track','trackzero','dtrack','lastcont','lastcurah','zerocurah','zerocont','gudang','pol','pod','kapal'));
    }
    

    public function getPo($id) {
        $query = PurchaseOrder::select('purchase_orders.po_muat', 'purchase_orders.po_kebun', 'pt_penerima.nama_penerima',
                'purchase_orders.no_pl', 'purchase_orders.simb','penerimas.estate', 'barangs.nama_barang',
                'purchase_orders.status')
                ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                ->join('penawaran_hargas', 'penawaran_hargas.id_penawaran', '=', 'detail_p_h_s.id_penawaran')
                ->join('customers', 'customers.id', '=', 'penawaran_hargas.id_customer')
                ->join('penerimas', 'detail_p_h_s.id_penerima', '=', 'penerimas.id_penerima')
                ->join('pt_penerima', 'pt_penerima.id_pt_penerima', '=', 'penerimas.id_pt_penerima')
                ->join('barangs', 'purchase_orders.id', '=', 'barangs.id')
                ->where('purchase_orders.status', '=', 2)
                ->where('purchase_orders.po_muat', $id);
        $getdata = $query->get();
        return response()->json($getdata);
    }             
    public function store(Request $request) {
        DocTracking::create([
            'no_po'     => $request->no_po,
            'id_pol'     => $request->id_pol,
            'id_pod'     => $request->id_pod,
            'status' => '1',
            'status_kapal'=> 1
        ]);
        return redirect()->back();
    }
    public function savecontainer(Request $request) {
        $request->validate([
            'file' => 'required|mimes:jpeg,png,pdf|max:2048',
        ]);
        
        $file1 = $request->file('file'); // Change variable name to $file1
        $fileName1 = time() . '_' . $file1->getClientOriginalName();
        
        Storage::disk('public')->putFileAs('uploads/tracking', $file1, $fileName1);
        
        $request->validate([
            'file_tbg' => 'required|mimes:jpeg,png,pdf|max:2048',
        ]);
        
        $file2 = $request->file('file_tbg'); // Change variable name to $file2
        $fileName2 = time() . '_' . $file2->getClientOriginalName();
        
        Storage::disk('public')->putFileAs('uploads/tracking', $file2, $fileName2);
        
        DetailTracking::create([
            'id_track'     => $request->id_track,
            'id_gudang'     => $request->id_gudang,
            'id_kapal'     => $request->id_kapal,
            'qty_tonase'     => $request->qty_tonase,
            'qty_timbang'     => $request->qty_timbang,
            'jml_sak'     => $request->jml_sak,
            'nopol'     => $request->nopol,
            'no_container'     => $request->no_container,
            'voyage'     => $request->voyage,
            'no_segel'     => $request->no_segel,
            'tgl_muat'     => $request->tgl_muat,
            'td'     => '',
            'td_jkt'     => '',
            'ta'     => '',
            'no_sj'     => $request->no_sj,
            'sj_file_name'     => $fileName1,
            'sj_file_path'     => 'uploads/tracking' . $fileName1,
            'st_file_name'     => $fileName2,
            'st_file_path'     => 'uploads/tracking' . $fileName2,                                    
            'status' => '1'
        ]);
        $c = $request->qty_cont_emp2;
        $b = $request->qty_cont_ada;            
        if ($c !== $b) {
            DetailTrackingSisa::where('id_track', $request->id_track)->
            where('tipe','Container')->update([
                'qty_tonase_sisa' => $request->qty_cont_ada,
            ]);
        } else if($c === $b){
            DetailTrackingSisa::create([
                'id_track'          => $request->id_track,
                'qty_tonase_sisa'   => $request->qty_cont_emp,
                'qty_total_tonase'  => $request->qty_cont_total,
                'status'            => 1,
                'tipe'              => 'Container'
            ]);
        }
        return redirect()->back();
    }
    public function savecurah(Request $request) {
        $request->validate([
            'file' => 'required|mimes:jpeg,png,pdf|max:2048',
        ]);
        
        $file1 = $request->file('file'); // Change variable name to $file1
        $fileName1 = time() . '_' . $file1->getClientOriginalName();
        
        Storage::disk('public')->putFileAs('uploads/tracking', $file1, $fileName1);
        
        $request->validate([
            'file_tbg' => 'required|mimes:jpeg,png,pdf|max:2048',
        ]);
        
        $file2 = $request->file('file_tbg'); // Change variable name to $file2
        $fileName2 = time() . '_' . $file2->getClientOriginalName();
        
        Storage::disk('public')->putFileAs('uploads/tracking', $file2, $fileName2);
        
        DetailTracking::create([
            'id_track'     => $request->id_track,
            'id_gudang'     => $request->id_gudang,
            'id_kapal'     => $request->id_kapal,
            'qty_tonase'     => $request->qty_tonase,
            'qty_timbang'     => $request->qty_timbang,
            'jml_sak'     => $request->jml_sak,
            'nopol'     => $request->nopol,
            'no_container'     => null,
            'voyage'     => null,
            'no_segel'     => null,
            'tgl_muat'     => $request->tgl_muat,
            'td'     => '',
            'td_jkt'     => '',
            'ta'     => '',
            'no_sj'     => $request->no_sj,
            'sj_file_name'     => $fileName1,
            'sj_file_path'     => 'uploads/tracking' . $fileName1,
            'st_file_name'     => $fileName2,
            'st_file_path'     => 'uploads/tracking' . $fileName2,                                    
            'status' => '1'
        ]);

        $c = $request->qty_sisa_curah2;
        $b = $request->qty;            
        if ($c !== $b) {
            DetailTrackingSisa::where('id_track', $request->id_track)->
            where('tipe','Curah')->update([
                'qty_tonase_sisa' => $request->qty,
            ]);
        } else if($c === $b){
            DetailTrackingSisa::create([
                'id_track'          => $request->id_track,
                'qty_tonase_sisa'   => $request->qty_sisa_curah,
                'qty_total_tonase'  => $request->qty_curah_total,
                'status'            => 1,
                'tipe'              => 'Curah'
            ]);
        }
        
        return redirect()->back();
    }           
    public function destroy(Request $request, $id) {
        // $idtracking = DetailTrackingSisa::select('qty_tonase_sisa')->where('id_track',$id)->get();
        $qty_sisa = $request->qty_sisa_simpan;
        // echo $qty_sisa;
        if ($qty_sisa > 0) {
            // echo 'ada';
            DocTracking::where('id_track', $id)->update([
                'status' => '2'
            ]);
            DetailTracking::where('id_track', $id)->update([
                'status' => '2'
            ]);
        }else if($qty_sisa == 0){
            // echo 'tidak';
            DocTracking::where('id_track', $id)->update([
                'status' => '3'
            ]);
            DetailTracking::where('id_track', $id)->update([
                'status' => '3'
            ]);
        }
        return redirect()->back();
        // $getdata = $idtracking->get();
        // return response()->json($getdata);
        // dd ([
        //     'idtracksisa'=>$idtracking ?? null,
        // ]);
        
    }    
}
