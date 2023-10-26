<?php

namespace App\Http\Controllers;

use App\DetailInvoicePel as AppDetailInvoicePel;
use App\Models\DetailInvoicePel;
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
use App\Models\DetailDooring;
use Illuminate\Http\Request;
use App\Models\DetailInvoiceDP;
use Illuminate\Support\Facades\DB;

class InvoiceLunasController extends Controller
{
    public function approvetimbang(Request $request, $id_invoice_pel)
    {
        $total = DetailInvoicePel::join('invoice_pelunasan', 'invoice_pelunasan.id_invoice_pel', '=', 'detail_invoice_pel.id_invoice_pel')
            ->leftJoin('invoice_dp', 'invoice_pelunasan.id_invoice_dp', '=', 'invoice_dp.id_invoice_dp')
            ->where('detail_invoice_pel.id_invoice_pel', $id_invoice_pel)
            ->whereNotIn('detail_invoice_pel.status', [0])
            ->selectRaw('CASE 
                    WHEN invoice_pelunasan.id_invoice_dp != 0 
                        THEN (
                            CASE 
                                WHEN invoice_dp.id_invoice_dp = invoice_pelunasan.id_invoice_dp 
                                THEN (SUM(total_harga_timbang) - invoice_dp.total_invoice)
                                ELSE SUM(total_harga_timbang)
                            END
                        )
                    ELSE SUM(total_harga_timbang)
                    END AS total')
            ->first();
        if ($total) {
            $total = $total->total;
        } else {
            $total = 0; // Handle the case where no records match the criteria.
        }
        DetailInvoicePel::where('id_invoice_pel', $id_invoice_pel)->whereNotIn('detail_invoice_pel.status', [0])
            ->update([
                'status' => '2',
            ]);
        InvoicePelunasan::where('id_invoice_pel', $id_invoice_pel)->update([
            'status' => '2',
            'total_invoice' => $total
        ]);
        return redirect()->back();
    }
    public function approvedooring(Request $request, $id_invoice_pel)
    {
        $total = DetailInvoicePel::join('invoice_pelunasan', 'invoice_pelunasan.id_invoice_pel', '=', 'detail_invoice_pel.id_invoice_pel')
            ->leftJoin('invoice_dp', 'invoice_pelunasan.id_invoice_dp', '=', 'invoice_dp.id_invoice_dp')
            ->where('detail_invoice_pel.id_invoice_pel', $id_invoice_pel)
            ->whereNotIn('detail_invoice_pel.status', [0])
            ->selectRaw('CASE 
                    WHEN invoice_pelunasan.id_invoice_dp != 0 
                        THEN (
                            CASE 
                                WHEN invoice_dp.id_invoice_dp = invoice_pelunasan.id_invoice_dp 
                                THEN (SUM(total_harga_dooring) - invoice_dp.total_invoice)
                                ELSE SUM(total_harga_dooring)
                            END
                        )
                    ELSE SUM(total_harga_dooring)
                    END AS total')
            ->first();
        if ($total) {
            $total = $total->total;
        } else {
            $total = 0; // Handle the case where no records match the criteria.
        }
        DetailInvoicePel::where('id_invoice_pel', $id_invoice_pel)->whereNotIn('detail_invoice_pel.status', [0])
            ->update([
                'status' => '3',
            ]);
        InvoicePelunasan::where('id_invoice_pel', $id_invoice_pel)->update([
            'status' => '3',
            'total_invoice' => $total
        ]);
        return redirect()->back();
    }

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
        $invdp = InvoicePelunasan::select('*', 'doc_tracking.no_po', 'invoice_pelunasan.status')
            ->join('doc_dooring', 'doc_dooring.id_dooring', '=', 'invoice_pelunasan.id_dooring')
            ->join('doc_tracking', 'doc_tracking.id_track', '=', 'doc_dooring.id_track')
            ->whereIn('invoice_pelunasan.status', [1, 2, 3])
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
        $datadetailInvoicePel = DetailInvoicePel::whereIn('detail_invoice_pel.status', [1, 2, 3])
            ->join('invoice_pelunasan', 'invoice_pelunasan.id_invoice_pel', '=', 'detail_invoice_pel.id_invoice_pel')
            ->leftJoin('invoice_dp', 'invoice_dp.id_invoice_dp', '=', 'invoice_pelunasan.id_invoice_dp')
            ->select('*', 'invoice_dp.total_invoice', 'detail_invoice_pel.status')
            ->selectRaw('CASE WHEN invoice_dp.id_invoice_dp != invoice_pelunasan.id_invoice_dp THEN 0 ELSE invoice_dp.total_invoice END AS total_invoice_adjusted')
            ->get();
        // dd($datadetailInvoicePel);
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.ipel', compact('title', 'breadcrumb', 'pomuat', 'bank', 'invdp', 'datadetailInvoicePel'));
    }

    public function detail($id)
    {
        $datadetail = DetailInvoicePel::where('id_invoice_pel', $id)->get();
        return response()->json($datadetail);
    }

    public function deletedetail($id)
    {
        DetailInvoicePel::where('id_detail_pel', $id)->update([
            'status' => '0'
        ]);
        return redirect()->back();
    }
    public function delete($id)
    {
        InvoicePelunasan::where('id_invoice_pel', $id)->update([
            'status' => '0'
        ]);
        DetailInvoicePel::where('id_invoice_pel', $id)->update([
            'status' => '0'
        ]);
        return redirect()->back();
    }
    public function detailstore(Request $request)
    {
        $purchase = DB::table('purchase_orders as po')
            ->select('dd.id_dooring', 'dt.id_track', 'po.id_po', 'dphs.oa_kpl_kayu', 'dphs.oa_container')
            ->join('detail_p_h_s as dphs', 'po.id_detail_ph', '=', 'dphs.id_detail_ph')
            ->join('doc_tracking as dt', 'dt.no_po', '=', 'po.po_muat')
            ->join('doc_dooring as dd', 'dd.id_track', '=', 'dt.id_track')
            ->where('dd.id_dooring', $request->cb_bypo)
            ->first();
        $doring = DetailDooring::where('id_detail_door', $request->cb_bypo)->value('estate');
        DetailInvoicePel::create([
            'id_invoice_pel' => $request->idInvoicePel,
            'estate' => $doring,
            'total_tonase_dooring' => $request->ttdb,
            'total_tonase_timbang' => $request->tttd,
            'total_harga_dooring' => $request->TotalHargaDooring,
            'total_harga_timbang' => $request->TotalHargaTimbangDooring,
            'total_harga_real' => 0,
            'harga_brg' => $request->hrg_freight,
            'prosentase_ppn' => $request->prosentaseppn,
            'total_ppn_dooring' => $request->totalppndoring,
            'total_ppn_timbang' => $request->totalppntimbang,
            'tipe' => $request->cb_kapal,
            'status' => 1,
        ]);
        return redirect()->back();
    }
    public function calculate($dooringId, Request $request)
    {
        if ($request->cbkapal == 1) {
            $jenis = 'Container';
        } else {
            $jenis = 'Curah';
        }
        $details = DB::table('doc_tracking')
            ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
            ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
            ->join('doc_dooring', 'doc_dooring.id_track', '=', 'doc_tracking.id_track')
            ->join('detail_dooring', 'detail_dooring.id_dooring', '=', 'doc_dooring.id_dooring')
            ->select(
                DB::raw("CONCAT(doc_tracking.no_po, ' (', detail_dooring.estate, ')') as po_muat_estate"),
                'detail_dooring.estate',
                'detail_dooring.tipe',
                DB::raw("SUM(detail_dooring.qty_tonase) as total_qty_tonase"),
                DB::raw("SUM(detail_dooring.qty_timbang) as total_qty_timbang"),
                'detail_p_h_s.oa_container as susut',
                DB::raw("(detail_p_h_s.oa_container * SUM(detail_dooring.qty_tonase)) as hrg_tonase"),
                DB::raw("(detail_p_h_s.oa_container * SUM(detail_dooring.qty_timbang)) as hrg_timbang"),
                DB::raw("CASE 
            WHEN '$jenis' = 'Container' 
                THEN detail_p_h_s.oa_container
            ELSE detail_p_h_s.oa_kpl_kayu
        END AS hrg_frg")
            )
            ->where('detail_dooring.tipe', $jenis)
            ->whereIn('doc_dooring.status', [2, 3])
            ->whereIn('detail_dooring.status', [2, 3])
            ->where('detail_dooring.id_dooring', $dooringId)
            ->where('detail_dooring.estate', '=', 'MCMR2')
            ->groupBy('detail_dooring.estate', 'doc_tracking.no_po', 'detail_dooring.tipe')
            ->first();


        // Access the calculated values with default 0
        $details->total_qty_tonase ?? 0;
        $details->total_qty_timbang ?? 0;
        $details->susut ?? 0;
        return response()->json($details);
    }
    public function cbkapal($cb_kapal, Request $request)
    {
        if ($cb_kapal == 1) {
            $details = DetailDooring::join('doc_dooring as b', 'detail_dooring.id_dooring', '=', 'b.id_dooring')
                ->join('doc_tracking as c', 'c.id_track', '=', 'b.id_track')
                ->selectRaw("CONCAT(c.no_po, ' (', detail_dooring.estate, ')') as no_po, detail_dooring.id_dooring, detail_dooring.id_detail_door, detail_dooring.estate")
                ->where('detail_dooring.tipe', 'Container')
                ->where('detail_dooring.status', 3)
                ->where('b.id_track', $request->idtrack)
                ->groupBy('c.no_po', 'detail_dooring.estate', 'detail_dooring.tipe')
                ->get();
        } else {
            $details = DetailDooring::join('doc_dooring as b', 'detail_dooring.id_dooring', '=', 'b.id_dooring')
                ->join('doc_tracking as c', 'c.id_track', '=', 'b.id_track')
                ->selectRaw("CONCAT(c.no_po, ' (', detail_dooring.estate, ')') as no_po, detail_dooring.id_dooring, detail_dooring.id_detail_door, detail_dooring.estate")
                ->where('detail_dooring.tipe', 'Curah')
                ->where('detail_dooring.status', 3)
                ->where('b.id_track', $request->idtrack)
                ->groupBy('c.no_po', 'detail_dooring.estate', 'detail_dooring.tipe')
                ->get();
        }
        return response()->json($details);
    }
    public function tipeinv($tipe_inv)
    {
        if ($tipe_inv == 1) {
            $data = DB::table('doc_tracking as a')
                ->join('doc_dooring as b', 'a.id_track', '=', 'b.id_track')
                ->where('a.status', 3)
                ->where('b.status', 3)
                ->whereIn('a.id_track', function ($query) {
                    $query->select('id_track')->from('invoice_dp');
                })
                ->get();
        } else {
            $data = DocTracking::select('id_dooring', 'no_po')
                ->join('doc_dooring', 'doc_dooring.id_track', '=', 'doc_tracking.id_track')
                ->where('doc_tracking.status', 3)
                ->where('doc_dooring.status', 3)
                ->whereNotIn('doc_tracking.id_track', function ($query) {
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
        $invoices = InvoiceDp::join('doc_dooring', 'doc_dooring.id_track', '=', 'invoice_dp.id_track')
            ->where('id_dooring', $request->cb_po)->where('invoice_dp.status', '=', '2')
            ->select('invoice_dp.id_invoice_dp', 'invoice_dp.id_track')
            ->first();
        $iddooring = $request->cb_po;
        $currentYear = date('Y');
        $currentMonth = date('m');
        $cekrow = InvoiceDp::join('doc_dooring', 'doc_dooring.id_track', '=', 'invoice_dp.id_track')->where('id_dooring', $request->cb_po)->where('invoice_dp.status', '=', 2)->whereYear('invoice_date', $currentYear)->count();
        $newCounter = 1;
        $newStatus = 1;
        if ($cekrow == 0) {
            $cekrow = InvoiceDp::whereYear('invoice_date', $currentYear)->where('status', '=', '2')->count() ?? 0;
            $newCounter = $cekrow <= 1 ? $cekrow + 1 : 1;
            $newInvoiceNumber = "ABP/{$currentYear}/{$currentMonth}/" .
                str_pad($newCounter, 4, '0', STR_PAD_LEFT) . '-' . $newStatus;
            // die($newInvoiceNumber);
            InvoicePelunasan::create([
                'id_bank'     => $request->cb_bank,
                'id_track'     => $invoices->id_track ?? 0,
                'invoice_date'     => $request->tgl_inv_dp,
                'invoice_no' => $newInvoiceNumber,
                'tipe_job' => $request->cb_tipe,
                'rinci_tipe' => $request->cb_rinci,
                'terms' => $request->terms,
                'tipe_invoice' => $request->cb_tipe_inv,
                'id_invoice_dp' => $request->cb_tipe_inv == 1 ? $invoices->id_invoice_dp : 0,
                'id_dooring' => $iddooring,
                'total_invoice' => 0,
                'status' => '1'
            ]);
            return redirect()->back();
        } else {
            $latestInvoice = InvoiceDP::whereYear('invoice_date', $currentYear)
                ->where('id_track', $invoices->id_track)
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
                'id_track'     => $invoices->id_track,
                'invoice_date'     => $request->tgl_inv_dp,
                'invoice_no' => $newInvoiceNumber,
                'tipe_job' => $request->cb_tipe,
                'rinci_tipe' => $request->cb_rinci,
                'terms' => $request->terms,
                'tipe_invoice' => $request->cb_tipe_inv,
                'id_invoice_dp' => $request->cb_tipe_inv == 1 ? $invoices->id_invoice_dp : 0,
                'id_dooring' => $iddooring,
                'total_invoice' => 0,
                'status' => '1'
            ]);
            return redirect()->back();
        }

        return redirect()->back();
    }
}
