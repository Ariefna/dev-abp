<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InvoicePelExport implements FromView
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('pages.abp-page.print.invoice_pelunasan', [
            'title' => 'Print Invoice Pelunasan',
            'breadcrumb' => 'This breadcrumb',
            'data' => $this->data,
        ]);
    }
}