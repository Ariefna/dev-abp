<?php

namespace App\Http\Controllers;

use App\Models\DetailPH;
use App\Models\PenawaranHarga;
use App\Models\Barang;
use App\Models\PurchaseOrder;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class POController extends Controller
{
    public function index() {
        $customer = DetailPH::query()
                    ->join('penawaran_hargas as ph', 'detail_p_h_s.id_penawaran', '=', 'ph.id_penawaran')
                    ->join('customers as cst', 'ph.id_customer', '=', 'cst.id')
                    ->join('penerimas as pen', 'pen.id_penerima', '=', 'detail_p_h_s.id_penerima')
                    ->where('detail_p_h_s.status', 2)
                    ->where('detail_p_h_s.id_penawaran', function ($query) {
                        $query->selectRaw('MAX(t2.id_penawaran)')
                            ->from('detail_p_h_s as t2')
                            ->join('penawaran_hargas as ph2', 't2.id_penawaran', '=', 'ph2.id_penawaran')
                            ->whereColumn('ph2.id_customer', 'ph.id_customer');
                    })
                    ->orderBy('detail_p_h_s.id_penawaran', 'DESC')
                    ->groupBy('cst.nama_customer')
                    ->select('detail_p_h_s.id_penawaran', 'cst.nama_customer', 'detail_p_h_s.id_detail_ph', 'pen.estate')
                    ->get();
        $barang = Barang::where('status', 1)
                    ->orderBy('id', 'desc')
                    ->get();
        $po = PurchaseOrder::select('purchase_orders.po_muat', 'purchase_orders.po_kebun', 'customers.nama_customer', 'purchase_orders.status')
                    ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                    ->join('penawaran_hargas', 'penawaran_hargas.id_penawaran', '=', 'detail_p_h_s.id_penawaran')
                    ->join('customers', 'customers.id', '=', 'penawaran_hargas.id_customer')
                    ->join('penerimas', 'detail_p_h_s.id_penerima', '=', 'penerimas.id_penerima')
                    ->join('pt_penerima', 'pt_penerima.id_pt_penerima', '=', 'penerimas.id_pt_penerima')
                    ->join('barangs', 'purchase_orders.id', '=', 'barangs.id')
                    ->where('purchase_orders.status', '=', 1)
                    ->orWhere('purchase_orders.status', '=', 2)
                    ->get();                                
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.dpo', compact('title', 'breadcrumb','customer','barang','po'));
    }

    public function getCustomerDetails($id)
    {
        $query = DetailPH::query()
                    ->join('penawaran_hargas as ph', 'detail_p_h_s.id_penawaran', '=', 'ph.id_penawaran')
                    ->join('customers as cst', 'ph.id_customer', '=', 'cst.id')
                    ->join('penerimas as pen', 'pen.id_penerima', '=', 'detail_p_h_s.id_penerima')
                    ->join('pt_penerima as pt', 'pen.id_pt_penerima', '=', 'pt.id_pt_penerima') 
                    ->where('detail_p_h_s.status', 2)
                    ->where('detail_p_h_s.id_penawaran', function ($query) {
                        $query->selectRaw('MAX(t2.id_penawaran)')
                            ->from('detail_p_h_s as t2')
                            ->join('penawaran_hargas as ph2', 't2.id_penawaran', '=', 'ph2.id_penawaran')
                            ->whereColumn('ph2.id_customer', 'ph.id_customer');
                    })
                    ->where('detail_p_h_s.id_penawaran', $id)
                    ->orderBy('detail_p_h_s.id_penawaran', 'DESC')
                    ->groupBy('pen.id_pt_penerima')
                    ->select('detail_p_h_s.id_penawaran', 'cst.nama_customer', 'detail_p_h_s.id_detail_ph', 'pen.id_pt_penerima','pt.nama_penerima');
        // echo $query->toSql();
        $getdata = $query->get();
        return response()->json($getdata);
    }

    public function getEstateDetails($id)
    {
        $query = DetailPH::query()
                ->join('penawaran_hargas as ph', 'detail_p_h_s.id_penawaran', '=', 'ph.id_penawaran')
                ->join('customers as cst', 'ph.id_customer', '=', 'cst.id')
                ->join('penerimas as pen', 'pen.id_penerima', '=', 'detail_p_h_s.id_penerima')
                ->join('pt_penerima as pt', 'pen.id_pt_penerima', '=', 'pt.id_pt_penerima')
                ->selectRaw(
                    "CONCAT(detail_p_h_s.id_penawaran, '', pen.id_pt_penerima) AS estate_id"
                )
                ->select(
                    'detail_p_h_s.id_penawaran',
                    'cst.nama_customer',
                    'detail_p_h_s.id_detail_ph',
                    'pen.id_pt_penerima',
                    'pt.nama_penerima',
                    'pen.estate',
                    'detail_p_h_s.oa_kpl_kayu',
                    'detail_p_h_s.oa_container',
                )
                ->where('detail_p_h_s.status', 2)
                ->whereRaw("CONCAT(detail_p_h_s.id_penawaran, '', pen.id_pt_penerima) = $id")
                ->orderBy('detail_p_h_s.id_penawaran', 'DESC');
        $getdata = $query->get();
        return response()->json($getdata);
    }

    public function getDetailOA($id)
    {
        $query = DetailPH::where('status', 2)
                ->where('id_detail_ph', $id);
                // ->whereRaw("CONCAT(detail_p_h_s.id_penawaran, '', pen.id_pt_penerima) = $id")
                // ->orderBy('detail_p_h_s.id_penawaran', 'DESC');
        $getdata = $query->get();
        return response()->json($getdata);
    }

    public function store(Request $request) {
        $request->validate([
            'file' => 'required|mimes:jpeg,png,pdf|max:2048',
        ]);
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
    
        Storage::disk('public')->putFileAs('uploads', $file, $fileName);


        $totalAll = (float) preg_replace("/[^0-9]/", "", $request->input('total_all'));
        $totalContainer = (float) preg_replace("/[^0-9]/", "", $request->input('total_container'));
        $priceContainer = (float) preg_replace("/[^0-9]/", "", $request->input('price_container'));
        $priceCurah = (float) preg_replace("/[^0-9]/", "", $request->input('price_curah'));
        $totalCurah = (float) preg_replace("/[^0-9]/", "", $request->input('total_curah'));

        PurchaseOrder::create([
            'po_muat'     => $request->po_muat,
            'po_kebun'     => $request->po_kebun,
            'no_pl'     => $request->no_pl,
            'simb'     => $request->simb,            
            'tgl'   => $request->tgl_po,
            'id_detail_ph'     => $request->id_est,
            'id'     => $request->items,
            'qty'     => $request->qty,
            'qty2'   => $request->qty2,
            'price_curah'     => $priceCurah,
            'total_curah'     => $totalCurah,
            'price_container'     => $priceContainer,
            'total_container'   => $totalContainer,
            'total_qty'     => $request->total_qty,
            'total_all'     => $totalAll,
            'file_name' => $fileName, // Store the file name, not the request input
            'file_path' => 'uploads/' . $fileName, // Store the file path                           
            'status' => '1'
        ]);
        return redirect()->back();
    }

    public function approve(Request $request, $po_muat) {
        PurchaseOrder::where('po_muat', $po_muat)->update([
            'status' => '2'
        ]);
        return redirect()->back();
    }    
}
