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

use PDF;
use Excel;
use App\Exports\InvoiceDpExport;

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
        $subtotal = DetailInvoiceDP::select('id_track')
                ->selectRaw('SUM(total_harga) as sub')
                ->where('tipe', 'Curah')
                ->groupBy('id_track')
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
        $getval = DocTracking::select('detail_tracking.tgl_muat','invoice_dp.id_track', 'doc_tracking.no_po')
                ->selectRaw('SUM(detail_tracking.qty_tonase) as total_muat')
                ->selectRaw("DATE_FORMAT(detail_tracking.tgl_muat, '%e-%M-%Y') as formatted_tgl_muat")
                ->join('detail_tracking', 'doc_tracking.id_track', '=', 'detail_tracking.id_track')
                ->join('purchase_orders','purchase_orders.po_muat','=','doc_tracking.no_po')
                ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                ->join('invoice_dp','invoice_dp.id_track','=','doc_tracking.id_track')
                ->whereNull('detail_tracking.no_container')
                ->whereIn('doc_tracking.status', [2, 3])
                ->groupBy('doc_tracking.no_po','detail_tracking.tgl_muat')
                ->get();
        // dd ($getval);
        $getvalcont = DocTracking::select('detail_tracking.tgl_muat','invoice_dp.id_track', 'doc_tracking.no_po')
                ->selectRaw('SUM(detail_tracking.qty_tonase) as total_muat')
                ->selectRaw("DATE_FORMAT(detail_tracking.tgl_muat, '%e-%M-%Y') as formatted_tgl_muat")
                ->join('detail_tracking', 'doc_tracking.id_track', '=', 'detail_tracking.id_track')
                ->join('purchase_orders','purchase_orders.po_muat','=','doc_tracking.no_po')
                ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                ->join('invoice_dp','invoice_dp.id_track','=','doc_tracking.id_track')
                ->whereNotNull('detail_tracking.no_container')
                ->whereIn('doc_tracking.status', [2, 3])
                ->groupBy('doc_tracking.no_po','detail_tracking.tgl_muat')
                ->get();
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.idp', compact('title', 'breadcrumb','pomuat','bank',
        'invdp','getval','subtotal','getvalcont'));
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
        $getdata = $query->get();
        return response()->json($getdata);
    }

    public function getDetailPOCont($id_track) {
        $query = DocTracking::select('*','invoice_dp.id_track', 'doc_tracking.no_po')
                ->selectRaw('SUM(detail_tracking.qty_tonase) as total_muat')
                ->selectRaw("DATE_FORMAT(detail_tracking.tgl_muat, '%e-%M-%Y') as formatted_tgl_muat")
                ->join('detail_tracking', 'doc_tracking.id_track', '=', 'detail_tracking.id_track')
                ->join('purchase_orders','purchase_orders.po_muat','=','doc_tracking.no_po')
                ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                ->join('invoice_dp','invoice_dp.id_track','=','doc_tracking.id_track')
                ->whereNotNull('detail_tracking.no_container')
                ->whereIn('doc_tracking.status', [2, 3])
                ->whereRaw('CONCAT(doc_tracking.no_po, "(", DATE_FORMAT(detail_tracking.tgl_muat, "%e-%M-%Y"), ")") = ?', [$id_track])
                ->groupBy('doc_tracking.id_track', 'doc_tracking.no_po', 'formatted_tgl_muat');
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
            // dd ($a);
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

        $ceksub = $request->sub_total;

        // DetailInvoiceDP::select
        // DetailInvoiceDP::where('id_dooring', $request->id_door)
        // ->where('tipe','Curah')->update([
        //     'qty_tonase_sisa' => $request->qty,
        // ]);

        DetailInvoiceDP::create([
            'id_invoice_dp'=>$request->id_invdp, 
            'id_track'=>$request->id_track_i,
            'po_muat_date'=>$request->tgl_muat,
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

    public function savecontaineridp(Request $request) {
        $hrg_fr = (int)str_replace(".", "", $request->input('hrg_freightcont'));
        $total_hrg = (int)str_replace(".", "", $request->input('total_hargacont'));
        $total_dp = (int)str_replace(".", "", $request->input('todpcont'));
        $total_ppn = (int)str_replace(".", "", $request->input('toppncont'));

        // $ceksub = $request->sub_total;

        // DetailInvoiceDP::select
        // DetailInvoiceDP::where('id_dooring', $request->id_door)
        // ->where('tipe','Curah')->update([
        //     'qty_tonase_sisa' => $request->qty,
        // ]);

        DetailInvoiceDP::create([
            'id_invoice_dp'=>$request->id_invdp, 
            'id_track'=>$request->id_track_i,
            'po_muat_date'=>$request->tgl_muatcont,
            'total_tonase'=>$request->ttdbcont,
            'harga_brg'=>$hrg_fr,
            'total_harga'=>$total_hrg,
            'sub_total'=>$request->total_hargacont,
            'prosentase_dp'=>$request->prodpcont,
            'total_dp'=>$total_dp,
            'prosentase_ppn'=>$request->proppncont,
            'total_ppn'=>$total_ppn,
            'tipe'=>'Container',
            'status'=>1
        ]);
        return redirect()->back();        
    }
        
    public function printInvoiceDp($id_invoice_dp) {
        $invoiceDp = InvoiceDP::with([
            'docTracking',
            'docTracking.po',
            'docTracking.po.detailPhs',
            'docTracking.po.detailPhs.penawaran',
            'docTracking.po.detailPhs.penawaran.customer',
            'docTracking.portOfLoading',
            'docTracking.portOfDestination',
            'docTracking.detailTrackingMultiple',
            'docTracking.detailTrackingMultiple.kapal',
            'docTracking.detailTrackingMultiple.kapal.cPort',
            'detailInvoiceDp'
        ])
        ->where('id_invoice_dp', $id_invoice_dp)
        ->groupBy('id_invoice_dp')
        ->first();
        // dd($invoiceDp);
        $data = [];
        
        if (!is_null($invoiceDp)) {
            $data = [
                'nama_customer' => $invoiceDp->docTracking->po->detailPhs->penawaran->customer->nama_customer ?? null,
                'kota_customer' => $invoiceDp->docTracking->po->detailPhs->penawaran->customer->kota ?? null,
                'invoice_date' => $invoiceDp->invoice_date ? date('d F Y', strtotime($invoiceDp->invoice_date)) : null,
                'invoice_no' => $invoiceDp->invoice_no ?? null,
                'terms' => $invoiceDp->terms ?? null,
                'no_po' => $invoiceDp->docTracking->no_po ?? null,
                'tujuan1' => $invoiceDp->docTracking->portOfLoading->nama_pol ?? null,
                'tujuan2' => $invoiceDp->docTracking->portOfDestination->nama_pod ?? null,
                'tipe_job' => $invoiceDp->tipe_job ?? null,
            ];
            
            // if (isset($invoiceDp->docTracking->detailTrackingMultiple) && $invoiceDp->docTracking->detailTrackingMultiple->count() > 0) {
            //     for ($i=0; $i < $invoiceDp->docTracking->detailTrackingMultiple->count(); $i++) { 
            //         $data['kapal'][$i] = ['name' => $invoiceDp->docTracking->detailTrackingMultiple[$i]->kapal->kode_kapal . ' ' . $invoiceDp->docTracking->detailTrackingMultiple[$i]->kapal->nama_kapal . ' ' . $invoiceDp->docTracking->detailTrackingMultiple[$i]->voyage];
            //         $data['pelayaran'] = $invoiceDp->docTracking->detailTrackingMultiple[$i]->kapal->cPort->nama;
            //     }
            // }

            
            if (isset($invoiceDp->docTracking->detailTrackingMultiple) && $invoiceDp->docTracking->detailTrackingMultiple->count() > 0) {
                // return response()->json([
                //     'multiple' => $invoiceDp->docTracking->detailTrackingMultiple,
                //     'count' => $invoiceDp->docTracking->detailTrackingMultiple->count(),
                // ]);

                $groupedData = []; // Initialize an empty array to hold the grouped data
                
                for ($i = 0; $i < $invoiceDp->docTracking->detailTrackingMultiple->count(); $i++) { 
                    $name = $invoiceDp->docTracking->detailTrackingMultiple[$i]->kapal->kode_kapal . ' ' . $invoiceDp->docTracking->detailTrackingMultiple[$i]->kapal->nama_kapal . ' ' . $invoiceDp->docTracking->detailTrackingMultiple[$i]->voyage;
                    $pelayaran = $invoiceDp->docTracking->detailTrackingMultiple[$i]->kapal->cPort->nama;
                    $tgl = $invoiceDp->docTracking->detailTrackingMultiple[$i]->tgl_muat;
                    $invoice_no = $invoiceDp->invoice_no;                      
                        $groupedData[$i] = [
                            'name' => $name,
                            'pelayaran' => $pelayaran,
                            'muat_date' => $tgl,
                            'invoice_no' => $invoice_no
                            // Add other data fields as needed
                        ];
                }
                $groupedDataResult = [];

                foreach ($groupedData as $item) {
                    $found = false;
                    foreach ($groupedDataResult as &$group) {
                        if ($group['pelayaran'] == $item['pelayaran'] && $group['name'] == $item['name']) {
                            // Jika 'name' dan 'pelayaran' sama, tambahkan data ke array yang ada
                            $group['muat_date'][] = $item['muat_date'];
                            $group['invoice_no'][] = $item['invoice_no'];
                            $found = true;
                            break;
                        }
                    }
                
                    if (!$found) {
                        // Jika tidak ada kelompok yang cocok, tambahkan data baru ke hasil akhir
                            $groupedDataResult[] = [
                                'name' => $item['name'],
                                'pelayaran' => $item['pelayaran'],
                                'muat_date' => [$item['muat_date']],
                                'invoice_no' => [$item['invoice_no']],
                            ];
                    }
                }
                $groupedData = $groupedDataResult;
                
                // Convert the grouped data into a simple array
                $data['kapal'] = array_values($groupedData);
            }
            $finalGroupedData = [];
            // foreach ($groupedData as $key => $data) {
            //     $invoiceNo = $data['invoice_no'];
            //     if (!isset($finalGroupedData[$invoiceNo])) {
            //         $finalGroupedData[$invoiceNo] = [];
            //     }
            //     $finalGroupedData[$invoiceNo][] = $data;
            // }

            // return response()->json($finalGroupedData);
            

            $groupedData = [];

            // Iterate through the original array
            foreach ($data['kapal'] as $item) {
                // Extract the 'name' field value
                $name = $item['name'];

                // Check if a group with this 'name' exists, if not, create it
                if (!isset($groupedData[$name])) {
                    $groupedData[$name] = [];
                }

                // Add the item to the corresponding group
                $groupedData[$name][] = $item;
            }

            $data['total-cont'] = $invoiceDp->detailInvoiceDp->sum('total_tonase');

            $pushData = collect([]);

            // dd($invoiceDp->detailInvoiceDp);

            foreach ($invoiceDp->detailInvoiceDp as $key => $detailInvoiceDp) {
                if($pushData->count() == 0){
                    $pushData->push([
                        'no_po' => $invoiceDp->docTracking->no_po,
                        'date' => $detailInvoiceDp->po_muat_date,
                        'total_tonase' => $detailInvoiceDp->total_tonase,
                        'tipe' => $detailInvoiceDp->tipe,
                        'harga_brg' => $detailInvoiceDp->harga_brg,
                        'prosentase_ppn' => $detailInvoiceDp->prosentase_ppn,
                        'total_dp' => $detailInvoiceDp->total_dp,
                        'total_ppn' => $detailInvoiceDp->total_ppn
                    ]);
                } else{
                    $exist = $pushData->where(
                        'date', $detailInvoiceDp->po_muat_date
                    )
                    ->where('tipe', $detailInvoiceDp->tipe,)
                    ->first();
                    if(empty($exist)){
                        $pushData->push([
                            'no_po' => $invoiceDp->docTracking->no_po,
                            'date' => $detailInvoiceDp->po_muat_date,
                            'total_tonase' => $detailInvoiceDp->total_tonase,
                            'tipe' => $detailInvoiceDp->tipe,
                            'harga_brg' => $detailInvoiceDp->harga_brg,
                            'prosentase_ppn' => $detailInvoiceDp->prosentase_ppn,
                            'total_dp' => $detailInvoiceDp->total_dp,
                            'total_ppn' => $detailInvoiceDp->total_ppn
                        ]); 
                    } else{
                        $sum = $detailInvoiceDp->total_tonase + $exist['total_tonase'];
                        $sumDp = $detailInvoiceDp->total_dp + $exist['total_dp'];
                        $sumppn = $detailInvoiceDp->total_ppn + $exist['total_ppn'];
                        $key = $pushData->search(function($item) use($detailInvoiceDp){
                            return $item['date'] == $detailInvoiceDp->po_muat_date;
                        });
                        $pushData->pull($key);

                        $pushData->push([
                            'no_po' => $invoiceDp->docTracking->no_po,
                            'date' => $detailInvoiceDp->po_muat_date,
                            'total_tonase' => $sum,
                            'tipe' => $detailInvoiceDp->tipe,
                            'harga_brg' => $detailInvoiceDp->harga_brg,
                            'prosentase_ppn' => $detailInvoiceDp->prosentase_ppn,
                            'total_dp' => $sumDp,
                            'total_ppn'=> $sumppn
                        ]);
                        
                    }
                }
            }

            $data['description'] = [];

            $totalTonasePerNoPO = [];
          
            foreach ($pushData as $key => $item) {
                $no_po = $item["no_po"];
                $total_tonase = intval($item["total_tonase"]);

                if (array_key_exists($no_po, $totalTonasePerNoPO)) {
                    $totalTonasePerNoPO[$no_po]['total_tonase'] += $total_tonase;
                $totalTonasePerNoPO[$no_po]['total_dp'] += $item["total_dp"];
                } else {
                    $totalTonasePerNoPO[$no_po]['total_tonase'] = $total_tonase;
                $totalTonasePerNoPO[$no_po]['total_dp'] = $item["total_dp"];
                }
                $totalTonasePerNoPO[$no_po]['harga_brg'] = $item["harga_brg"];
                $totalTonasePerNoPO[$no_po]['no_po'] = $item["no_po"];
                $totalTonasePerNoPO[$no_po]['date'] = $item["date"];
                $totalTonasePerNoPO[$no_po]['tipe'] = $item["tipe"];
                $totalTonasePerNoPO[$no_po]['prosentase_ppn'] = $item["prosentase_ppn"];
                $totalTonasePerNoPO[$no_po]['total_ppn'] = $item["total_ppn"];

                
            }

            foreach ($totalTonasePerNoPO as $no_po => $value) {
                // echo "no_po: $no_po, total_tonase: $total_tonase\n";
                $value['name'] = 'FREIGHT PO '.$no_po.' ('.number_format($value['total_tonase'], 0, ',', '.').' KG'.' X '.'Rp. '.number_format($value['harga_brg'], 0, ',', '.').')';
                $value['total_tonase'] = (string)$value['total_tonase'];
                array_push($data['description'], $value);
            }


           

            $data['bank'] = Bank::where('status', 1)->first();
        }

        $title = 'Print Invoice DP';
        $breadcrumb = 'This breadcrumb';

        $filename = 'invoice-dp-report-' . date('YmdHis') . '-' . rand(0, 1000) . ".xlsx";
        // dd($data);
        // die();
        return Excel::download(new InvoiceDpExport($data), $filename);
        
        // $pdf = PDF::loadview('pages.abp-page.print.invoice_dp', compact(
        //     'title', 'breadcrumb',
        //     'data','groupedData'
        // ))->setOptions(['dpi' => 100, 'defaultFont' => 'sans-serif']);
        // Set custom page size (A4, portrait)
        // $pdf->setPaper('A4');
        // $pdf->setOption('dpi','600');

        // $pdf->setOption('margin-top', '20mm');
        // $pdf->setOption('margin-right', '0mm');
        // $pdf->setOption('margin-bottom', '0mm');
        // $pdf->setOption('margin-left', '0mm');
    	// return $pdf->stream('invoice-dp.pdf');
        // return $pdf->download('invoice-dp.pdf');

        // return view('pages.abp-page.print.invoice_dp', compact(
        //     'title', 'breadcrumb',
        //     'data'
        // ));
    }

}
