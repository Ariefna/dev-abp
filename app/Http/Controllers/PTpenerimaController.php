<?php

namespace App\Http\Controllers;

use App\Models\Penerima;
use App\Models\PTpenerima;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;

class PTpenerimaController extends Controller
{
    public function store(Request $request) {
        PTpenerima::create([
            'nama_penerima'     => $request->nama,
            'status' => '1'
        ]);
        return redirect()->back();
    }
}
