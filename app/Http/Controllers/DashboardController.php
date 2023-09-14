<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $title = 'ABP';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.dashboard.analytics', compact('title', 'breadcrumb'));        
    }
}
