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
            @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss'])
            @vite(['resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss'])
            @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
            @vite(['resources/scss/dark/plugins/table/datatable/custom_dt_miscellaneous.scss'])
            @vite(['resources/scss/light/assets/components/timeline.scss'])

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



            .select2-selection__rendered {
                color: #333;
            }

            #select2-cb_po-container {
                border: 1px solid #1b2e4b;
                color: #009688;
                font-size: 15px;
                padding: 8px 10px;
                letter-spacing: 1px;
                padding: .75rem 1.25rem;
                border-radius: 6px;
                background: #1b2e4b;
                height: auto;
                transition: none;

            }

            .select2-dropdown {
                background-color: rgba(14, 23, 38, 1) !important;
            }

            .select2-container--default .select2-selection--single {
                background-color: inherit !important;
                border: none !important;
                border-radius: 4px !important;
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
                            <li class="breadcrumb-item">Monitoring</li>
                            <li class="breadcrumb-item active" aria-current="page">Dooring</li>
                        </ol>
                    </nav>
                </div>
                <!-- /BREADCRUMB -->
                <div class="row layout-top-spacing">
                    @if(in_array('monitoring-mon-dooring-UPDATE', Session::get('nama_action')) || Session::get('role')
                    == 'superadmin')
                    <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Update Tabel Monitoring</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area" style="padding: 1.5%;">
                                {{-- @foreach ($limitedCollection as $getpo) --}}
                                <form class="row g-3 needs-validation" action="{{ route('mon-dooring.update') }}"
                                    method="POST" enctype="multipart/form-data" novalidate>
                                    @csrf
                                    @method('PUT')
                                    <div class="col-md-4">
                                        <label for="validationCustom01" class="form-label">No PO </label>
                                        <select class="form-select" name="cb_po" id="cb_po" required>
                                            <option selected disabled value="">Pilih...</option>
                                            @foreach ($tbl_po->unique('no_po') as $getpo)
                                            <option value="{{ $getpo->id_dooring }}">{{ $getpo->no_po }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="validationCustom03" class="form-label">Upload File BAP</label>
                                        <div class="mb-3">
                                            <input name="file" accept=".jpg, .png, .pdf"
                                                class="form-control file-upload-input"
                                                style="height: 48px; padding: 0.75rem 1.25rem;" type="file"
                                                id="formFile">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="validationCustom03" class="form-label">Upload File Rekap
                                            Kebun</label>
                                        <div class="mb-3">
                                            <input name="file2" accept=".jpg, .png, .pdf"
                                                class="form-control file-upload-input"
                                                style="height: 48px; padding: 0.75rem 1.25rem;" type="file"
                                                id="formFile">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                                {{-- @endforeach             --}}
                            </div>
                        </div>
                    </div>
                    @endif
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
                                                        <th>No CONT</th>
                                                        <th>Nopol</th>
                                                        <th>Qty Timbang Kebun</th>
                                                        <th>Susut</th>
                                                        <th>Nama Kapal</th>
                                                        <th>No Surat Jalan</th>
                                                        <th>TD</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($monitoringDooring->count()==0)
                                                    @else
                                                    @foreach ($monitoringDooring as $item)
                                                    @php
                                                    $totalTimbang = 0;
                                                    $susut = 0;
                                                    @endphp

                                                    @foreach ($item->detailDooring as $md)
                                                    @php
                                                    $totalTimbang += $md->qty_timbang;
                                                    @endphp
                                                    @endforeach

                                                    @foreach ($item->detailDooring as $md)
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
                                                            <td>{{ $md->detailTracking->portOfLoading->nama_pol ?? '' }}
                                                                -
                                                                {{ $md->detailTracking->portOfDestination->nama_pod ?? '' }}
                                                            </td>
                                                            <td>{{ $md->docDooring->docTracking->po->po_kebun ?? '' }}
                                                            </td>
                                                            <td>{{ $md->docDooring->docTracking->po->detailPhs->penerima->ptPenerima->nama_penerima ?? '' }}
                                                            </td>
                                                            <td>{{ $md->estate }}</td>
                                                            <td>{{ $md->docDooring->docTracking->po->barang->nama_barang ?? '' }}
                                                            </td>
                                                            <td>{{ $md->qty_tonase != 0 ? number_format($md->qty_tonase, 0, ',', ',') : number_format($md->qty_tonase_bap, 0, ',', ',') }}
                                                            </td>
                                                            <td>KG</td>
                                                            <td>{{ number_format($md->jml_sak , 0, ',', ',') }}</td>
                                                            <td data-order="{{ $md->tgl_muat }}">
                                                                {{ $md->tgl_muat ? date('d-M-Y', strtotime($md->tgl_muat)) : '' }}
                                                            </td>
                                                            <td data-order="{{ $md->tgl_tiba }}">
                                                                {{ $md->tgl_tiba ? date('d-M-Y', strtotime($md->tgl_tiba)) : '' }}
                                                            </td>
                                                            <td>{{ $md->no_tiket }}</td>
                                                            <td>{{ $md->detailTrackingCont->no_container }}</td>
                                                            <td>{{ $md->nopol }}</td>
                                                            <td>{{ number_format($md->qty_timbang , 0, ',', ',') }}</td>
                                                            <td>{{ number_format($susut , 0, ',', ',') }}</td>
                                                            <td>{{ $namaKapal }}</td>
                                                            <td>{{ $md->no_sj }}</td>
                                                            <td
                                                                data-order="{{ $md->docDooring->docTracking->detailTracking->td }}">
                                                                {{ $md->docDooring->docTracking->detailTracking->td ? date('d-M-Y', strtotime($md->docDooring->docTracking->detailTracking->td)) : '' }}
                                                            </td>
                                                            <td class="text-center">{!! $md->status == 1 ? '<span
                                                                    class="shadow-none badge badge-success">Proses
                                                                    Muat</span>' : ($md->status == 2 ? '<span
                                                                    class="shadow-none badge badge-warning">Selesai
                                                                    Muat</span>' : '') !!}</td>
                                                            <td>
                                                                {!! $md->docDooring->sb_file_name != null
                                                                ?
                                                                '<a href="'.route('downloadfile', ['path' => $md->docDooring->sb_file_name]).'"
                                                                    target="_blank" class="bs-tooltip"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Download BAP Dooring"
                                                                    data-original-title="Print">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-download">
                                                                        <path
                                                                            d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4">
                                                                        </path>
                                                                        <polyline points="7 10 12 15 17 10"></polyline>
                                                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                                                    </svg></a>'
                                                                : ''
                                                                !!}
                                                                {!! $md->docDooring->sr_file_name != null
                                                                ?
                                                                '<a href="'.route('downloadfile', ['path' => $md->docDooring->sr_file_name]).'"
                                                                    target="_blank" class="bs-tooltip"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Download Rekap Kebun"
                                                                    data-original-title="Print"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-download">
                                                                        <path
                                                                            d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4">
                                                                        </path>
                                                                        <polyline points="7 10 12 15 17 10"></polyline>
                                                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                                                    </svg>
                                                                    </svg></a>'
                                                                : ''
                                                                !!}
                                                                {!! $md->sj_file_name != null
                                                                ?
                                                                '<a href="'.route('downloadfile', ['path' => $md->sj_file_name]).'"
                                                                    target="_blank" class="bs-tooltip"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Surat Jalan Dooring"
                                                                    data-original-title="Print"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-download">
                                                                        <path
                                                                            d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4">
                                                                        </path>
                                                                        <polyline points="7 10 12 15 17 10"></polyline>
                                                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                                                    </svg>
                                                                    </svg></a>'
                                                                : ''
                                                                !!}
                                                                {!! $md->st_file_name != null
                                                                ?
                                                                '<a href="'.route('downloadfile', ['path' => $md->st_file_name]).'"
                                                                    target="_blank" class="bs-tooltip"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Surat Timbang Dooring"
                                                                    data-original-title="Print"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-download">
                                                                        <path
                                                                            d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4">
                                                                        </path>
                                                                        <polyline points="7 10 12 15 17 10"></polyline>
                                                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                                                    </svg>
                                                                    </svg></a>'
                                                                : ''
                                                                !!}
                                                                @if ($md->tipe == "Curah")
                                                                @if ($md->st_file_name != null && $md->sj_file_name !=
                                                                null)
                                                                <a href="#detailcur"
                                                                    class="btn btn-outline-primary bs-tooltip me-2 editcurah"
                                                                    data-bs-toggle="modal" data-placement="top"
                                                                    data-id="{{ $md->id_detail_door }}"
                                                                    data-kapal="{{ $md->id_kapal }}"
                                                                    data-date_berangkat="{{ $md->tgl_muat }}"
                                                                    data-date_tiba="{{ $md->tgl_tiba }}"
                                                                    data-estate="{{ $md->estate }}"
                                                                    data-nopol_dooring="{{ $md->nopol }}"
                                                                    data-qty_tonase_dooring="{{ $md->qty_tonase }}"
                                                                    data-qty_timbang_dooring="{{ $md->qty_timbang }}"
                                                                    data-qty_tonase_bap="{{ $md->qty_tonase_bap }}"
                                                                    data-sak="{{ $md->jml_sak }}"
                                                                    data-qty_tonase_sisa="{{$md->sisa->qty_tonase_sisa??0}}"
                                                                    data-no_tiket_timbang="{{ $md->no_tiket }}"
                                                                    data-no_surat_jalan="{{ $md->no_sj }}"
                                                                    data-file_no_tiket="{{route('downloadfile', ['path' => $md->st_file_name])}}"
                                                                    data-file_surat_jalan="{{route('downloadfile', ['path' => $md->sj_file_name])}}">Curah</a>
                                                                @else
                                                                <a href="#detailcur"
                                                                    class="btn btn-outline-primary bs-tooltip me-2 editcurah"
                                                                    data-bs-toggle="modal" data-placement="top"
                                                                    data-id="{{ $md->id_detail_door }}"
                                                                    data-kapal="{{ $md->id_kapal }}"
                                                                    data-date_berangkat="{{ $md->tgl_muat }}"
                                                                    data-date_tiba="{{ $md->tgl_tiba }}"
                                                                    data-estate="{{ $md->estate }}"
                                                                    data-nopol_dooring="{{ $md->nopol }}"
                                                                    data-qty_tonase_dooring="{{ $md->qty_tonase }}"
                                                                    data-qty_timbang_dooring="{{ $md->qty_timbang }}"
                                                                    data-qty_tonase_bap="{{ $md->qty_tonase_bap }}"
                                                                    data-sak="{{ $md->jml_sak }}"
                                                                    data-qty_tonase_sisa="{{$md->sisa->qty_tonase_sisa??0}}"
                                                                    data-no_tiket_timbang="{{ $md->no_tiket }}"
                                                                    data-no_surat_jalan="{{ $md->no_sj }}">Curah</a>
                                                                @endif
                                                                @endif
                                                                @if ($md->tipe == "Container")
                                                                @if ($md->st_file_name != null && $md->sj_file_name !=
                                                                null)
                                                                <a href="#detailcontainer"
                                                                    class="btn btn-outline-primary bs-tooltip me-2 editcontainer"
                                                                    data-bs-toggle="modal" data-placement="top"
                                                                    data-id="{{ $md->id_detail_door }}"
                                                                    data-id_track="{{ $md->docDooring->docTracking->id_track }}"
                                                                    data-id_detail_track="{{ $md->detailTracking->id_detail_track }}"
                                                                    data-kapal="{{ $md->id_kapal }}"
                                                                    data-no_segel="{{ $md->detailTracking->no_segel }}"
                                                                    data-date_berangkat="{{ $md->tgl_muat }}"
                                                                    data-date_tiba="{{ $md->tgl_tiba }}"
                                                                    data-estate="{{ $md->estate }}"
                                                                    data-nopol_dooring="{{ $md->nopol }}"
                                                                    data-qty_tonase_dooring="{{ $md->qty_tonase }}"
                                                                    data-qty_timbang_dooring="{{ $md->qty_timbang }}"
                                                                    data-qty_tonase_bap="{{ $md->qty_tonase_bap }}"
                                                                    data-sak="{{ $md->jml_sak }}"
                                                                    data-vogaye="{{ $md->detailTracking->voyage }}"
                                                                    data-qty_tonase_sisa="{{$md->sisa->qty_tonase_sisa??0}}"
                                                                    data-no_tiket_timbang="{{ $md->no_tiket }}"
                                                                    data-no_surat_jalan="{{ $md->no_sj }}"
                                                                    data-file_no_tiket="{{route('downloadfile', ['path' => $md->st_file_name])}}"
                                                                    data-file_surat_jalan="{{route('downloadfile', ['path' => $md->sj_file_name])}}">Container</a>
                                                                @else
                                                                <a href="#detailcontainer"
                                                                    class="btn btn-outline-primary bs-tooltip me-2 editcontainer"
                                                                    data-bs-toggle="modal" data-placement="top"
                                                                    data-id="{{ $md->id_detail_door }}"
                                                                    data-id_track="{{ $md->docDooring->docTracking->id_track }}"
                                                                    data-id_detail_track="{{ $md->detailTracking->id_detail_track }}"
                                                                    data-kapal="{{ $md->id_kapal }}"
                                                                    data-no_segel="{{ $md->detailTracking->no_segel }}"
                                                                    data-date_berangkat="{{ $md->tgl_muat }}"
                                                                    data-date_tiba="{{ $md->tgl_tiba }}"
                                                                    data-estate="{{ $md->estate }}"
                                                                    data-nopol_dooring="{{ $md->nopol }}"
                                                                    data-qty_tonase_dooring="{{ $md->qty_tonase }}"
                                                                    data-qty_timbang_dooring="{{ $md->qty_timbang }}"
                                                                    data-qty_tonase_bap="{{ $md->qty_tonase_bap }}"
                                                                    data-sak="{{ $md->jml_sak }}"
                                                                    data-vogaye="{{ $md->detailTracking->voyage }}"
                                                                    data-qty_tonase_sisa="{{$md->sisa->qty_tonase_sisa??0}}"
                                                                    data-no_tiket_timbang="{{ $md->no_tiket }}"
                                                                    data-no_surat_jalan="{{ $md->no_sj }}">Container</a>
                                                                @endif
                                                                @endif



                                                            </td>
                                                        </tr>

                                                        @php
                                                        $totalQty = $md->docDooring->docTracking->po->total_qty;
                                                        @endphp
                                                        @endforeach
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
                </div>
                <div class="modal fade bd-example-modal-xl" id="detailcontainer" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h5>Edit Detail Dooring Kapal Container</h5>
                                <form name="modal-tracking-ada" class="row g-3 needs-validation"
                                    action="{{ route('dooring.updatecontainer') }}" method="POST"
                                    enctype="multipart/form-data" novalidate>
                                    @csrf
                                    <input type="hidden" id="idContainer" name="id">
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
                                        <label for="validationCustom03" class="form-label">Kapal</label>
                                        <select class="form-select" name="id_kpl" id="cb_kplcont" required>
                                            <option selected disabled value="">Pilih...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom03" class="form-label">No Cont</label>
                                        <select class="form-select" name="id_dtl" id="cb_cont" required>
                                            <option selected disabled value="">Pilih...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom04" class="form-label">No Segel</label>
                                        <input disabled name="no_segel" id="noSegel" class="form-control" type="text"
                                            placeholder="No Segel">
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <label for="validationCustom03" class="form-label">Estate</label>
                                        <input name="estate" type="text" value="" class="form-control" id="estate"
                                            placeholder="Masukkan estate" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="validationCustom03" class="form-label">Nopol Dooring</label>
                                        <input name="nopol" type="text" class="form-control" id="nopolDooring"
                                            placeholder="Nopol">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom01" class="form-label">QTY Tonase Dooring</label>
                                        <div class="input-group">
                                            <input type="number" name="qty_tonase" id="qtyTonaseDooring"
                                                class="form-control qty_container" placeholder="QTY Tonase" readonly="true">
                                            <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                        </div>
                                        <span class="shadow-none badge badge-danger mt-2" id="qtyTonaseSisa">Sisa:
                                        </span>
                                        <input name="qty_container_total" id="qty_container_total" value=""
                                            type="hidden" step="any" min="0">
                                        <input name="qty" id="qty_sisa_container" value="0" type="hidden" step="any"
                                            min="0">
                                        <div class="validationMessage"></div>
                                        <input name="qty_container_total" id="qty_container_total" value=""
                                            type="hidden" step="any" min="0">
                                        <input name="qty_sisa_container" id="qty_sisa_container" value="0" type="hidden"
                                            step="any" min="0">
                                        <div class="validationMessage"></div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom01" class="form-label">QTY Timbang Dooring</label>
                                        <div class="input-group">
                                            <input type="number" name="qty_timbang" class="form-control"
                                                placeholder="QTY Timbang" id="qtyTimbangDooring"  readonly="true">
                                            <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="validationCustom01" class="form-label">QTY Tonase BAP</label>
                                        <div class="input-group">
                                            <input type="number" name="qty_tonase_bap" class="form-control"
                                                placeholder="QTY BAP" id="qtyTonaseBap"  readonly="true">
                                            <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="validationCustom01" class="form-label">SAK</label>
                                        <input name="simb" type="number" class="form-control" id="sak"
                                            placeholder="Sak">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="validationCustom03" class="form-label">No Tiket Timbang</label>
                                        <input name="notiket" type="text" class="form-control" id="noTiketTimbang"
                                            placeholder="No Tiket">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationCustom01" class="form-label">No Surat Jalan</label>
                                        <div class="input-group">
                                            <input name="no_surat" type="text" class="form-control"
                                                placeholder="Surat Jalan" id="noSuratJalan">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationCustom03" class="form-label">Upload File No Tiket <a
                                                href="" id="fileNoTiket" target="_blank"
                                                class="shadow-none badge badge-success text-white">Lihat</a></label>
                                        <div class="mb-3">
                                            <input name="file_notiket" accept=".jpg, .png, .pdf"
                                                class="form-control file-upload-input"
                                                style="height: 48px; padding: 0.75rem 1.25rem;" type="file"
                                                id="formFile">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationCustom03" class="form-label">Upload File Surat
                                            Jalan <a href="" id="fileSuratJalan" target="_blank"
                                                class="shadow-none badge badge-success text-white">Lihat</a></label>
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
                                        <button type="button" class="btn btn btn-light-dark" data-bs-dismiss="modal"><i
                                                class="flaticon-cancel-12"></i>Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade bd-example-modal-xl" id="detailcur" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h5>Edit Detail Dooring Kapal Curah</h5>
                                <form name="modal-tracking-ada" class="row g-3 needs-validation"
                                    action="{{ route('dooring.updatecurah') }}" enctype="multipart/form-data" method="POST" novalidate>
                                    @csrf
                                    <input type="hidden" id="idCurah" name="id">
                                    <div class="col-md-6">
                                        <label for="validationCustom03" class="form-label">Date Berangkat</label>
                                        <input name="tgl_brkt" id="tanggalMuat" value="2022-09-04"
                                            class="form-control flatpickr flatpickr-input active" type="date"
                                            placeholder="Select Date..">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationCustom03" class="form-label">Date Tiba</label>
                                        <input name="tgl_tiba" id="tanggalTiba" value="2022-09-04"
                                            class="form-control flatpickr flatpickr-input" type="date"
                                            placeholder="Select Date..">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationCustom03" class="form-label">Kapal</label>
                                        <select class="form-select" name="kpl_id" id="kapal" required>
                                            <option selected disabled value="">Pilih...</option>
                                            @foreach ($kapal as $kpl)
                                            <option value="{{ $kpl->id }}">{{ $kpl->kode_kapal }} {{ $kpl->nama_kapal }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label for="validationCustom03" class="form-label">Estate</label>
                                        <input name="estate" type="text" value="" class="form-control" id="estateCurah"
                                            placeholder="Masukkan estate" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="validationCustom03" class="form-label">Nopol Dooring</label>
                                        <input name="nopol" type="text" class="form-control" id="nopolDooringCurah"
                                            placeholder="Nopol">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom01" class="form-label">QTY Tonase Dooring</label>
                                        <div class="input-group">
                                            <input type="number" name="qty_tonase" id="quantityTonaseDooring"
                                                class="form-control qty_curah" placeholder="QTY Tonase" readonly="true">
                                            <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                        </div>
                                        <span class="shadow-none badge badge-danger mt-2" id="qtyTonaseSisaCurah">Sisa:
                                        </span>
                                        <input name="qty" id="qty_sisa_curah" value="0" type="hidden" step="any"
                                            min="0">
                                        <div class="validationMessage"></div>
                                        <!-- <input name="qty_curah_total" id="qtyCurahTotal" value="" type="hidden"
                                            step="any" min="0"> -->
                                        <input name="qty_sisa_curah" id="qty_sisa_curah" value="0" type="hidden"
                                            step="any" min="0">
                                        <div class="validationMessage"></div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom01" class="form-label">QTY Timbang Dooring</label>
                                        <div class="input-group">
                                            <input type="number" name="qty_timbang" id="quantityTimbangDooring"
                                                class="form-control" placeholder="QTY Timbang" readonly="true">
                                            <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="validationCustom01" class="form-label">QTY Tonase BAP</label>
                                        <div class="input-group">
                                            <input type="number" name="qty_tonase_bap" class="form-control"
                                                placeholder="QTY BAP" id="quantityTonaseBap" readonly="true">
                                            <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="validationCustom01" class="form-label">SAK</label>
                                        <input name="sak" type="number" class="form-control" id="jumlahSak"
                                            placeholder="Sak">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationCustom03" class="form-label">No Tiket Timbang</label>
                                        <input name="notiket" type="text" class="form-control" id="noTiketTimbangCurah"
                                            placeholder="No Tiket">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationCustom01" class="form-label">No Surat Jalan</label>
                                        <div class="input-group">
                                            <input name="no_surat" type="text" class="form-control"
                                                placeholder="Surat Jalan" id="noSuratJalanCurah">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationCustom03" class="form-label">Upload File No Tiket <a
                                                href="" id="fileNoTiketCurah" target="_blank"
                                                class="shadow-none badge badge-success text-white">Lihat</a></label>
                                        <div class="mb-3">
                                            <input name="file_notiket" accept=".jpg, .png, .pdf"
                                                class="form-control file-upload-input"
                                                style="height: 48px; padding: 0.75rem 1.25rem;" type="file"
                                                id="formFile">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationCustom03" class="form-label">Upload File Surat
                                            Jalan <a href="" id="fileSuratJalanCurah" target="_blank"
                                                class="shadow-none badge badge-success text-white">Lihat</a></label>
                                        <div class="mb-3">
                                            <input name="file_nosj" accept=".jpg, .png, .pdf"
                                                class="form-control file-upload-input"
                                                style="height: 48px; padding: 0.75rem 1.25rem;" type="file"
                                                id="formFile">
                                        </div>
                                    </div>


                                    <div class="modal-footer justify-content-center">
                                        <button id="btn-modal-curah" type="submit" class="btn btn-primary">Ubah</button>
                                        <button type="button" class="btn btn btn-light-dark" data-bs-dismiss="modal"><i
                                                class="flaticon-cancel-12"></i>Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  BEGIN CUSTOM SCRIPTS FILE  -->
                <x-slot:footerFiles>

                    <script type="module" src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
                    <script type="module" src="{{asset('plugins/flatpickr/custom-flatpickr.js')}}"></script>
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
                    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css"
                        rel="stylesheet" />
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

                    <script type='text/javascript'>
                    $(document).ready(function() {
                        function removeDecimal(number) {
                            return Math.floor(number);
                        }

                        function convertToZero(value) {
                            // Parse the value to float and then round it to 2 decimal places
                            var parsedValue = parseFloat(value).toFixed(2);

                            // Check if the parsed value is "0.00" and return "0" instead
                            return parsedValue === "0.00" ? "0" : parsedValue;
                        }
                        $(document).on('click', '#show-hide-col', function(event) {
                            // Periksa apakah elemen yang diklik adalah .editcontainer
                            if ($(event.target).hasClass('editcontainer')) {
                                // Retrieve data attributes when clicked
                                var id = $(event.target).data('id');
                                var id_track = $(event.target).data('id_track');
                                var id_track_detail = $(event.target).data('id_track_detail');
                                var kapal = $(event.target).data('kapal');
                                var dateBerangkat = $(event.target).data('date_berangkat');
                                var dateTiba = $(event.target).data('date_tiba');
                                var estate = $(event.target).data('estate');
                                var nopolDooring = $(event.target).data('nopol_dooring');
                                var qtyTonaseDooring = $(event.target).data('qty_tonase_dooring');
                                var qtyTimbangDooring = $(event.target).data('qty_timbang_dooring');
                                var qtyTonaseBap = $(event.target).data('qty_tonase_bap');
                                var sak = $(event.target).data('sak');
                                var noCont = $(event.target).data('no_cont');
                                var noSegel = $(event.target).data('no_segel');
                                var qtyTonaseSisa = $(event.target).data('qty_tonase_sisa');
                                var noTiketTimbang = $(event.target).data('no_tiket_timbang');
                                var noSuratJalan = $(event.target).data('no_surat_jalan');
                                var fileNoTiket = $(event.target).data('file_no_tiket');
                                var fileSuratJalan = $(event.target).data('file_surat_jalan');
                                var voyage = $(event.target).data('vogaye');
                                // Set form field values
                                $('#idContainer').val(id);
                                $('#dateBerangkat').val(dateBerangkat);
                                $('#dateTiba').val(dateTiba);
                                $('#kapal').val(kapal);
                                $('#noCont').val(noCont);
                                $('#noSegel').val(noSegel);
                                $('#estate').val(estate);
                                $('#nopolDooring').val(nopolDooring);
                                $('#qtyTonaseDooring').val(removeDecimal(qtyTonaseDooring));
                                $('#qtyTimbangDooring').val(removeDecimal(qtyTimbangDooring));
                                $('#qtyTonaseBap').val(removeDecimal(qtyTonaseBap));
                                $('#sak').val(removeDecimal(sak));
                                $('#noTiketTimbang').val(noTiketTimbang);
                                $('#noSuratJalan').val(noSuratJalan);
                                $('#qtyTonaseSisa').text('sisa:' + convertToZero(qtyTonaseSisa));


                                $('#fileNoTiket').attr('href', fileNoTiket);
                                $('#fileSuratJalan').attr('href', fileSuratJalan);
                                fetchKapalData(id_track, id);
                                // getKapalDooring(id_track, voyage, id_track_detail);
                                setkapaldannocontainer(id);
                            }else if ($(event.target).hasClass('editcurah')) {
                            // Get data attributes
                            var id = $(event.target).data('id');
                            var tanggalMuat = $(event.target).data('date_berangkat');
                            var tanggalTiba = $(event.target).data('date_tiba');
                            var kapal = $(event.target).data('kapal');
                            var estate = $(event.target).data('estate');
                            var nopolDooring = $(event.target).data('nopol_dooring');
                            var quantityTonaseDooring = $(event.target).data('qty_tonase_dooring');
                            var quantityTimbangDooring = $(event.target).data('qty_timbang_dooring');
                            var quantityTonaseBap = $(event.target).data('qty_tonase_bap');
                            var jumlahSak = $(event.target).data('sak');
                            var noTiketTimbang = $(event.target).data('no_tiket_timbang');
                            var noSuratJalan = $(event.target).data('no_surat_jalan');
                            var qtyTonaseSisa = $(event.target).data('qty_tonase_sisa');
                            var fileNoTiket = $(event.target).data('file_no_tiket');
                            var fileSuratJalan = $(event.target).data('file_surat_jalan');

                            // Retrieve other data attributes in a similar manner
                            // Set form field values
                            $('#idCurah').val(id);
                            $('#tanggalMuat').val(tanggalMuat);
                            $('#tanggalTiba').val(tanggalTiba);
                            $('#kapal').val(kapal);
                            $('#estateCurah').val(estate);
                            $('#nopolDooringCurah').val(nopolDooring);
                            $('#quantityTonaseDooring').val(removeDecimal(quantityTonaseDooring));
                            $('#quantityTimbangDooring').val(removeDecimal(quantityTimbangDooring));
                            $('#quantityTonaseBap').val(removeDecimal(quantityTonaseBap));
                            $('#jumlahSak').val(removeDecimal(jumlahSak));
                            $('#noTiketTimbangCurah').val(noTiketTimbang);
                            $('#noSuratJalanCurah').val(noSuratJalan);
                            // $('#qtyCurahTotal').val(qtyCurahTotal);
                            $('#qtyTonaseSisaCurah').text('sisa:' + convertToZero(qtyTonaseSisa));
                            $('#fileNoTiketCurah').attr('href', fileNoTiket);
                            $('#fileSuratJalanCurah').attr('href', fileSuratJalan);

                        }
                        });


                        function setkapaldannocontainer(idDetailDooring) {
                            $.ajax({
                                url: "{{ route('geteditcontainer', ['detail_dooring' => ':id']) }}"
                                    .replace(':id',
                                        idDetailDooring),
                                type: 'GET',
                                success: function(response) {
                                    var cbKapalContainerIsExist = false;
                                    var cbNoContainerIsExist = false;
                                    $('#cb_kplcont option').each(function() {
                                        if ($(this).val() == response[0].id_track + '-' +
                                            response[0].voyage) {
                                            cbKapalContainerIsExist = true;
                                            $('#cb_kplcont').val(response[0].id_track +
                                                '-' + response[0].voyage);
                                        }
                                    });
                                    if (!cbKapalContainerIsExist) {
                                        $('#cb_kplcont').append('<option value="' + response[0]
                                            .id_track + '-' + response[0].voyage + '">' +
                                            response[0].nama_kapal + ' ' + response[0].voyage +
                                            '</option>');
                                        $('#cb_kplcont').val(response[0].id_track +
                                            '-' + response[0].voyage);
                                    }
                                    $('#cb_cont option').each(function() {
                                        console.log($(this).val() + "cb_cont value")
                                        if ($(this).val() == response[0].id_detail_track) {
                                            console.log("sini1");
                                            cbNoContainerIsExist = true;
                                            $("#cb_cont").empty();
                                            $('#cb_cont').append('<option value="' +
                                                response[0]
                                                .id_detail_track + '">' +
                                                response[0].no_container +
                                                '</option>');
                                            $('#cb_cont').val(response[0]
                                                .id_detail_track);
                                        }
                                    });
                                    if (!cbNoContainerIsExist) {
                                        console.log("sini2");
                                        $('#cb_cont').append('<option value="' + response[0]
                                            .id_detail_track + '">' +
                                            response[0].no_container +
                                            '</option>');
                                        $('#cb_cont').val(response[0]
                                            .id_detail_track);
                                    }
                                    console.log(response[0].id_track + '-' + response[0].voyage);
                                    console.log(response[0].nama_kapal + ' ' + response[0].voyage)

                                    console.log(response[0].id_detail_track);
                                    console.log(response[0].no_container);
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error fetching Kapal data:', error);
                                }
                            });
                        }

                        function fetchKapalData(idTrack, idDooring = '') {
                            var getKapalByTrackRoute = "{{ route('dooring.getKapalByTrack') }}";
                            var setvalue = "";
                            $.ajax({
                                url: getKapalByTrackRoute,
                                type: 'GET',
                                data: {
                                    id_track: idTrack
                                },
                                success: function(response) {
                                    // Clear existing options
                                    $('#cb_kplcont').empty();
                                    var defaultOption =
                                        "<option value='0' disabled selected required>Pilih...</option>";
                                    $('#cb_kplcont').append(defaultOption);
                                    // Append new options
                                    response.forEach(function(kapal) {
                                        $('#cb_kplcont').append('<option value="' + kapal
                                            .id_track + '-' + kapal.voyage + '">' +
                                            kapal.nama_kapal + ' ' + kapal.voyage +
                                            '</option>');
                                        if (kapal.id_detail_door == idDooring &&
                                            idDooring != "") {
                                            setvalue = kapal
                                                .id_track + '-' + kapal.voyage
                                        }
                                    });
                                    if (response.length == 1 && setvalue == "") {
                                        setvalue = response[0].id_track + '-' + response[0].voyage;
                                    } else {
                                        setvalue = response[0].id_track + '-' + response[0].voyage;
                                    }
                                    $('#cb_kplcont').val(setvalue);
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error fetching Kapal data:', error);
                                }
                            });
                        }


                     

                        function matchCustom(params, data) {
                            // If there are no search terms, return all of the data
                            if ($.trim(params.term) === '') {
                                return data;
                            }

                            // Do not display the item if there is no 'text' property
                            if (typeof data.text === 'undefined') {
                                return null;
                            }

                            // `params.term` should be the term that is used for searching
                            // `data.text` is the text that is displayed for the data object
                            if (data.text.indexOf(params.term) > -1) {
                                var modifiedData = $.extend({}, data, true);


                                // You can return modified objects from here
                                // This includes matching the `children` how you want in nested data sets
                                return modifiedData;
                            }

                            // Return `null` if the term should not be displayed
                            return null;
                        }
                        $('#cb_po').select2({
                            matcher: matchCustom
                        });
                        $('#cb_po').change(function() {
                            var selectedId = $(this).val();
                            // $('#sel_emp').find('option').not(':first').remove();
                            if (selectedId !== '') {
                                $.ajax({
                                    url: "{{ route('getPo', ['id' => ':id']) }}"
                                        .replace(':id', selectedId),
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(response) {
                                        var data = response[0];
                                        $("#po_kebun").empty();
                                        $("#nm_kebun").empty();
                                        $("#no_pl").empty();
                                        $("#simb").empty();
                                        $("#est").empty();
                                        $("#brg").empty();
                                        if (response.length > 0) {
                                            for (var i = 0; i < response.length; i++) {

                                                $('#po_kebun').val(response[i].po_kebun);
                                                $('#nm_kebun').val(response[i]
                                                    .nama_penerima);
                                                $('#no_pl').val(response[i].no_pl);
                                                $('#simb').val(response[i].simb);
                                                $('#est').val(response[i].estate);
                                                $('#brg').val(response[i].nama_barang);
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
                                $('#no_pl').val('');
                                $('#simb').val('');
                                $('#est').val('');
                                $('#brg').val('');
                            }
                        });
                    });
                    </script>
                    <script>
                    function getKapalDooring(id_track, voyage, selection = '') {
                        $.ajax({
                            url: "{{ route('getKapalDooring', ['id' => ':id','voyage'=>':voyage']) }}"
                                .replace(':id', id_track)
                                .replace(':voyage', voyage),
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                var data = response[0];
                                $("#cb_cont").empty();
                                if (response.length > 0) {
                                    var defaultOption =
                                        "<option value='0' disabled selected required>Pilih...</option>";
                                    $('#cb_cont').append(defaultOption);
                                    for (var i = 0; i < response.length; i++) {
                                        var optVal = response[i].id_detail_track;
                                        var kapal_id = response[i].id_kapal;
                                        var option = $("<option>").val(optVal).text(response[i]
                                            .no_container);
                                        $('#cb_cont').append(option);
                                        if (response.length == 1) {
                                            $('#cb_cont').val(optVal);
                                        }
                                    }
                                    if (selection != '') {
                                        $('#cb_cont').val(selection);
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

                    $('#cb_kplcont').change(function() {
                        var selectedId = $(this).val();
                        var id_dt = $('#id_detail').val();
                        var parts = selectedId.split('-');
                        var id_track = parts[0];
                        var voyage = escape(parts[1]);
                        if (selectedId !== '') {
                            getKapalDooring(id_track, voyage);
                        } else {
                            $("#cb_cont").empty();
                        }
                    });
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
                                extend: 'excel',
                                className: 'btn btn-success',
                                exportOptions: {
                                    columns: ':visible'
                                },
                            },
                            {
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
                                text: 'Susut',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(16);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'Nama Kapal',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(17);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'No Surat Jalan',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(18);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'TD',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(19);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'Status',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(20);
                                    column.visible(!column.visible());
                                }
                            },
                        ],
                        "stripeClasses": [],
                        "lengthMenu": [7, 10, 20, 50],
                        "pageLength": 7,
                    });
                    </script>

                    </x-slot>
                    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>