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
                            <li class="breadcrumb-item active" aria-current="page">Tracking</li>
                        </ol>
                    </nav>
                </div>
                <!-- /BREADCRUMB -->
                <div class="row layout-top-spacing">
                    @if(in_array('monitoring-mon-tracking-UPDATE', Session::get('nama_action')) || Session::get('role')
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
                                @php
                                $limitedCollection = $tbl_po->toArray();
                                $limitedCollection = array_slice($limitedCollection, 0, 1);
                                @endphp
                                {{-- @foreach ($limitedCollection as $getpo) --}}
                                <form class="row g-3 needs-validation" action="{{ route('mon-tracking.update') }}"
                                    method="POST" enctype="multipart/form-data" novalidate>
                                    @csrf
                                    @method('PUT')
                                    <div class="col-md-6">
                                        <label for="validationCustom01" class="form-label">No PO </label>
                                        <select class="form-select" name="cb_po" id="cb_po" required>
                                            <option selected disabled value="">Pilih...</option>
                                            @foreach ($tbl_po->unique('no_po') as $getpo)
                                            <option value="{{ $getpo->id_track }}">{{ $getpo->no_po }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationCustom01" class="form-label">Kapal </label>
                                        <select class="form-select" name="cb_kpl" id="cb_kpl" required>
                                            <option selected disabled value="">Pilih...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationCustom03" class="form-label">Upload SPK Tracking</label>
                                        <div class="mb-3">
                                            <input name="file" accept=".jpg, .png, .pdf"
                                                class="form-control file-upload-input"
                                                style="height: 48px; padding: 0.75rem 1.25rem;" type="file"
                                                id="formFile">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationCustom03" class="form-label">Upload SPK Dooring</label>
                                        <div class="mb-3">
                                            <input name="file2" accept=".jpg, .png, .pdf"
                                                class="form-control file-upload-input"
                                                style="height: 48px; padding: 0.75rem 1.25rem;" type="file"
                                                id="formFile">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="validationCustom01" class="form-label">TD</label>
                                        <div class="input-group has-validation">
                                            <input name="td" id="td"
                                                class="form-control flatpickr flatpickr-input active" type="date"
                                                placeholder="Select Date..">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="validationCustom01" class="form-label">TD JKT</label>
                                        <div class="input-group has-validation">
                                            <input name="td_jkt" id="td_jkt"
                                                class="form-control flatpickr flatpickr-input active" type="date"
                                                placeholder="Select Date..">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="validationCustom01" class="form-label">TA</label>
                                        <div class="input-group has-validation">
                                            <input name="ta" id="ta"
                                                class="form-control flatpickr flatpickr-input active" type="date"
                                                placeholder="Select Date..">
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
                                        <h4>Monitoring Tracking</h4>
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
                                                        <th>QTY PO</th>
                                                        <th>Rute</th>
                                                        <th>Gudang Muat</th>
                                                        <th>PT Kebun</th>
                                                        <th>Estate</th>
                                                        <th>Jenis Pupuk</th>
                                                        <th>No. PL</th>
                                                        <th>SO/DO/SPK/CA</th>
                                                        <th>PO Kebun</th>
                                                        <th>Qty Muat</th>
                                                        <th>Qty Bag</th>
                                                        <th>Qty Timbang</th>
                                                        <th>Nopol</th>
                                                        <th>No Container</th>
                                                        <th>Nama Kapal</th>
                                                        <th>Tanggal Muat</th>
                                                        <th>TD</th>
                                                        <th>TD JKT</th>
                                                        <th>TA</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($tbl_po as $tra)
                                                    <tr>
                                                        <td>{{ $tra->nama_customer }}</td>
                                                        <td>{{ number_format($tra->total_qty , 0, ',', ',') }}</td>
                                                        <td>{{ $tra->nama_pol }} - {{ $tra->nama_pod }}</td>
                                                        <td>{{ $tra->nama_gudang }}</td>
                                                        <td>{{ $tra->nama_penerima }}</td>
                                                        <td>{{ $tra->estate }}</td>
                                                        <td>{{ $tra->nama_barang }}</td>
                                                        <td>{{ $tra->no_pl }}</td>
                                                        <td>{{ $tra->no_po }}</td>
                                                        <td>{{ $tra->po_kebun }}</td>
                                                        <td>{{ number_format($tra->qty_tonase , 0, ',', ',') }}</td>
                                                        <td>{{ number_format($tra->jml_sak , 0, ',', ',') }}</td>
                                                        <td>{{ number_format($tra->qty_timbang , 0, ',', ',') }}</td>
                                                        <td>{{ $tra->nopol }}</td>
                                                        @if($tra->no_container !== null)
                                                        <td>{{ $tra->no_container }}</td>
                                                        @else
                                                        <td>-</td>
                                                        @endif
                                                        <td>{{ $tra->kode_kapal }} {{ $tra->nama_kapal }}
                                                            {{ $tra->voyage }}</td>
                                                        <td data-order="{{ $tra->tgl_muat }}">
                                                            {{ $tra->tgl_muat ? date('d-M-Y', strtotime($tra->tgl_muat)) : '' }}
                                                        </td>
                                                        <td data-order="{{ $tra->td }}">
                                                            {{ $tra->td ? date('d-M-Y', strtotime($tra->td)) : '' }}
                                                        </td>
                                                        <td data-order="{{ $tra->td_jkt }}">
                                                            {{ $tra->td_jkt ? date('d-M-Y', strtotime($tra->td_jkt)) : '' }}
                                                        </td>
                                                        <td data-order="{{ $tra->ta }}">
                                                            {{ $tra->ta ? date('d-M-Y', strtotime($tra->ta)) : '' }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($tra->status_kapal == 1)
                                                            <span class="shadow-none badge badge-success">Proses
                                                                Muat</span>
                                                            @elseif ($tra->status_kapal == 2)
                                                            <span class="shadow-none badge badge-warning">Selesai
                                                                Muat</span>
                                                            @elseif ($tra->status_kapal == 3)
                                                            <span class="shadow-none badge badge-info">Kapal
                                                                Berangkat</span>
                                                            @elseif ($tra->status_kapal == 4)
                                                            <span class="shadow-none badge badge-primary">Kapal Tiba di
                                                                Port Dooring</span>
                                                            @else
                                                            <span class="shadow-none badge badge-danger">Kapal TD
                                                                Jakarta</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{route('monitoring.tracking.print', $tra->id_detail_track)}}"
                                                                class="bs-tooltip" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Loading Report"
                                                                data-original-title="Print">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-download">
                                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4">
                                                                    </path>
                                                                    <polyline points="7 10 12 15 17 10"></polyline>
                                                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                                                </svg>
                                                            </a>
                                                            {!! $tra->track_file != null
                                                            ?
                                                            '<a href="'.route('downloadspktrack', ['path' => $tra->track_file]).'"
                                                                target="_blank" class="bs-tooltip"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Download Spk Tracking"
                                                                data-original-title="Print">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-download">
                                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4">
                                                                    </path>
                                                                    <polyline points="7 10 12 15 17 10"></polyline>
                                                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                                                </svg></a>'
                                                            : ''
                                                            !!}
                                                            {!! $tra->door_file != null
                                                            ?
                                                            '<a href="'.route('downloadspktrack', ['path' => $tra->door_file]).'"
                                                                target="_blank" class="bs-tooltip"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Download Spk Dooring"
                                                                data-original-title="Print"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-download">
                                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4">
                                                                    </path>
                                                                    <polyline points="7 10 12 15 17 10"></polyline>
                                                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                                                </svg>
                                                                </svg></a>'
                                                            : ''
                                                            !!}
                                                            {!! $tra->st_file_name != null
                                                            ?
                                                            '<a href="'.route('downloadspktrack', ['path' => $tra->st_file_name]).'"
                                                                target="_blank" class="bs-tooltip"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Surat Timbang Tracking"
                                                                data-original-title="Print"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-download">
                                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4">
                                                                    </path>
                                                                    <polyline points="7 10 12 15 17 10"></polyline>
                                                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                                                </svg>
                                                                </svg></a>'
                                                            : ''
                                                            !!}
                                                            {!! $tra->sj_file_name != null
                                                            ?
                                                            '<a href="'.route('downloadspktrack', ['path' => $tra->sj_file_name]).'"
                                                                target="_blank" class="bs-tooltip"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Surat Jalan Tracking"
                                                                data-original-title="Print"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-download">
                                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4">
                                                                    </path>
                                                                    <polyline points="7 10 12 15 17 10"></polyline>
                                                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                                                </svg>
                                                                </svg></a>'
                                                            : ''
                                                            !!}
                                                            <a href="#detailcur" id="editcurah"
                                                                class="btn btn-outline-primary bs-tooltip me-2"
                                                                data-bs-toggle="modal" data-placement="top"
                                                                data-id="{{$tra->id_detail_track}}"
                                                                data-tanggal_muat="{{ $tra->tgl_muat }}"
                                                                data-gudang_muat="{{ $tra->id_gudang }}"
                                                                data-kapal="{{ $tra->id_kapal }}"
                                                                data-nopol="{{ $tra->nopol }}"
                                                                data-port_of_loading="{{ $tra->id_pol }}"
                                                                data-port_of_destination="{{ $tra->id_pod }}"
                                                                data-quantity_tonase="{{ $tra->qty_tonase }}"
                                                                data-jumlah_sak="{{ $tra->jml_sak }}"
                                                                data-quantity_timbangan="{{ $tra->qty_timbang }}"
                                                                data-file_surat_timbang="{{ route('downloadspktrack', ['path' => $tra->st_file_name]) }}"
                                                                data-harga_hpp_kapal="{{ $tra->harga_hpp }}"
                                                                data-no_surat_jalan="{{ $tra->no_sj }}"
                                                                data-file_surat_jalan title="Edit Curah">Curah</a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
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
                                <h5>Edit Detail Tracking Kapal Curah</h5>
                                <form name="modal-tracking-ada" class="row g-3 needs-validation"
                                    action="{{ route('tracking.updatecontainer') }}" method="POST"
                                    enctype="multipart/form-data" novalidate>
                                    @csrf
                                    @method('put')
                                    <input type="hidden" id="id_edit" name="id_edit">
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <label for="validationCustom04" class="form-label">Tanggal Muat</label>
                                        <div class="input-group has-validation">
                                            <input name="tgl_muat" id="tanggalMuat" value=""
                                                class="form-control flatpickr flatpickr-input active" type="date"
                                                placeholder="Select Date..">
                                        </div>
                                    </div>
                                    @if ($details || $trackzero->count())
                                    @if ($lastcurah)
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <label for="validationCustom03" class="form-label">Gudang Muat</label>
                                        <select class="form-select" name="id_gudang" id="gudangMuat" required>
                                            <option selected disabled value="">Pilih...</option>
                                            @foreach ($gudang as $gd)
                                            <option {{ $lastcurah->id_gudang == $gd->id_gudang ? 'selected' : '' }}
                                                value="{{ $gd->id_gudang }}">{{ $gd->nama_gudang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <label for="validationCustom03" class="form-label">Kapal</label>
                                        <select class="form-select" name="id_kapal" id="kapal" required>
                                            <option selected disabled value="">Pilih...</option>
                                            @foreach ($kapal as $kpl)
                                            <option {{ $lastcurah->id_kapal == $kpl->id ? 'selected' : '' }}
                                                value="{{ $kpl->id }}">{{ $kpl->kode_kapal }} {{ $kpl->nama_kapal }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @elseif($lastcurah == 0)
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <label for="validationCustom03" class="form-label">Gudang Muat</label>
                                        <select class="form-select" name="id_gudang" id="gudangMuat" required>
                                            <option selected disabled value="">Pilih...</option>
                                            @foreach ($gudang as $gd)
                                            <option value="{{ $gd->id_gudang }}">{{ $gd->nama_gudang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <label for="validationCustom03" class="form-label">Kapal</label>
                                        <select class="form-select" name="id_kapal" id="kapal" required>
                                            <option selected disabled value="">Pilih...</option>
                                            @foreach ($kapal as $kpl)
                                            <option value="{{ $kpl->id }}">{{ $kpl->kode_kapal }} {{ $kpl->nama_kapal }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                    @elseif($details==0 && $trackzero->count()==0)
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <label for="validationCustom03" class="form-label">Gudang Muat</label>
                                        <select class="form-select" name="id_gudang" id="gudangMuat" required>
                                            <option selected disabled value="">Pilih...</option>
                                            @foreach ($gudang as $gd)
                                            <option value="{{ $gd->id_gudang }}">{{ $gd->nama_gudang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <label for="validationCustom03" class="form-label">Kapal</label>
                                        <select class="form-select" name="id_kapal" id="kapal" required>
                                            <option selected disabled value="">Pilih...</option>
                                            @foreach ($kapal as $kpl)
                                            <option value="{{ $kpl->id }}">{{ $kpl->kode_kapal }} {{ $kpl->nama_kapal }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <label for="validationCustom03" class="form-label">Nopol</label>
                                        <input name="nopol" type="text" class="form-control" id="nopol"
                                            placeholder="Masukkan Nopol" required>
                                    </div>
                                    @if(isset($tra))
                                    <div class="col-md-6">
                                        <label for="validationCustom03" class="form-label">Port Of Loading</label>
                                        <select class="form-select" name="did_pol" id="portOfLoading" required>
                                            <option selected disabled value="">Pilih...</option>
                                            @foreach ($pol as $pol)
                                            <option
                                                {{ $selectpol->where('id_track',$tra->id_track)->contains('id_pol', $pol->id) ? 'selected' : '' }}
                                                value="{{ $pol->id }}">{{ $pol->nama_pol }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationCustom03" class="form-label">Port Of Destination</label>
                                        <select class="form-select" name="did_pod" id="portOfDestination" required>
                                            <option selected disabled value="">Pilih...</option>
                                            @foreach ($pod as $pod)
                                            <option
                                                {{ $selectpod->where('id_track',$tra->id_track)->contains('id_pod', $pod->id) ? 'selected' : '' }}
                                                value="{{ $pod->id }}">{{ $pod->nama_pod }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif

                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        @foreach($tracknull as $tra)
                                        @php
                                        $match = $tracksisa->where('id_track',
                                        $tra->id_track)->where('tipe','Curah')->count() > 0;
                                        @endphp
                                        @if ($lastcurah || $match)
                                        @foreach ($getcurahqty as $tra)
                                        <label for="validationMessage" class="form-label">Quantity Tonase </label>
                                        <div class="input-group">
                                            <input name="qty_tonase" id="quantityTonase" type="number" step="any"
                                                min="0" class="form-control qty_curah" placeholder="QTY Tonase"
                                                required>
                                            <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                        </div>
                                        <span class="shadow-none badge badge-danger mt-2">Sisa:
                                            {{ number_format($tra->qty_tonase_sisa , 0, ',', '.') }}</span>
                                        <div class="validationMessage"></div>
                                        <input name="qty_curah_total" id="qty_curah_total"
                                            value="{{ $tra->qty_tonase_sisa }}" type="hidden" step="any" min="0">
                                        <input type="hidden" name="qty" id="qty_sisa_curah" step="any" min="0">
                                        @endforeach
                                        @elseif($lastcurah==0 || $match->count()==0)
                                        @foreach ($zerocurah as $tra)
                                        <label for="validationMessage" class="form-label">Quantity Tonase</label>
                                        <div class="input-group">
                                            <input name="qty_tonase" id="quantityTonase" type="number" value="0"
                                                step="any" min="0" class="form-control qty_curah"
                                                placeholder="QTY Tonase" required>
                                            <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                        </div>
                                        <span class="shadow-none badge badge-danger mt-2">Sisa:
                                            {{ number_format($tra->qty , 0, ',', '.') }}</span>
                                        <input name="qty_curah_total" id="qty_curah_total" value="{{ $tra->qty }}"
                                            type="hidden" step="any" min="0">
                                        <input name="qty_sisa_curah" id="qty_sisa_curah" value="0" type="hidden"
                                            step="any" min="0">
                                        <div class="validationMessage"></div>
                                        @endforeach
                                        @endif
                                        @endforeach
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <label for="validationCustom03" class="form-label">Jumlah Sak</label>
                                        <input name="jml_sak" type="number" class="form-control" id="jumlahSak"
                                            placeholder="Jumlah Sak" required>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <label for="validationCustom03" class="form-label">Quantity Timbangan</label>
                                        <div class="input-group">
                                            <input name="qty_timbang" step="any" min="0" type="number"
                                                class="form-control" placeholder="QTY Timbang" id="quantityTimbangan"
                                                required>
                                            <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <label for="validationCustom03" class="form-label">Upload File Surat
                                            Timbang <a href="" id="fileSuratTimbang" target="_blank"
                                                class="shadow-none badge badge-success text-white">Lihat</a></label>
                                        <div class="mb-3">
                                            <input name="file_tbg" accept=".jpg, .png, .pdf"
                                                class="form-control file-upload-input"
                                                style="height: 48px; padding: 0.75rem 1.25rem;" type="file"
                                                id="upload_file_surat_timbang">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="validationCustom04" class="form-label">Harga HPP Kapal</label>
                                        <div class="input-group has-validation">
                                            <input name="hpp_kpl" type="number" value="" class="form-control"
                                                id="hargaHppKapal" placeholder="Masukkan HPP Kapal" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="validationCustom04" class="form-label">No Surat Jalan</label>
                                        <div class="input-group has-validation">
                                            <input name="no_sj" type="text" value="" class="form-control"
                                                id="noSuratJalan" placeholder="Masukkan Nomor Surat Jalan" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="validationCustom03" class="form-label">Upload File Surat
                                            Jalan <a href="" class="shadow-none badge badge-success text-white"
                                                id="fileSuratJalan" target="_blank">Lihat</a></label>
                                        <div class="mb-3">
                                            <input name="file" accept=".jpg, .png, .pdf"
                                                class="form-control file-upload-input"
                                                style="height: 48px; padding: 0.75rem 1.25rem;" type="file"
                                                id="upload_file_surat_jalan">
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button id="btn-modal-curah" type="submit"
                                            class="btn btn-primary">Submit</button>
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
                    {{-- <script type="module" src="{{asset('plugins/table/datatable/datatables.js')}}">
                    </script> --}}
                    @vite(['resources/assets/js/custom.js'])
                    {{-- <script type="module" src="{{asset('plugins/table/datatable/datatables.js')}}">
                    </script> --}}
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                    <script src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
                    <script src="{{asset('plugins/global/vendors.min.js')}}"></script>
                    <script src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
                    <script src="{{asset('plugins/table/datatable/button-ext/dataTables.buttons.min.js')}}">
                    </script>
                    <script src="{{asset('plugins/table/datatable/button-ext/buttons.html5.min.js')}}"></script>
                    <script src="{{asset('plugins/table/datatable/button-ext/jszip.min.js')}}"></script>
                    <script src="{{asset('plugins/table/datatable/button-ext/buttons.print.min.js')}}"></script>
                    {{-- <script src="{{asset('plugins/table/datatable/custom_miscellaneous.js')}}"></script>
                    --}}
                    <script>
                    var f2 = flatpickr(document.getElementById('td'), {
                        defaultDate: 'dd/mm/yyyy',
                        // dateFormat: 'd/m/Y',
                    });
                    var f3 = flatpickr(document.getElementById('td_jkt'), {
                        defaultDate: 'dd/mm/yyyy',
                    });
                    var f4 = flatpickr(document.getElementById('ta'), {
                        defaultDate: 'dd/mm/yyyy',
                    });
                    </script>
                    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css"
                        rel="stylesheet" />
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
                    <script type='text/javascript'>
                    $(document).ready(function() {
                        $('#editcurah').on('click', function() {
                            // Get data attributes
                            var id = $(this).data('id');
                            var tanggalMuat = $(this).data('tanggal_muat');
                            var kapal = $(this).data('kapal');
                            var nopol = $(this).data('nopol');
                            var portOfLoading = $(this).data('port_of_loading');
                            var portOfDestination = $(this).data('port_of_destination');
                            var quantityTonase = $(this).data('quantity_tonase');
                            var jumlahSak = $(this).data('jumlah_sak');
                            var quantityTimbangan = $(this).data('quantity_timbangan');
                            var fileSuratTimbang = $(this).data('file_surat_timbang');
                            var hargaHppKapal = $(this).data('harga_hpp_kapal');
                            var noSuratJalan = $(this).data('no_surat_jalan');
                            var fileSuratJalan = $(this).data('file_surat_jalan');

                            // Retrieve other data attributes in a similar manner

                            // Set form field values
                            $('#id_edit').val(id);
                            $('#kapal').val(kapal);
                            $('#nopol').val(nopol);
                            $('#tanggalMuat').val(tanggalMuat);
                            $('#portOfLoading').val(portOfLoading);
                            $('#portOfDestination').val(portOfDestination);
                            $('#quantityTonase').val(quantityTonase);
                            $('#jumlahSak').val(jumlahSak);
                            $('#quantityTimbangan').val(quantityTimbangan);
                            $('#hargaHppKapal').val(hargaHppKapal);
                            $('#noSuratJalan').val(noSuratJalan);
                            $('#fileSuratJalan').attr('href', fileSuratJalan);
                            $('#fileSuratTimbang').attr('href', fileSuratTimbang);
                            // Set other form field values in a similar manner

                            // Open your modal or perform other actions as needed
                            // $('#yourModalId').modal('show');
                        });

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
                                    url: "{{ route('getPoDate', ['id' => ':id']) }}"
                                        .replace(':id', selectedId),
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(response) {
                                        var data = response[0];
                                        $("#cb_kpl").empty();
                                        if (response.length > 0) {
                                            var defaultOption =
                                                "<option value='0' disabled selected required>Pilih...</option>";
                                            $("#cb_kpl").append(defaultOption);
                                            for (var i = 0; i < response
                                                .length; i++) {
                                                var idkpl = response[i].id_kapal;
                                                var voyage = response[i].voyage !=
                                                    null ?
                                                    response[i].voyage : '';
                                                var namakpl = "<option value='" +
                                                    idkpl +
                                                    '-' + voyage + "' required>" +
                                                    response[i].kode_kapal + ' ' +
                                                    response[i].nama_kapal + ' ' +
                                                    voyage +
                                                    "</option>";
                                                $("#cb_kpl").append(namakpl);
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
                                $("#cb_kpl").val('');
                            }
                        });
                        $('#cb_kpl').change(function() {
                            var selectedId = $(this).val();
                            var parts = selectedId.split('-');
                            var id_kapal = parts[0];
                            var voyage = escape(parts[1]);
                            var selectedIdT = $('#cb_po').val();
                            if (voyage == '') {
                                console.log('null');
                                var v = 'null';
                                if (selectedId !== '' && selectedIdT !== '') {
                                    $.ajax({
                                        url: "{{ route('getPoKapal', ['id_track' => ':id_track', 'id' => ':id', 'voyage' => ':voyage']) }}"
                                            .replace(':id_track', selectedIdT)
                                            .replace(':id', id_kapal)
                                            .replace(':voyage', v),
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function(response) {
                                            var data = response[0];
                                            $('#td').empty();
                                            $('#td_jkt').empty();
                                            $('#ta').empty();
                                            if (response.length > 0) {
                                                for (var i = 0; i < response
                                                    .length; i++) {
                                                    $('#td').val(response[i].td);
                                                    $('#td_jkt').val(response[i]
                                                        .td_jkt);
                                                    $('#ta').val(response[i].ta);
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
                                    $('#td').val('');
                                    $('#td_jkt').val('');
                                    $('#ta').val('');
                                }
                            } else if (voyage !== '') {
                                console.log(voyage);
                                if (selectedId !== '' && selectedIdT !== '') {
                                    $.ajax({
                                        url: "{{ route('getPoKapal', ['id_track' => ':id_track', 'id' => ':id', 'voyage' => ':voyage']) }}"
                                            .replace(':id_track', selectedIdT)
                                            .replace(':id', id_kapal)
                                            .replace(':voyage', voyage),
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function(response) {
                                            var data = response[0];
                                            $('#td').empty();
                                            $('#td_jkt').empty();
                                            $('#ta').empty();
                                            if (response.length > 0) {
                                                for (var i = 0; i < response
                                                    .length; i++) {
                                                    $('#td').val(response[i].td);
                                                    $('#td_jkt').val(response[i]
                                                        .td_jkt);
                                                    $('#ta').val(response[i].ta);
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
                                    $('#td').val('');
                                    $('#td_jkt').val('');
                                    $('#ta').val('');
                                }
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
                                text: 'QTY PO',
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
                                text: 'Gudang Muat',
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
                                text: 'Jenis Pupuk',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(6);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'NO. PL',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(7);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'SO/DO/SPK/CA',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(8);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'PO Kebun',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(9);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'QTY Muat',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(10);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'QTY Bag',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(11);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'QTY Timbang',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(12);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'Nopol',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(13);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'No Container',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(14);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'Nama Kapal',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(15);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'Tanggal Muat',
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
                                text: 'TD JKT',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(18);
                                    column.visible(!column.visible());
                                }
                            },
                            {
                                text: 'TA',
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
                            {
                                text: 'Action',
                                className: 'btn btn-secondary toggle-vis mb-1',
                                action: function(e, dt, node, config) {
                                    var column = dt.column(21);
                                    column.visible(!column.visible());
                                }
                            },
                        ],

                        "stripeClasses": [],
                        "lengthMenu": [7, 10, 20, 50],
                        "pageLength": 10,
                        "responsive": true
                    });
                    </script>

                    </x-slot>
                    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>