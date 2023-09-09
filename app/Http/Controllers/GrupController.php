<?php

namespace App\Http\Controllers;

use App\Models\Grup;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;

class GrupController extends Controller
{
    public function store(Request $request) {
        Grup::create([
            'nama_grup'     => $request->nama,
            'status' => '1'
        ]);
        return redirect()->back();
    }
}
