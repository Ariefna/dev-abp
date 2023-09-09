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
use App\Models\Tracking;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrackingController extends Controller
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
        $tbl_po = Tracking::select('purchase_orders.po_muat', 'purchase_orders.po_kebun', 
                'purchase_orders.total_qty', 'port_of_loading.nama_pol', 'port_of_destination.nama_pod',
                'trackings.status', 'kapals.kode_kapal','kapals.nama_kapal','pt_penerima.nama_penerima',
                'gudang_muats.nama_gudang', 'barangs.nama_barang','purchase_orders.no_pl', 'trackings.tgl_muat',
                'purchase_orders.po_kebun','trackings.qty_muat', 'trackings.qty_timbang','trackings.jml_bag',
                'trackings.nopol','trackings.no_container','trackings.voyage','trackings.td','trackings.td_jkt',
                'trackings.eta','customers.nama_customer')
                ->join('gudang_muats', 'gudang_muats.id_gudang', '=', 'trackings.id_gudang')
                ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'trackings.no_po')
                ->join('port_of_loading', 'port_of_loading.id', '=', 'trackings.id_pol')
                ->join('port_of_destination', 'port_of_destination.id', '=', 'trackings.id_pod')
                ->join('kapals', 'kapals.id', '=', 'trackings.id_kapal')
                ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                ->join('penawaran_hargas', 'penawaran_hargas.id_penawaran', '=', 'detail_p_h_s.id_penawaran')
                ->join('customers', 'customers.id', '=', 'penawaran_hargas.id_customer')
                ->join('penerimas', 'detail_p_h_s.id_penerima', '=', 'penerimas.id_penerima')
                ->join('pt_penerima', 'pt_penerima.id_pt_penerima', '=', 'penerimas.id_pt_penerima')
                ->join('barangs', 'purchase_orders.id', '=', 'barangs.id')
                ->where('trackings.status', '=', 1)
                ->get();
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.tra', compact('title', 'breadcrumb','po','tbl_po','gudang','pol','pod','kapal'));
    }
    public function getPo($id) {
        $query = PurchaseOrder::select('purchase_orders.po_muat', 'purchase_orders.po_kebun', 'pt_penerima.nama_penerima',
                'purchase_orders.no_pl', 'purchase_orders.simb','penerimas.estate', 'barangs.nama_barang',
                'purchase_orders.status')
                ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                ->join('penawaran_hargas', 'penawaran_hargas.id_penawaran', '=', 'detail_p_h_s.id_penawaran')
                ->join('customers', 'customers.id', '=', 'penawaran_hargas.id_customer')
                ->join('penerimas', 'detail_p_h_s.id_penerima', '=', 'penerimas.id_penerima')
                ->join('pt_penerima', 'pt_penerima.id_pt_penerima', '=', 'penerimas.id_pt_penerima')
                ->join('barangs', 'purchase_orders.id', '=', 'barangs.id')
                ->where('purchase_orders.status', '=', 2)
                ->where('purchase_orders.po_muat', $id);
        $getdata = $query->get();
        return response()->json($getdata);
    }             
    public function store(Request $request) {
        $request->validate([
            'file' => 'required|mimes:jpeg,png,pdf|max:2048',
        ]);
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
    
        Storage::disk('public')->putFileAs('uploads/tracking', $file, $fileName);

        Tracking::create([
            'no_po'     => $request->no_po,
            'id_gudang'     => $request->id_gudang,
            'id_pol'     => $request->id_pol,
            'id_pod'     => $request->id_pod,            
            'id_kapal'   => $request->id_kapal,
            'qty_muat'     => $request->qty_muat,
            'qty_timbang'     => $request->qty_timbang,
            'jml_bag'     => $request->jml_bag,
            'nopol'   => $request->nopol,
            'no_container'     => $request->no_container,
            'voyage'   => $request->voyage,
            'tgl_muat'=> $request->tgl_muat,
            'td'     => $request->td,
            'td_jkt'     => $request->td_jkt,
            'eta'     => $request->eta,
            'file_name' => $fileName, // Store the file name, not the request input
            'file_path' => 'uploads/tracking' . $fileName, // Store the file path                           
            'status' => '1'
        ]);
        return redirect()->back();
    }    
}
