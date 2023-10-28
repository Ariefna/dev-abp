<?php

namespace App\Http\Controllers;

use App\DetailInvoicePel as AppDetailInvoicePel;
use App\Exports\InvoicePelExport;
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

use Excel;

class InvoiceLunasController extends Controller
{
    public function print($id)
    {
        $data = [];
        $array = [];
      
        $invoicePelunasanData = DB::table(DB::raw('(
            SELECT
                customers.nama_customer,
                customers.kota,
                invoice_pelunasan.invoice_date,
                invoice_pelunasan.invoice_no,
                invoice_pelunasan.terms,
                invoice_pelunasan.tipe_job,
                doc_tracking.no_po,
                port_of_loading.nama_pol,
                port_of_destination.nama_pod,
                invoice_pelunasan.status,
                detail_invoice_pel.id_detail_pel,
                detail_invoice_pel.total_tonase_dooring,
                detail_invoice_pel.total_tonase_timbang
            FROM invoice_pelunasan
            LEFT JOIN doc_dooring ON doc_dooring.id_dooring = invoice_pelunasan.id_dooring
            LEFT JOIN detail_invoice_pel ON detail_invoice_pel.id_invoice_pel = invoice_pelunasan.id_invoice_pel
            LEFT JOIN doc_tracking ON doc_dooring.id_track = doc_tracking.id_track
            LEFT JOIN purchase_orders ON purchase_orders.po_muat = doc_tracking.no_po
            LEFT JOIN detail_p_h_s ON detail_p_h_s.id_detail_ph = purchase_orders.id_detail_ph
            LEFT JOIN penawaran_hargas ON penawaran_hargas.id_penawaran = detail_p_h_s.id_penawaran
            LEFT JOIN customers ON customers.id = penawaran_hargas.id_customer
            LEFT JOIN port_of_loading ON port_of_loading.id = doc_tracking.id_pol
            LEFT JOIN port_of_destination ON port_of_destination.id = doc_tracking.id_pod
            LEFT JOIN detail_tracking ON detail_tracking.id_track = doc_tracking.id_track
            LEFT JOIN kapals ON kapals.id = detail_tracking.id_kapal
            LEFT JOIN c_ports ON c_ports.id_company_port = kapals.id_company_port
            WHERE invoice_pelunasan.id_invoice_pel = '.$id.'
            GROUP BY detail_invoice_pel.id_detail_pel
        ) as a'))
            ->select('*', DB::raw('SUM(total_tonase_dooring) as sum_total_tonase_dooring'), DB::raw('SUM(total_tonase_timbang) as sum_total_tonase_timbang'))
            ->first();
        $kapal = InvoicePelunasan::select(DB::raw("CONCAT(IFNULL(kapals.kode_kapal, ''), ' ', IFNULL(kapals.nama_kapal, ''), ' ', IFNULL(detail_tracking.voyage, '')) AS nama"),
             'c_ports.nama as pelayaran',
             'detail_tracking.tgl_muat',
             'invoice_no')
    ->leftJoin('doc_dooring', 'doc_dooring.id_dooring', '=', 'invoice_pelunasan.id_dooring')
    ->leftJoin('detail_invoice_pel', 'detail_invoice_pel.id_invoice_pel', '=', 'invoice_pelunasan.id_invoice_pel')
    ->leftJoin('doc_tracking', 'doc_dooring.id_track', '=', 'doc_tracking.id_track')
    ->leftJoin('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
    ->leftJoin('detail_p_h_s', 'detail_p_h_s.id_detail_ph', '=', 'purchase_orders.id_detail_ph')
    ->leftJoin('penawaran_hargas', 'penawaran_hargas.id_penawaran', '=', 'detail_p_h_s.id_penawaran')
    ->leftJoin('customers', 'customers.id', '=', 'penawaran_hargas.id_customer')
    ->leftJoin('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
    ->leftJoin('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
    ->leftJoin('detail_tracking', 'detail_tracking.id_track', '=', 'doc_tracking.id_track')
    ->leftJoin('kapals', 'kapals.id', '=', 'detail_tracking.id_kapal')
    ->leftJoin('c_ports', 'c_ports.id_company_port', '=', 'kapals.id_company_port')
    ->where('invoice_pelunasan.id_invoice_pel', $id)
    ->groupBy('c_ports.nama', 'kapals.kode_kapal')
    ->get();

    $deskripsi = InvoicePelunasan::select(
        DB::raw('CONCAT("FREIGHT PO ", purchase_orders.id_po, " (", detail_invoice_pel.total_tonase_dooring, " KG X Rp. ", detail_invoice_pel.total_harga_dooring, ")") as name_doring'),
        DB::raw('CONCAT("FREIGHT PO ", purchase_orders.id_po, " (", detail_invoice_pel.total_tonase_timbang, " KG X Rp. ", detail_invoice_pel.total_harga_timbang, ")") as name_timbang'),
        'detail_invoice_pel.total_tonase_dooring',
        'detail_invoice_pel.total_harga_dooring',
        'detail_invoice_pel.total_tonase_timbang',
        'detail_invoice_pel.total_harga_timbang',
        'detail_invoice_pel.total_ppn_dooring',
        'invoice_pelunasan.invoice_date',
        'detail_invoice_pel.estate',
        'purchase_orders.id_po',
        'detail_invoice_pel.prosentase_ppn',
    'detail_invoice_pel.total_ppn_timbang',
        DB::raw('COALESCE(invoice_dp.total_invoice, 0) as total_invoice'),
        'invoice_pelunasan.id_invoice_dp'
    )
    ->leftJoin('doc_dooring', 'doc_dooring.id_dooring', '=', 'invoice_pelunasan.id_dooring')
    ->leftJoin('detail_invoice_pel', 'detail_invoice_pel.id_invoice_pel', '=', 'invoice_pelunasan.id_invoice_pel')
    ->leftJoin('doc_tracking', 'doc_dooring.id_track', '=', 'doc_tracking.id_track')
    ->leftJoin('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
    ->leftJoin('invoice_dp', 'invoice_pelunasan.id_invoice_dp', '=', 'invoice_dp.id_invoice_dp')
    ->where('invoice_pelunasan.id_invoice_pel', $id)
    ->get();

        if (!is_null($invoicePelunasanData)) {
            $data = [
                'nama_customer' => $invoicePelunasanData->nama_customer ?? null,
                'kota_customer' => $invoicePelunasanData->kota ?? null,
                'invoice_date' => $invoicePelunasanData->invoice_date ? date('d F Y', strtotime($invoicePelunasanData->invoice_date)) : null,
                'invoice_no' => $invoicePelunasanData->invoice_no ?? null,
                'terms' => $invoicePelunasanData->terms ?? null,
                'no_po' => $invoicePelunasanData->no_po ?? null,
                'tujuan1' => $invoicePelunasanData->nama_pol ?? null,
                'tujuan2' => $invoicePelunasanData->nama_pod ?? null,
                'tipe_job' => $invoicePelunasanData->tipe_job ?? null,
                'id_invoice_dp' => $invoicePelunasanData->id_invoice_dp ?? 0,
                'total-cont' => $invoicePelunasanData->status == 3 ? $invoicePelunasanData->sum_total_tonase_dooring : $invoicePelunasanData->sum_total_tonase_timbang,
            ];
          
            foreach ($kapal as $item) {
                $array[] = [
                    'name' => $item['nama'],
                    'pelayaran' => $item['pelayaran'],
                    'muat_date' => [$item['tgl_muat']],
                    'invoice_no' => [$item['invoice_no']],
                ];
            }

            $data['kapal'] = $array;
            $array = [];
            foreach ($deskripsi as $item) {
                $array[] = [
                    'name' => $invoicePelunasanData->status == 3 ? $item['name_doring']:$item['name_timbang'],
                    'total_tonase' => $invoicePelunasanData->status == 3 ? $item['total_tonase_dooring']:$item['total_tonase_timbang'],
                    'harga_brg' => $invoicePelunasanData->status == 3 ? $item['total_harga_dooring']:$item['total_harga_timbang'],
                    "total_ppn" => $invoicePelunasanData->status == 3 ? $item['total_ppn_dooring']:$item['total_ppn_timbang'],
                    "no_po" => $item['id_po'],
                    "date" => $item['invoice_date'],
                    "tipe" => $item['estate'],
                    "prosentase_ppn" => $item['prosentase_ppn'],
                    "total_dp" => $item['total_invoice'],
                ];
            }
            $data['description'] = $array;
            $data['bank'] = Bank::where('status', 1)->first();
        }
        $filename = 'invoice-pel-report-' . date('YmdHis') . '-' . rand(0, 1000) . ".xlsx";
        return Excel::download(new InvoicePelExport($data), $filename);
    }
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

        $parts = explode('-', $request->cb_bypo);
        $purchase = DB::table('purchase_orders as po')
            ->select('dd.id_dooring', 'dt.id_track', 'po.id_po', 'dphs.oa_kpl_kayu', 'dphs.oa_container')
            ->join('detail_p_h_s as dphs', 'po.id_detail_ph', '=', 'dphs.id_detail_ph')
            ->join('doc_tracking as dt', 'dt.no_po', '=', 'po.po_muat')
            ->join('doc_dooring as dd', 'dd.id_track', '=', 'dt.id_track')
            ->where('dd.id_dooring', $parts[0])
            ->first();
        DetailInvoicePel::create([
            'id_invoice_pel' => $request->idInvoicePel,
            'estate' => $parts[1],
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
            ->where('detail_dooring.estate', '=', $request->estate)
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
