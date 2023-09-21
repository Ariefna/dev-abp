<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KapalController;
use App\Http\Controllers\GudangMuatController;
use App\Http\Controllers\CompanyPortController;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\PHController;
use App\Http\Controllers\DooringController;
use App\Http\Controllers\InvoiceDPController;
use App\Http\Controllers\InvoiceLunasController;
use App\Http\Controllers\MTrackingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require_once 'theme-routes.php';

Route::get('/', function () {
    return view('pages.dashboard.analytics', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
});

