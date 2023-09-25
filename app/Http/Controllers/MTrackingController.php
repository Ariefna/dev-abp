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
        $tbl_po = DocTracking::select('doc_tracking.no_po', 'purchase_orders.po_kebun', 
                'purchase_orders.total_qty', 'port_of_loading.nama_pol', 'port_of_destination.nama_pod',
                'detail_tracking.status', 'kapals.kode_kapal','kapals.nama_kapal','pt_penerima.nama_penerima',
                'gudang_muats.nama_gudang', 'barangs.nama_barang','purchase_orders.no_pl', 'detail_tracking.tgl_muat',
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
                ->where('doc_tracking.status', [2,3,4])
                ->get();
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.montracking', compact('title', 'breadcrumb','tbl_po',));
    }

    public function update(Request $request) {
        DetailTracking::where('id_track',$request->cb_po)
        ->update([
            'td' => $request->td,
            'td_jkt' => $request->td_jkt,
            'ta' => $request->ta
        ]);
        return redirect()->back();
    }
    
    public function print(Request $request, $id_detail_track)
    {
        $DetailTracking = DetailTracking::with([
                'docTracking.portOfLoading',
                'docTracking.portOfDestination',
                'docTracking.po.barang',
                'docTracking.po.detailPhs.penerima.ptPenerima',
                'kapal',
        ])->where('id_detail_track', $id_detail_track)->first();

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
                ->where('doc_tracking.status', [2,3,4])
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
