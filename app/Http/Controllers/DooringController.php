<?php

namespace App\Http\Controllers;

use App\Models\DetailPH;
use App\Models\PortOfLoading;
use App\Models\PortOfDestination;
use App\Models\GudangMuat;
use App\Models\Penerima;
use App\Models\Kapal;
use App\Models\CPort;
use App\Models\PenawaranHarga;
use App\Models\Barang;
use App\Models\PurchaseOrder;
use App\Models\PtPenerima;
use App\Models\DocTracking;
use App\Models\DetailTracking;
use App\Models\DocDooring;
use App\Models\DetailDooring;
use App\Models\DetailDooringSisa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class DooringController extends Controller
{
    public function index()
    {
        $gudang = GudangMuat::where("status", 1)
            ->orderBy("id_gudang", "desc")
            ->get();
        $pol = PortOfLoading::where("status", 1)
            ->orderBy("id", "desc")
            ->get();
        $pod = PortOfDestination::where("status", 1)
            ->orderBy("id", "desc")
            ->get();
        $kapal = Kapal::select("*", "detail_tracking.id_track")
            ->join(
                "c_ports",
                "c_ports.id_company_port",
                "=",
                "kapals.id_company_port"
            )
            ->join(
                "detail_tracking",
                "detail_tracking.id_kapal",
                "=",
                "kapals.id"
            )
            ->where("kapals.status", 1)
            ->whereIn("detail_tracking.status", [2, 3])
            ->groupBy(
                "detail_tracking.voyage",
                "detail_tracking.id_kapal",
                "detail_tracking.id_track"
            )
            ->get();
        $po = DetailTracking::select("*")
            ->join(
                "doc_tracking",
                "doc_tracking.id_track",
                "=",
                "detail_tracking.id_track"
            )
            ->join(
                "purchase_orders",
                "purchase_orders.po_muat",
                "=",
                "doc_tracking.no_po"
            )
            ->join(
                "detail_p_h_s",
                "purchase_orders.id_detail_ph",
                "=",
                "detail_p_h_s.id_detail_ph"
            )
            ->join(
                "penawaran_hargas",
                "penawaran_hargas.id_penawaran",
                "=",
                "detail_p_h_s.id_penawaran"
            )
            ->join(
                "customers",
                "customers.id",
                "=",
                "penawaran_hargas.id_customer"
            )
            ->join(
                "penerimas",
                "detail_p_h_s.id_penerima",
                "=",
                "penerimas.id_penerima"
            )
            ->join(
                "pt_penerima",
                "pt_penerima.id_pt_penerima",
                "=",
                "penerimas.id_pt_penerima"
            )
            ->join("barangs", "purchase_orders.id", "=", "barangs.id")
            // ->join('doc_dooring','doc_dooring.id_track','=','doc_tracking.id_track')
            // ->whereIn('doc_tracking.status', [2, 3])
            // ->where('doc_tracking.created_by',Session::get('id'))
            // ->whereNotIn('purchase_orders.status', [0])
            // ->where('detail_tracking.ta','!=','')
            // ->groupBy('doc_tracking.no_po')
            // ->get();
            ->whereIn("doc_tracking.status", [2, 3])
            ->whereNotIn("doc_tracking.id_track", function ($query) {
                $query->select("id_track")->from("doc_dooring");
            })
            ->where(function ($query) {
                $query
                    ->where("detail_tracking.ta", "!=", "")
                    ->orWhereNull("detail_tracking.ta");
            })
            ->groupBy("doc_tracking.no_po")
            ->get();
        $track = DocDooring::select(
            "*",
            "doc_dooring.status",
            "doc_dooring.id_dooring",
            "detail_dooring.qty_tonase",
            "detail_dooring_sisa.tipe",
            "detail_dooring_sisa.qty_tonase_sisa",
            "detail_dooring.tipe"
        )
            ->selectSub(function ($query) {
                $query
                    ->selectRaw("SUM(qty_tonase_sisa)")
                    ->from("detail_dooring_sisa")
                    ->whereColumn(
                        "detail_dooring_sisa.id_dooring",
                        "doc_dooring.id_dooring"
                    )
                    // ->where('detail_tracking_sisa.status',1)
                    ->groupBy("detail_dooring_sisa.id_dooring");
            }, "total_all_sisa")
            ->selectSub(function ($query) {
                $query
                    ->selectRaw("SUM(qty_tonase)")
                    ->from("detail_dooring")
                    ->whereColumn(
                        "detail_dooring.id_dooring",
                        "doc_dooring.id_dooring"
                    )
                    ->whereIn("detail_dooring.status", [1, 2, 3])
                    ->where("tipe", "Container")
                    ->groupBy("detail_dooring.id_dooring");
            }, "door_container")
            ->selectSub(function ($query) {
                $query
                    ->selectRaw("SUM(qty_tonase)")
                    ->from("detail_dooring")
                    ->whereColumn(
                        "detail_dooring.id_dooring",
                        "doc_dooring.id_dooring"
                    )
                    ->whereIn("detail_dooring.status", [1, 2, 3])
                    ->where("tipe", "Curah")
                    ->groupBy("detail_dooring.id_dooring");
            }, "door_curah")
            ->selectSub(function ($query) {
                $query
                    ->selectRaw("SUM(qty_tonase)")
                    ->from("detail_dooring")
                    ->whereColumn(
                        "detail_dooring.id_dooring",
                        "doc_dooring.id_dooring"
                    )
                    ->whereIn("detail_dooring.status", [1, 2, 3])
                    ->groupBy("detail_dooring.id_dooring");
            }, "total_tonase_dooring")
            ->selectSub(function ($query) {
                $query
                    ->selectRaw("SUM(qty_tonase)")
                    ->from("detail_tracking")
                    ->whereColumn(
                        "detail_tracking.id_track",
                        "doc_tracking.id_track"
                    )
                    ->whereIn("status", [1, 2, 3])
                    ->groupBy("detail_tracking.id_track");
            }, "total_tonase_track")
            ->selectSub(function ($query) {
                $query
                    ->selectRaw("SUM(qty_tonase)")
                    ->from("detail_tracking")
                    ->whereColumn(
                        "detail_tracking.id_track",
                        "doc_tracking.id_track"
                    )
                    ->whereIn("detail_tracking.status", [1, 2, 3])
                    ->whereNull("no_container")
                    ->groupBy("detail_tracking.id_track");
            }, "muat_curah_track")
            ->selectSub(function ($query) {
                $query
                    ->selectRaw("SUM(qty_tonase)")
                    ->from("detail_tracking")
                    ->whereColumn(
                        "detail_tracking.id_track",
                        "doc_tracking.id_track"
                    )
                    ->whereIn("detail_tracking.status", [1, 2, 3])
                    ->whereNotNull("no_container")
                    ->groupBy("detail_tracking.id_track");
            }, "muat_container_track")
            ->join(
                "doc_tracking",
                "doc_tracking.id_track",
                "=",
                "doc_dooring.id_track"
            )
            ->join(
                "port_of_loading",
                "port_of_loading.id",
                "=",
                "doc_tracking.id_pol"
            )
            ->join(
                "port_of_destination",
                "port_of_destination.id",
                "=",
                "doc_tracking.id_pod"
            )
            ->join(
                "purchase_orders",
                "purchase_orders.po_muat",
                "=",
                "doc_tracking.no_po"
            )
            ->join(
                "detail_dooring",
                "detail_dooring.id_dooring",
                "=",
                "doc_dooring.id_dooring"
            )
            ->join(
                "detail_tracking",
                "detail_tracking.id_track",
                "=",
                "doc_tracking.id_track"
            )
            ->join(
                "detail_dooring_sisa",
                "detail_dooring_sisa.id_dooring",
                "=",
                "doc_dooring.id_dooring"
            )
            ->where("doc_dooring.status", 1)
            ->whereNotIn("purchase_orders.status", [0])
            ->whereNotIn("detail_tracking.status", [0])
            ->where("doc_dooring.created_by", Session::get("id"))
            ->groupBy("doc_dooring.id_dooring")
            ->orderBy("doc_dooring.id_dooring", "desc")
            ->get();
        $doornull = DocDooring::select(
            "*",
            "doc_dooring.status",
            "doc_dooring.id_dooring"
        )
            ->selectSub(function ($query) {
                $query
                    ->selectRaw("SUM(qty_tonase)")
                    ->from("detail_tracking")
                    ->whereColumn(
                        "detail_tracking.id_track",
                        "doc_tracking.id_track"
                    )
                    ->whereIn("status", [2, 3])
                    ->groupBy("detail_tracking.id_track");
            }, "total_tonase_track")
            ->selectSub(function ($query) {
                $query
                    ->selectRaw("SUM(qty_tonase)")
                    ->from("detail_tracking")
                    ->whereColumn(
                        "detail_tracking.id_track",
                        "doc_tracking.id_track"
                    )
                    ->whereIn("status", [2, 3])
                    ->whereNull("no_container")
                    ->groupBy("detail_tracking.id_track");
            }, "qty_curah_track")
            ->selectSub(function ($query) {
                $query
                    ->selectRaw("SUM(qty_tonase)")
                    ->from("detail_tracking")
                    ->whereColumn(
                        "detail_tracking.id_track",
                        "doc_tracking.id_track"
                    )
                    ->whereIn("status", [2, 3])
                    ->whereNotNull("no_container")
                    ->groupBy("detail_tracking.id_track");
            }, "qty_curah_cont")
            ->join(
                "doc_tracking",
                "doc_tracking.id_track",
                "=",
                "doc_dooring.id_track"
            )
            ->join(
                "detail_tracking",
                "detail_tracking.id_track",
                "=",
                "doc_dooring.id_track"
            )
            ->join(
                "port_of_loading",
                "port_of_loading.id",
                "=",
                "doc_tracking.id_pol"
            )
            ->join(
                "port_of_destination",
                "port_of_destination.id",
                "=",
                "doc_tracking.id_pod"
            )
            ->join(
                "purchase_orders",
                "purchase_orders.po_muat",
                "=",
                "doc_tracking.no_po"
            )
            ->where("doc_dooring.status", 1)
            ->whereNotIn("purchase_orders.status", [0])
            ->whereNotIn("detail_tracking.status", [0])
            ->where("doc_dooring.created_by", Session::get("id"))
            ->groupBy("doc_dooring.id_dooring")
            ->orderBy("doc_dooring.id_dooring", "desc")
            ->get();
        $doorzero = DocDooring::select(
            "*",
            "doc_dooring.status",
            "doc_dooring.id_dooring",
            "detail_tracking.id_detail_track"
        )
            ->selectSub(function ($query) {
                $query
                    ->selectRaw("SUM(qty_tonase)")
                    ->from("detail_tracking")
                    ->whereColumn(
                        "detail_tracking.id_track",
                        "doc_tracking.id_track"
                    )
                    ->whereIn("status", [2, 3])
                    ->groupBy("detail_tracking.id_track");
            }, "total_tonase_track")
            ->selectSub(function ($query) {
                $query
                    ->selectRaw("SUM(qty_tonase)")
                    ->from("detail_tracking")
                    ->whereColumn(
                        "detail_tracking.id_track",
                        "doc_tracking.id_track"
                    )
                    ->whereIn("status", [2, 3])
                    ->whereNull("no_container")
                    ->groupBy("detail_tracking.id_track");
            }, "qty_curah_track")
            ->selectSub(function ($query) {
                $query
                    ->selectRaw("SUM(qty_tonase)")
                    ->from("detail_tracking")
                    ->whereColumn(
                        "detail_tracking.id_track",
                        "doc_tracking.id_track"
                    )
                    ->whereIn("status", [2, 3])
                    ->whereNotNull("no_container")
                    ->groupBy("detail_tracking.id_track");
            }, "qty_curah_cont")
            ->join(
                "doc_tracking",
                "doc_tracking.id_track",
                "=",
                "doc_dooring.id_track"
            )
            ->join(
                "detail_tracking",
                "detail_tracking.id_track",
                "=",
                "doc_dooring.id_track"
            )
            ->join(
                "port_of_loading",
                "port_of_loading.id",
                "=",
                "doc_tracking.id_pol"
            )
            ->join(
                "port_of_destination",
                "port_of_destination.id",
                "=",
                "doc_tracking.id_pod"
            )
            ->join(
                "purchase_orders",
                "purchase_orders.po_muat",
                "=",
                "doc_tracking.no_po"
            )
            ->where("doc_dooring.status", 1)
            ->whereNotIn("purchase_orders.status", [0])
            ->whereNotIn("detail_tracking.status", [0])
            ->where("doc_dooring.created_by", Session::get("id"))
            ->whereIn("detail_tracking.status", [2, 3])
            ->groupBy("doc_dooring.id_dooring")
            ->orderBy("doc_dooring.id_dooring", "desc")
            ->get();
        $doorzero1 = DocDooring::select(
            "*",
            "doc_dooring.status",
            "doc_dooring.id_dooring"
        )
            ->selectSub(function ($query) {
                $query
                    ->selectRaw("SUM(qty_tonase)")
                    ->from("detail_tracking")
                    ->whereColumn(
                        "detail_tracking.id_track",
                        "doc_tracking.id_track"
                    )
                    ->whereIn("status", [2, 3])
                    ->groupBy("detail_tracking.id_track");
            }, "total_tonase_track")
            ->selectSub(function ($query) {
                $query
                    ->selectRaw("SUM(qty_tonase)")
                    ->from("detail_tracking")
                    ->whereColumn(
                        "detail_tracking.id_track",
                        "doc_tracking.id_track"
                    )
                    ->whereIn("status", [2, 3])
                    ->whereNull("no_container")
                    ->groupBy("detail_tracking.id_track");
            }, "qty_curah_track")
            ->selectSub(function ($query) {
                $query
                    ->selectRaw("SUM(qty_tonase)")
                    ->from("detail_tracking")
                    ->whereColumn(
                        "detail_tracking.id_track",
                        "doc_tracking.id_track"
                    )
                    ->whereIn("status", [2, 3])
                    ->whereNotNull("no_container")
                    ->groupBy("detail_tracking.id_track");
            }, "qty_curah_cont")
            ->join(
                "doc_tracking",
                "doc_tracking.id_track",
                "=",
                "doc_dooring.id_track"
            )
            // ->join('detail_tracking', 'detail_tracking.id_track', '=', 'doc_tracking.id_track')
            ->join(
                "detail_tracking",
                "detail_tracking.id_track",
                "=",
                "doc_dooring.id_track"
            )
            ->join(
                "detail_dooring_sisa",
                "detail_dooring_sisa.id_dooring",
                "=",
                "doc_dooring.id_dooring"
            )
            ->join(
                "port_of_loading",
                "port_of_loading.id",
                "=",
                "doc_tracking.id_pol"
            )
            ->join(
                "port_of_destination",
                "port_of_destination.id",
                "=",
                "doc_tracking.id_pod"
            )
            ->join(
                "purchase_orders",
                "purchase_orders.po_muat",
                "=",
                "doc_tracking.no_po"
            )
            ->where("doc_dooring.status", 1)
            ->whereNotIn("purchase_orders.status", [0])
            ->whereNotIn("detail_tracking.status", [0])
            ->where("doc_dooring.created_by", Session::get("id"))
            ->groupBy("doc_dooring.id_dooring")
            ->orderBy("doc_dooring.id_dooring", "desc")
            ->get();
        $doorsisa = DetailDooringSisa::select(
            "detail_dooring_sisa.id_dooring",
            "detail_dooring_sisa.tipe",
            "detail_dooring_sisa.qty_tonase_sisa"
        )
            ->join(
                "doc_dooring",
                "doc_dooring.id_dooring",
                "=",
                "doc_dooring.id_dooring"
            )
            ->where("doc_dooring.created_by", Session::get("id"))
            ->get();
        $getcurahqty = DocDooring::select(
            "doc_dooring.status",
            "doc_dooring.id_track",
            "detail_dooring_sisa.qty_tonase_sisa",
            "detail_tracking.no_segel",
            "detail_dooring.id_kapal"
        )
            ->join(
                "doc_tracking",
                "doc_tracking.id_track",
                "=",
                "doc_dooring.id_track"
            )
            ->join(
                "detail_tracking",
                "detail_tracking.id_track",
                "=",
                "doc_tracking.id_track"
            )
            ->join(
                "detail_dooring",
                "detail_dooring.id_dooring",
                "=",
                "doc_dooring.id_dooring"
            )
            ->join(
                "detail_dooring_sisa",
                "detail_dooring_sisa.id_dooring",
                "=",
                "doc_dooring.id_dooring"
            )
            ->join(
                "port_of_loading",
                "port_of_loading.id",
                "=",
                "doc_tracking.id_pol"
            )
            ->join(
                "port_of_destination",
                "port_of_destination.id",
                "=",
                "doc_tracking.id_pod"
            )
            ->join(
                "purchase_orders",
                "purchase_orders.po_muat",
                "=",
                "doc_tracking.no_po"
            )
            ->where("doc_dooring.status", 1)
            ->whereNotIn("purchase_orders.status", [0])
            ->whereNotIn("detail_tracking.status", [0])
            ->where("doc_dooring.created_by", Session::get("id"))
            ->where("detail_dooring_sisa.tipe", "Curah")
            ->groupBy("doc_dooring.id_dooring")
            ->orderBy("doc_dooring.id_dooring", "desc")
            ->get();
        $getcontqty = DocDooring::select(
            "doc_dooring.status",
            "doc_dooring.id_track",
            "detail_dooring_sisa.qty_tonase_sisa",
            "detail_tracking.no_segel",
            "detail_dooring.id_kapal"
        )
            ->join(
                "doc_tracking",
                "doc_tracking.id_track",
                "=",
                "doc_dooring.id_track"
            )
            ->join(
                "detail_tracking",
                "detail_tracking.id_track",
                "=",
                "doc_tracking.id_track"
            )
            ->join(
                "detail_dooring",
                "detail_dooring.id_dooring",
                "=",
                "doc_dooring.id_dooring"
            )
            ->join(
                "detail_dooring_sisa",
                "detail_dooring_sisa.id_dooring",
                "=",
                "doc_dooring.id_dooring"
            )
            ->join(
                "port_of_loading",
                "port_of_loading.id",
                "=",
                "doc_tracking.id_pol"
            )
            ->join(
                "port_of_destination",
                "port_of_destination.id",
                "=",
                "doc_tracking.id_pod"
            )
            ->join(
                "purchase_orders",
                "purchase_orders.po_muat",
                "=",
                "doc_tracking.no_po"
            )
            ->where("doc_dooring.status", 1)
            ->whereNotIn("purchase_orders.status", [0])
            ->whereNotIn("detail_tracking.status", [0])
            ->where("doc_dooring.created_by", Session::get("id"))
            ->where("detail_dooring_sisa.tipe", "Container")
            ->groupBy("doc_dooring.id_dooring")
            ->orderBy("doc_dooring.id_dooring", "desc")
            ->get();
        $details = DocDooring::select(
            "*",
            "doc_dooring.status",
            "doc_dooring.id_dooring"
        )
            ->join(
                "doc_tracking",
                "doc_tracking.id_track",
                "=",
                "doc_dooring.id_track"
            )
            ->join(
                "port_of_loading",
                "port_of_loading.id",
                "=",
                "doc_tracking.id_pol"
            )
            ->join(
                "port_of_destination",
                "port_of_destination.id",
                "=",
                "doc_tracking.id_pod"
            )
            ->join(
                "purchase_orders",
                "purchase_orders.po_muat",
                "=",
                "doc_tracking.no_po"
            )
            ->join(
                "detail_dooring",
                "detail_dooring.id_dooring",
                "=",
                "doc_dooring.id_dooring"
            )
            ->where("doc_dooring.status", 1)
            ->whereNotIn("purchase_orders.status", [0])
            ->whereNotIn("detail_dooring.status", [0])
            ->where("detail_dooring.status", 1)
            ->where("doc_dooring.created_by", Session::get("id"))
            ->groupBy("doc_dooring.id_dooring")
            ->orderBy("doc_dooring.id_dooring", "desc")
            ->count();
        $dtrack = DetailDooring::select(
            "detail_dooring.id_detail_door",
            "detail_dooring.tgl_muat",
            "detail_dooring.tgl_tiba",
            "detail_dooring.nopol",
            "detail_dooring.id_dooring",
            "detail_tracking.no_container",
            "detail_tracking.no_segel",
            "detail_dooring.qty_tonase",
            "detail_dooring.jml_sak",
            "detail_dooring.qty_timbang",
            "detail_dooring.no_tiket",
            "detail_dooring.no_sj",
            "detail_dooring.estate",
            "detail_dooring.status"
        )
            ->join(
                "doc_dooring",
                "doc_dooring.id_dooring",
                "=",
                "detail_dooring.id_dooring"
            )
            ->where("doc_dooring.created_by", Session::get("id"))
            ->join(
                "detail_tracking",
                "detail_tracking.id_detail_track",
                "=",
                "detail_dooring.id_detail_track"
            )
            ->whereNotIn("detail_dooring.status", [0])
            ->whereNotIn("detail_tracking.status", [0])
            ->where("detail_dooring.status", 1)
            ->get();
        $lastcurah = DetailDooring::join(
            "detail_dooring_sisa",
            "detail_dooring_sisa.id_dooring",
            "=",
            "detail_dooring.id_dooring"
        )
            ->join(
                "doc_dooring",
                "doc_dooring.id_dooring",
                "=",
                "detail_dooring.id_dooring"
            )
            ->select("*", "detail_dooring.id_detail_track")
            ->where("detail_dooring.status", 1)
            ->where("detail_dooring.tipe", "Curah")
            ->whereNotIn("detail_dooring.status", [0])
            ->where("doc_dooring.created_by", Session::get("id"))
            ->orderBy("detail_dooring.id_detail_door", "desc")
            ->first();
        $lastcontainer = DetailDooring::join(
            "detail_dooring_sisa",
            "detail_dooring_sisa.id_dooring",
            "=",
            "detail_dooring.id_dooring"
        )
            ->join(
                "doc_dooring",
                "doc_dooring.id_dooring",
                "=",
                "detail_dooring.id_dooring"
            )
            ->select("*", "detail_dooring.id_detail_track")
            ->where("detail_dooring.status", 1)
            ->where("detail_dooring.tipe", "Container")
            ->whereNotIn("detail_dooring.status", [0])
            ->where("doc_dooring.created_by", Session::get("id"))
            ->orderBy("detail_dooring.id_detail_door", "desc")
            ->first();
        $zerocurah = DocDooring::select("*")
            ->selectSub(function ($query) {
                $query
                    ->selectRaw("SUM(qty_tonase)")
                    ->from("detail_tracking")
                    ->whereColumn(
                        "detail_tracking.id_track",
                        "doc_tracking.id_track"
                    )
                    ->whereIn("detail_tracking.status", [2, 3])
                    ->whereNull("no_container")
                    ->groupBy("detail_tracking.id_track");
            }, "qty_curah_tracking")
            ->join(
                "doc_tracking",
                "doc_tracking.id_track",
                "=",
                "doc_dooring.id_track"
            )
            ->join(
                "detail_tracking",
                "detail_tracking.id_track",
                "=",
                "doc_dooring.id_track"
            )
            ->join(
                "purchase_orders",
                "purchase_orders.po_muat",
                "=",
                "doc_tracking.no_po"
            )
            ->where("doc_dooring.status", 1)
            ->whereNotIn("purchase_orders.status", [0])
            ->whereNotIn("detail_tracking.status", [0])
            ->whereNotIn("purchase_orders.status", [0])
            ->where("doc_dooring.created_by", Session::get("id"))
            ->whereNull("detail_tracking.no_container")
            ->groupBy("detail_tracking.no_container")
            ->get();
        $zeroContainer = DocDooring::select("*")
            ->selectSub(function ($query) {
                $query
                    ->selectRaw("SUM(qty_tonase)")
                    ->from("detail_tracking")
                    ->whereColumn(
                        "detail_tracking.id_track",
                        "doc_tracking.id_track"
                    )
                    ->whereIn("detail_tracking.status", [2, 3])
                    ->whereNotNull("no_container")
                    ->groupBy("detail_tracking.id_track");
            }, "qty_container_tracking")
            ->join(
                "doc_tracking",
                "doc_tracking.id_track",
                "=",
                "doc_dooring.id_track"
            )
            ->join(
                "detail_tracking",
                "detail_tracking.id_track",
                "=",
                "doc_dooring.id_track"
            )
            ->join(
                "purchase_orders",
                "purchase_orders.po_muat",
                "=",
                "doc_tracking.no_po"
            )
            ->where("doc_dooring.status", 1)
            ->whereNotIn("purchase_orders.status", [0])
            ->whereNotIn("detail_tracking.status", [0])
            ->whereNotIn("purchase_orders.status", [0])
            ->where("doc_dooring.created_by", Session::get("id"))
            ->whereNotNull("detail_tracking.no_container")
            ->groupBy("detail_tracking.no_container")
            ->limit(1)
            ->get();
        $estate = DocTracking::select("*")
            ->join(
                "purchase_orders",
                "purchase_orders.po_muat",
                "=",
                "doc_tracking.no_po"
            )
            ->join(
                "detail_p_h_s",
                "detail_p_h_s.id_detail_ph",
                "=",
                "purchase_orders.id_detail_ph"
            )
            ->join(
                "penerimas",
                "penerimas.id_penerima",
                "=",
                "detail_p_h_s.id_penerima"
            )
            ->where("doc_tracking.status", [2, 3])
            ->whereNotIn("purchase_orders.status", [0])
            ->get();
        $getcontainer = DetailTracking::select(
            "detail_tracking.no_container",
            "detail_tracking.id_detail_track",
            "detail_tracking.no_segel"
        )
            ->join(
                "doc_tracking",
                "doc_tracking.id_track",
                "=",
                "detail_tracking.id_track"
            )
            ->join(
                "doc_dooring",
                "doc_dooring.id_track",
                "=",
                "doc_tracking.id_track"
            )
            ->whereIn("detail_tracking.status", [2, 3])
            ->where("doc_dooring.created_by", Session::get("id"))
            ->whereNotNull("detail_tracking.no_container")
            ->get();
        $nosegel = DetailTracking::select(
            "detail_tracking.no_container",
            "detail_dooring.id_detail_track",
            "detail_tracking.no_segel"
        )
            ->join(
                "detail_dooring",
                "detail_tracking.id_detail_track",
                "=",
                "detail_dooring.id_detail_track"
            )
            ->join(
                "doc_tracking",
                "doc_tracking.id_track",
                "=",
                "detail_tracking.id_track"
            )
            ->join(
                "doc_dooring",
                "doc_dooring.id_track",
                "=",
                "doc_tracking.id_track"
            )
            ->whereIn("detail_tracking.status", [2, 3])
            ->where("doc_dooring.created_by", Session::get("id"))
            ->whereNotNull("detail_tracking.no_container")
            ->groupBy("detail_tracking.no_segel")
            ->get();
        $cek = DocDooring::where("doc_dooring.status", 1)
            ->where("created_by", Session::get("id"))
            ->get();
        $title = "Adhipramana Bahari Perkasa";
        $breadcrumb = "This Breadcrumb";

        $docDooring = DocDooring::with([
            "detailDooring" => function ($query) {
                $query->where("status", "=", 1);
            },
            "detailDooring.detailTracking",
            "detailDooring.detailTracking.docTracking",
            "detailDooring.detailTracking.docTracking.po",
            "detailDooring.detailTracking.docTracking.po.detailPhs",
            "detailDooring.detailTracking.docTracking.po.detailPhs.penerima",
        ])->get();

        $monitoringDooring = DocDooring::with([
            "detailDooring" => function ($query) {
                $query->whereIn("status", [2, 3, 4]);
            },
            "detailDooring.sisa",
            "detailDooring.detailTrackingCont",
            "detailDooring.docDooring",
            "detailDooring.docDooring.docTracking",
            "detailDooring.docDooring.docTracking.detailTracking",
            "detailDooring.docDooring.docTracking.detailTracking.kapal",
            "detailDooring.docDooring.docTracking.po.detailPhs",
            "detailDooring.docDooring.docTracking.po.detailPhs.penawaran",
            "detailDooring.docDooring.docTracking.po.detailPhs.penawaran.customer",
            "detailDooring.docDooring.docTracking.po.detailPhs.penerima",
            "detailDooring.docDooring.docTracking.po.detailPhs.penerima.ptPenerima",
            "detailDooring.docDooring.docTracking.po.barang",
            "detailDooring.docDooring.docTracking.portOfLoading",
            "detailDooring.docDooring.docTracking.portOfDestination",
        ])->get();
        return view(
            "pages.abp-page.dor",
            compact(
                "title",
                "breadcrumb",
                "po",
                "details",
                "getcurahqty",
                "getcontqty",
                "track",
                "doorzero",
                "dtrack",
                "lastcurah",
                "lastcontainer",
                "zerocurah",
                "zeroContainer",
                "gudang",
                "pol",
                "pod",
                "kapal",
                "estate",
                "docDooring",
                "monitoringDooring",
                "doornull",
                "cek",
                "getcontainer",
                "nosegel",
                "doorzero1",
                "doorsisa"
            )
        );
    }
    public function getKapalByTrack(Request $request)
    {
        // Validate the request
        $request->validate([
            'id_track' => 'required|integer', // Assuming id_track is an integer
        ]);

        // Fetch data from the database based on the provided id_track
        $kapal = Kapal::where('id_track', $request->id_track)
                      ->whereNotNull('no_container')
                      ->get();

                      $kapal = Kapal::select("*", "detail_tracking.id_track")
            ->join(
                "c_ports",
                "c_ports.id_company_port",
                "=",
                "kapals.id_company_port"
            )
            ->join(
                "detail_tracking",
                "detail_tracking.id_kapal",
                "=",
                "kapals.id"
            )
            ->where("kapals.status", 1)
            ->whereIn("detail_tracking.status", [2, 3])
            ->where('id_track', $request->id_track)
            ->whereNotNull('no_container')
            ->groupBy(
                "detail_tracking.voyage",
                "detail_tracking.id_kapal",
                "detail_tracking.id_track"
            )
            ->get();
        return response()->json($kapal);
    }

    public function getKapalDooringByID(Request $request)
    {
        $id = $request->id;
        // DB::enableQueryLog();
        $detailDooring = DetailDooring::select(
            'detail_dooring.id_dooring',
            'detail_dooring.id_detail_door',
            'kapals.nama_kapal',
            'detail_tracking.no_container',
            'detail_tracking.voyage',
            'detail_tracking.no_segel'
        )
        ->join('detail_tracking', 'detail_dooring.id_detail_track', '=', 'detail_tracking.id_detail_track')
        ->join('kapals', 'kapals.id', '=', 'detail_dooring.id_kapal')
        ->where('detail_dooring.id_detail_door', $id)
        ->whereIn('detail_dooring.status', [2, 3])
        ->get();
        // dd(DB::getQueryLog());
        return response()->json($detailDooring);
    }

    public function getKapalDooring($id, $voyage)
    {
        // DB::enableQueryLog();
        $kapal = Kapal::select("*", "detail_tracking.id_track")
            ->join(
                "c_ports",
                "c_ports.id_company_port",
                "=",
                "kapals.id_company_port"
            )
            ->join(
                "detail_tracking",
                "detail_tracking.id_kapal",
                "=",
                "kapals.id"
            )
            ->where("kapals.status", 1)
            ->whereIn("detail_tracking.status", [2, 3])
            ->where("detail_tracking.id_track", $id)
            ->where("detail_tracking.voyage", $voyage)
            ->whereNotNull("detail_tracking.no_container")
            ->groupBy("detail_tracking.no_container");
        $getdata = $kapal->get();
        // dd(DB::getQueryLog());
        return response()->json($getdata);
    }
    public function getContainer($id)
    {
        $cont = DetailTracking::select(
            "detail_tracking.no_container",
            "detail_tracking.id_detail_track",
            "detail_tracking.no_segel"
        )
            ->join(
                "doc_tracking",
                "doc_tracking.id_track",
                "=",
                "detail_tracking.id_track"
            )
            ->join(
                "doc_dooring",
                "doc_dooring.id_track",
                "=",
                "doc_tracking.id_track"
            )
            ->whereIn("detail_tracking.status", [2, 3])
            ->where("detail_tracking.id_detail_track", $id)
            ->whereNotNull("detail_tracking.no_container");
        $getdata = $cont->get();
        return response()->json($getdata);
    }
    public function getPoDooring($id)
    {
        $query = DetailTracking::select("*")
            ->join(
                "doc_tracking",
                "doc_tracking.id_track",
                "=",
                "detail_tracking.id_track"
            )
            ->join(
                "port_of_destination",
                "port_of_destination.id",
                "=",
                "doc_tracking.id_pod"
            )
            ->join(
                "port_of_loading",
                "port_of_loading.id",
                "=",
                "doc_tracking.id_pol"
            )
            ->join(
                "purchase_orders",
                "purchase_orders.po_muat",
                "=",
                "doc_tracking.no_po"
            )
            ->whereNotIn("purchase_orders.status", [0])
            ->join(
                "detail_p_h_s",
                "purchase_orders.id_detail_ph",
                "=",
                "detail_p_h_s.id_detail_ph"
            )
            ->join(
                "penawaran_hargas",
                "penawaran_hargas.id_penawaran",
                "=",
                "detail_p_h_s.id_penawaran"
            )
            ->join(
                "customers",
                "customers.id",
                "=",
                "penawaran_hargas.id_customer"
            )
            ->join(
                "penerimas",
                "detail_p_h_s.id_penerima",
                "=",
                "penerimas.id_penerima"
            )
            ->join(
                "pt_penerima",
                "pt_penerima.id_pt_penerima",
                "=",
                "penerimas.id_pt_penerima"
            )
            ->join("barangs", "purchase_orders.id", "=", "barangs.id")
            ->whereIn("doc_tracking.status", [2, 3])
            ->where("doc_tracking.id_track", $id);
        $getdata = $query->get();
        return response()->json($getdata);
    }
    public function store(Request $request)
    {
        // $request->validate([
        //     'file_bap' => 'required|mimes:jpeg,png,pdf|max:2048',
        // ]);

        // $file1 = $request->file('file_bap');
        // $fileName1 = time() . '_' . $file1->getClientOriginalName();

        // Storage::disk('public')->putFileAs('uploads/dooring', $file1, $fileName1);

        // $request->validate([
        //     'file_rekap' => 'required|mimes:jpeg,png,pdf|max:2048',
        // ]);

        // $file2 = $request->file('file_rekap');
        // $fileName2 = time() . '_' . $file2->getClientOriginalName();

        // Storage::disk('public')->putFileAs('uploads/dooring', $file2, $fileName2);
        DocDooring::create([
            "id_track" => $request->no_po,
            "created_by" => Session::get("id"),
            // 'sb_file_name'     => $fileName1,
            // 'sb_file_path'     => 'uploads/dooring' . $fileName1,
            // 'sr_file_name'     => $fileName2,
            // 'sr_file_path'     => 'uploads/dooring' . $fileName2,
            "status" => "1",
        ]);
        return redirect()->back();
    }

    public function updateCurah(Request $request)
    {

        $request->validate([
            "file_notiket" => "nullable|mimes:jpeg,png,pdf",
            "file_nosj" => "nullable|mimes:jpeg,png,pdf",
        ]);

        $id = $request->id;

        $detailDooring = DetailDooring::findOrFail($id);
        $detailDooring->tgl_muat = $request->tgl_brkt;
        $detailDooring->tgl_tiba = $request->tgl_tiba;
        $detailDooring->nopol = $request->nopol;
        $detailDooring->estate = $request->estate;
        $detailDooring->qty_tonase = $request->qty_tonase;
        $detailDooring->qty_timbang = $request->qty_timbang;
        $detailDooring->qty_tonase_bap = $request->qty_tonase_bap;
        $detailDooring->jml_sak = $request->sak;
        $detailDooring->no_tiket = $request->notiket;
        $detailDooring->no_sj = $request->no_surat;

        if ($request->hasFile("file_notiket")) {
            $detailDooring->st_file_name = $this->uploadFile(
                $request->file("file_notiket")
            );
        }

        if ($request->hasFile("file_nosj")) {
            $detailDooring->sj_file_name = $this->uploadFile(
                $request->file("file_nosj")
            );
        }

        $detailDooring->save();

        $this->updateDetailDooringSisa($request);

        return redirect()->back();
    }

    private function uploadFile($file)
    {
        $fileName = time() . "_" . $file->getClientOriginalName();
        $fileType = $file->getMimeType();

        if (in_array($fileType, ["image/jpeg", "image/jpg", "image/png"])) {
            $quality = 50;
            $image = Image::make($file->getPathname());

            if ($fileType === "image/png") {
                $quality = floor((9 * $quality) / 100);
            }

            $image->save(
                storage_path("app/public/uploads/dooring/" . $fileName),
                $quality
            );
        } else {
            $file->storeAs("uploads/dooring", $fileName, "public");
        }

        return $fileName;
    }

    private function updateDetailDooringSisa($request)
    {
        $qty_sisa_curah2 = $request->qty_sisa_curah2;
        $qty = $request->qty;
        $updateData = $qty_sisa_curah2 !== $qty
                ? ["qty_tonase_sisa" => $request->qty]
                : [];
        if (count($updateData) > 0) {
            DetailDooringSisa::where("id_dooring", $request->id_door)
            ->where("tipe", "Curah")
            ->update($updateData);
        }   
    }

    public function savecurah(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            "file_notiket" => "nullable|mimes:jpeg,png,pdf",
            "file_nosj" => "nullable|mimes:jpeg,png,pdf",
        ]);
    
        // Process file_notiket
        if ($request->hasFile("file_notiket")) {
            $file_notiket = $request->file("file_notiket");
            $file_notiket_path = $file_notiket->store("uploads/dooring");
        } else {
            $file_notiket_path = null; // No file provided
        }
    
        // Process file_nosj
        if ($request->hasFile("file_nosj")) {
            $file_nosj = $request->file("file_nosj");
            $file_nosj_path = $file_nosj->store("uploads/dooring");
        } else {
            $file_nosj_path = null; // No file provided
        }
    
        // Extracting data from the request
        list($id_kapal, $id_detail_track) = explode("-", $request->input("kpl_id"));
        
        // Create a new DetailDooring record
        $detailDooring = DetailDooring::create([
            "id_dooring" => $request->id_door,
            "id_kapal" => $id_kapal,
            "id_detail_track" => $id_detail_track,
            "tgl_muat" => $request->tgl_brkt,
            "tgl_tiba" => $request->tgl_tiba,
            "nopol" => $request->nopol,
            "estate" => $request->estate,
            "qty_tonase" => $request->qty_tonase,
            "qty_timbang" => $request->qty_timbang,
            "qty_tonase_bap" => $request->qty_tonase_bap,
            "jml_sak" => $request->sak,
            "no_tiket" => $request->notiket,
            "st_file_name" => $file_notiket_path ? basename($file_notiket_path) : null,
            "st_file_path" => $file_notiket_path,
            "no_sj" => $request->no_surat,
            "sj_file_name" => $file_nosj_path ? basename($file_nosj_path) : null,
            "sj_file_path" => $file_nosj_path,
            "tipe" => "Curah",
            "status" => 1,
        ]);
    
        // Updating DetailDooringSisa record
        $qty_sisa_curah2 = $request->qty_sisa_curah2;
        $qty = $request->qty;
        $qty_curah_total = $request->qty_curah_total;
    
        DetailDooringSisa::updateOrCreate(
            ["id_dooring" => $request->id_door, "tipe" => "Curah"],
            ["qty_tonase_sisa" => $qty == $qty_sisa_curah2 ? $qty_curah_total : $qty]
        );
    
        // Redirect back
        return redirect()->back();
    }

    public function savecontainer(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            "file_notiket" => "nullable|mimes:jpeg,png,pdf",
            "file_surat_jalan" => "nullable|mimes:jpeg,png,pdf",
        ]);
    
        // Process file_notiket
        $file_notiket_path = null;
        if ($request->hasFile("file_notiket")) {
            $file_notiket = $request->file("file_notiket");
            $file_notiket_path = $file_notiket->store("uploads/dooring");
        }
    
        // Process file_surat_jalan
        $file_surat_jalan_path = null;
        if ($request->hasFile("file_surat_jalan")) {
            $file_surat_jalan = $request->file("file_surat_jalan");
            $file_surat_jalan_path = $file_surat_jalan->store("uploads/dooring");
        }
    
        // Create a new DetailDooring record
        $detailDooring = DetailDooring::create([
            "id_dooring" => $request->id_door,
            "id_detail_track" => $request->id_dtl,
            "id_kapal" => $request->id_kpl,
            "tgl_muat" => $request->tgl_brkt,
            "tgl_tiba" => $request->tgl_tiba,
            "nopol" => $request->nopol,
            "estate" => $request->estate,
            "qty_tonase" => $request->qty_tonase,
            "qty_timbang" => $request->qty_timbang,
            "qty_tonase_bap" => $request->qty_tonase_bap,
            "jml_sak" => $request->simb,
            "no_tiket" => $request->notiket,
            "st_file_name" => $file_notiket_path ? basename($file_notiket_path) : null,
            "st_file_path" => $file_notiket_path,
            "no_sj" => $request->no_surat,
            "sj_file_name" => $file_surat_jalan_path ? basename($file_surat_jalan_path) : null,
            "sj_file_path" => $file_surat_jalan_path,
            "tipe" => "Container",
            "status" => 1,
        ]);
    
        // Updating DetailDooringSisa record
        $qty_sisa_container2 = $request->qty_sisa_container2;
        $qty = $request->qty;
        $qty_container_total = $request->qty_container_total;
    
        DetailDooringSisa::updateOrCreate(
            ["id_dooring" => $request->id_door, "tipe" => "Container"],
            ["qty_tonase_sisa" => $qty == $qty_sisa_container2 ? $qty_container_total : $qty]
        );
    
        // Redirect back
        return redirect()->back();
    }
    

    public function destroy(Request $request, $id)
    {
        // $idtracking = DetailTrackingSisa::select('qty_tonase_sisa')->where('id_track',$id)->get();
        $qty_sisa = $request->qty_sisa_simpan;
        if ($qty_sisa > 0) {
            DocDooring::where("id_dooring", $id)->update([
                "status" => "2",
            ]);
            DetailDooring::where("id_dooring", $id)
                ->whereNotIn("status", [0])
                ->update([
                    "status" => "2",
                ]);
        } elseif ($qty_sisa == 0) {
            DocDooring::where("id_dooring", $id)->update([
                "status" => "3",
            ]);
            DetailDooring::where("id_dooring", $id)
                ->whereNotIn("status", [0])
                ->update([
                    "status" => "3",
                ]);
        }
        return redirect()->back();
    }

    public function updateContainer(Request $request)
{
    $request->validate([
        "file_notiket" => "nullable|mimes:jpeg,png,pdf",
        "file_surat_jalan" => "nullable|mimes:jpeg,png,pdf",
    ]);

    $id = $request->id;

    $detailDooring = DetailDooring::findOrFail($id);

    if ($request->hasFile("file_notiket")) {
        $detailDooring->st_file_name = $this->uploadFile($request->file("file_notiket"));
    }

    if ($request->hasFile("file_surat_jalan")) {
        $detailDooring->sj_file_name = $this->uploadFile($request->file("file_surat_jalan"));
    }

    $detailDooring->tgl_muat = $request->tgl_brkt;
    $detailDooring->tgl_tiba = $request->tgl_tiba;
    $detailDooring->nopol = $request->nopol;
    $detailDooring->estate = $request->estate;
    $detailDooring->qty_tonase = $request->qty_tonase;
    $detailDooring->qty_timbang = $request->qty_timbang;
    $detailDooring->qty_tonase_bap = $request->qty_tonase_bap;
    $detailDooring->jml_sak = $request->simb;
    $detailDooring->no_tiket = $request->notiket;
    $detailDooring->no_sj = $request->no_surat;

    $detailDooring->save();

    $this->updateDetailDooringSisa($request);

    return redirect()->back();
}

    public function deletedata($id_dooring, $id_detail_door, $tonase)
    {
        DetailDooring::where("id_detail_door", $id_detail_door)->update([
            "status" => 0,
        ]);
        $tipe = DetailDooring::where("id_detail_door", $id_detail_door)->value(
            "tipe"
        );
        $qty_tonase = DetailDooringSisa::where("id_dooring", $id_dooring)
            ->where("tipe", $tipe)
            ->value("qty_tonase_sisa");
        $qtyt = intval($qty_tonase);
        $qty = $tonase + $qtyt;
        if ($tipe === "Curah") {
            DetailDooringSisa::where("id_dooring", $id_dooring)
                ->where("tipe", "Curah")
                ->update([
                    "qty_tonase_sisa" => $qty,
                ]);
        } elseif ($tipe === "Container") {
            DetailDooringSisa::where("id_dooring", $id_dooring)
                ->where("tipe", "Container")
                ->update([
                    "qty_tonase_sisa" => $qty,
                ]);
        }
        return redirect()->back();
    }
}