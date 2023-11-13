<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DocTracking;
use App\Models\DocDooring;
use App\Models\InvoiceDP;
use App\Models\InvoicePelunasan;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        $tbl_po = DocTracking::select('doc_tracking.no_po', 'purchase_orders.po_kebun', 
                'purchase_orders.total_qty', 'port_of_loading.nama_pol', 'port_of_destination.nama_pod',
                'detail_tracking.status', 'kapals.kode_kapal','kapals.nama_kapal','pt_penerima.nama_penerima',
                'gudang_muats.nama_gudang', 'barangs.nama_barang','purchase_orders.no_pl', 'detail_tracking.tgl_muat',
                'purchase_orders.po_kebun','detail_tracking_sisa.qty_tonase_sisa', 'detail_tracking.qty_timbang','detail_tracking.jml_sak',
                'detail_tracking.nopol','detail_tracking.no_container','detail_tracking.voyage','detail_tracking.td','detail_tracking.td_jkt',
                'detail_tracking.ta','customers.nama_customer','doc_tracking.status_kapal','detail_tracking_sisa.tipe')
                ->selectSub(function ($query) {
                    $query->selectRaw('SUM(qty_tonase_sisa)')
                        ->from('detail_tracking_sisa')
                        ->whereColumn('detail_tracking_sisa.id_track', 'doc_tracking.id_track')
                        ->groupBy('detail_tracking_sisa.id_track');
                }, 'qty_sisa')
                ->join('detail_tracking','detail_tracking.id_track','=','doc_tracking.id_track')
                ->join('detail_tracking_sisa','detail_tracking_sisa.id_track','=','doc_tracking.id_track')
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
                ->whereIn('doc_tracking.status', [1,2,3])
                ->orderBy('doc_tracking.no_po')
                ->groupBy('detail_tracking_sisa.id_track')
                ->get();
        $tbl_dor = DocDooring::select('doc_dooring.id_dooring','doc_tracking.no_po', 'purchase_orders.po_kebun', 
                'purchase_orders.total_qty', 'port_of_loading.nama_pol', 'port_of_destination.nama_pod',
                'detail_tracking.status', 'kapals.kode_kapal','kapals.nama_kapal','pt_penerima.nama_penerima',
                'gudang_muats.nama_gudang', 'barangs.nama_barang','purchase_orders.no_pl', 'detail_tracking.tgl_muat',
                'purchase_orders.po_kebun','detail_dooring_sisa.qty_tonase_sisa', 'detail_tracking.qty_timbang','detail_tracking.jml_sak',
                'detail_tracking.nopol','detail_tracking.no_container','detail_tracking.voyage','detail_tracking.td','detail_tracking.td_jkt',
                'detail_tracking.ta','customers.nama_customer','doc_tracking.status_kapal','detail_dooring_sisa.tipe')
                ->selectSub(function ($query) {
                    $query->selectRaw('SUM(qty_tonase_sisa)')
                        ->from('detail_dooring_sisa')
                        ->whereColumn('detail_dooring_sisa.id_dooring', 'doc_dooring.id_dooring')
                        ->groupBy('detail_dooring_sisa.id_dooring');
                }, 'qty_sisa')
                ->join('doc_tracking','doc_tracking.id_track','=','doc_dooring.id_track')
                ->join('detail_tracking','detail_tracking.id_track','=','doc_tracking.id_track')
                ->join('detail_dooring_sisa','detail_dooring_sisa.id_dooring','=','doc_dooring.id_dooring')
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
                ->whereIn('doc_dooring.status', [1,2,3])
                ->orderBy('doc_tracking.no_po')
                ->groupBy('detail_dooring_sisa.id_dooring')
                ->get();                
        $currentMonth = Carbon::now()->month;
        $datagrafik = [];
        // $totaldp = InvoiceDp::where('status', 2)->whereYear('invoice_date', $currentYear)->sum('total_invoice');
        // $totalpel = InvoicePelunasan::whereIn('status', [2,3])->whereYear('invoice_date', $currentYear)->sum('total_invoice');
        // $totalpo = PurchaseOrder::whereIn('status',[2])->sum('total_all');
        $totaldp = InvoiceDp::where('status', 2)->whereMonth('invoice_date', $currentMonth)->sum('total_invoice');
        $totalpel = InvoicePelunasan::whereIn('status', [2,3])->whereMonth('invoice_date', $currentMonth)->sum('total_invoice');
        $totalpo = PurchaseOrder::whereIn('status',[2])->whereMonth('tgl', $currentMonth)->sum('total_all');        

        for ($i = 0; $i < 10; $i++) {
            $year = $currentYear + $i;
            
            $dp = InvoiceDp::where('status', 2)->whereYear('invoice_date', $year)->sum('total_invoice');
            $pel = InvoicePelunasan::whereIn('status', [2,3])->whereYear('invoice_date', $year)->sum('total_invoice');
            
            $datagrafik[$year] = $dp + $pel;
        }
        // dd($datagrafik);
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.dashboard.analytics', compact('title', 'breadcrumb',
        'tbl_po','tbl_dor','totaldp','totalpel','datagrafik','totalpo'));        
    }

    public function addsisatrack(Request $request, $no_po) {
        DocTracking::where('no_po', $no_po)->update([
            'status' => '1'
        ]);
        // return redirect()->back();
        return redirect()->route('tracking.index');
    }

    public function addsisadoor(Request $request, $id_dooring) {
        DocDooring::where('id_dooring', $id_dooring)->update([
            'status' => '1'
        ]);
        // return redirect()->back();
        return redirect()->route('dooring.index');
    }
}
