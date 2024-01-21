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
                            <li class="breadcrumb-item">Finance</li>
                            <li class="breadcrumb-item active" aria-current="page">Invoice Pelunasan</li>
                        </ol>
                    </nav>
                </div>
                <!-- /BREADCRUMB -->
                <div class="row layout-top-spacing">

                    <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Form Invoice Pelunasan</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area" style="padding: 1.5%;">
                                <form class="row g-3 needs-validation" action="{{ route('invoice-pelunasan.store') }}"
                                    method="POST" enctype="multipart/form-data" novalidate>
                                    @csrf
                                    <div class="col-md-3">
                                        <label for="validationCustom01" class="form-label">Invoice Date</label>
                                        <input name="tgl_inv_dp" id="basicFlatpickr" value="2022-09-04"
                                            class="form-control flatpickr flatpickr-input active" type="text"
                                            placeholder="Select Date..">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom01" class="form-label">Tipe Invoice</label>
                                        <select class="form-select" name="cb_tipe_inv" id="cb_tipe_inv" required>
                                            <option selected disabled value="">Pilih...</option>
                                            <option value="1">Invoice dengan DP</option>
                                            <option value="2">Invoice tanpa DP</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Pilih tipe invoice
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom01" class="form-label">No PO Muat</label>
                                        <select class="form-select" name="cb_po" id="cb_po" required>
                                            <option selected disabled value="">Pilih...</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            No PO Muat tidak boleh kosong
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom01" class="form-label">Invoice No</label>
                                        <input name="invoice_no" type="text" class="form-control" id="invoice_no"
                                            placeholder="Autofill no invoice dp terakhir dari po + 1" readonly>
                                        <div class="invalid-feedback">
                                            Invoice No tidak boleh kosong
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="validationCustom04" class="form-label">Tipe Job</label>
                                        <select class="form-select" name="cb_tipe" id="cb_tipe" required>
                                            <option selected disabled value="">Pilih...</option>
                                            <option value="DOOR TO DOOR">DOOR TO DOOR</option>
                                            <option value="DOOR TO PORT">DOOR TO PORT</option>
                                            <option value="PORT TO PORT">PORT TO PORT</option>
                                            <option value="PORT TO DOOR">PORT TO DOOR</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Pilih tipe job
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom04" class="form-label">Rincian Tipe</label>
                                        <select class="form-select" name="cb_rinci" id="cb_rinci" required>
                                            <option selected disabled value="">Pilih...</option>
                                            <option value="FREIGHT">FREIGHT</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Pilih rincian
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom04" class="form-label">Bank</label>
                                        <select class="form-select" name="cb_bank" id="cb_bank" required>
                                            <option selected disabled value="">Pilih...</option>
                                            @foreach ($bank as $b)
                                            <option value="{{ $b->id_bank }}">{{ $b->nama_bank }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Pilih bank
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom01" class="form-label">Terms</label>
                                        <input name="terms" type="text" class="form-control" id="terms"
                                            placeholder="Masukkan terms" required>
                                        <div class="invalid-feedback">
                                            Terms tidak boleh kosong
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Tabel Invoice Pelunasan</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="col-lg-12">
                                    <div class="statbox widget box box-shadow">
                                        <div class="widget-content widget-content-area">
                                            <div class="widget-header" style="padding: 1.5%;">
                                                <div class="row">
                                                    <button id="exportButton"
                                                        class="col-md-1 btn btn-primary _effect--ripple waves-effect waves-light"><span>Excel</span></button>
                                                </div>
                                            </div>
                                            <table id="style-3" class="table style-3 dt-table-hover"
                                                style="width:100%;">
                                                <thead style="border-bottom: none;">
                                                    <tr>
                                                        <th>Invoice No</th>
                                                        <th>No PO Muat</th>
                                                        <th>Tipe Job</th>
                                                        <th>Rincian</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($invdp as $tdp)
                                                    <tr>
                                                        <td>{{ $tdp->invoice_no }}</td>
                                                        <td>{{ $tdp->no_po }}</td>
                                                        <td>{{ $tdp->tipe_job }}</td>
                                                        <td>{{ $tdp->rinci_tipe }}</td>
                                                        @if ($tdp->status == 1)
                                                        <td class="text-center"><span
                                                                class="shadow-none badge badge-danger">Pending</span>
                                                        </td>
                                                        @elseif($tdp->status == 3)
                                                        <td class="text-center"><span
                                                                class="shadow-none badge badge-success">Approved
                                                                Dooring</span></td>
                                                        @elseif($tdp->status == 2)
                                                        <td class="text-center"><span
                                                                class="shadow-none badge badge-success">Approved Timbang
                                                                Dooring</span></td>
                                                        @endif
                                                        <td class="text-center">
                                                            @if ($tdp->status == 1)
                                                            <a href="#modalIPLcur" data-id-track="{{$tdp->id_track }}"
                                                                data-id-invoice-pel="{{$tdp->id_invoice_pel }}"
                                                                class="bs-tooltip" data-bs-toggle="modal"
                                                                data-bs-placement="top" title="Tambah Detail"
                                                                data-original-title="Tambah Detail"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-plus-circle">
                                                                    <circle cx="12" cy="12" r="10"></circle>
                                                                    <line x1="12" y1="8" x2="12" y2="16"></line>
                                                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                                                </svg></a>
                                                            @endif
                                                            <!-- <a href="#modalDetailInvoice" data-id-track="{{$tdp->id_track }}" data-id-invoice-pel="{{$tdp->id_invoice_pel }}" class="bs-tooltip" data-bs-toggle="modal" data-bs-placement="top" title="Detail" data-original-title="Print"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></a> -->
                                                            <a href="#modalDetailInvoice{{ $tdp->id_invoice_pel }}"
                                                                class="bs-tooltip" data-bs-toggle="modal"
                                                                data-bs-placement="top" title="Detail"
                                                                data-original-title="Print">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-file-text">
                                                                    <path
                                                                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                                    </path>
                                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                                                    <polyline points="10 9 9 9 8 9"></polyline>
                                                                </svg>
                                                            </a>
                                                            @if(in_array('finance-invoice-pelunasan-DELETE',
                                                            Session::get('nama_action')) || Session::get('role') ==
                                                            'superadmin')
                                                            <a href="/horizontal-dark-menu/finance/invoice-pelunasan/delete/{{ $tdp->id_invoice_pel }}"
                                                                class="bs-tooltip" data-bs-placement="top"
                                                                title="Delete" data-original-title="Delete"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-trash">
                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                    <path
                                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                    </path>
                                                                </svg></a>
                                                            @endif
                                                            <div class="p-1"></div>
                                                            @if ($tdp->status == 3)
                                                            <a href="/horizontal-dark-menu/finance/invoice-pelunasan/print/{{ $tdp->id_invoice_pel }}"
                                                                class="bs-tooltip" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Print Tonase Dooring"
                                                                data-original-title="Print"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-printer">
                                                                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                                    <path
                                                                        d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                                                                    </path>
                                                                    <rect x="6" y="14" width="12" height="8"></rect>
                                                                </svg></a>
                                                            @elseif ($tdp->status == 2)
                                                            <a href="/horizontal-dark-menu/finance/invoice-pelunasan/print/{{ $tdp->id_invoice_pel }}"
                                                                class="bs-tooltip" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Print Timbang Dooring"
                                                                data-original-title="Print"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-printer">
                                                                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                                    <path
                                                                        d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                                                                    </path>
                                                                    <rect x="6" y="14" width="12" height="8"></rect>
                                                                </svg></a>
                                                            @endif
                                                            <a href="#style-3" class="bs-tooltip exportButtonRow"
                                                                title="Export Excel" data-original-title="Export Excel"
                                                                data-row="{{ $tdp->id_invoice_pel }}"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="20"
                                                                    height="20" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-download">
                                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4">
                                                                    </path>
                                                                    <polyline points="7 10 12 15 17 10"></polyline>
                                                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                                                </svg>
                                                                </svg></a>


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
                    @foreach($invdp as $tdp)
                    <div class="modal fade bd-example-modal-xl" id="modalDetailInvoice{{ $tdp->id_invoice_pel }}"
                        tabindex="-1" role="dialog" aria-labelledby="modalIDPdetail" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalIDPdetail">Detail Invoice</h5>
                                </div>
                                <div class="modal-body">
                                    <table id="style-4" class="table style-4 dt-table-hover" style="width:100%;">
                                        <thead style="border-bottom: none;">
                                            <tr>
                                                <th>No Invoice</th>
                                                <th>Estate</th>
                                                <th>Total Tonase Dooring</th>
                                                <th>Total Harga Dooring</th>
                                                <th>Total Tonase Timbang Dooring</th>
                                                <th>Total Harga Timbang Dooring</th>
                                                <th>Total DP</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datadetailInvoicePel as $item)
                                            @if ($tdp->id_invoice_pel == $item->id_invoice_pel)
                                            <tr>
                                                <td>{{$tdp->invoice_no}}</td>
                                                <td>{{$item->estate}}</td>
                                                <td>{{number_format($item->total_tonase_dooring , 0, ',', '.')}} KG</td>
                                                <td>Rp. {{number_format($item->total_harga_dooring , 0, ',', '.')}}</td>
                                                <td>{{number_format($item->total_tonase_timbang , 0, ',', '.')}} KG</td>
                                                <td>Rp. {{number_format($item->total_harga_timbang , 0, ',', '.')}}</td>
                                                <td>Rp.
                                                    {{number_format($item->total_invoice_adjusted , 0, ',', '.') ?? 0}}
                                                </td>
                                                <td class="text-center">
                                                    @if(in_array('finance-invoice-pelunasan-DELETE',
                                                    Session::get('nama_action')) || Session::get('role') ==
                                                    'superadmin')
                                                    @if ($tdp->status == 1 && $item->status == 1)
                                                    <a href="{{route('invoice-pelunasan.deletedetail',['id'=>$item->id_detail_pel])}}"
                                                        class="bs-tooltip" data-bs-placement="top" title="Delete"
                                                        data-original-title="Delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-trash p-1 br-8 mb-1">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path
                                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                            </path>
                                                        </svg>
                                                    </a>
                                                    @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                                <div class="modal-footer">
                                    @if(in_array('finance-invoice-pelunasan-APPROVE', Session::get('nama_action')) ||
                                    Session::get('role') == 'superadmin')
                                    @if ($tdp->status == 1)
                                    <a class="btn btn-success"
                                        href="{{ route('invoice-pelunasan.approvetimbang', ['id_invoice_pel' => $tdp->id_invoice_pel]) }}">Approve
                                        Timbang Dooring</a>
                                    <a class="btn btn-success"
                                        href="{{ route('invoice-pelunasan.approvedooring', ['id_invoice_pel' => $tdp->id_invoice_pel]) }}">Approve
                                        Dooring</a>
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="modal fade bd-example-modal-xl" id="modalIPLcur" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Detail Invoice Pelunasan</h5>
                                </div>
                                <div class="modal-body">
                                    <form name="modal-tracking-ada" class="row g-3 needs-validation"
                                        action="{{ route('invoice-pelunasan-detail.detailstore') }}" method="POST"
                                        enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <input type="hidden" name="id_track_i" id="id_track_i" value="">
                                        <input type="hidden" name="idInvoicePel" id="idInvoicePel" value="">

                                        <div class="col-md-6">
                                            <label for="validationCustom04" class="form-label">Tipe Kapal</label>
                                            <select class="form-select" name="cb_kapal" id="cb_kapal" required>
                                                <option selected disabled value="">Pilih...</option>
                                                <option value="2">Curah</option>
                                                <option value="1">Container</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Pilih Tipe Kapal
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="validationCustom04" class="form-label">PO Muat</label>
                                            <select class="form-select" name="cb_bypo" id="cb_bypo" required>
                                                <option selected disabled value="">Pilih...</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Pilih PO Muat
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="notAllowCont" class="form-label">Total Tonase Dooring</label>
                                            <div class="input-group">
                                                <input name="ttdb" step="any" min="0" id="ttdb" type="number"
                                                    class="form-control qty_cont" required readonly>
                                                <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="notAllowCont" class="form-label">Total Tonase Timbang
                                                Dooring</label>
                                            <div class="input-group">
                                                <input name="tttd" step="any" min="0" id="tttd" type="number"
                                                    class="form-control qty_cont" required>
                                                <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="notAllowCont" class="form-label">Total Harga Dooring</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                                <input name="TotalHargaDooring" min="0" id="TotalHargaDooring"
                                                    type="text" class="form-control" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="notAllowCont" class="form-label">Total Harga Timbang
                                                Dooring</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                                <input name="TotalHargaTimbangDooring" min="0"
                                                    id="TotalHargaTimbangDooring" type="text" class="form-control"
                                                    required readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="notAllowCont" class="form-label">Harga Freight</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                                <input name="hrg_freight" step="any" min="0" id="hrg_freight"
                                                    type="number" class="form-control qty_cont" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="notAllowCont" class="form-label">Prosentase PPn</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend">%</span>
                                                <input name="prosentaseppn" step="any" min="0" value="0"
                                                    id="prosentaseppn" type="number" class="form-control qty_cont"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="notAllowCont" class="form-label">Total PPn Dooring</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                                <input name="totalppndoring" step="any" min="0" value="0"
                                                    id="totalppndoring" type="number" class="form-control qty_cont"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="notAllowCont" class="form-label">Total PPn Timbang</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                                <input name="totalppntimbang" step="any" min="0" value="0"
                                                    id="totalppntimbang" type="number" class="form-control qty_cont"
                                                    required>
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
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"
                        integrity="sha512-r22gChDnGvBylk90+2e/ycr3RVrDi8DIOkIGNhJlKfuyQM4tIRAI062MaV8sfjQKYVGjOBaZBOA87z+IhZE9DA=="
                        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                    <script src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
                    <script src="{{asset('plugins/global/vendors.min.js')}}"></script>
                    <script src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
                    <script src="{{asset('plugins/table/datatable/button-ext/dataTables.buttons.min.js')}}"></script>
                    <script src="{{asset('plugins/table/datatable/button-ext/jszip.min.js')}}"></script>
                    <script src="{{asset('plugins/table/datatable/button-ext/buttons.html5.min.js')}}"></script>
                    <script src="{{asset('plugins/table/datatable/button-ext/buttons.print.min.js')}}"></script>
                    {{-- <script src="{{asset('plugins/table/datatable/custom_miscellaneous.js')}}"></script> --}}

                    <script>
                    let jsonInvdp = @json($invdp);
                    let jsonInvDpDetail = @json($datadetailInvoicePel);

                    var f1 = flatpickr(document.getElementById('basicFlatpickr'), {
                        defaultDate: new Date()
                    });
                    $('#exportButton').on('click', function() {
                        exportTableToExcel('style-3', 'Adhipramana Bahari Perkasa.xlsx');
                    });
                    $('.exportButtonRow').on('click', function() {
                        // Get the data-row attribute value from the element
                        var id_invoice_pel = $(this).data('row');

                        // Call the exportTableToExcel function with the specified row index
                        exportTableToExcelByRow('style-3', 'Adhipramana Bahari Perkasa.xlsx',
                            id_invoice_pel);
                    });


                    function exportTableToExcelByRow(tableId, filename, id_invoice_pel_selected) {

                        var formattedInvoices = jsonInvdp.map(item => {
                            var matchingDetail = jsonInvDpDetail.find(itemdetail => item.id_invoice_pel ==
                                itemdetail.id_invoice_pel && id_invoice_pel_selected == item.id_invoice_pel);
                            if (matchingDetail) {
                                return {
                                    "No Invoice": item.invoice_no,
                                    "Estate": matchingDetail.estate,
                                    "Total Tonase Dooring": `${Number(matchingDetail.total_tonase_dooring || 0).toLocaleString()} KG`,
                                    "Total Harga Dooring": `Rp. ${Number(matchingDetail.total_harga_dooring || 0).toLocaleString()}`,
                                    "Total Tonase Timbang Dooring": `${Number(matchingDetail.total_tonase_timbang || 0).toLocaleString()} KG`,
                                    "Total Harga Timbang Dooring": `Rp. ${Number(matchingDetail.total_harga_timbang || 0).toLocaleString()}`,
                                    "Total DP": `Rp. ${Number(matchingDetail.total_invoice_adjusted || 0).toLocaleString()}`,
                                };
                            }

                            return null; // handle the case when there is no matching detail
                        }).filter(item => item !== null); // remove null entries from the array

                        if (formattedInvoices === null) {
                            window.alert("Data Detail Tidak Tersedia");
                        }

                        // Convert JSON back to worksheet
                        ws = XLSX.utils.json_to_sheet(formattedInvoices);

                        // Calculate maximum column widths
                        var columnWidths = Array.from({
                            length: ws["!ref"].split(":")[1].charCodeAt(0) - 'A'.charCodeAt(0) + 1
                        }, () => 0);

                        // Set header row style
                        ws["!rows"] = [{
                            hpx: 20,
                            level: 1,
                            hidden: false
                        }];
                        ws["!cols"] = [];

                        // Iterate through all cells to measure column widths
                        XLSX.utils.sheet_to_json(ws, {
                            header: 1
                        }).forEach(row => {
                            row.forEach((value, columnIndex) => {
                                var textLength = value.toString().length;
                                if (textLength > columnWidths[columnIndex]) {
                                    columnWidths[columnIndex] = textLength;
                                }
                            });
                        });

                        // Set column widths in the worksheet object
                        columnWidths.forEach((width, index) => {
                            ws["!cols"].push({
                                wch: width + 2
                            }); // Add padding 2 for extra space
                        });

                        // Create workbook and save to file
                        var wb = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

                        // Add an additional column to ensure the last column is also exported
                        ws['!cols'].push({
                            wch: 10
                        });

                        XLSX.writeFile(wb, filename);
                    }

                    function exportTableToExcel(tableId, filename) {

                        // Convert HTML table to worksheet
                        var ws = XLSX.utils.table_to_sheet(document.getElementById(tableId));

                        // Convert worksheet to JSON and remove 'Action' column
                        var jsonSheet = XLSX.utils.sheet_to_json(ws, {
                            raw: false
                        }).map(item => {

                            delete item.Action;
                            return item;
                        });

                        // Convert JSON back to worksheet
                        ws = XLSX.utils.json_to_sheet(jsonSheet);

                        // Calculate maximum column widths
                        var columnWidths = Array.from({
                            length: ws["!ref"].split(":")[1].charCodeAt(0) - 'A'.charCodeAt(0) + 1
                        }, () => 0);

                        // Set header row style
                        ws["!rows"] = [{
                            hpx: 20,
                            level: 1,
                            hidden: false
                        }];
                        ws["!cols"] = [];

                        // Iterate through all cells to measure column widths
                        XLSX.utils.sheet_to_json(ws, {
                            header: 1
                        }).forEach(row => {
                            row.forEach((value, columnIndex) => {
                                var textLength = value.toString().length;
                                if (textLength > columnWidths[columnIndex]) {
                                    columnWidths[columnIndex] = textLength;
                                }
                            });
                        });

                        // Set column widths in the worksheet object
                        columnWidths.forEach((width, index) => {
                            ws["!cols"].push({
                                wch: width + 2
                            }); // Add padding 2 for extra space
                        });

                        // Create workbook and save to file
                        var wb = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

                        // Add an additional column to ensure the last column is also exported
                        ws['!cols'].push({
                            wch: 10
                        });

                        XLSX.writeFile(wb, filename);
                    }
                    </script>
                    <script>
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
                    <script>
                    $(document).ready(function() {
                        var formatter = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0
                        });
                        $('#modalIPLcur').on('show.bs.modal', function(event) {
                            var button = $(event.relatedTarget); // Button that triggered the modal
                            var idTrack = button.data(
                                'id-track'); // Get the data-id-track attribute from the button
                            var idInvoicePel = button.data(
                                'id-invoice-pel'); // Get the data-id-track attribute from the button


                            // Set the value of the hidden input
                            $('#id_track_i').val(idTrack);
                            $('#idInvoicePel').val(idInvoicePel);

                        });
                        $('#prosentaseppn').on('input', function() {
                            var ppn = $(this).val();
                            var TotalHargaDooring = $('#TotalHargaDooring').val();
                            var TotalHargaTimbangDooring = $('#TotalHargaTimbangDooring').val();
                            $('#totalppndoring').val(((ppn * TotalHargaDooring) / 100).toFixed(2));
                            $('#totalppntimbang').val(((ppn * TotalHargaTimbangDooring) / 100).toFixed(
                                2));
                        });
                        $('#cb_bypo').change(function() {
                            var selectedValue = $(this).val();
                            var valuecbkapal = $('#cb_kapal').val();
                            var parts = selectedValue.split('-');
                            // Make an AJAX request to fetch data based on the selected value
                            $.ajax({
                                url: '/horizontal-dark-menu/finance/invoice-pelunasan/calculate/' +
                                    parts[0], // Replace with your actual route URL
                                type: 'GET',
                                data: {
                                    cbkapal: valuecbkapal,
                                    estate: parts[1]
                                },
                                success: function(data) {
                                    // Update the input fields with the received data
                                    $('#ttdb').val(data.total_qty_tonase);
                                    $('#hrg_freight').val(data.hrg_frg);
                                    $('#tttd').val(data.total_qty_timbang);
                                    $('#ttrd').val(data.qty_tonase_real);
                                    $('#TotalHargaDooring').val(data.total_qty_tonase * data
                                        .hrg_frg);
                                    $('#TotalHargaTimbangDooring').val(data
                                        .total_qty_timbang * data.hrg_frg);
                                    $('#TotalHargaRealDooring').val(data.qty_tonase_real *
                                        data.hrg_frg);




                                    // Add similar lines for other input fields
                                },
                                error: function() {
                                    console.log('Error fetching data');
                                }
                            });
                        });
                        $('#cb_kapal').change(function() {
                            var selectedValue = $(this).val();
                            var idTrack = $('#id_track_i')
                                .val(); // Get the value from the hidden input field
                            if (selectedValue) {
                                // Send an Ajax request to get data for cb_bypo
                                $.ajax({
                                    type: 'GET',
                                    url: '/horizontal-dark-menu/finance/invoice-pelunasan/cb-kapal/' +
                                        selectedValue, // Replace with your actual endpoint URL
                                    data: {
                                        'idtrack': idTrack
                                    },
                                    success: function(response) {
                                        // Populate the cb_bypo select field with the received data
                                        // console.log(response);
                                        // Populate the 'cb_po' dropdown with the response data
                                        var cbbypo = $('#cb_bypo');
                                        cbbypo.empty(); // Clear existing options

                                        // Add new options from the response
                                        cbbypo.append(
                                            '<option selected disabled value="">Pilih...</option>'
                                        );
                                        $.each(response, function(index, value) {
                                            cbbypo.append('<option value="' + value
                                                .id_dooring + '-' + value
                                                .estate + '">' + value.no_po +
                                                '</option>');
                                        });
                                    },
                                    error: function() {
                                        console.log('Error fetching data');
                                    }
                                });
                            } else {
                                // Clear the cb_bypo select field when nothing is selected in cb_kapal
                                $('#cb_bypo').html(
                                    '<option selected disabled value="">Pilih...</option>');
                            }
                        });
                        $('#cb_po').change(function() {
                            var selectedValue = $(this).val();
                            var type_invoice = $('#cb_tipe_inv').val();
                            var id = selectedValue + "-" + type_invoice;
                            $.ajax({
                                type: 'GET',
                                url: '/horizontal-dark-menu/finance/invoice-pelunasan/get-invoice-number/' +
                                    id,
                                success: function(response) {
                                    $('#invoice_no').val(response.invoice_number);
                                },
                                error: function(error) {
                                    console.log('Error:', error);
                                }
                            });
                        });
                        $('#cb_tipe_inv').change(function() {
                            var selectedValue = $(this).val();

                            // Make an AJAX request
                            $.ajax({
                                type: 'GET',
                                url: '/horizontal-dark-menu/finance/invoice-pelunasan/cb-tipe-inv/' +
                                    selectedValue, // Replace with your actual endpoint URL
                                // data: { cb_tipe_inv: selectedValue },
                                success: function(response) {
                                    // Populate the 'cb_po' dropdown with the response data
                                    var cbPo = $('#cb_po');
                                    cbPo.empty(); // Clear existing options

                                    // Add new options from the response
                                    cbPo.append(
                                        '<option selected disabled value="">Pilih...</option>'
                                    );
                                    $.each(response, function(index, value) {
                                        cbPo.append('<option value="' + value
                                            .id_dooring + '">' + value.no_po +
                                            '</option>');
                                        console.log(value.id_dooring)
                                    });
                                },
                                error: function(error) {
                                    console.log('Error:', error);
                                }
                            });
                        });
                    });
                    </script>

                    </x-slot>
                    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>