<?php

namespace App\Http\Controllers;

use App\Models\DetailDooring;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DocDooring;
use App\Models\DocTracking;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Models\Kapal;
use Illuminate\Support\Facades\DB;

class MDooringController extends Controller
{
    public function index(){
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        
        $tbl_po = DocTracking::select('doc_tracking.no_po', 'purchase_orders.po_kebun', 'penerimas.estate',
                'purchase_orders.total_qty', 'port_of_loading.nama_pol', 'port_of_destination.nama_pod',
                'detail_tracking.status', 'kapals.kode_kapal','kapals.nama_kapal','pt_penerima.nama_penerima',
                'gudang_muats.nama_gudang', 'barangs.nama_barang','purchase_orders.no_pl', 'detail_tracking.tgl_muat',
                'purchase_orders.po_kebun','detail_tracking.qty_tonase','detail_tracking.id_detail_track as id_edit', 'detail_tracking.qty_timbang','detail_tracking.jml_sak',
                'detail_tracking.nopol','detail_tracking.no_container','detail_tracking.voyage','detail_tracking.td','detail_tracking.td_jkt',
                'detail_tracking.ta','customers.nama_customer','doc_tracking.status_kapal','doc_dooring.id_dooring',
                'doc_tracking.id_track', 'detail_tracking.id_detail_track','detail_tracking.track_file','detail_tracking.door_file')
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
                ->join('doc_dooring','doc_dooring.id_track','=','doc_tracking.id_track')
                ->whereIn('doc_dooring.status', [2,3,4])
                ->get();
                // DB::enableQueryLog();
        $monitoringDooring = DocDooring::with([
            'detailDooring' => function($query) {
                $query->whereIn('detail_dooring.status', [2,3,4]);
            },
            'detailDooring.sisa',
            'detailDooring.detailTrackingCont',
            'detailDooring.docDooring',
            'detailDooring.docDooring.docTracking',
            'detailDooring.docDooring.docTracking.detailTracking',
            'detailDooring.docDooring.docTracking.detailTracking.kapal',
            'detailDooring.docDooring.docTracking.po.detailPhs',
            'detailDooring.docDooring.docTracking.po.detailPhs.penawaran',
            'detailDooring.docDooring.docTracking.po.detailPhs.penawaran.customer',
            'detailDooring.docDooring.docTracking.po.detailPhs.penerima',
            'detailDooring.docDooring.docTracking.po.detailPhs.penerima.ptPenerima',
            'detailDooring.docDooring.docTracking.po.barang',
            'detailDooring.detailTracking.portOfLoading',
            'detailDooring.detailTracking.portOfDestination',
        ])
        ->get();
        $kapal = Kapal::select('kapals.id', 'kapals.id_company_port', 'c_ports.nama', 'c_ports.no_telp', 'c_ports.alamat', 'kapals.kode_kapal', 'kapals.nama_kapal', "detail_tracking.id_track", 'detail_tracking.voyage')
                ->join('c_ports', 'c_ports.id_company_port', '=', 'kapals.id_company_port')
                ->join(
                    "detail_tracking",
                    "detail_tracking.id_kapal",
                    "=",
                    "kapals.id"
                )
                ->where('kapals.status', 1)
                ->whereIn("detail_tracking.status", [2, 3])
                ->groupBy(
                    "detail_tracking.id_kapal",
                )
                ->get(); 
                // dd(DB::getQueryLog());

        return view('pages.abp-page.mondooring', 
            compact('title', 'breadcrumb', 'monitoringDooring','tbl_po','kapal'
            )
        );
    }
    
   public function geteditcontainer($id)
    {
        $detailDooring = DetailDooring::query()
    ->join('detail_tracking', 'detail_dooring.id_detail_track', '=', 'detail_tracking.id_detail_track')
    ->join('kapals', 'kapals.id', '=', 'detail_dooring.id_kapal')
    ->select([
        'detail_dooring.id_dooring',
        'detail_dooring.id_detail_door',
        'kapals.nama_kapal',
        'detail_tracking.no_container',
        'detail_tracking.voyage',
        'detail_tracking.no_segel',
        'detail_tracking.id_track',
        'detail_dooring.id_detail_track',

        
    ])
    ->where('detail_dooring.status', '<>', 0)
    ->where('detail_dooring.id_detail_door', $id)
    ->get();

// Assuming you want to return the result as JSON
return response()->json($detailDooring);
    }

       public function getKapalByTrack(Request $request)
    {
        // Validate the request
        $request->validate([
            'id_track' => 'required|integer', // Assuming id_track is an integer
        ]);
                      $kapal = Kapal::select("*", "detail_tracking.id_track", "detail_dooring.id_detail_door")
            ->join(
                "c_ports",
                "c_ports.id_company_port",
                "=",
                "kapals.id_company_port"
            )
            ->join(
                "detail_tracking",
                "detail_tracking.id_kapal",
                "=",
                "kapals.id"
            )
            ->leftJoin('detail_dooring', function ($join) use ($request) {
                $join->on('detail_dooring.id_detail_track', '=', 'detail_tracking.id_detail_track');
            })
            ->where("kapals.status", 1)
            ->whereIn("detail_tracking.status", [2, 3])
            ->where('id_track', $request->id_track)
            ->whereNotNull('no_container')
            ->groupBy(
                "detail_tracking.voyage",
                "detail_tracking.id_kapal",
            )
            ->get();
        return response()->json($kapal);
    }
        public function history(){
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        
        $monitoringDooring = DocDooring::with([
            'detailDooring.sisa',
            'detailDooring.docDooring',
            'detailDooring.docDooring.docTracking.detailTracking.kapal',
            'detailDooring.docDooring.docTracking.po.detailPhs' => function ($query) {
                $query->with([
                    'penawaran.customer',
                    'penerima.ptPenerima',
                ]);
            },
            'detailDooring.detailTracking.portOfLoading',
            'detailDooring.detailTracking.portOfDestination',
        ])
        ->whereHas('detailDooring', function ($query) {
            $query->whereIn('detail_dooring.status', [0]);
        })
        ->get();
    
        return view('pages.abp-page.mondoorhistory', compact('title', 'breadcrumb', 'monitoringDooring'));
    }


    public function update(Request $request) {
        try {
                $request->validate([
                        'file' => 'required|mimes:jpeg,png,pdf|max:10048',
                        'file2' => 'required|mimes:jpeg,png,pdf|max:10048',
                    ]);
                    
                    $file = $request->file('file');
                    $file2 = $request->file('file2');
                    $fileName = time() . '-bap-dooring-' . $file->getClientOriginalName();
                    $fileName2 = time() . '-rekap-kebun-' . $file2->getClientOriginalName();
                    Storage::disk('public')->putFileAs('uploads/dooring', $file, $fileName);
                    Storage::disk('public')->putFileAs('uploads/dooring', $file2, $fileName2);
                    DocDooring::where('id_dooring', $request->cb_po)
                    ->update([
                        'sb_file_name'     => $fileName,
                        'sb_file_path'     => 'uploads/dooring' . $fileName,
                        'sr_file_name'     => $fileName2,
                        'sr_file_path'     => 'uploads/dooring' . $fileName2,
                    ]);
                    return redirect()->back();
            } catch (\Exception $e) {
            }       
    }

    public function downloadfile($path) {
        $filePath = storage_path('app/public/uploads/dooring/' . $path);

        if (file_exists($filePath)) {
            $originalName = basename($path);
    
            $contentType = Storage::mimeType('public/uploads/dooring/' . $path);
    
            return response(file_get_contents($filePath))
                ->header('Content-Type', $contentType)
                ->header('Content-Disposition', 'inline; filename="' . $originalName . '"');
        }
    
        abort(404, 'File not found');
    }

    public function printSPK(Request $request, $id_detail_door)
    {
        $DetailDooring = DetailDooring::with([
            'detailTracking.docTracking.portOfDestination',
            'detailTracking.docTracking.po.detailPhs.penerima.ptPenerima',
            'detailTracking.kapal',
        ])->where('id_detail_door', $id_detail_door)->first();

        $DocDooring = DocDooring::with([
            'detailDooring',
            'detailDooring.detailTracking.docTracking.po.barang',
        ])->where('id_dooring', $DetailDooring->id_dooring)->first();
        // dd($DocDooring);

        // set tanggal spk, td
        setlocale(LC_TIME, 'id_ID');
        $date_spk = Carbon::parse($DetailDooring->tgl_tiba);
        $date_td = Carbon::parse($DetailDooring->detailTracking->td);
        $tgl_spk = $date_spk->formatLocalized('%d %B %Y');
        $tgl_td = $date_td->formatLocalized('%d %B %Y') ?? '';

        // set nomor spk
        $date = Carbon::parse($DetailDooring->tgl_tiba);
        $month = $date->format('F');
        $romawi = formatMonthInRoman($month);
        $year = date('Y');
        $nomor = "$DetailDooring->id_dooring / ABP / SPK / $romawi / $year";
        
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML(view('pages.abp-page.print.spk-dooring', compact('DetailDooring','DocDooring','tgl_spk','tgl_td','nomor')));
        return $pdf->stream();
    }
}