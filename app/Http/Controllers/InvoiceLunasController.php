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
use App\Models\DocDooring;
use App\Models\DetailTracking;
use App\Models\DetailTrackingSisa;
use App\Models\InvoiceDP;
use App\Models\InvoicePelunasan;
use App\Models\Bank;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;

class InvoiceLunasController extends Controller
{
    public function index() {
        $pomuat = DocTracking::select('*','doc_tracking.no_po')
                ->join('purchase_orders','purchase_orders.po_muat','=','doc_tracking.no_po')
                ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                ->join('penawaran_hargas', 'penawaran_hargas.id_penawaran', '=', 'detail_p_h_s.id_penawaran')
                ->join('customers', 'customers.id', '=', 'penawaran_hargas.id_customer')
                ->join('penerimas', 'detail_p_h_s.id_penerima', '=', 'penerimas.id_penerima')
                ->join('pt_penerima', 'pt_penerima.id_pt_penerima', '=', 'penerimas.id_pt_penerima')
                ->join('barangs', 'purchase_orders.id', '=', 'barangs.id')
                ->where('doc_tracking.status', '=', 2)
                ->orWhere('doc_tracking.status', '=', 3)
                ->get();
        $bank = Bank::where('status','=','1')
                ->get();
        $invdp = InvoicePelunasan::select('*','doc_tracking.no_po')
                ->join('doc_dooring','doc_dooring.id_dooring','=','invoice_pelunasan.id_dooring')
                ->join('doc_tracking','doc_tracking.id_track','=','doc_dooring.id_track')
                ->where('invoice_pelunasan.status','=','1')
                ->get();
        // $totalmuat = DocTracking::select('*','doc_tracking.id_track', 'doc_tracking.no_po')
        //         ->selectRaw('SUM(detail_tracking.qty_tonase) as total_muat')
        //         ->select('detail_tracking.tgl_muat')
        //         ->join('detail_tracking', 'doc_tracking.id_track', '=', 'detail_tracking.id_track')
        //         ->join('purchase_orders','purchase_orders.po_muat','=','doc_tracking.no_po')
        //         ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
        //         ->whereIn('doc_tracking.status', [2, 3])
        //         ->groupBy('detail_tracking.tgl_muat')
        //         ->get();
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.ipel', compact('title', 'breadcrumb','pomuat','bank','invdp'));
    }

    public function getOptionsPO($id_track) {
        $query = DocTracking::select('*','invoice_dp.id_track', 'doc_tracking.no_po')
                ->selectRaw('SUM(detail_tracking.qty_tonase) as total_muat')
                ->selectRaw("DATE_FORMAT(detail_tracking.tgl_muat, '%e %M %Y') as formatted_tgl_muat")
                // ->select('detail_tracking.tgl_muat')
                ->join('detail_tracking', 'doc_tracking.id_track', '=', 'detail_tracking.id_track')
                ->join('purchase_orders','purchase_orders.po_muat','=','doc_tracking.no_po')
                ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                ->join('invoice_dp','invoice_dp.id_track','=','doc_tracking.id_track')
                ->where('invoice_dp.id_track',$id_track)
                ->whereIn('doc_tracking.status', [2, 3])
                ->groupBy('detail_tracking.tgl_muat');
        $getdata = $query->get();
        return response()->json($getdata);
    }

    public function getDetailPO($id_track) {
        $query = DocTracking::select('*','invoice_dp.id_track', 'doc_tracking.no_po')
                ->selectRaw('SUM(detail_tracking.qty_tonase) as total_muat')
                ->selectRaw("DATE_FORMAT(detail_tracking.tgl_muat, '%e-%M-%Y') as formatted_tgl_muat")
                // ->select('detail_tracking.tgl_muat')
                ->join('detail_tracking', 'doc_tracking.id_track', '=', 'detail_tracking.id_track')
                ->join('purchase_orders','purchase_orders.po_muat','=','doc_tracking.no_po')
                ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                ->join('invoice_dp','invoice_dp.id_track','=','doc_tracking.id_track')
                ->whereIn('doc_tracking.status', [2, 3])
                // ->whereRaw('CONCAT(doc_tracking.no_po, "-", DATE_FORMAT(detail_tracking.tgl_muat, "%e-%M-%Y")) = ?', [$id_track])
                ->whereRaw('CONCAT(doc_tracking.no_po, "(", DATE_FORMAT(detail_tracking.tgl_muat, "%e %M %Y"), ")") = ?', [$id_track])
                ->groupBy('doc_tracking.id_track', 'doc_tracking.no_po', 'formatted_tgl_muat');
                // ->havingRaw("formatted_tgl_muat = ?", [$tgl]);
        $getdata = $query->get();
        return response()->json($getdata);
    }

    public function store(Request $request) {
        $id_doc_tracking = $request->get('cb_po');
        $DocDooring = DocDooring::with(
            'invoiceDp',
            'invoiceDp.detailInvoiceDp',
        )
        ->where('id_track', $id_doc_tracking)
        ->firstOrFail();

        $lastInvoiceDp = $DocDooring->invoiceDp->SortByDesc('id_invoice_dp')->first()->invoice_no;
        $getCount = (int)explode('-', $lastInvoiceDp)[1];
        $nextInvoiceNo = explode('-', $lastInvoiceDp)[0].'-'.$getCount + 1;

        foreach ($DocDooring->invoiceDp as $key => $invoiceDp) {
            $data = [
                'id_invoice_dp' => $DocDooring->invoiceDp[$key]->id_invoice_dp,
                'id_bank' => $DocDooring->invoiceDp[$key]->id_bank,
                'id_dooring' => $DocDooring->id_dooring,
                'invoice_date' => $DocDooring->invoiceDp[$key]->invoice_date,
                'invoice_no' => $nextInvoiceNo,
                'tipe_job' => $DocDooring->invoiceDp[$key]->tipe_job,
                'rinci_tipe' => $DocDooring->invoiceDp[$key]->rinci_tipe,
                'terms' => $DocDooring->invoiceDp[$key]->terms,
                'total_invoice' => $DocDooring->invoiceDp[$key]->total_invoice,
                'status' => 1,
                // 'status' => $DocDooring->invoiceDp[$key]->status,
            ];

            InvoicePelunasan::create($data);
        }

        return redirect()->back();
    }
}
