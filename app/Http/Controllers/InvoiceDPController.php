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
use App\Models\InvoiceDP;
use App\Models\DetailInvoiceDP;
use App\Models\Bank;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;

class InvoiceDPController extends Controller
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
        $invdp = InvoiceDP::select('*','invoice_dp.status')
                ->join('doc_tracking','doc_tracking.id_track','=','invoice_dp.id_track')
                ->get();
        // dd ($invdp);                
        // $totalmuat = DocTracking::select('*','doc_tracking.id_track', 'doc_tracking.no_po')
        //         ->selectRaw('SUM(detail_tracking.qty_tonase) as total_muat')
        //         ->select('detail_tracking.tgl_muat')
        //         ->join('detail_tracking', 'doc_tracking.id_track', '=', 'detail_tracking.id_track')
        //         ->join('purchase_orders','purchase_orders.po_muat','=','doc_tracking.no_po')
        //         ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
        //         ->whereIn('doc_tracking.status', [2, 3])
        //         ->groupBy('detail_tracking.tgl_muat')
        //         ->get();
        $getval = DocTracking::select('detail_tracking.tgl_muat','invoice_dp.id_track', 'doc_tracking.no_po','detail_tracking.tgl_muat')
                ->selectRaw('SUM(detail_tracking.qty_tonase) as total_muat')
                ->selectRaw("DATE_FORMAT(detail_tracking.tgl_muat, '%e-%M-%Y') as formatted_tgl_muat")
                ->join('detail_tracking', 'doc_tracking.id_track', '=', 'detail_tracking.id_track')
                ->join('purchase_orders','purchase_orders.po_muat','=','doc_tracking.no_po')
                ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                ->join('invoice_dp','invoice_dp.id_track','=','doc_tracking.id_track')
                ->whereNull('detail_tracking.no_container')
                ->whereIn('doc_tracking.status', [2, 3])
                ->groupBy('doc_tracking.no_po')
                ->get();
        // dd ($getval);
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.idp', compact('title', 'breadcrumb','pomuat','bank','invdp','getval'));
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
                ->join('detail_tracking', 'doc_tracking.id_track', '=', 'detail_tracking.id_track')
                ->join('purchase_orders','purchase_orders.po_muat','=','doc_tracking.no_po')
                ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                ->join('invoice_dp','invoice_dp.id_track','=','doc_tracking.id_track')
                ->whereNull('detail_tracking.no_container')
                ->whereIn('doc_tracking.status', [2, 3])
                ->whereRaw('CONCAT(doc_tracking.no_po, "(", DATE_FORMAT(detail_tracking.tgl_muat, "%e-%M-%Y"), ")") = ?', [$id_track])
                ->groupBy('doc_tracking.id_track', 'doc_tracking.no_po', 'formatted_tgl_muat');
                // ->havingRaw("formatted_tgl_muat = ?", [$tgl]);
        // dd ([
        //         '$countersisa' => $query ,
        //     ]);
        $getdata = $query->get();
        return response()->json($getdata);
    }



    public function generate() {
        $currentYear = date('Y');
        $currentMonth = date('m');
    
        $latestInvoice = InvoiceDP::whereYear('invoice_date', $currentYear)
            ->whereMonth('invoice_date', $currentMonth)
            ->orderBy('id_invoice_dp', 'desc')
            ->first();

        $newCounter = 1;
        $newStatus = 1;
    
        if ($latestInvoice) {
            $parts = preg_split('/[-\/]/', $latestInvoice->invoice_no);
            $existingCounter = intval($parts[3]);
            $existingStatus = intval($parts[4]);
            if ($latestInvoice->status == 2) {
                $newCounter = $existingCounter + 1;
                $a = 1;
            } elseif ($latestInvoice->status == 1) {
                $newStatus = $existingStatus + 1;
                $a = 2;
            }
        }
        $newInvoiceNumber = "ABP/{$currentYear}/{$currentMonth}/" .
            str_pad($newCounter, 4, '0', STR_PAD_LEFT) . '-' . $newStatus;
    
        echo $newInvoiceNumber;
    }

    public function approve(Request $request, $id_invoic_dp) {
        InvoiceDP::where('id_invoice_dp', $id_invoic_dp)->update([
            'status' => '2'
        ]);
        return redirect()->back();
    }

    public function store(Request $request) {
        $currentYear = date('Y');
        $currentMonth = date('m');
        $cekrow = InvoiceDP::select('*')->count();
        $newCounter = 1;
        $newStatus = 1;
        if ($cekrow == 0) {
            $newInvoiceNumber = "ABP/{$currentYear}/{$currentMonth}/" .
            str_pad($newCounter, 4, '0', STR_PAD_LEFT) . '-' . $newStatus;
            InvoiceDP::create([
                'id_bank'     => $request->cb_bank,
                'id_track'     => $request->cb_po,
                'invoice_date'     => $request->tgl_inv_dp,
                'invoice_no' => $newInvoiceNumber,
                'tipe_job' => $request->cb_tipe,
                'rinci_tipe'=>$request->cb_rinci,
                'terms' => $request->terms,
                'total_invoice' => 0,
                'status' => '1'
            ]);
            return redirect()->back();
        }else{
            $latestInvoice = InvoiceDP::whereYear('invoice_date', $currentYear)
                ->whereMonth('invoice_date', $currentMonth)
                ->orderBy('id_invoice_dp', 'desc')
                ->first();
        
            if ($latestInvoice) {
                $parts = preg_split('/[-\/]/', $latestInvoice->invoice_no);
                $existingCounter = intval($parts[3]);
                $existingStatus = intval($parts[4]);
                if ($latestInvoice->status == 2) {
                    $newCounter = $existingCounter + 1;
                    $a = 1;
                } elseif ($latestInvoice->status == 1) {
                    $newStatus = $existingStatus + 1;
                    $a = 2;
                }
            }
            $newInvoiceNumber = "ABP/{$currentYear}/{$currentMonth}/" .
                str_pad($newCounter, 4, '0', STR_PAD_LEFT) . '-' . $newStatus;            
            
                InvoiceDP::create([
                    'id_bank'     => $request->cb_bank,
                    'id_track'     => $request->cb_po,
                    'invoice_date'     => $request->tgl_inv_dp,
                    'invoice_no' => $newInvoiceNumber,
                    'tipe_job' => $request->cb_tipe,
                    'rinci_tipe'=>$request->cb_rinci,
                    'terms' => $request->terms,
                    'total_invoice' => 0,
                    'status' => '1'
                ]);
                return redirect()->back();
        }
    }

    public function savecurahidp(Request $request) {
        $hrg_fr = (int)str_replace(".", "", $request->input('hrg_freight'));
        $total_hrg = (int)str_replace(".", "", $request->input('total_harga'));
        $total_dp = (int)str_replace(".", "", $request->input('todp'));
        $total_ppn = (int)str_replace(".", "", $request->input('toppn'));

        DetailInvoiceDP::create([
            'id_invoice_dp'=>$request->id_invdp, 
            'id_track'=>$request->id_track_i,
            'po_muat_date'=>$request->cb_bypo,
            'total_tonase'=>$request->ttdb,
            'harga_brg'=>$hrg_fr,
            'total_harga'=>$total_hrg,
            'sub_total'=>$request->total_harga,
            'prosentase_dp'=>$request->prodp,
            'total_dp'=>$total_dp,
            'prosentase_ppn'=>$request->proppn,
            'total_ppn'=>$total_ppn,
            'tipe'=>'Curah',
            'status'=>1
        ]);

        return redirect()->back();
    }
}
