<?php

namespace App\Http\Controllers;

use App\Models\DetailPH;
use App\Models\PortOfLoading;
use App\Models\PortOfDestination;
use App\Models\GudangMuat;
use App\Models\Penerima;
use App\Models\Kapal;
use App\Models\CPort;
use App\Models\PenawaranHarga;
use App\Models\Barang;
use App\Models\PurchaseOrder;
use App\Models\PtPenerima;
use App\Models\DocTracking;
use App\Models\DetailTracking;
use App\Models\DocDooring;
use App\Models\DetailDooring;
use App\Models\DetailDooringSisa;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DooringController extends Controller
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
        $kapal = Kapal::select('*')
                ->join('c_ports', 'c_ports.id_company_port', '=', 'kapals.id_company_port')
                ->join('detail_tracking','detail_tracking.id_kapal','=','kapals.id')
                ->where('kapals.status', 1)
                ->where('detail_tracking.status',[2,3])
                ->groupBy('detail_tracking.id_kapal')
                ->get();                   
        $po = DetailTracking::select('*')
                ->join('doc_tracking','doc_tracking.id_track','=','detail_tracking.id_track')
                ->join('purchase_orders','purchase_orders.po_muat','=','doc_tracking.no_po')
                ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                ->join('penawaran_hargas', 'penawaran_hargas.id_penawaran', '=', 'detail_p_h_s.id_penawaran')
                ->join('customers', 'customers.id', '=', 'penawaran_hargas.id_customer')
                ->join('penerimas', 'detail_p_h_s.id_penerima', '=', 'penerimas.id_penerima')
                ->join('pt_penerima', 'pt_penerima.id_pt_penerima', '=', 'penerimas.id_pt_penerima')
                ->join('barangs', 'purchase_orders.id', '=', 'barangs.id')
                ->whereIn('doc_tracking.status', [2, 3])
                ->groupBy('doc_tracking.no_po')
                ->get();
        $track = DocDooring::select('*', 'doc_dooring.status', 'doc_dooring.id_dooring','detail_dooring.qty_tonase'
                ,'detail_dooring_sisa.tipe','detail_dooring_sisa.qty_tonase_sisa')
                ->selectSub(function ($query) {
                    $query->selectRaw('SUM(qty_tonase)')
                        ->from('detail_dooring')
                        ->whereColumn('detail_dooring.id_dooring', 'doc_dooring.id_dooring')
                        ->where('detail_dooring.status', 1)
                        ->groupBy('detail_dooring.id_dooring');
                }, 'total_tonase_dooring')
                ->selectSub(function ($query) {
                    $query->selectRaw('SUM(qty_tonase)')
                        ->from('detail_tracking')
                        ->whereColumn('detail_tracking.id_track', 'doc_tracking.id_track')
                        ->where('status',[2,3])
                        ->groupBy('detail_tracking.id_track');
                }, 'total_tonase_track')                
                ->selectSub(function ($query) {
                    $query->selectRaw('SUM(qty_tonase)')
                        ->from('detail_tracking')
                        ->whereColumn('detail_tracking.id_track', 'doc_tracking.id_track')
                        ->where('detail_tracking.status', [2,3])
                        ->whereNull('no_container')
                        ->groupBy('detail_tracking.id_track');
                }, 'muat_curah_track')
                ->selectSub(function ($query) {
                    $query->selectRaw('SUM(qty_tonase)')
                        ->from('detail_tracking')
                        ->whereColumn('detail_tracking.id_track', 'doc_tracking.id_track')
                        ->where('detail_tracking.status', [2,3])
                        ->whereNotNull('no_container')
                        ->groupBy('detail_tracking.id_track');
                }, 'muat_container_track')
                ->join('doc_tracking','doc_tracking.id_track','=','doc_dooring.id_track')
                ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                ->join('detail_dooring', 'detail_dooring.id_dooring', '=', 'doc_dooring.id_dooring')
                ->join('detail_tracking', 'detail_tracking.id_track', '=', 'doc_tracking.id_track')
                ->join('detail_dooring_sisa','detail_dooring_sisa.id_dooring','=','doc_dooring.id_dooring')
                ->where('doc_dooring.status', 1)
                ->groupBy('doc_dooring.id_dooring')
                ->orderBy('doc_dooring.id_dooring', 'desc')
                ->get();
        $doorzero = DocDooring::select('*', 'doc_dooring.status', 'doc_dooring.id_dooring')
                    ->selectSub(function ($query) {
                        $query->selectRaw('SUM(qty_tonase)')
                            ->from('detail_tracking')
                            ->whereColumn('detail_tracking.id_track', 'doc_tracking.id_track')
                            ->where('status',[2,3])
                            ->groupBy('detail_tracking.id_track');
                    }, 'total_tonase_track')
                    ->selectSub(function ($query) {
                        $query->selectRaw('SUM(qty_tonase)')
                            ->from('detail_tracking')
                            ->whereColumn('detail_tracking.id_track', 'doc_tracking.id_track')
                            ->where('status',[2,3])
                            ->whereNull('no_container')
                            ->groupBy('detail_tracking.id_track');
                    }, 'qty_curah_track')
                    ->selectSub(function ($query) {
                        $query->selectRaw('SUM(qty_tonase)')
                            ->from('detail_tracking')
                            ->whereColumn('detail_tracking.id_track', 'doc_tracking.id_track')
                            ->where('status',[2,3])
                            ->whereNotNull('no_container')
                            ->groupBy('detail_tracking.id_track');
                    }, 'qty_curah_cont')
                    ->join('doc_tracking','doc_tracking.id_track','=','doc_dooring.id_track')
                    ->join('detail_tracking', 'detail_tracking.id_track', '=', 'doc_dooring.id_track')
                    ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                    ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                    ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                    ->where('doc_dooring.status', 1)
                    ->where('detail_tracking.status', [2,3])
                    ->groupBy('doc_dooring.id_dooring')
                    ->orderBy('doc_dooring.id_dooring', 'desc')
                    ->get();
        $getcurahqty = DocTracking::select('*', 'doc_tracking.status', 'doc_tracking.id_track')
                    ->selectSub(function ($query) {
                        $query->selectRaw('SUM(qty_tonase)')
                            ->from('detail_tracking')
                            ->whereColumn('detail_tracking.id_track', 'doc_tracking.id_track')
                            ->where('detail_tracking.status', 1)
                            ->whereNull('no_container')
                            ->groupBy('detail_tracking.id_track');
                    }, 'total_qty_curah')
                    ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                    ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                    ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                    ->join('detail_tracking', 'detail_tracking.id_track', '=', 'doc_tracking.id_track')
                    ->where('doc_tracking.status', 1)
                    ->groupBy('doc_tracking.id_track')
                    ->orderBy('doc_tracking.id_track', 'desc')
                    ->get();
        $getcontqty = DocTracking::select('*', 'doc_tracking.status', 'doc_tracking.id_track')
                    ->selectSub(function ($query) {
                        $query->selectRaw('SUM(qty_tonase)')
                            ->from('detail_tracking')
                            ->whereColumn('detail_tracking.id_track', 'doc_tracking.id_track')
                            ->where('detail_tracking.status', 1)
                            ->whereNotNull('no_container')
                            ->groupBy('detail_tracking.id_track');
                    }, 'total_qty_cont')
                    ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                    ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                    ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                    ->join('detail_tracking', 'detail_tracking.id_track', '=', 'doc_tracking.id_track')
                    ->where('doc_tracking.status', 1)
                    ->groupBy('doc_tracking.id_track')
                    ->orderBy('doc_tracking.id_track', 'desc')
                    ->get();                    
        $details = DocDooring::select('*', 'doc_dooring.status', 'doc_dooring.id_dooring')
                ->join('doc_tracking','doc_tracking.id_track','=','doc_dooring.id_track')
                ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                ->join('detail_dooring', 'detail_dooring.id_dooring', '=', 'doc_dooring.id_dooring')
                ->where('doc_dooring.status', 1)
                ->where('detail_dooring.status', 1)
                ->groupBy('doc_dooring.id_dooring')
                ->orderBy('doc_dooring.id_dooring', 'desc')
                ->count();
        // dd($details);
        $dtrack = DetailTracking::select('*')
                ->join('gudang_muats', 'gudang_muats.id_gudang', '=', 'detail_tracking.id_gudang')
                ->join('kapals', 'kapals.id', '=', 'detail_tracking.id_kapal')                
                ->where('detail_tracking.status', 1)
                ->orderBy('detail_tracking.id_detail_track', 'desc')
                ->get();    
        $lastcont = DetailTracking::where('status', 1)->whereNotNull('no_container')->latest()->first();
        $lastcurah = DetailDooring::where('status', 1)->where('tipe','Curah')->latest()->first();
        $zerocurah = DocDooring::select('*')
                    ->selectSub(function ($query) {
                        $query->selectRaw('SUM(qty_tonase)')
                            ->from('detail_tracking')
                            ->whereColumn('detail_tracking.id_track', 'doc_tracking.id_track')
                            ->where('detail_tracking.status', [2,3])
                            ->whereNull('no_container')
                            ->groupBy('detail_tracking.id_track');
                    }, 'qty_curah_tracking')
                    ->join('doc_tracking','doc_tracking.id_track','=','doc_dooring.id_track')
                    ->join('detail_tracking','detail_tracking.id_track','=','doc_dooring.id_track')
                    ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                    ->where('doc_dooring.status',1)
                    ->whereNull('detail_tracking.no_container')
                    ->groupBy('detail_tracking.no_container')
                    ->get();
        $estate = DocTracking::select('*')
                ->join('purchase_orders','purchase_orders.po_muat','=','doc_tracking.no_po')
                ->join('detail_p_h_s','detail_p_h_s.id_detail_ph','=','purchase_orders.id_detail_ph')
                ->join('penerimas','penerimas.id_penerima','=','detail_p_h_s.id_penerima')
                ->where('doc_tracking.status',[2,3])
                ->get();
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.dor', compact('title', 'breadcrumb','po','details','getcurahqty','getcontqty','track','doorzero','dtrack','lastcont','lastcurah','zerocurah','gudang','pol','pod','kapal','estate'));
    }

    public function getKapalDooring($id) {
        $kapal = Kapal::select('*')
                ->join('c_ports', 'c_ports.id_company_port', '=', 'kapals.id_company_port')
                ->join('detail_tracking','detail_tracking.id_kapal','=','kapals.id')
                ->where('kapals.status', 1)
                ->whereIn('detail_tracking.status',[2,3])
                ->where('detail_tracking.id_kapal',$id)
                ->groupBy('detail_tracking.id_kapal');
        $getdata = $kapal->get();
        return response()->json($getdata);
    }
    public function getPoDooring($id) {
        $query = DetailTracking::select('*')
                ->join('doc_tracking','doc_tracking.id_track','=','detail_tracking.id_track')
                ->join('port_of_destination','port_of_destination.id','=','doc_tracking.id_pod')
                ->join('port_of_loading','port_of_loading.id','=','doc_tracking.id_pol')
                ->join('purchase_orders','purchase_orders.po_muat','=','doc_tracking.no_po')
                ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                ->join('penawaran_hargas', 'penawaran_hargas.id_penawaran', '=', 'detail_p_h_s.id_penawaran')
                ->join('customers', 'customers.id', '=', 'penawaran_hargas.id_customer')
                ->join('penerimas', 'detail_p_h_s.id_penerima', '=', 'penerimas.id_penerima')
                ->join('pt_penerima', 'pt_penerima.id_pt_penerima', '=', 'penerimas.id_pt_penerima')
                ->join('barangs', 'purchase_orders.id', '=', 'barangs.id')
                ->whereIn('doc_tracking.status', [2, 3])
                ->where('doc_tracking.id_track', $id);
        $getdata = $query->get();
        return response()->json($getdata);
    }
    public function store(Request $request) {
        $request->validate([
            'file_bap' => 'required|mimes:jpeg,png,pdf|max:2048',
        ]);
        
        $file1 = $request->file('file_bap'); // Change variable name to $file1
        $fileName1 = time() . '_' . $file1->getClientOriginalName();
        
        Storage::disk('public')->putFileAs('uploads/dooring', $file1, $fileName1);
        
        $request->validate([
            'file_rekap' => 'required|mimes:jpeg,png,pdf|max:2048',
        ]);
        
        $file2 = $request->file('file_rekap'); // Change variable name to $file2
        $fileName2 = time() . '_' . $file2->getClientOriginalName();
        
        Storage::disk('public')->putFileAs('uploads/dooring', $file2, $fileName2);
        DocDooring::create([
            'id_track'     => $request->no_po,
            'sb_file_name'     => $fileName1,
            'sb_file_path'     => 'uploads/dooring' . $fileName1,
            'sr_file_name'     => $fileName2,
            'sr_file_path'     => 'uploads/dooring' . $fileName2,
            'status' => '1'
        ]);
        return redirect()->back();
    }    

    public function savecurah(Request $request){
        $request->validate([
            'file_notiket' => 'required|mimes:jpeg,png,pdf|max:2048',
        ]);
        
        $file1 = $request->file('file_notiket'); // Change variable name to $file1
        $fileName1 = time() . '_' . $file1->getClientOriginalName();
        
        Storage::disk('public')->putFileAs('uploads/dooring', $file1, $fileName1);
        //
        $request->validate([
            'file_nosj' => 'required|mimes:jpeg,png,pdf|max:2048',
        ]);
        
        $file2 = $request->file('file_nosj'); // Change variable name to $file2
        $fileName2 = time() . '_' . $file2->getClientOriginalName();
        
        Storage::disk('public')->putFileAs('uploads/dooring', $file2, $fileName2);
        
        DetailDooring::create([
            'id_dooring'=>$request->id_door, 
            'tgl_muat'=>$request->tgl_brkt,
            'tgl_tiba'=>$request->tgl_tiba,
            'nopol'     => $request->nopol,
            'qty_tonase'     => $request->qty_tonase,
            'qty_timbang'     => $request->qty_timbang,
            'jml_sak'     => $request->sak,
            'no_tiket'=>$request->notiket,
            'st_file_name'=>$fileName1,
            'st_file_path'=>'uploads/dooring'.$fileName1,
            'no_sj'=>$request->no_surat,
            'sj_file_name'=>$fileName2,
            'sj_file_path'=>'uploads/dooring'.$fileName2,
            'tipe'=>'Curah',
            'status'=> 1
        ]);

        $c = $request->qty_sisa_curah2;
        $b = $request->qty;            
        if ($c !== $b) {
            DetailDooringSisa::where('id_dooring', $request->id_door)
            ->where('tipe','Curah')->update([
                'qty_tonase_sisa' => $request->qty,
            ]);
        } else if($c === $b){
            DetailDooringSisa::create([
                'id_dooring'          => $request->id_door,
                'qty_tonase_sisa'   => $request->qty_sisa_curah,
                'qty_total_tonase'  => $request->qty_curah_total,
                'status'            => 1,
                'tipe'              => 'Curah'
            ]);
        }
        
        return redirect()->back();
    }
}
