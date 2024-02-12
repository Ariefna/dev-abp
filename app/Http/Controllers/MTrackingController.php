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
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class MTrackingController extends Controller
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
        $tbl_po = DocTracking::select('doc_tracking.no_po', 'purchase_orders.po_kebun', 'penerimas.estate',
                'purchase_orders.total_qty', 'port_of_loading.id as id_pol','port_of_loading.nama_pol','port_of_destination.id as id_pod', 'port_of_destination.nama_pod',
                'detail_tracking.status', 'kapals.id as id_kapal','kapals.kode_kapal','kapals.nama_kapal','pt_penerima.nama_penerima',
                'gudang_muats.nama_gudang', 'barangs.nama_barang','purchase_orders.no_pl', 'detail_tracking.tgl_muat',
                'purchase_orders.po_kebun','detail_tracking.qty_tonase', 'detail_tracking.qty_timbang','detail_tracking.jml_sak',
                'detail_tracking.nopol','detail_tracking.no_container','detail_tracking.voyage','detail_tracking.td','detail_tracking.td_jkt',
                'detail_tracking.ta','customers.nama_customer','doc_tracking.status_kapal',
                'doc_tracking.id_track', 'detail_tracking.id_detail_track','detail_tracking.track_file','detail_tracking.door_file'
                ,'detail_tracking.sj_file_name','detail_tracking.st_file_name', 'detail_tracking.harga_hpp', 'detail_tracking.no_sj')
                ->join('detail_tracking','detail_tracking.id_track','=','doc_tracking.id_track')
                ->join('gudang_muats', 'gudang_muats.id_gudang', '=', 'detail_tracking.id_gudang')
                ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                ->join('port_of_loading', 'port_of_loading.id', '=', 'detail_tracking.id_pol')
                ->join('port_of_destination', 'port_of_destination.id', '=', 'detail_tracking.id_pod')
                ->join('kapals', 'kapals.id', '=', 'detail_tracking.id_kapal')
                ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                ->join('penawaran_hargas', 'penawaran_hargas.id_penawaran', '=', 'detail_p_h_s.id_penawaran')
                ->join('customers', 'customers.id', '=', 'penawaran_hargas.id_customer')
                ->join('penerimas', 'detail_p_h_s.id_penerima', '=', 'penerimas.id_penerima')
                ->join('pt_penerima', 'pt_penerima.id_pt_penerima', '=', 'penerimas.id_pt_penerima')
                ->join('barangs', 'purchase_orders.id', '=', 'barangs.id')
                ->whereIn('doc_tracking.status', [2,3,4])
                ->whereIn('detail_tracking.status', [2,3,4])
                ->whereNotIn('purchase_orders.status',[0])
                ->get();
        $trackzero = DocTracking::select('*', 'doc_tracking.status', 'doc_tracking.id_track')
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
                ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                ->join('detail_tracking', 'detail_tracking.id_track', '=', 'doc_tracking.id_track')
                ->join('detail_tracking_sisa','detail_tracking_sisa.id_track','=','doc_tracking.id_track')
                ->where('doc_tracking.status', 1)
                ->whereIn('detail_tracking.status', [1,2,3])
                ->where('created_by',Session::get('id'))
                ->groupBy('doc_tracking.id_track')
                ->orderBy('doc_tracking.id_track', 'desc')
                ->get();
        $tracknull = DocTracking::select('*', 'doc_tracking.status', 'doc_tracking.id_track')
                ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                ->where('doc_tracking.status', 1)
                ->where('created_by',Session::get('id'))
                ->groupBy('doc_tracking.id_track')
                ->orderBy('doc_tracking.id_track', 'desc')
                ->get();
        $details = DocTracking::select('*', 'doc_tracking.status', 'doc_tracking.id_track')
                ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                ->join('detail_tracking', 'detail_tracking.id_track', '=', 'doc_tracking.id_track')
                ->where('doc_tracking.status', 1)
                ->where('detail_tracking.status', 1)
                ->where('created_by',Session::get('id'))
                ->groupBy('doc_tracking.id_track')
                ->orderBy('doc_tracking.id_track', 'desc')
                ->count();
        $lastcurah = DetailTracking::join('detail_tracking_sisa', 'detail_tracking_sisa.id_track', '=', 'detail_tracking.id_track')
                ->join('doc_tracking', 'doc_tracking.id_track', '=', 'detail_tracking.id_track')
                ->where('detail_tracking.status', 1)
                ->where('created_by',Session::get('id'))
                ->whereNull('detail_tracking.no_container')
                ->where('detail_tracking_sisa.tipe', 'Curah')
                ->first();
        $gudang = GudangMuat::where('status', 1)
                ->orderBy('id_gudang', 'desc')
                ->get();
        $kapal = Kapal::select('kapals.id', 'kapals.id_company_port', 'c_ports.nama', 'c_ports.no_telp', 'c_ports.alamat', 'kapals.kode_kapal', 'kapals.nama_kapal')
                ->join('c_ports', 'c_ports.id_company_port', '=', 'kapals.id_company_port')
                ->where('kapals.status', 1)
                ->get();  
        $pod = PortOfDestination::where('status', 1)
                ->orderBy('id', 'desc')
                ->get();
        $tracksisa = DetailTrackingSisa::select('detail_tracking_sisa.id_track', 'detail_tracking_sisa.tipe', 'detail_tracking_sisa.qty_tonase_sisa')
                ->join('doc_tracking', 'doc_tracking.id_track', '=', 'detail_tracking_sisa.id_track')
                ->where('doc_tracking.created_by', Session::get('id'))
                ->get();
        $getcurahqty = DocTracking::select('*', 'doc_tracking.status', 'doc_tracking.id_track')
                ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                ->join('detail_tracking', 'detail_tracking.id_track', '=', 'doc_tracking.id_track')
                ->join('detail_tracking_sisa','detail_tracking_sisa.id_track','=','doc_tracking.id_track')
                ->where('doc_tracking.status', 1)
                ->where('detail_tracking_sisa.tipe', 'Curah')
                ->where('created_by',Session::get('id'))
                ->groupBy('doc_tracking.id_track')
                ->orderBy('doc_tracking.id_track', 'desc')
                ->get();
        $selectpol = DocTracking::select('id_pol', 'id_track')->where('created_by',Session::get('id'))->get();
        $selectpod = DocTracking::select('id_pod','id_track')->where('created_by',Session::get('id'))->get();
        $zerocurah = DocTracking::select('*')
                    ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                    ->where('doc_tracking.status',1)
          			->whereNotIn('purchase_orders.status', [0])
                    ->where('created_by',Session::get('id'))
                    ->get();


        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.montracking', compact('title', 'breadcrumb','tbl_po','trackzero', 'tracknull', 'details','lastcurah','gudang','kapal','pod','tracksisa','getcurahqty','selectpol','selectpod','pol','zerocurah'));
    }

    public function getPoDate($id) {
        $tbl_po = DocTracking::select('doc_tracking.no_po','detail_tracking.td','detail_tracking.td_jkt',
                'detail_tracking.ta','doc_tracking.id_track', 'detail_tracking.id_detail_track',
                'detail_tracking.id_kapal','kapals.kode_kapal','kapals.nama_kapal','detail_tracking.voyage')
                ->join('detail_tracking','detail_tracking.id_track','=','doc_tracking.id_track')
                ->join('kapals','kapals.id','=','detail_tracking.id_kapal')
                ->whereIn('doc_tracking.status', [2,3,4])
                ->where('doc_tracking.id_track', $id)
                ->groupBy('detail_tracking.id_kapal','detail_tracking.voyage');
        $getdata = $tbl_po->get();
        return response()->json($getdata);
    }

    public function getPoKapal($id_track, $id, $voyage) {
        $tbl_po = DocTracking::select('doc_tracking.no_po','detail_tracking.td','detail_tracking.td_jkt',
                'detail_tracking.ta','doc_tracking.id_track', 'detail_tracking.id_detail_track',
                'detail_tracking.id_kapal','kapals.kode_kapal','kapals.nama_kapal','detail_tracking.voyage')
                ->join('detail_tracking','detail_tracking.id_track','=','doc_tracking.id_track')
                ->join('kapals','kapals.id','=','detail_tracking.id_kapal')
                ->whereIn('doc_tracking.status', [2,3,4])
                ->where('detail_tracking.id_kapal', $id)
                ->where('doc_tracking.id_track', $id_track)
                ->where(function ($query) use ($voyage) {
                        $query->where('detail_tracking.voyage', 'LIKE', '%' . $voyage . '%')
                        ->orWhereNull('detail_tracking.voyage');
                })
                ->groupBy('detail_tracking.id_kapal');
        $getdata = $tbl_po->get();
        return response()->json($getdata);
    }

    public function history() {
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
        $tbl_po = DocTracking::select('doc_tracking.no_po', 'purchase_orders.po_kebun', 
                'purchase_orders.total_qty', 'port_of_loading.nama_pol', 'port_of_destination.nama_pod',
                'detail_tracking.status','kapals.kode_kapal','kapals.nama_kapal','pt_penerima.nama_penerima',
                'gudang_muats.nama_gudang', 'gudang_muats.id_gudang', 'barangs.nama_barang','purchase_orders.no_pl', 'detail_tracking.tgl_muat',
                'purchase_orders.po_kebun','detail_tracking.qty_tonase', 'detail_tracking.qty_timbang','detail_tracking.jml_sak',
                'detail_tracking.nopol','detail_tracking.no_container','detail_tracking.voyage','detail_tracking.td','detail_tracking.td_jkt',
                'detail_tracking.ta','customers.nama_customer','doc_tracking.status_kapal','doc_tracking.id_track', 'detail_tracking.id_detail_track')
                ->join('detail_tracking','detail_tracking.id_track','=','doc_tracking.id_track')
                ->join('gudang_muats', 'gudang_muats.id_gudang', '=', 'detail_tracking.id_gudang')
                ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                ->join('kapals', 'kapals.id', '=', 'detail_tracking.id_kapal')
                ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                ->join('penawaran_hargas', 'penawaran_hargas.id_penawaran', '=', 'detail_p_h_s.id_penawaran')
                ->join('customers', 'customers.id', '=', 'penawaran_hargas.id_customer')
                ->join('penerimas', 'detail_p_h_s.id_penerima', '=', 'penerimas.id_penerima')
                ->join('pt_penerima', 'pt_penerima.id_pt_penerima', '=', 'penerimas.id_pt_penerima')
                ->join('barangs', 'purchase_orders.id', '=', 'barangs.id')
                ->whereIn('detail_tracking.status', [0])
                ->whereNotIn('purchase_orders.status',[0])
                ->get();
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.montrackhistory', compact('title', 'breadcrumb','tbl_po',));
    }

    public function update(Request $request) {
        try {
                $request->validate([
                        'file' => 'required|mimes:jpeg,png,pdf|max:10048',
                        'file2' => 'required|mimes:jpeg,png,pdf|max:10048',
                ]);                    
                $file = $request->file('file');
                $file2 = $request->file('file2');
                $fileName = time() . '-spk-tracking-' . $file->getClientOriginalName();
                $fileName2 = time() . '-spk-dooring-' . $file2->getClientOriginalName();
                Storage::disk('public')->putFileAs('uploads/tracking', $file, $fileName);
                Storage::disk('public')->putFileAs('uploads/tracking', $file2, $fileName2);
                list($id_kapal, $voyage) = explode('-', $request->input('cb_kpl'));
                // dd([
                //         $id_kapal,
                //         $voyage
                // ]);
                if ($voyage !== '') {
                        $query = DetailTracking::where('id_track', $request->cb_po)
                                ->where('id_kapal', $id_kapal)->where('voyage', $voyage);
                        $query->update([
                                'td' => $request->td,
                                'td_jkt' => $request->td_jkt,
                                'ta' => $request->ta,
                                'track_file'     => $fileName,
                                'track_path'     => 'uploads/tracking' . $fileName,
                                'door_file'     => $fileName2,
                                'door_path'     => 'uploads/tracking' . $fileName2,
                        ]);
                }elseif ($voyage == '') {
                        $query2 = DetailTracking::where('id_track', $request->cb_po)
                                ->where('id_kapal', $id_kapal);
                        $query2->update([
                                'td' => $request->td,
                                'td_jkt' => $request->td_jkt,
                                'ta' => $request->ta,
                                'track_file'     => $fileName,
                                'track_path'     => 'uploads/tracking' . $fileName,
                                'door_file'     => $fileName2,
                                'door_path'     => 'uploads/tracking' . $fileName2,
                        ]);                        
                }
                return redirect()->back();
            } catch (\Exception $e) {
            }
            
    }

    public function downloadspktrack($path) {
        // $filePath = 'public/uploads/tracking/' . $path;
        // if (Storage::exists($filePath)) {
        //     return Storage::download($filePath);
        // }
        // abort(404, 'File not found');
        $filePath = storage_path('app/public/uploads/tracking/' . $path);

        if (file_exists($filePath)) {
            $originalName = basename($path);
    
            $contentType = Storage::mimeType('public/uploads/tracking/' . $path);
    
            return response(file_get_contents($filePath))
                ->header('Content-Type', $contentType)
                ->header('Content-Disposition', 'inline; filename="' . $originalName . '"');
        }
    
        abort(404, 'File not found');
    }   
    
    public function print(Request $request, $id_detail_track)
    {
        $DetailTracking = DetailTracking::with([
                'docTracking.portOfLoading',
                'docTracking.portOfDestination',
                'docTracking.po.barang',
                'docTracking.po.detailPhs.penerima.ptPenerima',
                'kapal',
        ])->where('id_detail_track', $id_detail_track)
        ->whereNotIn('status',[0])
        ->first();

        $tbl_po = DocTracking::select('doc_tracking.no_po', 'purchase_orders.po_kebun', 
                'purchase_orders.total_qty', 'port_of_loading.nama_pol', 'port_of_destination.nama_pod',
                'detail_tracking.status', 'kapals.kode_kapal','kapals.nama_kapal','pt_penerima.nama_penerima',
                'gudang_muats.nama_gudang', 'barangs.nama_barang','purchase_orders.no_pl', 'detail_tracking.tgl_muat',
                'purchase_orders.po_kebun','detail_tracking.qty_tonase', 'detail_tracking.qty_timbang','detail_tracking.jml_sak',
                'detail_tracking.nopol','detail_tracking.no_container','detail_tracking.voyage','detail_tracking.td','detail_tracking.td_jkt',
                'detail_tracking.ta','customers.nama_customer','doc_tracking.status_kapal','doc_tracking.id_track',
                'detail_tracking.id_detail_track','penerimas.estate')
                ->join('detail_tracking','detail_tracking.id_track','=','doc_tracking.id_track')
                ->join('gudang_muats', 'gudang_muats.id_gudang', '=', 'detail_tracking.id_gudang')
                ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                ->join('kapals', 'kapals.id', '=', 'detail_tracking.id_kapal')
                ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                ->join('penawaran_hargas', 'penawaran_hargas.id_penawaran', '=', 'detail_p_h_s.id_penawaran')
                ->join('customers', 'customers.id', '=', 'penawaran_hargas.id_customer')
                ->join('penerimas', 'detail_p_h_s.id_penerima', '=', 'penerimas.id_penerima')
                ->join('pt_penerima', 'pt_penerima.id_pt_penerima', '=', 'penerimas.id_pt_penerima')
                ->join('barangs', 'purchase_orders.id', '=', 'barangs.id')
                ->whereIn('doc_tracking.status', [2,3,4])
                ->whereNotIn('detail_tracking.status',[0])
                ->whereNotIn('purchase_orders.status',[0])                
                ->where('doc_tracking.id_track', $DetailTracking->id_track)
                ->where('detail_tracking.id_kapal', $DetailTracking->id_kapal)
                ->get();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML(view('pages.abp-page.print.loading_report', compact('DetailTracking', 'tbl_po')));
        return $pdf->stream();
    }

    public function printSPK(Request $request, $id_detail_track)
    {
        $DetailTracking = DetailTracking::with([
                'docTracking.portOfLoading',
                'docTracking.portOfDestination',
                'docTracking.po.barang',
                'docTracking.po.detailPhs.penerima.ptPenerima',
                'kapal.cPort',
        ])->where('id_detail_track', $id_detail_track)->first();

        $DocTracking = DocTracking::with([
                'detailTrackingMultiple.kapal',
        ])->where('id_track', $DetailTracking->id_track)->first();

        $groupedData = $DocTracking->detailTrackingMultiple->groupBy(function ($query) use ($DetailTracking) {
                if ($query->id_kapal == $DetailTracking->id_kapal) {
                        return $query->id_kapal;
                }
        });

        $groupedData->transform(function ($group, $groupId) use ($DetailTracking) {
                $sum = $group->sum('qty_tonase'); 
                $trac = $group->first();
                $kapal = $group->first()->kapal;
                if ($trac->id_kapal == $DetailTracking->id_kapal) {
                        return [
                            'group' => $group,
                            'kapal' => "$kapal->kode_kapal $kapal->nama_kapal",
                            'qty_tonase' => $sum,
                        ];
                }
        });

        $totalSum = $groupedData->sum('qty_tonase');

        // set tanggal spk
        setlocale(LC_TIME, 'id_ID');
        $date = Carbon::parse($DetailTracking->tgl_muat);
        $taggal_spk = $date->formatLocalized('%d %B %Y');
        
        // set nomor spk
        $date = Carbon::parse($DetailTracking->tgl_muat);
        $month = $date->format('F');
        $romawi = formatMonthInRoman($month);
        $year = date('Y');
        $nomor = "$DetailTracking->id_track / ABP / SPK / $romawi / $year";

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML(view('pages.abp-page.print.spk', compact('DetailTracking','DocTracking','groupedData','taggal_spk','nomor','totalSum')));
        return $pdf->stream();
    }
}