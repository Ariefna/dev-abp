<?php

namespace App\Http\Controllers;

use App\Models\DetailDooring;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DocDooring;

class MDooringController extends Controller
{
    public function index(){
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        $monitoringDooring = DocDooring::with([
            'detailDooring' => function($query) {
                $query->whereIn('status', [2,3,4]);
            },
            'detailDooring.sisa',
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
            'detailDooring.docDooring.docTracking.portOfLoading',
            'detailDooring.docDooring.docTracking.portOfDestination',
        ])
        ->get();
        return view('pages.abp-page.mondooring', 
            compact('title', 'breadcrumb', 'monitoringDooring'
            )
        );
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
