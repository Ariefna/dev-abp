<?php

namespace App\Http\Controllers;

use App\Models\DetailPH;
use App\Models\PortOfLoading;
use App\Models\PortOfDestination;
use App\Models\GudangMuat;
use App\Models\Kapal;
use App\Models\CPort;
use App\Models\PenawaranHarga;
use App\Models\Barang;
use App\Models\PurchaseOrder;
use App\Models\PtPenerima;
use App\Models\DocTracking;
use App\Models\DetailTracking;
use App\Models\DetailTrackingSisa;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class DocTrackingController extends Controller
{
    public function index() {
        $gudang = GudangMuat::where('status', 1)
                ->orderBy('id_gudang', 'desc')
                ->get();
        $pol = PortOfLoading::where('status', 1)
                ->orderBy('id', 'desc')
                ->get();
        $pod = PortOfDestination::where('status', 1)
                ->orderBy('id', 'desc')
                ->get();
        $selectpol = DocTracking::select('id_pol', 'id_track')->where('created_by',Session::get('id'))->get();
        $selectpod = DocTracking::select('id_pod','id_track')->where('created_by',Session::get('id'))->get();
        $kapal = Kapal::select('kapals.id', 'kapals.id_company_port', 'c_ports.nama', 'c_ports.no_telp', 'c_ports.alamat', 'kapals.kode_kapal', 'kapals.nama_kapal')
                ->join('c_ports', 'c_ports.id_company_port', '=', 'kapals.id_company_port')
                ->where('kapals.status', 1)
                ->get();                                        
        $po = PurchaseOrder::select('purchase_orders.po_muat', 'purchase_orders.po_kebun',
                'customers.nama_customer', 'purchase_orders.status')
                ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                ->join('penawaran_hargas', 'penawaran_hargas.id_penawaran', '=', 'detail_p_h_s.id_penawaran')
                ->join('customers', 'customers.id', '=', 'penawaran_hargas.id_customer')
                ->join('penerimas', 'detail_p_h_s.id_penerima', '=', 'penerimas.id_penerima')
                ->join('pt_penerima', 'pt_penerima.id_pt_penerima', '=', 'penerimas.id_pt_penerima')
                ->join('barangs', 'purchase_orders.id', '=', 'barangs.id')
                ->where('purchase_orders.status', '=', 2)
                ->whereNotIn('purchase_orders.po_muat', function ($query) {
                    $query->select('no_po')
                        ->from('doc_tracking');
                })
                ->get();
        $track = DocTracking::select('*', 'doc_tracking.status', 'doc_tracking.id_track')
                ->selectSub(function ($query) {
                    $query->selectRaw('SUM(qty_tonase_sisa)')
                        ->from('detail_tracking_sisa')
                        ->whereColumn('detail_tracking_sisa.id_track', 'doc_tracking.id_track')
                        // ->where('detail_tracking_sisa.status',1)
                        ->groupBy('detail_tracking.id_track');
                }, 'total_all_sisa')
                ->selectSub(function ($query) {
                    $query->selectRaw('SUM(qty_tonase)')
                        ->from('detail_tracking')
                        ->whereColumn('detail_tracking.id_track', 'doc_tracking.id_track')
                        ->whereIn('detail_tracking.status', [1, 2, 3])
                        ->whereNull('no_container')
                        ->groupBy('detail_tracking.id_track');
                }, 'muat_curah')
                ->selectSub(function ($query) {
                    $query->selectRaw('SUM(qty_tonase)')
                        ->from('detail_tracking')
                        ->whereColumn('detail_tracking.id_track', 'doc_tracking.id_track')
                        ->whereIn('detail_tracking.status', [1,2,3])
                        ->whereNotNull('no_container')
                        ->groupBy('detail_tracking.id_track');
                }, 'muat_container')
                ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                ->join('detail_tracking', 'detail_tracking.id_track', '=', 'doc_tracking.id_track')
                ->join('detail_tracking_sisa','detail_tracking_sisa.id_track','=','doc_tracking.id_track')
                ->where('doc_tracking.status', 1)
                ->whereNotIn('detail_tracking.status', [0])
                ->whereNotIn('purchase_orders.status', [0])
                ->where('created_by',Session::get('id'))
                ->groupBy('doc_tracking.id_track')
                ->orderBy('doc_tracking.id_track', 'desc')
                ->get();
        $trackzero = DocTracking::select('*', 'doc_tracking.status', 'doc_tracking.id_track')
                    ->selectSub(function ($query) {
                        $query->selectRaw('SUM(qty_tonase)')
                            ->from('detail_tracking')
                            ->whereColumn('detail_tracking.id_track', 'doc_tracking.id_track')
                            ->where('status',[2,3])
                            ->whereNull('no_container')
                            ->groupBy('detail_tracking.id_track');
                    }, 'qty_curah_track')
                    ->selectSub(function ($query) {
                        $query->selectRaw('SUM(qty_tonase)')
                            ->from('detail_tracking')
                            ->whereColumn('detail_tracking.id_track', 'doc_tracking.id_track')
                            ->where('status',[2,3])
                            ->whereNotNull('no_container')
                            ->groupBy('detail_tracking.id_track');
                    }, 'qty_curah_cont')
                    ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                    ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                    ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                    ->join('detail_tracking', 'detail_tracking.id_track', '=', 'doc_tracking.id_track')
                    ->join('detail_tracking_sisa','detail_tracking_sisa.id_track','=','doc_tracking.id_track')
                    ->where('doc_tracking.status', 1)
                    ->whereIn('detail_tracking.status', [1,2,3])
                    ->where('created_by',Session::get('id'))
                    ->groupBy('doc_tracking.id_track')
                    ->orderBy('doc_tracking.id_track', 'desc')
                    ->get();
        // dd($trackzero);
        $tracknull = DocTracking::select('*', 'doc_tracking.status', 'doc_tracking.id_track')
                    ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                    ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                    ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                    ->where('doc_tracking.status', 1)
                    ->where('created_by',Session::get('id'))
                    ->groupBy('doc_tracking.id_track')
                    ->orderBy('doc_tracking.id_track', 'desc')
                    ->get();
        $getcurahqty = DocTracking::select('*', 'doc_tracking.status', 'doc_tracking.id_track')
                    ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                    ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                    ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                    ->join('detail_tracking', 'detail_tracking.id_track', '=', 'doc_tracking.id_track')
                    ->join('detail_tracking_sisa','detail_tracking_sisa.id_track','=','doc_tracking.id_track')
                    ->where('doc_tracking.status', 1)
                    ->where('detail_tracking_sisa.tipe', 'Curah')
                    ->where('created_by',Session::get('id'))
                    ->groupBy('doc_tracking.id_track')
                    ->orderBy('doc_tracking.id_track', 'desc')
                    ->get();
        $getcontqty = DocTracking::select('*', 'doc_tracking.status', 'doc_tracking.id_track')
                    ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                    ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                    ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                    ->join('detail_tracking', 'detail_tracking.id_track', '=', 'doc_tracking.id_track')
                    ->join('detail_tracking_sisa','detail_tracking_sisa.id_track','=','doc_tracking.id_track')
                    ->where('doc_tracking.status', 1)
                    ->where('detail_tracking_sisa.tipe', 'Container')
                    ->where('created_by',Session::get('id'))
                    ->groupBy('doc_tracking.id_track')
                    ->orderBy('doc_tracking.id_track', 'desc')
                    ->get();                    
        $details = DocTracking::select('*', 'doc_tracking.status', 'doc_tracking.id_track')
                // ->selectSub(function ($query) {
                //     $query->selectRaw('SUM(qty_tonase)')
                //         ->from('detail_tracking')
                //         ->whereColumn('detail_tracking.id_track', 'doc_tracking.id_track')
                //         ->groupBy('detail_tracking.id_track');
                // }, 'total_qty_tonase')
                ->join('port_of_loading', 'port_of_loading.id', '=', 'doc_tracking.id_pol')
                ->join('port_of_destination', 'port_of_destination.id', '=', 'doc_tracking.id_pod')
                ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                ->join('detail_tracking', 'detail_tracking.id_track', '=', 'doc_tracking.id_track')
                ->where('doc_tracking.status', 1)
                ->where('detail_tracking.status', 1)
                ->where('created_by',Session::get('id'))
                ->groupBy('doc_tracking.id_track')
                ->orderBy('doc_tracking.id_track', 'desc')
                ->count();
        $dtrack = DetailTracking::select('*')
                ->join('gudang_muats', 'gudang_muats.id_gudang', '=', 'detail_tracking.id_gudang')
                ->join('kapals', 'kapals.id', '=', 'detail_tracking.id_kapal')
                ->join('doc_tracking', 'doc_tracking.id_track', '=', 'detail_tracking.id_track')
                ->where('detail_tracking.status', 1)
                ->where('doc_tracking.created_by',Session::get('id'))
                // ->groupBy('doc_tracking.id_track')
                ->orderBy('detail_tracking.id_detail_track', 'desc')
                ->get();    
        $lastcont = DetailTracking::join('detail_tracking_sisa','detail_tracking_sisa.id_track','=','detail_tracking.id_track')
                    ->join('doc_tracking', 'doc_tracking.id_track', '=', 'detail_tracking.id_track')
                    ->where('detail_tracking.status', 1)
                    ->where('created_by',Session::get('id'))
                    ->whereNotNull('detail_tracking.no_container')
                    ->where('detail_tracking_sisa.tipe', 'Container')
                    ->first();
        $lastcurah = DetailTracking::join('detail_tracking_sisa', 'detail_tracking_sisa.id_track', '=', 'detail_tracking.id_track')
                    ->join('doc_tracking', 'doc_tracking.id_track', '=', 'detail_tracking.id_track')
                    ->where('detail_tracking.status', 1)
                    ->where('created_by',Session::get('id'))
                    ->whereNull('detail_tracking.no_container')
                    ->where('detail_tracking_sisa.tipe', 'Curah')
                    ->first();
        $zerocurah = DocTracking::select('*')
                    ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                    ->where('doc_tracking.status',1)
          			->whereNotIn('purchase_orders.status', [0])
                    ->where('created_by',Session::get('id'))
                    ->get();
                    // dd($zerocurah);
        $zerocont = DocTracking::select('*')
                    ->join('purchase_orders', 'purchase_orders.po_muat', '=', 'doc_tracking.no_po')
                    ->where('doc_tracking.status',1)
          			->whereNotIn('purchase_orders.status', [0])
                    ->where('created_by',Session::get('id'))
                    ->get();                    
        $cek = DocTracking::where('status',1)->where('created_by',Session::get('id'))->get();
        $tracksisa = DetailTrackingSisa::select('detail_tracking_sisa.id_track', 'detail_tracking_sisa.tipe', 'detail_tracking_sisa.qty_tonase_sisa')
        ->join('doc_tracking', 'doc_tracking.id_track', '=', 'detail_tracking_sisa.id_track')
        ->where('doc_tracking.created_by', Session::get('id'))
        ->get();
        $title = 'Adhipramana Bahari Perkasa';
        $breadcrumb = 'This Breadcrumb';
        return view('pages.abp-page.tra', compact('title', 'breadcrumb','po','details','getcurahqty','getcontqty',
        'track','trackzero','dtrack','lastcont','lastcurah','zerocurah',
        'zerocont','gudang','pol','pod','kapal','tracknull','cek','tracksisa','selectpol','selectpod'));
    }
    

    public function getPo($id) {
        $query = PurchaseOrder::select('purchase_orders.po_muat', 'purchase_orders.po_kebun', 'pt_penerima.nama_penerima',
                'purchase_orders.no_pl', 'purchase_orders.simb','penerimas.estate', 'barangs.nama_barang',
                'purchase_orders.status')
                ->join('detail_p_h_s', 'purchase_orders.id_detail_ph', '=', 'detail_p_h_s.id_detail_ph')
                ->join('penawaran_hargas', 'penawaran_hargas.id_penawaran', '=', 'detail_p_h_s.id_penawaran')
                ->join('customers', 'customers.id', '=', 'penawaran_hargas.id_customer')
                ->join('penerimas', 'detail_p_h_s.id_penerima', '=', 'penerimas.id_penerima')
                ->join('pt_penerima', 'pt_penerima.id_pt_penerima', '=', 'penerimas.id_pt_penerima')
                ->join('barangs', 'purchase_orders.id', '=', 'barangs.id')
                ->where('purchase_orders.status', '=', 2)
                ->where('purchase_orders.po_muat', $id);
        $getdata = $query->get();
        return response()->json($getdata);
    }             
    public function store(Request $request) {
        DocTracking::create([
            'no_po'     => $request->no_po,
            'id_pol'     => $request->id_pol,
            'id_pod'     => $request->id_pod,
            'created_by'=> Session::get('id'),
            'status' => '1',
            'status_kapal'=> 1
        ]);
        return redirect()->back();
    }
    public function updatecurah(Request $request, $id) {
        $request->validate([
            'file' => 'mimes:jpeg,png,pdf',
            'file_tbg' => 'mimes:jpeg,png,pdf',
        ]);
    
        $detailTracking = DetailTracking::findOrFail($id);
    
        // Handle file uploads
        $this->handleFileUploadUpdateCurah($request, $detailTracking);
    
        // Update detail tracking information
        $this->updateDetailTrackingUpdateCurah($request, $detailTracking);
    
        // Update DetailTrackingSisa if necessary
        $this->updateDetailTrackingSisaUpdateCurah($request);
    
        return redirect()->back();
    }
    protected function handleFileUploadUpdateCurah($request, $detailTracking) {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $this->uploadFileUpdateCurah($file);
            $detailTracking->sj_file_name = $fileName;
            $detailTracking->sj_file_path = 'uploads/tracking/' . $fileName;
        }
    
        if ($request->hasFile('file_tbg')) {
            $file2 = $request->file('file_tbg');
            $fileName2 = $this->uploadFileUpdateCurah($file2);
            $detailTracking->st_file_name = $fileName2;
            $detailTracking->st_file_path = 'uploads/tracking/' . $fileName2;
        }
    
        $detailTracking->save();
    }
    
    protected function uploadFileUpdateCurah($file) {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = storage_path('app/public/uploads/tracking/' . $fileName);
    
        if (in_array($file->getMimeType(), ['image/jpeg', 'image/jpg', 'image/png'])) {
            $this->handleImageUploadUpdateCurah($file, $filePath);
        } else {
            Storage::disk('public')->putFileAs('uploads/tracking', $file, $fileName);
        }
    
        return $fileName;
    }
    
    protected function handleImageUploadUpdateCurah($file, $filePath) {
        $quality = 50;
        $imgInfo = getimagesize($file->getPathname());
        $mime = $imgInfo['mime'];
    
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($file->getPathname());
                break;
            case 'image/png':
                $image = imagecreatefrompng($file->getPathname());
                break;
            default:
                $image = imagecreatefromjpeg($file->getPathname());
        }
    
        if ($mime === 'image/png') {
            $quality = floor(9 * $quality / 100);
        }
    
        imagejpeg($image, $filePath, $quality);
        imagedestroy($image);
    }
    
    protected function updateDetailTrackingUpdateCurah($request, $detailTracking) {
        $detailTracking->fillUpdateCurah($request->except(['file', 'file_tbg', '_token']));
        $detailTracking->save();
    }
    
    protected function updateDetailTrackingSisaUpdateCurah($request) {
        $c = $request->qty_sisa_curah2;
        $b = $request->qty;
    
        $detailTrackingSisa = DetailTrackingSisa::where('id_track', $request->id_track)
            ->where('tipe', 'Curah')->first();
    
        if ($detailTrackingSisa) {
            $detailTrackingSisa->qty_tonase_sisa = ($c !== $b) ? $request->qty : $request->qty_sisa_curah;
            $detailTrackingSisa->save();
        } elseif ($c === $b) {
            DetailTrackingSisa::create([
                'id_track'          => $request->id_track,
                'qty_tonase_sisa'   => $request->qty_sisa_curah,
                'qty_total_tonase'  => $request->qty_curah_total,
                'status'            => 1,
                'tipe'              => 'Curah'
            ]);
        }
    }
    public function updateContainer(Request $request) {
        
        $request->validate([
            'file' => 'nullable|mimes:jpeg,png,pdf',
            'file_tbg' => 'nullable|mimes:jpeg,png,pdf',
        ]);
        
        $id = $request->id_edit;
    
        // Find the existing record by its ID
        $detailTracking = DetailTracking::where('id_detail_track', $id)->firstOrFail();
    
        // Update the record with the new values
        $detailTracking->update([
            'id_gudang'     => $request->id_gudang,
            'id_kapal'     => $request->id_kapal,
            'id_pol'   => $request->cont_pol,
            'id_pod'   => $request->cont_pod,
            'qty_tonase'     => $request->qty_tonase,
            'qty_timbang'     => $request->qty_timbang,
            'jml_sak'     => $request->jml_sak,
            'nopol'     => $request->nopol,
            'no_container'     => $request->no_container,
            'voyage'     => $request->voyage,
            'no_segel'     => $request->no_segel,
            'tgl_muat'     => $request->tgl_muat,
            'no_sj'     => $request->no_sj,
            'harga_hpp' => $request->hpp_kpl,   
        ]);
    
        // // Handle file uploads if provided
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $fileType = $file->getMimeType(); // Get the MIME type of the file
            
            // Handle file upload logic similar to your saveContainer function
            $imgInfo = getimagesize($file->getPathname());
            $mime = $imgInfo['mime'];
            $quality = 50;
    
            switch ($mime) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($file->getPathname());
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($file->getPathname());
                    break;
                default:
                    $image = imagecreatefromjpeg($file->getPathname());
            }
    
            $filePath = storage_path('app/public/uploads/tracking/' . $fileName);
    
            switch ($mime) {
                case 'image/jpeg':
                    imagejpeg($image, $filePath, $quality);
                    break;
                case 'image/png':
                    imagepng($image, $filePath, floor(9 * $quality / 100));
                    break;
                default:
                    imagejpeg($image, $filePath, $quality);
            }
    
            imagedestroy($image);
    
            // Update file information in the database
            $detailTracking->update([
                'sj_file_name'     => $fileName,
                'sj_file_path'     => 'uploads/tracking' . $fileName,
            ]);
        }
    
        if ($request->hasFile('file_tbg')) {
            $file2 = $request->file('file_tbg'); // Change variable name to $file2
            $fileName2 = time() . '_' . $file2->getClientOriginalName();
            $fileType2 = $file2->getMimeType(); // Get the MIME type of the file
            
            // Handle file_tbg upload logic similar to your saveContainer function
            $imgInfo2 = getimagesize($file2->getPathname());
            $mime2 = $imgInfo2['mime'];
            $quality2 = 50;
    
            switch ($mime2) {
                case 'image/jpeg':
                    $image2 = imagecreatefromjpeg($file2->getPathname());
                    break;
                case 'image/png':
                    $image2 = imagecreatefrompng($file2->getPathname());
                    break;
                default:
                    $image2 = imagecreatefromjpeg($file2->getPathname());
            }
    
            $filePath2 = storage_path('app/public/uploads/tracking/' . $fileName2);
    
            switch ($mime2) {
                case 'image/jpeg':
                    imagejpeg($image2, $filePath2, $quality2);
                    break;
                case 'image/png':
                    imagepng($image2, $filePath2, floor(9 * $quality2 / 100));
                    break;
                default:
                    imagejpeg($image2, $filePath2, $quality2);
            }
    
            imagedestroy($image2);
    
            // Update file_tbg information in the database
            $detailTracking->update([
                'st_file_name'     => $fileName2,
                'st_file_path'     => 'uploads/tracking' . $fileName2,
            ]);
        }
    
        // // Save the changes to the database
        $detailTracking->save();
    
        // // Redirect back or to a specific route
        return redirect()->back();
    }
    

    public function savecontainer(Request $request) {
        $request->validate([
            'file' => 'required|mimes:jpeg,png,pdf',
            'file_tbg' => 'required|mimes:jpeg,png,pdf',
        ]);
    
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $fileType = $file->getMimeType(); // Get the MIME type of the file

        $file2 = $request->file('file_tbg'); // Change variable name to $file2
        $fileName2 = time() . '_' . $file2->getClientOriginalName();
        $fileType2 = $file2->getMimeType(); // Get the MIME type of the file
    
        if (in_array($fileType, ['image/jpeg', 'image/jpg', 'image/png'])) {
            // It's an image, so perform resize and compression
    
            $imgInfo = getimagesize($file->getPathname());
            $mime = $imgInfo['mime'];
            $quality = 50;
    
            switch ($mime) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($file->getPathname());
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($file->getPathname());
                    break;
                default:
                    $image = imagecreatefromjpeg($file->getPathname());
            }
    
            $filePath = storage_path('app/public/uploads/tracking/' . $fileName);
    
            switch ($mime) {
                case 'image/jpeg':
                    imagejpeg($image, $filePath, $quality);
                    break;
                case 'image/png':
                    imagepng($image, $filePath, floor(9 * $quality / 100));
                    break;
                default:
                    imagejpeg($image, $filePath, $quality);
            }
    
            imagedestroy($image);
        } else {
            // It's not an image, so don't perform any resize or compression
            Storage::disk('public')->putFileAs('uploads/tracking', $file, $fileName);
        }
    
        if (in_array($fileType2, ['image/jpeg', 'image/jpg', 'image/png'])) {
            // It's an image, so perform resize and compression for the second file
    
            $imgInfo2 = getimagesize($file2->getPathname());
            $mime2 = $imgInfo2['mime'];
            $quality2 = 50;
    
            switch ($mime2) {
                case 'image/jpeg':
                    $image2 = imagecreatefromjpeg($file2->getPathname());
                    break;
                case 'image/png':
                    $image2 = imagecreatefrompng($file2->getPathname());
                    break;
                default:
                    $image2 = imagecreatefromjpeg($file2->getPathname());
            }
    
            $filePath2 = storage_path('app/public/uploads/tracking/' . $fileName2);
    
            switch ($mime2) {
                case 'image/jpeg':
                    imagejpeg($image2, $filePath2, $quality2);
                    break;
                case 'image/png':
                    imagepng($image2, $filePath2, floor(9 * $quality2 / 100));
                    break;
                default:
                    imagejpeg($image2, $filePath2, $quality2);
            }
    
            imagedestroy($image2);
        } else {
            // It's not an image, so don't perform any resize or compression for the second file
            Storage::disk('public')->putFileAs('uploads/tracking', $file2, $fileName2);
        }
        //batas
        
        DetailTracking::create([
            'id_track'     => $request->id_track,
            'id_gudang'     => $request->id_gudang,
            'id_kapal'     => $request->id_kapal,
            'id_pol'   => $request->cont_pol,
            'id_pod'   => $request->cont_pod,
            'qty_tonase'     => $request->qty_tonase,
            'qty_timbang'     => $request->qty_timbang,
            'jml_sak'     => $request->jml_sak,
            'nopol'     => $request->nopol,
            'no_container'     => $request->no_container,
            'voyage'     => $request->voyage,
            'no_segel'     => $request->no_segel,
            'tgl_muat'     => $request->tgl_muat,
            'td'     => '',
            'td_jkt'     => '',
            'ta'     => '',
            'no_sj'     => $request->no_sj,
            'harga_hpp' => $request->hpp_kpl,
            'sj_file_name'     => $fileName,
            'sj_file_path'     => 'uploads/tracking' . $fileName,
            'st_file_name'     => $fileName2,
            'st_file_path'     => 'uploads/tracking' . $fileName2,                                    
            'status' => '1'
        ]);
        $c = $request->qty_cont_emp2;
        $b = $request->qty_cont_ada;            
        $cekid = DetailTrackingSisa::where('id_track', $request->id_track)
                ->where('tipe','Container')->value('id_track');
        if ($cekid == $request->id_track){
            if ($c !== $b) {
                DetailTrackingSisa::where('id_track', $request->id_track)
                ->where('tipe','Container')->update([
                    'qty_tonase_sisa' => $request->qty_cont_ada,
                ]);
            } else if($c === $b){
                DetailTrackingSisa::where('id_track', $request->id_track)
                ->where('tipe','Container')->update([
                    'qty_tonase_sisa' => $request->qty_cont_emp2,
                ]);
            }
        }else if($cekid != $request->id_track){
            if($c === $b){
                DetailTrackingSisa::create([
                    'id_track'          => $request->id_track,
                    'qty_tonase_sisa'   => $request->qty_cont_emp,
                    'qty_total_tonase'  => $request->qty_cont_total,
                    'status'            => 1,
                    'tipe'              => 'Container'
                ]);
            }
        }
        return redirect()->back();
    }
    public function savecurah(Request $request) {
        $request->validate([
            'file' => 'required|mimes:jpeg,png,pdf',
            'file_tbg' => 'required|mimes:jpeg,png,pdf',
        ]);
    
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $fileType = $file->getMimeType(); // Get the MIME type of the file

        $file2 = $request->file('file_tbg'); // Change variable name to $file2
        $fileName2 = time() . '_' . $file2->getClientOriginalName();
        $fileType2 = $file2->getMimeType(); // Get the MIME type of the file
    
        if (in_array($fileType, ['image/jpeg', 'image/jpg', 'image/png'])) {
            // It's an image, so perform resize and compression
    
            $imgInfo = getimagesize($file->getPathname());
            $mime = $imgInfo['mime'];
            $quality = 50;
    
            switch ($mime) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($file->getPathname());
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($file->getPathname());
                    break;
                default:
                    $image = imagecreatefromjpeg($file->getPathname());
            }
    
            $filePath = storage_path('app/public/uploads/tracking/' . $fileName);
    
            switch ($mime) {
                case 'image/jpeg':
                    imagejpeg($image, $filePath, $quality);
                    break;
                case 'image/png':
                    imagepng($image, $filePath, floor(9 * $quality / 100));
                    break;
                default:
                    imagejpeg($image, $filePath, $quality);
            }
    
            imagedestroy($image);
        } else {
            // It's not an image, so don't perform any resize or compression
            Storage::disk('public')->putFileAs('uploads/tracking', $file, $fileName);
        }
    
        if (in_array($fileType2, ['image/jpeg', 'image/jpg', 'image/png'])) {
            // It's an image, so perform resize and compression for the second file
    
            $imgInfo2 = getimagesize($file2->getPathname());
            $mime2 = $imgInfo2['mime'];
            $quality2 = 50;
    
            switch ($mime2) {
                case 'image/jpeg':
                    $image2 = imagecreatefromjpeg($file2->getPathname());
                    break;
                case 'image/png':
                    $image2 = imagecreatefrompng($file2->getPathname());
                    break;
                default:
                    $image2 = imagecreatefromjpeg($file2->getPathname());
            }
    
            $filePath2 = storage_path('app/public/uploads/tracking/' . $fileName2);
    
            switch ($mime2) {
                case 'image/jpeg':
                    imagejpeg($image2, $filePath2, $quality2);
                    break;
                case 'image/png':
                    imagepng($image2, $filePath2, floor(9 * $quality2 / 100));
                    break;
                default:
                    imagejpeg($image2, $filePath2, $quality2);
            }
    
            imagedestroy($image2);
        } else {
            // It's not an image, so don't perform any resize or compression for the second file
            Storage::disk('public')->putFileAs('uploads/tracking', $file2, $fileName2);
        }
        
        DetailTracking::create([
            'id_track'     => $request->id_track,
            'id_gudang'     => $request->id_gudang,
            'id_kapal'     => $request->id_kapal,
            'id_pol'   => $request->did_pol,
            'id_pod'   => $request->did_pod,
            'qty_tonase'     => $request->qty_tonase,
            'qty_timbang'     => $request->qty_timbang,
            'jml_sak'     => $request->jml_sak,
            'nopol'     => $request->nopol,
            'no_container'     => null,
            'voyage'     => null,
            'no_segel'     => null,
            'tgl_muat'     => $request->tgl_muat,
            'td'     => '',
            'td_jkt'     => '',
            'ta'     => '',
            'no_sj'     => $request->no_sj,
            'harga_hpp' => $request->hpp_kpl,
            'sj_file_name'     => $fileName,
            'sj_file_path'     => 'uploads/tracking' . $fileName,
            'st_file_name'     => $fileName2,
            'st_file_path'     => 'uploads/tracking' . $fileName2,                                    
            'status' => '1'
        ]);

        $c = $request->qty_sisa_curah2;
        $b = $request->qty;            
        $cekid = DetailTrackingSisa::where('id_track', $request->id_track)
                ->where('tipe','Curah')->value('id_track');
        if ($cekid == $request->id_track){
            if ($c !== $b) {
                DetailTrackingSisa::where('id_track', $request->id_track)
                ->where('tipe','Curah')->update([
                    'qty_tonase_sisa' => $request->qty,
                ]);
            } else if($c === $b){
                DetailTrackingSisa::where('id_track', $request->id_track)
                ->where('tipe','Curah')->update([
                    'qty_tonase_sisa' => $request->qty_sisa_curah,
                ]);
            }
        }else if($cekid != $request->id_track){
            if($c === $b){
                DetailTrackingSisa::create([
                    'id_track'          => $request->id_track,
                    'qty_tonase_sisa'   => $request->qty_sisa_curah,
                    'qty_total_tonase'  => $request->qty_curah_total,
                    'status'            => 1,
                    'tipe'              => 'Curah'
                ]);
            }
        }
        
        return redirect()->back();
    }
    public function destroy(Request $request, $id) {
        // $idtracking = DetailTrackingSisa::select('qty_tonase_sisa')->where('id_track',$id)->get();
        $qty_sisa = $request->qty_sisa_simpan;
        if ($qty_sisa > 0) {
            DocTracking::where('id_track', $id)->update([
                'status' => '2'
            ]);
            DetailTracking::where('id_track', $id)
            ->whereNotIn('status', [0])
            ->update([
                'status' => '2'
            ]);
        }else if($qty_sisa == 0){
            DocTracking::where('id_track', $id)->update([
                'status' => '3'
            ]);
            DetailTracking::where('id_track', $id)
            ->whereNotIn('status', [0])
            ->update([
                'status' => '3'
            ]);
        }
        return redirect()->back();
        
    }    
    public function batal(Request $request) {
        if ($request->isMethod('put')) { // Check for PUT request
            $qty_sisa = $request->input('qty_sisa');
            $id = $request->input('id_track_btl');
    
            if ($qty_sisa > 0) {
                DocTracking::where('id_track', $id)->update([
                    'status' => '2'
                ]);
            } else if ($qty_sisa == 0) {
                DocTracking::where('id_track', $id)->update([
                    'status' => '3'
                ]);
            }
        }
    
        return redirect()->back();
    }    
    public function deletedata($id_track, $id_detail_track, $tonase) {
        DetailTracking::where('id_detail_track', $id_detail_track)
            ->update([
                'status' => 0,
            ]);
        $tipe = DetailTracking::where('id_detail_track', $id_detail_track)->value('no_container');
        
        if ($tipe==null) {
            $qty_tonase = DetailTrackingSisa::where('id_track', $id_track)->where('tipe','Curah')
                ->value('qty_tonase_sisa');
            $qtyt = intval($qty_tonase);
            $qty = $tonase + $qtyt;
            DetailTrackingSisa::where('id_track', $id_track)->where('tipe','Curah')
                ->update([
                    'qty_tonase_sisa' => $qty
                ]);
        }else if($tipe!=null){
            $qty_tonase = DetailTrackingSisa::where('id_track', $id_track)->where('tipe','Container')
                ->value('qty_tonase_sisa');
            $qtyt = intval($qty_tonase);
            $qty = $tonase + $qtyt;
            DetailTrackingSisa::where('id_track', $id_track)->where('tipe','Container')
                ->update([
                    'qty_tonase_sisa' => $qty
                ]);
        }
        return redirect()->back();
    }
}