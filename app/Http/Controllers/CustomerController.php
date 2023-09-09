<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::where('status', 1)
                    ->orderBy('id', 'desc')
                    ->get();
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.mcustomer', compact('title', 'breadcrumb','customer'));
    }

    public function store(Request $request) {
        Customer::create([
            'nama_customer'     => $request->nama_cst,
            'kota'     => $request->kota_cst,
            'no_telpon'   => $request->no_cst,
            'alamat'   => $request->alamat_cst,
            'status' => '1'
        ]);
        return redirect()->back();
    }

    public function edit(Customer $customer) {
        return view('customer.index', compact('customer'));
    }

    public function update(Request $request, Customer $customer) {
        $customer->update([
            'nama_customer'     => $request->nama_cst,
            'kota'     => $request->kota_cst,
            'no_telpon'   => $request->no_cst,
            'alamat'   => $request->alamat_cst,
            'status' => '1'
        ]);
        return redirect()->back();
    }

    public function destroy($id) {
        $customer = Customer::find($id);
        $customer->update([
            'status' => '0'
        ]);
        return redirect()->back();
    }
}
