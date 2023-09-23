<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InvoiceDpExport implements FromView
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('pages.abp-page.print.invoice_dp', [
            'title' => 'Print Invoice DP',
            'breadcrumb' => 'This breadcrumb',
            'data' => $this->data,
        ]);
    }
}