<?php

namespace App\Http\Controllers;

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
}
