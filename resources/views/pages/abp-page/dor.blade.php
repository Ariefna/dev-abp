<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
        </x-slot>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <x-slot:headerFiles>
            <!--  BEGIN CUSTOM STYLE FILE  -->
            <link rel="stylesheet" href="{{asset('plugins/table/datatable/datatables.css')}}">
            <link rel="stylesheet" href="{{asset('plugins/flatpickr/flatpickr.css')}}">
            <link rel="stylesheet" href="{{asset('plugins/noUiSlider/nouislider.min.css')}}">
            @vite(['resources/scss/dark/assets/elements/alert.scss'])
            {{-- @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss']) --}}
            {{-- @vite(['resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss']) --}}
            @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
            @vite(['resources/scss/dark/plugins/table/datatable/custom_dt_miscellaneous.scss'])
            @vite(['resources/scss/light/assets/components/timeline.scss'])
            @vite(['resources/scss/dark/assets/components/modal.scss'])

            <!--  END CUSTOM STYLE FILE  -->

            <style>
            .toggle-code-snippet {
                margin-bottom: 0px;
            }

            body.dark .toggle-code-snippet {
                margin-bottom: 0px;
            }

            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            /* Firefox */
            input[type=number] {
                -moz-appearance: textfield;
            }
            </style>
            </x-slot>
            <!-- END GLOBAL MANDATORY STYLES -->

            <x-slot:scrollspyConfig>
                data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
                </x-slot>

                <!-- BREADCRUMB -->
                <div class="page-meta">
                    <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Document</li>
                            <li class="breadcrumb-item active" aria-current="page">Dooring</li>
                        </ol>
                    </nav>
                </div>
                <!-- /BREADCRUMB -->
                <div class="row layout-top-spacing">
                    {{-- @if ($cek->where('status', 1)->count() > 0) --}}
                    @if ($cek->where('status', 1)->count() > 0)
                    <div id="alertIcon" class="col-lg-12 mb-2">
                        <div class="widget-content widget-content-area">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg
                                        xmlns="http://www.w3.org/2000/svg" data-bs-dismiss="alert" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-x close">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg></button>
                                <strong>Selesaikan Dooring ini terlebih dahulu!</strong>
                            </div>
                        </div>
                    </div>
                    @else
                    <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Form Dooring</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area" style="padding: 1.5%;">
                                <form class="row g-3 needs-validation" action="{{ route('dooring.store') }}"
                                    method="POST" enctype="multipart/form-data" novalidate>
                                    @csrf
                                    <div class="col-md-6">
                                        <label for="validationCustom01" class="form-label">No PO</label>
                                        <select class="form-select" name="no_po" id="cb_po" required>
                                            <option selected disabled value="">Pilih...</option>
                                            @foreach ($po as $po)
                                            <option value="{{ $po->id_track }}">{{ $po->no_po }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            No PO tidak boleh kosong
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationCustom01" class="form-label">Rute</label>
                                        <input disabled name="rute" type="text" class="form-control" id="rute"
                                            placeholder="Rute">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="validationCustom01" class="form-label">PO Kebun</label>
                                        <input disabled name="po_kebun" type="text" class="form-control" id="po_kebun"
                                            placeholder="PO Kebun">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom03" class="form-label">Nama PT Kebun</label>
                                        <input disabled name="nm_kebun" type="text" class="form-control" id="nm_kebun"
                                            placeholder="Nama PT Kebun">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom01" class="form-label">Estate</label>
                                        <input disabled name="simb" type="text" class="form-control" id="est"
                                            placeholder="Estate">
                                        <div class="invalid-feedback">
                                            Form estate tidak boleh kosong
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom01" class="form-label">Jenis Pupuk</label>
                                        <input disabled name="simb" type="text" class="form-control" id="brg"
                                            placeholder="Jenis Pupuk">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationCustom03" class="form-label">Upload File Surat BAP</label>
                                        <div class="mb-3">
                                            <input name="file_bap" accept=".jpg, .png, .pdf"
                                                class="form-control file-upload-input"
                                                style="height: 48px; padding: 0.75rem 1.25rem;" type="file"
                                                id="formFile">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationCustom03" class="form-label">Upload File Rekap
                                            Kebun</label>
                                        <div class="mb-3">
                                            <input name="file_rekap" accept=".jpg, .png, .pdf"
                                                class="form-control file-upload-input"
                                                style="height: 48px; padding: 0.75rem 1.25rem;" type="file"
                                                id="formFile">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Tabel Dooring</h4>
                                        {{-- <p>{{ $details }}</p>
                                        <p>{{ $doorzero->count() }}</p> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="col-lg-12">
                                    <div class="statbox widget box box-shadow">
                                        <div class="widget-content widget-content-area">
                                            <table id="style-3" class="table style-3 dt-table-hover"
                                                style="width:100%;">
                                                <thead style="border-bottom: none;">
                                                    <tr>
                                                        <th>No PO</th>
                                                        <th>Rute</th>
                                                        <th>Dari Curah</th>
                                                        <th>Dari Container</th>
                                                        <th>Total Tonase</th>
                                                        <th>Total Muat Dooring</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- @if($) --}}
                                                    @if($doorzero1->count()==0)
                                                    @foreach ($doornull as $tra)
                                                    <tr>
                                                        <td>{{ $tra->no_po }}</td>
                                                        <td>{{ $tra->nama_pol }} - {{ $tra->nama_pod }}</td>
                                                        @if ($tra->qty_curah_track==null)
                                                        <td>0</td>
                                                        @else
                                                        <td>{{ number_format($tra->qty_curah_track , 0, ',', '.') }}
                                                        </td>
                                                        @endif
                                                        @if ($tra->qty_curah_cont==null)
                                                        <td>0</td>
                                                        @else
                                                        <td>{{ number_format($tra->qty_curah_cont , 0, ',', '.') }}</td>
                                                        @endif
                                                        <td>{{ number_format($tra->total_tonase_track , 0, ',', '.') }}
                                                        </td>
                                                        <td>0</td>
                                                        <td class="text-center"><span
                                                                class="shadow-none badge badge-danger">{{ $tra->status == 1 ? 'Pending' : '' }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            @if($tra->qty != 0)
                                                            <a href="#detailcur"
                                                                class="btn btn-outline-primary bs-tooltip me-2"
                                                                data-bs-toggle="modal" data-placement="top"
                                                                title="Add Curah">Curah</a>
                                                            @endif
                                                            @if($tra->qty2 != 0)
                                                            <a href="#detailcont"
                                                                class="btn btn-outline-primary bs-tooltip me-2"
                                                                data-bs-toggle="modal" data-placement="top"
                                                                title="Add Container">Container</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @elseif($doorzero->count()>0)
                                                    @if ($details==0 && $doorzero->count()==0)

                                                    @elseif($details && $doorzero->count())
                                                    @foreach ($track as $trac)
                                                    <tr>
                                                        <td>{{ $trac->no_po }}</td>
                                                        <td>{{ $trac->nama_pol }} - {{ $trac->nama_pod }}</td>
                                                        {{-- <td>{{ $track->where('tipe', 'Curah')->isEmpty() 
                                                        ? number_format($track->first()->muat_curah_track , 0, ',', '.') 
                                                        : number_format($track->first()->qty_tonase_sisa , 0, ',', '.') }}
                                                        </td> --}}
                                                        {{-- <td>{{ $track->where('tipe', 'Container')->isEmpty() 
                                                        ? number_format($track->first()->muat_container_track , 0, ',', '.')
                                                        : number_format($track->first()->qty_tonase_sisa , 0, ',', '.') }}
                                                        </td> --}}
                                                        <td>{{ number_format($trac->muat_curah_track - $trac->door_curah, 0, ',', '.') }}
                                                        </td>
                                                        <td>{{ number_format($trac->muat_container_track - $trac->door_container, 0, ',', '.') }}
                                                        </td>
                                                        {{-- <td>{{ number_format($trac->total_tonase_track , 0, ',', '.') }}
                                                        </td> --}}
                                                        <td>
                                                            {{ 
                                                            $total_track = 
                                                                number_format(
                                                                    (
                                                                        $trac->muat_curah_track - $trac->door_curah
                                                                    ) +
                                                                    (
                                                                        $trac->muat_container_track - $trac->door_container
                                                                    ),
                                                                    0, 
                                                                    ',', 
                                                                    '.'  
                                                                )
                                                            }}
                                                        </td>
                                                        <td>{{ number_format($trac->total_tonase_dooring , 0, ',', '.') }}
                                                        </td>
                                                        <td class="text-center"><span
                                                                class="shadow-none badge badge-danger">{{ $trac->status == 1 ? 'Pending' : '' }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            @if($trac->qty != 0)
                                                            @if(count($doorzero) > 0)
                                                            <a href="#detailcur"
                                                                class="btn btn-outline-primary bs-tooltip me-2"
                                                                data-bs-toggle="modal" data-placement="top"
                                                                title="Add Curah">Curah</a>
                                                            @else
                                                            <button class="btn btn-outline-primary bs-tooltip me-2"
                                                                data-placement="top" title="Add Curah"
                                                                disabled>Curah</button>
                                                            @endif
                                                            @endif
                                                            @if($trac->qty2 != 0)
                                                            @if(count($doorzero) > 0)
                                                            <a href="#detailcont"
                                                                class="btn btn-outline-primary bs-tooltip me-2"
                                                                data-bs-toggle="modal" data-placement="top"
                                                                title="Add Container">Container</a>
                                                            @else
                                                            <button type="button"
                                                                class="btn btn-outline-primary bs-tooltip me-2"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Add Container" disabled>Container</button>
                                                            @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @elseif($details==0 && $doorzero->count() > 0)
                                                    @foreach ($track as $trac)
                                                    @php
                                                    $total_track = 0;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $trac->no_po }}</td>
                                                        <td>{{ $trac->nama_pol }} - {{ $trac->nama_pod }}</td>
                                                        {{-- <td>{{ $track->where('tipe', 'Curah')->isEmpty() 
                                                        ? number_format($track->first()->muat_curah_track , 0, ',', '.') 
                                                        : number_format($track->first()->qty_tonase_sisa , 0, ',', '.') }}
                                                        </td>
                                                        <td>{{ $track->where('tipe', 'Container')->isEmpty() 
                                                        ? number_format($track->first()->muat_container_track , 0, ',', '.')
                                                        : number_format($track->first()->qty_tonase_sisa , 0, ',', '.') }}
                                                        </td> --}}
                                                        <td>{{ number_format($trac->muat_curah_track - $trac->door_curah, 0, ',', '.') }}
                                                        </td>
                                                        <td>{{ number_format($trac->muat_container_track - $trac->door_container, 0, ',', '.') }}
                                                        </td>
                                                        <td>
                                                            {{ 
                                                            $total_track = 
                                                                number_format(
                                                                    (
                                                                        $trac->muat_curah_track - $trac->door_curah
                                                                    ) +
                                                                    (
                                                                        $trac->muat_container_track - $trac->door_container
                                                                    ),
                                                                    0, 
                                                                    ',', 
                                                                    '.'  
                                                                )
                                                            }}
                                                        </td>
                                                        {{-- <td>{{ number_format($trac->total_tonase_track , 0, ',', '.') }}
                                                        </td> --}}
                                                        <td>{{ number_format($trac->total_tonase_dooring , 0, ',', '.') }}
                                                        </td>
                                                        <td class="text-center"><span
                                                                class="shadow-none badge badge-danger">{{ $trac->status == 1 ? 'Pending' : '' }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            @if($trac->qty != 0)
                                                            @if(count($doorzero) > 0)
                                                            <a href="#detailcur"
                                                                class="btn btn-outline-primary bs-tooltip me-2"
                                                                data-bs-toggle="modal" data-placement="top"
                                                                title="Add Curah">Curah</a>
                                                            @else
                                                            <button class="btn btn-outline-primary bs-tooltip me-2"
                                                                data-placement="top" title="Add Curah"
                                                                disabled>Curah</button>
                                                            @endif
                                                            @endif
                                                            @if($trac->qty2 != 0)
                                                            @if(count($doorzero) > 0)
                                                            <a href="#detailcont"
                                                                class="btn btn-outline-primary bs-tooltip me-2"
                                                                data-bs-toggle="modal" data-placement="top"
                                                                title="Add Container">Container</a>
                                                            @else
                                                            <button type="button"
                                                                class="btn btn-outline-primary bs-tooltip me-2"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Add Container" disabled>Container</button>
                                                            @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Tabel Detail Dooring</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="col-lg-12">
                                    <div class="statbox widget box box-shadow">
                                        <div class="widget-content widget-content-area">
                                            <table id="style-4" class="table style-4 dt-table-hover"
                                                style="width:100%;">
                                                <thead style="border-bottom: none;">
                                                    <tr>
                                                        <th>Tgl Muat</th>
                                                        <th>Tgl Tiba</th>
                                                        <th>Nopol</th>
                                                        <th>No Container</th>
                                                        <th>No Segel</th>
                                                        <th>Tonase</th>
                                                        <th>SAK</th>
                                                        <th>Timbangan</th>
                                                        <th>No Tiket Timbang</th>
                                                        <th>No Surat Jalan</th>
                                                        <th>Estate</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- @if($docDooring->count()==0)
                                        @else
                                        @foreach ($docDooring[0]->detailDooring as $dd) --}}
                                                    @foreach($dtrack as $dd)
                                                    <tr>
                                                        <td>{{ $dd->tgl_muat }}</td>
                                                        <td>{{ $dd->tgl_tiba }}</td>
                                                        <td>{{ $dd->nopol }}</td>
                                                        <td>{{ $dd->no_container ?? '-' }}</td>
                                                        <td>{{ $dd->no_segel ?? '-' }}</td>
                                                        <td>{{ number_format($dd->qty_tonase , 0, ',', '.') }}</td>
                                                        <td>{{ number_format($dd->jml_sak , 0, ',', '.') }}</td>
                                                        <td>{{ number_format($dd->qty_timbang , 0, ',', '.') }}</td>
                                                        <td>{{ $dd->no_tiket }}</td>
                                                        <td>{{ $dd->no_sj }}</td>
                                                        {{-- <td>{{ $dd->detailTracking->docTracking->po->detailPhs->penerima->estate ?? '-' }}
                                                        </td> --}}
                                                        <td>{{ $dd->estate }}</td>
                                                        <td class="text-center"><span
                                                                class="shadow-none badge badge-danger">{{ $dd->status == 1 ? 'Pending' : '' }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            @if(in_array('document-dooring-DELETE',
                                                            Session::get('nama_action')) || Session::get('role') ==
                                                            'superadmin')
                                                            <a href="#delete-{{ $dd->id_detail_door }}"
                                                                class="bs-tooltip" data-bs-toggle="modal"
                                                                data-bs-placement="top" title="Delete"
                                                                data-original-title="Delete"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="26"
                                                                    height="26" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-trash p-1 br-8 mb-1">
                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                    <path
                                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                    </path>
                                                                </svg></a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    {{-- @endif --}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Monitoring Dooring</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="col-lg-12">
                                    <div class="statbox widget box box-shadow">
                                        <div class="widget-content widget-content-area">
                                            <table id="show-hide-col" class="table show-hide-col dt-table-hover"
                                                style="width:100%;">
                                                <thead style="border-bottom: none;">
                                                    <tr>
                                                        <th>Customer</th>
                                                        <th>SPK</th>
                                                        <th>Rute</th>
                                                        <th>PO Kebun</th>
                                                        <th>PT Kebun</th>
                                                        <th>Estate</th>
                                                        <th>Description Barang</th>
                                                        <th>Qty Dooring</th>
                                                        <th>KG</th>
                                                        <th>SAK</th>
                                                        <th>Date Berangkat</th>
                                                        <th>Date Tiba</th>
                                                        <th>No Tiket Timbang</th>
                                                        <th>No Container</th>
                                                        <th>Nopol</th>
                                                        <th>Qty Timbang Kebun</th>
                                                        <th>Susut</th>
                                                        <th>Nama Kapal</th>
                                                        <th>TD</th>
                                                        <th class="text-center">Status</th>
                                                        {{-- <th class="text-center">Action</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($monitoringDooring->count()==0)
                                                    @else
                                                    @php
                                                    $totalTimbang = 0;
                                                    $susut = 0;
                                                    @endphp

                                                    @foreach ($monitoringDooring[1]->detailDooring as $md)
                                                    @php
                                                    $totalTimbang += $md->qty_timbang;
                                                    @endphp
                                                    @endforeach

                                                    @foreach ($monitoringDooring[1]->detailDooring as $md)
                                                    @if (!isset($totalQty))
                                                    @php
                                                    $totalQty = $md->docDooring->docTracking->po->total_qty;
                                                    @endphp
                                                    @endif

                                                    @php
                                                    $susut = $totalTimbang - $totalQty;

                                                    $noContainer = '';
                                                    $idKapal = $md->id_kapal;
                                                    $countDetailTrackingMultiple =
                                                    count($md->docDooring->docTracking->detailTrackingMultiple);

                                                    $namaKapal = '';
                                                    @endphp

                                                    @if ($countDetailTrackingMultiple > 0)
                                                    @for ($i=0; $i<$countDetailTrackingMultiple; $i++) @if ($md->
                                                        docDooring->docTracking->detailTrackingMultiple[$i]->id_kapal ==
                                                        $idKapal)
                                                        @php
                                                        $namaKapal =
                                                        $md->docDooring->docTracking->detailTrackingMultiple[$i]->kapal->nama_kapal;
                                                        @endphp

                                                        @if ($md->tipe == 'Container')
                                                        @php
                                                        $noContainer =
                                                        $md->docDooring->docTracking->detailTrackingMultiple[$i]->no_container;
                                                        @endphp
                                                        @endif
                                                        @endif
                                                        @endfor
                                                        @endif
                                                        <tr>
                                                            <td>{{ $md->docDooring->docTracking->po->detailPhs->penawaran->customer->nama_customer ?? '' }}
                                                            </td>
                                                            <td>{{ $md->docDooring->docTracking->no_po ?? '' }}</td>
                                                            <td>{{ $md->docDooring->docTracking->portOfLoading->nama_pol ?? '' }}
                                                                -
                                                                {{ $md->docDooring->docTracking->portOfDestination->nama_pod ?? '' }}
                                                            </td>
                                                            <td>{{ $md->docDooring->docTracking->po->po_kebun ?? '' }}
                                                            </td>
                                                            <td>{{ $md->docDooring->docTracking->po->detailPhs->penerima->ptPenerima->nama_penerima ?? '' }}
                                                            </td>
                                                            <td>{{ $md->estate }}</td>
                                                            <td>{{ $md->docDooring->docTracking->po->barang->nama_barang ?? '' }}
                                                            </td>
                                                            <td>{{ number_format($md->qty_tonase , 0, ',', '.') ?? '' }}
                                                            </td>
                                                            <td>KG</td>
                                                            <td>{{ number_format($md->jml_sak , 0, ',', '.') }}</td>
                                                            <td>{{ $md->tgl_muat }}</td>
                                                            <td>{{ $md->tgl_tiba }}</td>
                                                            <td>{{ $md->no_tiket }}</td>
                                                            <td>{{ $noContainer }}</td>
                                                            <td>{{ $md->nopol }}</td>
                                                            <td>{{ number_format($md->qty_timbang , 0, ',', '.') }}</td>
                                                            <td>{{ number_format($susut , 0, ',', '.') }}</td>
                                                            <td>{{ $namaKapal }}</td>
                                                            <td>{{ $md->docDooring->docTracking->detailTracking->td }}
                                                            </td>
                                                            <td class="text-center">{!! $md->status == 1 ? '<span
                                                                    class="shadow-none badge badge-success">Proses
                                                                    Muat</span>' : ($md->status == 2 ? '<span
                                                                    class="shadow-none badge badge-warning">Selesai
                                                                    Muat</span>' : '') !!}</td>
                                                            {{-- <td>
                                                <a href="{{route('monitoring.dooring.spk', $md->id_detail_door)}}"
                                                            class="btn btn-outline-primary mb-1">SPK Dooring</a>
                                                            </td> --}}
                                                        </tr>

                                                        @php
                                                        $totalQty = $md->docDooring->docTracking->po->total_qty;
                                                        @endphp
                                                        @endforeach
                                                        @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade bd-example-modal-xl" id="detailcur" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h5>Tambah Detail Dooring Kapal Curah</h5>
                                    <form name="modal-tracking-ada" class="row g-3 needs-validation"
                                        action="{{ route('dooring.savecurah') }}" method="POST"
                                        enctype="multipart/form-data" novalidate>
                                        @csrf
                                        @foreach ($doorzero as $tra)
                                        <input name="id_door" value="{{ $tra->id_dooring }}" type="hidden"
                                            class="form-control" id="validationCustom01" required>
                                        @endforeach
                                        <div class="col-md-6">
                                            <label for="validationCustom03" class="form-label">Date Berangkat</label>
                                            <input name="tgl_brkt" id="basicFlatpickr" value="2022-09-04"
                                                class="form-control flatpickr flatpickr-input active" type="date"
                                                placeholder="Select Date..">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="validationCustom03" class="form-label">Date Tiba</label>
                                            <input name="tgl_tiba" id="tgl_tiba" value="2022-09-04"
                                                class="form-control flatpickr flatpickr-input" type="date"
                                                placeholder="Select Date..">
                                        </div>
                                        <div class="col-md-6">
                                            @foreach ($doorzero as $tra)
                                            @if($lastcurah)
                                            <label for="validationCustom03" class="form-label">Kapal</label>
                                            <select class="form-select" name="kpl_id" id="cb_kpl" required>
                                                <option selected disabled value="">Pilih...</option>
                                                @foreach ($kapal as $kp)
                                                @if ($kp->id_track === $tra->id_track && $kp->no_container === null)
                                                <option
                                                    {{ $lastcurah->id_dooring == $tra->id_dooring ? 'selected' : '' }}
                                                    value="{{ $kp->id_kapal.'-'.$kp->id_detail_track }}">
                                                    {{ $kp->nama_kapal }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            @elseif($lastcurah==0)
                                            <label for="validationCustom03" class="form-label">Kapal</label>
                                            <select class="form-select" name="kpl_id" id="cb_kpl" required>
                                                <option selected disabled value="">Pilih...</option>
                                                @foreach ($kapal as $kp)
                                                @if ($kp->id_track === $tra->id_track && $kp->no_container === null)
                                                <option value="{{ $kp->id_kapal.'-'.$kp->id_detail_track }}">
                                                    {{ $kp->nama_kapal }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            {{-- <input type="text" name="" id="" value="{{ $tra->id_dooring }}"> --}}
                                            @endif
                                            @endforeach
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label for="validationCustom03" class="form-label">Estate</label>
                                            <input name="estate" type="text" value="" class="form-control"
                                                id="validationCustom01" placeholder="Masukkan estate" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="validationCustom03" class="form-label">Nopol Dooring</label>
                                            <input name="nopol" type="text" class="form-control" id="validationCustom01"
                                                placeholder="Nopol">
                                        </div>
                                        <div class="col-md-3">
                                            @foreach($doorzero as $tra)
                                            @php
                                            $match = $doorsisa->where('id_dooring',
                                            $tra->id_dooring)->where('tipe','Curah')->count() > 0;
                                            @endphp

                                            @if($lastcurah || $match)
                                            @foreach($getcurahqty as $zc)
                                            <label for="validationCustom01" class="form-label">QTY Tonase
                                                Dooring</label>
                                            <div class="input-group">
                                                <input type="number" name="qty_tonase" id="qty_curah"
                                                    class="form-control qty_curah" placeholder="QTY Tonase">
                                                <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                            </div>
                                            <span class="shadow-none badge badge-danger mt-2">Sisa:
                                                {{ number_format($zc->qty_tonase_sisa , 0, ',', '.') }}</span>
                                            <input name="qty_curah_total" id="qty_curah_total"
                                                value="{{ $zc->qty_tonase_sisa }}" type="hidden" step="any" min="0">
                                            <input name="qty" id="qty_sisa_curah" value="0" type="hidden" step="any"
                                                min="0">
                                            <div class="validationMessage"></div>
                                            @endforeach
                                            @elseif($lastcurah==0 || $match->count()==0)
                                            @foreach($zerocurah as $zc)
                                            <label for="validationCustom01" class="form-label">QTY Tonase
                                                Dooring</label>
                                            <div class="input-group">
                                                <input type="number" name="qty_tonase" id="qty_curah"
                                                    class="form-control qty_curah" placeholder="QTY Tonase">
                                                <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                            </div>
                                            <span class="shadow-none badge badge-danger mt-2">Sisa:
                                                {{ number_format($zc->qty_curah_tracking , 0, ',', '.') }}</span>
                                            <input name="qty_curah_total" id="qty_curah_total"
                                                value="{{ $zc->qty_curah_tracking }}" type="hidden" step="any" min="0">
                                            <input name="qty_sisa_curah" id="qty_sisa_curah" value="0" type="hidden"
                                                step="any" min="0">
                                            <div class="validationMessage"></div>
                                            @endforeach
                                            @endif
                                            @endforeach
                                        </div>
                                        <div class="col-md-3">
                                            <label for="validationCustom01" class="form-label">QTY Timbang
                                                Dooring</label>
                                            <div class="input-group">
                                                <input type="number" name="qty_timbang" class="form-control"
                                                    placeholder="QTY Timbang">
                                                <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="validationCustom01" class="form-label">QTY Tonase BAP</label>
                                            <div class="input-group">
                                                <input type="number" name="qty_tonase_bap" class="form-control"
                                                    placeholder="QTY BAP">
                                                <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="validationCustom01" class="form-label">SAK</label>
                                            <input name="sak" type="number" class="form-control" id="brg"
                                                placeholder="Sak">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="validationCustom03" class="form-label">No Tiket Timbang</label>
                                            <input name="notiket" type="text" class="form-control"
                                                id="validationCustom01" placeholder="No Tiket">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="validationCustom01" class="form-label">No Surat Jalan</label>
                                            <div class="input-group">
                                                <input name="no_surat" type="text" class="form-control"
                                                    placeholder="Surat Jalan">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="validationCustom03" class="form-label">Upload File No
                                                Tiket</label>
                                            <div class="mb-3">
                                                <input name="file_notiket" accept=".jpg, .png, .pdf"
                                                    class="form-control file-upload-input"
                                                    style="height: 48px; padding: 0.75rem 1.25rem;" type="file"
                                                    id="formFile">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="validationCustom03" class="form-label">Upload File Surat
                                                Jalan</label>
                                            <div class="mb-3">
                                                <input name="file_nosj" accept=".jpg, .png, .pdf"
                                                    class="form-control file-upload-input"
                                                    style="height: 48px; padding: 0.75rem 1.25rem;" type="file"
                                                    id="formFile">
                                            </div>
                                        </div>


                                        <div class="modal-footer justify-content-center">
                                            <button id="btn-modal-curah" type="submit"
                                                class="btn btn-primary">Tambah</button>
                                            <button type="button" class="btn btn btn-light-dark"
                                                data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i>Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- container --}}
                    {{-- @foreach ($doorzero as $tra) --}}
                    <div class="modal fade bd-example-modal-xl" id="detailcont" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h5>Tambah Detail Dooring Kapal Container</h5>
                                    <form name="modal-tracking-ada" class="row g-3 needs-validation"
                                        action="{{ route('dooring.savecontainer') }}" method="POST"
                                        enctype="multipart/form-data" novalidate>
                                        @csrf
                                        @foreach ($doorzero as $tra)
                                        <input name="id_track" value="{{ $tra->id_track }}" type="hidden"
                                            class="form-control" id="validationCustom01" required>
                                        <input name="id_door" value="{{ $tra->id_dooring }}" type="hidden"
                                            class="form-control" id="validationCustom01" required>
                                        @if($lastcontainer)
                                        <input name="id_detail" value="{{ $lastcontainer->id_detail_track }}"
                                            type="hidden" class="form-control" id="id_detail" required>
                                        @endif
                                        @endforeach
                                        <div class="col-md-6">
                                            <label for="validationCustom03" class="form-label">Date Berangkat</label>
                                            <input name="tgl_brkt" id="tgl_mcont" value="2022-09-04"
                                                class="form-control flatpickr flatpickr-input active" type="date"
                                                placeholder="Select Date..">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="validationCustom03" class="form-label">Date Tiba</label>
                                            <input name="tgl_tiba" id="tgl_tcont" value="2022-09-04"
                                                class="form-control flatpickr flatpickr-input" type="date"
                                                placeholder="Select Date..">
                                        </div>
                                        <div class="col-md-3">
                                            @foreach ($doorzero as $tra)
                                            @if($lastcontainer)
                                            <label for="validationCustom03" class="form-label">Kapal</label>
                                            <select class="form-select" name="id_kpl" id="cb_kplcont" required>
                                                <option selected disabled value="">Pilih...</option>
                                                @foreach
                                                ($kapal->where('id_track',$tra->id_track)->whereNotNull('no_container')
                                                as $kp)
                                                {{-- <option {{ $lastcontainer->id_dooring == $tra->id_dooring ? 'selected' : '' }}
                                                value="{{ $kp->id_track }}">{{ $kp->nama_kapal }}</option> --}}
                                                <option
                                                    {{ $lastcontainer->id_dooring == $tra->id_dooring ? 'selected' : '' }}
                                                    value="{{ $kp->id_track.'-'.$kp->voyage }}">
                                                    {{ $kp->nama_kapal.' '.$kp->voyage }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="id_kpl" id="id_kpl">
                                            @elseif($lastcontainer==0)
                                            <label for="validationCustom03" class="form-label">Kapal</label>
                                            <select class="form-select" name="kpl_id" id="cb_kplcont" required>
                                                <option selected disabled value="">Pilih...</option>
                                                @foreach
                                                ($kapal->where('id_track',$tra->id_track)->whereNotNull('no_container')
                                                as $kp)
                                                <option value="{{ $kp->id_track.'-'.$kp->voyage }}">
                                                    {{ $kp->nama_kapal.' '.$kp->voyage }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="id_kpl" id="id_kpl">
                                            @endif
                                            @endforeach
                                        </div>
                                        <div class="col-md-3">
                                            <label for="validationCustom03" class="form-label">No Cont</label>
                                            <select class="form-select" name="id_dtl" id="cb_cont" required>
                                                <option selected disabled value="">Pilih...</option>
                                                {{-- @foreach ($doorzero as $tra)
                                        @if($lastcontainer)
                                            @foreach ($getcontainer as $kp)
                                                <option {{ $lastcontainer->id_detail_track == $kp->id_detail_track ? 'selected' : '' }}
                                                value="{{ $kp->id_detail_track }}">{{ $kp->no_container }}</option>
                                                @endforeach
                                                @elseif($lastcontainer==0)
                                                <input type="text" name="id_dtl" id="id_dtl">
                                                @endif
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="validationCustom04" class="form-label">No Segel</label>
                                            <input disabled name="no_segel" id="no_segel" class="form-control"
                                                type="text" placeholder="No Segel">
                                            <!--@if($lastcontainer)-->
                                            <!--    @foreach($nosegel->where('id_detail_track',$lastcontainer->id_detail_track) as $tra)-->
                                            <!--        <input disabled name="no_segel" id="no_segel" value="{{ $lastcontainer->id_detail_track == $tra->id_detail_track ? $tra->no_segel : ''  }}" class="form-control" type="text" placeholder="No Segel">-->
                                            <!--    @endforeach-->
                                            <!--@elseif($lastcontainer==0)-->
                                            <!--        <input disabled name="no_segel" id="no_segel" class="form-control" type="text" placeholder="No Segel">-->
                                            <!--@endif-->
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <label for="validationCustom03" class="form-label">Estate</label>
                                            <input name="estate" type="text" value="" class="form-control"
                                                id="validationCustom01" placeholder="Masukkan estate" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="validationCustom03" class="form-label">Nopol Dooring</label>
                                            <input name="nopol" type="text" class="form-control" id="validationCustom01"
                                                placeholder="Nopol">
                                        </div>
                                        <div class="col-md-3">
                                            @foreach ($doorzero as $tra)
                                            @php
                                            $match = $doorsisa->where('id_dooring',
                                            $tra->id_dooring)->where('tipe','Container')->count() > 0;
                                            @endphp
                                            @if($lastcontainer || $match)
                                            @foreach($getcontqty as $zc)
                                            <label for="validationCustom01" class="form-label">QTY Tonase
                                                Dooring</label>
                                            <div class="input-group">
                                                <input type="number" name="qty_tonase" id="qty_container"
                                                    class="form-control qty_container" placeholder="QTY Tonase">
                                                <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                            </div>
                                            <span class="shadow-none badge badge-danger mt-2">Sisa:
                                                {{ number_format($zc->qty_tonase_sisa, 0, ',', '.') }}</span>
                                            <input name="qty_container_total" id="qty_container_total"
                                                value="{{ $zc->qty_tonase_sisa }}" type="hidden" step="any" min="0">
                                            <input name="qty" id="qty_sisa_container" value="0" type="hidden" step="any"
                                                min="0">
                                            <div class="validationMessage"></div>
                                            @endforeach
                                            @elseif($lastcontainer==0 || $match->count()==0)
                                            @foreach($zeroContainer as $zc)
                                            <label for="validationCustom01" class="form-label">QTY Tonase
                                                Dooring</label>
                                            <div class="input-group">
                                                <input type="number" name="qty_tonase" id="qty_container"
                                                    class="form-control qty_container" placeholder="QTY Tonase">
                                                <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                            </div>
                                            <span class="shadow-none badge badge-danger mt-2">Sisa:
                                                {{ number_format($zc->qty_container_tracking, 0, ',', '.') }}</span>
                                            <input name="qty_container_total" id="qty_container_total"
                                                value="{{ $zc->qty_container_tracking }}" type="hidden" step="any"
                                                min="0">
                                            <input name="qty_sisa_container" id="qty_sisa_container" value="0"
                                                type="hidden" step="any" min="0">
                                            <div class="validationMessage"></div>
                                            @endforeach
                                            @endif
                                            @endforeach
                                        </div>
                                        <div class="col-md-3">
                                            <label for="validationCustom01" class="form-label">QTY Timbang
                                                Dooring</label>
                                            <div class="input-group">
                                                <input type="number" name="qty_timbang" class="form-control"
                                                    placeholder="QTY Timbang">
                                                <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="validationCustom01" class="form-label">QTY Tonase BAP</label>
                                            <div class="input-group">
                                                <input type="number" name="qty_tonase_bap" class="form-control"
                                                    placeholder="QTY BAP">
                                                <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="validationCustom01" class="form-label">SAK</label>
                                            <input name="simb" type="number" class="form-control" id="brg"
                                                placeholder="Sak">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="validationCustom03" class="form-label">No Tiket Timbang</label>
                                            <input name="notiket" type="text" class="form-control"
                                                id="validationCustom01" placeholder="No Tiket">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="validationCustom01" class="form-label">No Surat Jalan</label>
                                            <div class="input-group">
                                                <input name="no_surat" type="text" class="form-control"
                                                    placeholder="Surat Jalan">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="validationCustom03" class="form-label">Upload File No
                                                Tiket</label>
                                            <div class="mb-3">
                                                <input name="file_notiket" accept=".jpg, .png, .pdf"
                                                    class="form-control file-upload-input"
                                                    style="height: 48px; padding: 0.75rem 1.25rem;" type="file"
                                                    id="formFile">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="validationCustom03" class="form-label">Upload File Surat
                                                Jalan</label>
                                            <div class="mb-3">
                                                <input name="file_surat_jalan" accept=".jpg, .png, .pdf"
                                                    class="form-control file-upload-input"
                                                    style="height: 48px; padding: 0.75rem 1.25rem;" type="file"
                                                    id="formFile">
                                            </div>
                                        </div>


                                        <div class="modal-footer justify-content-center">
                                            <button id="btn-modal-container" type="submit"
                                                class="btn btn-primary">Tambah</button>
                                            <button type="button" class="btn btn btn-light-dark"
                                                data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i>Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- @if($docDooring->count()==0)
        @else --}}
                    @foreach($dtrack as $dd)
                    <div class="modal fade bd-example-modal-l" id="delete-{{ $dd->id_detail_door }}" tabindex="-1"
                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-l modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body text-center">
                                    <h5>Apakah anda yakin ingin hapus data ini?</h5>
                                    <form class="row g-3 needs-validation"
                                        action="{{ route('dooring.deletedata', ['id_dooring'=>$dd->id_dooring,'id_detail_door' => $dd->id_detail_door, 'tonase'=>$dd->qty_tonase]) }}"
                                        method="POST">
                                        @method('PUT')
                                        @csrf
                                        <div class="modal-footer justify-content-center">
                                            <button type="submit" class="btn btn-primary">Iya hapus data ini!</button>
                                            <button type="button" class="btn btn btn-light-dark"
                                                data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i>Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    {{-- @endif --}}
                    <div class="d-grid gap-2 col-6 mx-auto">
                        @foreach ($track as $tra)
                        <form class="row g-3 needs-validation"
                            action="{{ route('dooring.destroy', ['dooring' => $tra->id_dooring]) }}" method="POST"
                            enctype="multipart/form-data" novalidate>
                            @method('DELETE')
                            @csrf
                            @if (count($track->where('status', 1)) >= 1 && count($docDooring->where('status', 1 )) >= 1)
                            <input type="hidden" value="{{ $tra->total_all_sisa }}" name="qty_sisa_simpan">
                            <button class="btn btn-success mb-4" type="submit">Simpan Dooring Ini</button>
                            @else
                            <button disabled class="btn btn-success mb-4" type="submit">Simpan Dooring Ini</button>
                            @endif
                        </form>
                        @endforeach
                    </div>
                </div>

                <!--  BEGIN CUSTOM SCRIPTS FILE  -->
                <x-slot:footerFiles>

                    <script type="module" src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
                    {{-- <script type="module" src="{{asset('plugins/flatpickr/custom-flatpickr.js')}}"></script> --}}
                    @vite(['resources/assets/js/forms/bootstrap_validation/bs_validation_script.js'])
                    <script type="module" src="{{asset('plugins/global/vendors.min.js')}}"></script>
                    @vite(['resources/assets/js/custom.js'])
                    {{-- <script type="module" src="{{asset('plugins/table/datatable/datatables.js')}}"></script> --}}
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                    <script src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
                    <script src="{{asset('plugins/global/vendors.min.js')}}"></script>
                    <script src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
                    <script src="{{asset('plugins/table/datatable/button-ext/dataTables.buttons.min.js')}}"></script>
                    <script src="{{asset('plugins/table/datatable/button-ext/jszip.min.js')}}"></script>
                    <script src="{{asset('plugins/table/datatable/button-ext/buttons.html5.min.js')}}"></script>
                    <script src="{{asset('plugins/table/datatable/button-ext/buttons.print.min.js')}}"></script>
                    {{-- <script src="{{asset('plugins/table/datatable/custom_miscellaneous.js')}}"></script> --}}

                    <script>
                    var f1 = flatpickr(document.getElementById('basicFlatpickr'), {
                        defaultDate: new Date()
                    });
                    var f2 = flatpickr(document.getElementById('tgl_tiba'), {
                        defaultDate: new Date()
                    });
                    var f3 = flatpickr(document.getElementById('tgl_mcont'), {
                        defaultDate: new Date()
                    });
                    var f4 = flatpickr(document.getElementById('tgl_tcont'), {
                        defaultDate: new Date()
                    });
                    </script>
                    <script type='text/javascript'>
                    $(document).ready(function() {
                        var valueidt = [];
                        $('#cb_po').change(function() {
                            var selectedId = $(this).val();
                            // $('#sel_emp').find('option').not(':first').remove();
                            if (selectedId !== '') {
                                $.ajax({
                                    url: "{{ route('getPoDooring', ['id' => ':id']) }}"
                                        .replace(':id', selectedId),
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(response) {
                                        var data = response[0];
                                        $("#po_kebun").empty();
                                        $("#nm_kebun").empty();
                                        $("#est").empty();
                                        $("#brg").empty();
                                        $("#rute").empty();
                                        if (response.length > 0) {
                                            for (var i = 0; i < response.length; i++) {

                                                $('#po_kebun').val(response[i].po_kebun);
                                                $('#nm_kebun').val(response[i]
                                                    .nama_penerima);
                                                $('#est').val(response[i].estate);
                                                $('#brg').val(response[i].nama_barang);
                                                $('#rute').val(response[i].nama_pol +
                                                    " - " + response[i].nama_pod);
                                            }
                                        } else {
                                            console.log("no data");
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.log("AJAX Error: " + error);
                                    }
                                });
                            } else {
                                $('#po_kebun').val('');
                                $('#nm_kebun').val('');
                                $('#est').val('');
                                $('#brg').val('');
                                $('#rute').val('');
                            }
                        });
                        $('#cb_kplcont').change(function() {
                            var selectedId = $(this).val();
                            var id_dt = $('#id_detail').val();
                            var parts = selectedId.split('-');
                            var id_track = parts[0];
                            var voyage = escape(parts[1]);
                            if (selectedId !== '') {
                                $.ajax({
                                    type: 'POST',
                                    url: "{{ route('getKapalDooring') }}",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        "id": id_track,
                                        "voyage": voyage
                                    },
                                    success: function(response) {
                                        var data = response[0];
                                        $("#cb_cont").empty();
                                        $('#id_kpl').empty();
                                        if (response.length > 0) {
                                            var defaultOption =
                                                "<option value='0' disabled selected required>Pilih...</option>";
                                            $('#cb_cont').append(defaultOption);
                                            for (var i = 0; i < response.length; i++) {
                                                var optVal = response[i].id_detail_track;
                                                var kapal_id = response[i].id_kapal;
                                                // var option = "<option value='"+ optVal +"' required>"+response[i].no_container+"</option>";
                                                var option = $("<option>")
                                                    .val(optVal)
                                                    .text(response[i].no_container);
                                                valueidt.push(optVal);
                                                $('#cb_cont').append(option);
                                                $('#id_kpl').val(kapal_id);
                                            }
                                            console.log(valueidt);
                                        } else {
                                            console.log("no data");
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.log("AJAX Error: " + error);
                                    }
                                });
                            } else {
                                $("#cb_cont").empty();
                            }
                        });
                        $('#cb_cont').change(function() {
                            var selectedId = $(this).val();
                            // $('#sel_emp').find('option').not(':first').remove();
                            if (selectedId !== '') {
                                $.ajax({
                                    url: "{{ route('getContainer', ['id' => ':id']) }}"
                                        .replace(':id', selectedId),
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(response) {
                                        var data = response[0];
                                        $("#no_segel").empty();
                                        $('#id_dtl').empty();
                                        if (response.length > 0) {
                                            for (var i = 0; i < response.length; i++) {
                                                var optVal = response[i].id_detail_track;
                                                $('#no_segel').val(response[i].no_segel);
                                                $('#id_dtl').val(optVal);
                                            }
                                        } else {
                                            console.log("no data");
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.log("AJAX Error: " + error);
                                    }
                                });
                            } else {
                                $("#no_segel").empty();
                            }
                        });
                        $('#detailcont').on('show.bs.modal', function(e) {
                            var id_dt = $('#id_detail').val();
                            if (id_dt !== '' && $('#cb_kplcont').val() !== null) {
                                var selectedId = $('#cb_kplcont').val();
                                var parts = selectedId.split('-');
                                var id_track = parts[0];
                                var voyage = escape(parts[1]);
                                voyage = voyage.replace(/%20/g, ' ')
                                $.ajax({
                                    type: 'POST',
                                    url: "{{ route('getKapalDooring') }}",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        "id": id_track,
                                        "voyage": voyage
                                    },
                                    success: function(response) {
                                        var data = response[0];
                                        $("#cb_cont").empty();
                                        $('#id_kpl').empty();
                                        if (response.length > 0) {
                                            var defaultOption =
                                                "<option value='0' disabled selected required>Pilih...</option>";
                                            $('#cb_cont').append(defaultOption);
                                            for (var i = 0; i < response.length; i++) {
                                                var optVal = response[i].id_detail_track;
                                                var kapal_id = response[i].id_kapal;
                                                var option = $("<option>")
                                                    .val(optVal)
                                                    .text(response[i].no_container);
                                                valueidt.push(optVal);
                                                if (optVal == id_dt) {
                                                    option.attr('selected', 'selected');
                                                }
                                                $('#cb_cont').append(option);
                                                $('#id_kpl').val(kapal_id);
                                            }
                                        } else {
                                            console.log("no data");
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.log("AJAX Error: " + error);
                                    }
                                });
                            }
                        });
                        $('.qty_curah').on('input', function() {
                            var inputVal = parseFloat($(this)
                                .val()); // Get the value of the input field as a number
                            // var totalQtyCurah = parseFloat($(this).data('total-qty-curah'));
                            var totalQtyCurah = parseFloat($('#qty_curah_total').val()) || 0;
                            var $validationMessage = $(this).closest('.input-group').siblings(
                                '.validationMessage'); // Find the validation message div

                            if (isNaN(inputVal)) {
                                $validationMessage.text('Please enter a valid number');
                                $('#btn-modal-curah').attr('disabled', true);
                                parseFloat($('#qty_sisa_curah').val(totalQtyCurah - inputVal));
                            } else if (inputVal > totalQtyCurah) {
                                $validationMessage.text('Tonase lebih dari sisa muat');
                                $('#btn-modal-curah').attr('disabled', true);
                                parseFloat($('#qty_sisa_curah').val(totalQtyCurah - inputVal));
                            } else {
                                $validationMessage.text('');
                                $('#btn-modal-curah').attr('disabled', false);
                                parseFloat($('#qty_sisa_curah').val(totalQtyCurah - inputVal));
                            }
                        });

                        $('.qty_container').on('input', function() {
                            var inputVal = parseFloat($(this).val());
                            var totalQtyContainer = parseFloat($('#qty_container_total').val()) || 0;
                            var $validationMessage = $(this).closest('.input-group').siblings(
                                '.validationMessage');

                            if (isNaN(inputVal)) {
                                $validationMessage.text('Please enter a valid number');
                                $('#btn-modal-container').attr('disabled', true);
                                parseFloat($('#qty_sisa_container').val(totalQtyContainer - inputVal));
                            } else if (inputVal > totalQtyContainer) {
                                $validationMessage.text('Tonase lebih dari sisa muat');
                                $('#btn-modal-container').attr('disabled', true);
                                parseFloat($('#qty_sisa_container').val(totalQtyContainer - inputVal));
                            } else {
                                $validationMessage.text('');
                                $('#btn-modal-container').attr('disabled', false);
                                parseFloat($('#qty_sisa_container').val(totalQtyContainer - inputVal));
                            }
                        });
                    });
                    </script>
                    <script>
                    var table = $('#show-hide-col').DataTable({
                        "dom": "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                            "<'table-responsive'tr>" +
                            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                        "oLanguage": {
                            "oPaginate": {
                                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                            },
                            "sInfo": "Showing page _PAGE_ of _PAGES_",
                            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                            "sSearchPlaceholder": "Search...",
                            "sLengthMenu": "Results :  _MENU_",
                        },
                        buttons: [{
                                text: 'Customer',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(0);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'SPK',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(1);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'Rute',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(2);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'PO Kebun',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(3);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'PT Kebun',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(4);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'Estate',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(5);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'Description Barang',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(6);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'QTY Dooring',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(7);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'KG',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(8);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'SAK',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(9);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'Date Berangkat',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(10);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'Date Tiba',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(11);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'No Tiket Timbang',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(12);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'No CONT',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(13);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'Nopol',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(14);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'QTY Timbang Kebun',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(15);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'Nama Kapal',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(16);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'TD',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(17);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'Status',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(18);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'Action',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(19);
                                    column.visible(!column.visible());
                                }
                            },
                        ],
                        "stripeClasses": [],
                        "lengthMenu": [7, 10, 20, 50],
                        "pageLength": 7,
                    });
                    // Create a reusable configuration object
                    const dataTableConfig = {
                        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                            "<'table-responsive'tr>" +
                            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                        "oLanguage": {
                            "oPaginate": {
                                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                            },
                            "sInfo": "Showing page _PAGE_ of _PAGES_",
                            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                            "sSearchPlaceholder": "Search...",
                            "sLengthMenu": "Results :  _MENU_",
                        },
                        "stripeClasses": [],
                        "lengthMenu": [5, 10, 20, 50],
                        "pageLength": 10,
                        "responsive": true
                    };

                    // Initialize DataTables using the configuration
                    $('#style-3, #style-4').DataTable(dataTableConfig);
                    </script>

                    </x-slot>
                    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>