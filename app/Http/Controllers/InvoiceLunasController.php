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
use App\Models\DetailDooring;
use Illuminate\Http\Request;

class InvoiceLunasController extends Controller
{
    public function index()
    {
        $pomuat = DocTracking::select('*', 'doc_tracking.no_po')
            ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
            ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
            ->join('penawaran_hargas', 'penawaran_hargas.id_penawaran', '=', 'detail_p_h_s.id_penawaran')
            ->join('customers', 'customers.id', '=', 'penawaran_hargas.id_customer')
            ->join('penerimas', 'detail_p_h_s.id_penerima', '=', 'penerimas.id_penerima')
            ->join('pt_penerima', 'pt_penerima.id_pt_penerima', '=', 'penerimas.id_pt_penerima')
            ->join('barangs', 'purchase_orders.id', '=', 'barangs.id')
            ->where('doc_tracking.status', '=', 2)
            ->orWhere('doc_tracking.status', '=', 3)
            ->get();

            $docTrackingData = DocTracking::leftJoin('invoice_dp', 'invoice_dp.id_track', '=', 'doc_tracking.id_track')
    ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
    ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
    ->join('penawaran_hargas', 'penawaran_hargas.id_penawaran', '=', 'detail_p_h_s.id_penawaran')
    ->join('customers', 'customers.id', '=', 'penawaran_hargas.id_customer')
    ->join('penerimas', 'detail_p_h_s.id_penerima', '=', 'penerimas.id_penerima')
    ->join('pt_penerima', 'pt_penerima.id_pt_penerima', '=', 'penerimas.id_pt_penerima')
    ->join('barangs', 'purchase_orders.id', '=', 'barangs.id')
    ->where(function ($query) {
        $query->where('doc_tracking.status', 2)
            ->orWhere('doc_tracking.status', 3);
    })
    ->selectRaw('CASE WHEN doc_tracking.id_track = invoice_dp.id_track THEN 1 ELSE 2 END AS cb_tipe_inv')
    ->select('doc_tracking.no_po')
    ->get();

    // return response()->json($docTrackingData);

        $bank = Bank::where('status', '=', '1')
            ->get();
        $invdp = InvoicePelunasan::select('*', 'doc_tracking.no_po')
            ->join('doc_dooring', 'doc_dooring.id_dooring', '=', 'invoice_pelunasan.id_dooring')
            ->join('doc_tracking', 'doc_tracking.id_track', '=', 'doc_dooring.id_track')
            ->where('invoice_pelunasan.status', '=', '1')
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
        return view('pages.abp-page.ipel', compact('title', 'breadcrumb', 'pomuat', 'bank', 'invdp'));
    }
    
    // public function cbkapal($cb_kapal, Request $request)
    
    public function calculate($dooringId)
    {
        $details = DetailDooring::selectRaw('SUM(qty_tonase) as total_qty_tonase')
        ->selectRaw('SUM(qty_timbang) as total_qty_timbang')
        ->selectRaw('COALESCE(SUM(qty_timbang), 0) - COALESCE(SUM(qty_tonase), 0) as susut')
        ->selectRaw('COALESCE(SUM(qty_tonase), 0) - COALESCE(SUM(qty_timbang), 0) - COALESCE(SUM(qty_tonase), 0) as qty_tonase_real')
        ->where('id_dooring', $dooringId)
        ->first(); // You can use "get()" if you expect multiple rows
    
    // Access the calculated values with default 0
    $details->total_qty_tonase ?? 0;
    $details->total_qty_timbang ?? 0;
    $details->susut ?? 0;
    $details->qty_tonase_real ?? 0;
    return response()->json($details);

    }
    public function cbkapal($cb_kapal)
    {
        if ($cb_kapal == 1) {
            $details = DetailDooring::join('doc_dooring as b', 'detail_dooring.id_dooring', '=', 'b.id_dooring')
    ->join('doc_tracking as c', 'c.id_track', '=', 'b.id_track')
    ->select('c.no_po', 'detail_dooring.id_dooring')
    ->where('detail_dooring.tipe', 'Container')
    ->where('detail_dooring.status', 3)
    ->Groupby('c.no_po', 'detail_dooring.id_dooring')
    // ->where('b.id_track', $request->idtrack)
    ->get();
        }else {
            $details = DetailDooring::join('doc_dooring as b', 'detail_dooring.id_dooring', '=', 'b.id_dooring')
    ->join('doc_tracking as c', 'c.id_track', '=', 'b.id_track')
    ->select('c.no_po', 'detail_dooring.id_dooring')
    ->where('detail_dooring.tipe', 'Curah')
    ->where('detail_dooring.status', 3)
    ->Groupby('c.no_po', 'detail_dooring.id_dooring')
    // ->where('b.id_track', $request->idtrack)
    ->get();
        }
        return response()->json($details);
    }
    public function tipeinv($tipe_inv)
    {
        if ($tipe_inv == 1) {
            $data = DocTracking::select('id_track', 'no_po')->whereIn('id_track', function($query) {
                $query->select('id_track')->from('invoice_dp');
            })->get();
        }else {
            $data = DocTracking::select('id_track', 'no_po')->whereNotIn('id_track', function($query) {
                $query->select('id_track')->from('invoice_dp');
            })->get();
        }
        return response()->json($data);
    }

    public function getDetailPO($id_track)
    {
        $query = DocTracking::select('*', 'invoice_dp.id_track', 'doc_tracking.no_po')
            ->selectRaw('SUM(detail_tracking.qty_tonase) as total_muat')
            ->selectRaw("DATE_FORMAT(detail_tracking.tgl_muat, '%e-%M-%Y') as formatted_tgl_muat")
            // ->select('detail_tracking.tgl_muat')
            ->join('detail_tracking', 'doc_tracking.id_track', '=', 'detail_tracking.id_track')
            ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
            ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
            ->join('invoice_dp', 'invoice_dp.id_track', '=', 'doc_tracking.id_track')
            ->whereIn('doc_tracking.status', [2, 3])
            // ->whereRaw('CONCAT(doc_tracking.no_po, "-", DATE_FORMAT(detail_tracking.tgl_muat, "%e-%M-%Y")) = ?', [$id_track])
            ->whereRaw('CONCAT(doc_tracking.no_po, "(", DATE_FORMAT(detail_tracking.tgl_muat, "%e %M %Y"), ")") = ?', [$id_track])
            ->groupBy('doc_tracking.id_track', 'doc_tracking.no_po', 'formatted_tgl_muat');
        // ->havingRaw("formatted_tgl_muat = ?", [$tgl]);
        $getdata = $query->get();
        return response()->json($getdata);
    }

    public function store(Request $request)
    {
//         dd($request);        
//         $id_doc_tracking = $request->get('cb_po');
//         $DocDooring = DocDooring::with(
//             'invoiceDp',
//             'invoiceDp.detailInvoiceDp',
//         )
//             ->where('id_track', $id_doc_tracking)
//             ->firstOrFail();

//         $lastInvoiceDp = $DocDooring->invoiceDp->SortByDesc('id_invoice_dp')->first()->invoice_no;
//         $getCount = (int)explode('-', $lastInvoiceDp)[1];
//         $nextInvoiceNo = explode('-', $lastInvoiceDp)[0] . '-' . $getCount + 1;
// var_dump($DocDooring);die();
//         foreach ($DocDooring->invoiceDp as $key => $invoiceDp) {
//             $data = [
//                 'id_invoice_dp' => $DocDooring->invoiceDp[$key]->id_invoice_dp,
//                 'id_bank' => $DocDooring->invoiceDp[$key]->id_bank,
//                 'id_dooring' => $DocDooring->id_dooring,
//                 'invoice_date' => $DocDooring->invoiceDp[$key]->invoice_date,
//                 'invoice_no' => $nextInvoiceNo,
//                 'tipe_job' => $DocDooring->invoiceDp[$key]->tipe_job,
//                 'rinci_tipe' => $DocDooring->invoiceDp[$key]->rinci_tipe,
//                 'terms' => $DocDooring->invoiceDp[$key]->terms,
//                 'total_invoice' => $DocDooring->invoiceDp[$key]->total_invoice,
//                 'status' => 1,
//                 // 'status' => $DocDooring->invoiceDp[$key]->status,
//             ];

//             InvoicePelunasan::create($data);
//         }
if ($request->cb_tipe_inv == 1) {
    $invoices = InvoiceDp::where('id_track', $request->cb_po)->where('status', '=', '2')
    ->select('id_invoice_dp')
    ->first();
}

$iddooring = DocDooring::where('id_track', $request->cb_po)->where('status', '=', '3')
    ->select('id_dooring')
    ->first();
$currentYear = date('Y');
        $currentMonth = date('m');
        $cekrow = InvoiceDp::where('id_track', $request->cb_po)
    ->whereYear('invoice_date', $currentYear)->where('status', '=', '2')
    ->count() ?? 0;
        $newCounter = 1;    
        $newStatus = 1;
        if ($cekrow == 0) {
            $cekrow = InvoiceDp::whereYear('invoice_date', $currentYear)->where('status', '=', '2')->count() ?? 0;
            $newCounter = $cekrow<=1 ? $cekrow+1 : 1;
            $newInvoiceNumber = "ABP/{$currentYear}/{$currentMonth}/" .
                str_pad($newCounter, 4, '0', STR_PAD_LEFT) . '-' . $newStatus;
                InvoicePelunasan::create([
                'id_bank'     => $request->cb_bank,
                'id_track'     => $request->cb_po,
                'invoice_date'     => $request->tgl_inv_dp,
                'invoice_no' => $newInvoiceNumber,
                'tipe_job' => $request->cb_tipe,
                'rinci_tipe' => $request->cb_rinci,
                'terms' => $request->terms,
                'tipe_invoice'=>$request->cb_tipe_inv,
                'id_invoice_dp'=>$request->cb_tipe_inv==1?$invoices->id_invoice_dp:0,
                'id_dooring'=>$iddooring->id_dooring,
                'total_invoice' => 0,
                'status' => '1'
            ]);
            return redirect()->back();
        } else {
            $latestInvoice = InvoiceDP::whereYear('invoice_date', $currentYear)
                ->where('id_track', $request->cb_po)
                ->where('status', '=', '2')
                ->orderBy('id_invoice_dp', 'desc')
                ->first();

            if ($latestInvoice) {
                $parts = preg_split('/[-\/]/', $latestInvoice->invoice_no);
                $existingCounter = intval($parts[3]);
                $existingStatus = intval($parts[4]);
                $newCounter = $existingCounter;
                $a = 1;
                $newStatus = $existingStatus + 1;
            }
            $newInvoiceNumber = "ABP/{$currentYear}/{$currentMonth}/" .
                str_pad($newCounter, 4, '0', STR_PAD_LEFT) . '-' . $newStatus;
                InvoicePelunasan::create([
                'id_bank'     => $request->cb_bank,
                'id_track'     => $request->cb_po,
                'invoice_date'     => $request->tgl_inv_dp,
                'invoice_no' => $newInvoiceNumber,
                'tipe_job' => $request->cb_tipe,
                'rinci_tipe' => $request->cb_rinci,
                'terms' => $request->terms,
                'tipe_invoice'=>$request->cb_tipe_inv,
                'id_invoice_dp'=>$request->cb_tipe_inv==1?$invoices->id_invoice_dp:0,
                'total_invoice' => 0,
                'status' => '1'
            ]);
            return redirect()->back();
        }

        return redirect()->back();
    }
}
