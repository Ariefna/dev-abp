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
                            <li class="breadcrumb-item active" aria-current="page">Invoice DP</li>
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
                                        <h4>Form Invoice DP</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area" style="padding: 1.5%;">
                                <form class="row g-3 needs-validation" action="{{ route('invoice-dp.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                                    @csrf
                                    <div class="col-md-4">
                                        <label for="validationCustom01" class="form-label">Invoice Date</label>
                                        <input name="tgl_inv_dp" id="basicFlatpickr" value="2022-09-04" class="form-control flatpickr flatpickr-input active" type="date" placeholder="Select Date..">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="validationCustom01" class="form-label">Invoice No</label>
                                        <input readonly name="invoice_no" type="text" class="form-control" id="invoice_no" placeholder="Otomatis Generate">
                                        <div class="invalid-feedback">
                                            Invoice No tidak boleh kosong
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="validationCustom01" class="form-label">No PO Muat</label>
                                        {{-- <input name="no_job" type="text" class="form-control" id="no_job" placeholder="No Job" required> --}}
                                        <select class="form-select" name="cb_po" id="cb_po" required>
                                            <option selected disabled value="">Pilih...</option>
                                            @foreach ($pomuat as $getpo)
                                            <option value="{{ $getpo->id_track }}">{{ $getpo->no_po }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            No PO Muat tidak boleh kosong
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
                                        <input name="terms" type="text" class="form-control" id="terms" placeholder="Masukkan terms" required>
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
                                        <h4>Tabel Invoice DP</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="col-lg-12">
                                    <div class="statbox widget box box-shadow">
                                        <div class="widget-content widget-content-area">
                                            <table id="style-3" class="table style-3 dt-table-hover" style="width:100%;">
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
                                                        {{-- <td>{{ $tdp->status }}</td> --}}
                                                        {{-- @if($tdp->status===1)
                                            <td><span class="shadow-none badge badge-danger">Pending</span></td>
                                            @else
                                            <td><span class="shadow-none badge badge-success">Approved</span></td>
                                            @endif --}}
                                                        <td class="text-center">{!! $tdp->status == 2 ? '<span class="shadow-none badge badge-success">Approved</span>' : ($tdp->status == 1 ? '<span class="shadow-none badge badge-danger">Pending</span>' : '') !!}
                                                        </td>
                                                        <td class="text-center">
                                                            {!! $tdp->status == 1 ? '<a href="#modalIDPcur-'. $tdp->id_invoice_dp .'" class="btn btn-outline-primary bs-tooltip me-2" data-bs-toggle="modal" data-placement="top" title="Invoice Curah">Curah</a>' : ($tdp->status == 1 ? '':'') !!}
                                                            {!! $tdp->status == 1 ? '<a href="#modalIDPcont-'. $tdp->id_invoice_dp.'" class="btn btn-outline-primary bs-tooltip me-2" data-bs-toggle="modal" data-placement="top" title="Invoice Container">Container</a>' : ($tdp->status == 1 ? '':'') !!}
                                                            {!! $tdp->status == 1 ? '<a href="'. route('invoice-dp.approve', ['id_invoice_dp' => $tdp->id_invoice_dp]) .'" class="btn btn-outline-primary bs-tooltip me-2" id="approve-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve" data-original-title="Approve">Approve</a>' : ($tdp->status == 2 ? '':'') !!}
                                                            {!! $tdp->status == 2 ? '<a href="'. route('invoice-dp.print',['id_invoice_dp'=>$tdp->id_invoice_dp]).'" class="btn btn-outline-primary bs-tooltip me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Print" data-original-title="Print">Print</a>' : ($tdp->status == 1 ? '':'') !!}
                                                            <a href="#modalIDPdetail-{{ $tdp->id_invoice_dp }}" class="btn btn-outline-primary bs-tooltip me-2" data-bs-toggle="modal" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail" data-original-title="Detail">Detail</a>
                                                            <a href="{!!route('invoice-dp.delete',['id_invoice_dp'=>$tdp->id_invoice_dp])!!}" class="btn btn-outline-primary bs-tooltip me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-original-title="Delete">Delete</a>
                                                            {{-- <a href="#modalInvDP-{{ $tdp->id_track }}" class="bs-tooltip" data-bs-toggle="modal" data-bs-placement="top" title="Tambah Detail" data-original-title="Tambah Detail"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
                                                                <circle cx="12" cy="12" r="10"></circle>
                                                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                                                <line x1="8" y1="12" x2="16" y2="12"></line>
                                                            </svg></a>
                                                            {!! $tdp->status == 1 ? '<a href="'. route('invoice-dp.approve', ['id_invoice_dp' => $tdp->id_invoice_dp]) .'" id="approve-link" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve" data-original-title="Approve"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check">
                                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                                </svg></a>' : ($tdp->status == 2 ? '':'') !!}
                                                            <a href="javascript:void(0);" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Print" data-original-title="Print"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer">
                                                                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                                                    <rect x="6" y="14" width="12" height="8"></rect>
                                                                </svg></a> --}}
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
                    @foreach ($invdp as $tdp)
                    <div class="modal fade bd-example-modal-xl" id="modalIDPdetail-{{ $tdp->id_invoice_dp }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                <th>PO Muat</th>
                                                <th>Total Tonase</th>
                                                <th>Total Harga</th>
                                                <th>Total DP</th>
                                                <th>Total PPN</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($datadetailInvoiceDp as $item)
                                            @if ($tdp->id_invoice_dp == $item->id_invoice_dp)
                                            <tr>
                                                <td>{{$item->invoice_no}}</td>
                                                <td>{{$item->no_po}}</td>
                                                <td>{{number_format($item->total_tonase , 0, ',', '.')}}</td>
                                                <td>{{number_format($item->total_harga , 0, ',', '.')}}</td>
                                                <td>{{number_format($item->total_dp , 0, ',', '.')}}</td>
                                                <td>{{number_format($item->total_ppn , 0, ',', '.')}}</td>
                                                <td class="text-center">
                                                    <a href="{{route('invoice-dp.deletedetail',['id_detail_dp'=>$item->id_detail_dp])}}" class="bs-tooltip" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                        </svg></a>
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade bd-example-modal-xl" id="modalIDPcur-{{ $tdp->id_invoice_dp }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalIDPcur">Tambah Detail Invoice DP Kapal Curah</h5>
                                </div>
                                <div class="modal-body">
                                    <form name="modal-detail" class="row g-3 needs-validation" action="{{ route('invoice-dp.savecurahidp') }}" method="POST" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <input type="hidden" name="id_track_i" id="id_track_i" value="{{ $tdp->id_track }}">
                                        <input type="hidden" name="id_invdp" id="id_invdp" value="{{ $tdp->id_invoice_dp }}">
                                        <div class="col-md-3">
                                            <label for="validationCustom04" class="form-label">PO Muat</label>
                                            <select class="form-select cb_bypo" name="cb_bypo" required>
                                                <option selected disabled value="">Pilih...</option>
                                                @foreach($getval->where('no_po',$tdp->no_po) as $gv)
                                                <option value="{{ $gv->no_po }}({{ $gv->formatted_tgl_muat }})">{{ $gv->no_po }}({{ $gv->formatted_tgl_muat }})</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="tgl_muat" id="tgl_muat">
                                            <div class="invalid-feedback">
                                                Pilih PO Muat
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="notAllowCont" class="form-label">Total Tonase by Date</label>
                                            <div class="input-group">
                                                <input name="ttdb" step="any" min="0" id="ttdb" type="number" class="form-control ttdb" readonly required>
                                                <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="notAllowCont" class="form-label">Harga Freight</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                                <input name="hrg_freight" step="any" min="0" id="hrg_freight" type="text" class="form-control hrg_freight" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="notAllowCont" class="form-label">Total Harga</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                                <input name="total_harga" min="0" id="total_harga" type="text" class="form-control total_harga" required>
                                            </div>
                                            <input type="hidden" name="sub_total" class="sub_total" value="{{ $subtotal->where('id_track', $tdp->id_track)->first()?->sub ?? 0 }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="validationCustom01" class="form-label">Prosentase DP</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend">%</span>
                                                <input name="prodp" step="any" min="0" max="100" type="number" class="form-control prodp" required>
                                            </div>
                                            <div class="invalid-feedback">
                                                Masukkan prosentase dengan benar
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="notAllowCont" class="form-label">Total DP</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                                <input name="todp" min="0" type="text" class="form-control todp" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="notAllowCont" class="form-label">Prosentase PPn</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend">%</span>
                                                <input name="proppn" step="any" min="0" max="100" type="number" class="form-control proppn" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="notAllowCont" class="form-label">Total PPn</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                                <input name="toppn" min="0" type="text" class="form-control toppn" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button id="btn-modal-curah" type="submit" class="btn btn-primary">Tambah</button>
                                            <button id="btn-batal-{{ $tdp->id_invoice_dp }}" type="button" class="btn btn btn-light-dark btn-batal">Batal</button>
                                        </div>
                                    </form>
                                </div>
                                {{-- <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing mx-auto">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">                                
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Tabel Detail Invoice DP</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <div class="col-lg-12">
                                        <div class="statbox widget box box-shadow">
                                            <div class="widget-content widget-content-area">
                                                <table id="style-4" class="table style-4 dt-table-hover" style="width:100%;">
                                                    <thead style="border-bottom: none;">
                                                        <tr>
                                                            <th>PO Muat</th>
                                                            <th>Total Harga</th>
                                                            <th>Subtotal</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>162002101</td>
                                                            <td>1.200.000</td>
                                                            <td>1.200.000</td>
                                                            <td class="text-center"><span class="shadow-none badge badge-success">Success</span></td>
                                                            <td class="text-center">
                                                                <a href="#exampleModalhps" class="bs-tooltip" data-bs-toggle="modal" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="modal fade bd-example-modal-xl" id="modalIDPcont-{{ $tdp->id_invoice_dp }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalIDPcont">Tambah Detail Invoice DP Kapal Container</h5>
                                </div>
                                <div class="modal-body">
                                    <form name="modal-tracking-ada" class="row g-3 needs-validation" action="{{ route('invoice-dp.savecontaineridp') }}" method="POST" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <input type="hidden" name="id_track_i" id="id_track_i" value="{{ $tdp->id_track }}">
                                        <input type="hidden" name="id_invdp" id="id_invdp" value="{{ $tdp->id_invoice_dp }}">
                                        <div class="col-md-3">
                                            <label for="validationCustom04" class="form-label">PO Muat</label>
                                            <select class="form-select cb_bypocont" name="cb_bypocont" id="cb_bypocont" required>
                                                <option selected disabled value="">Pilih...</option>
                                                @foreach($getvalcont->where('no_po',$tdp->no_po) as $gvc)
                                                <option value="{{ $gvc->no_po }}({{ $gvc->formatted_tgl_muat }})">{{ $gvc->no_po }}({{ $gvc->formatted_tgl_muat }})</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="tgl_muatcont" id="tgl_muatcont">
                                            <div class="invalid-feedback">
                                                Pilih PO Muat
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="notAllowCont" class="form-label">Total Tonase by Date</label>
                                            <div class="input-group">
                                                <input readonly name="ttdbcont" step="any" min="0" id="ttdbcont" type="number" class="form-control ttdbcont" required>
                                                <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="notAllowCont" class="form-label">Harga Freight</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                                <input readonly name="hrg_freightcont" step="any" min="0" id="hrg_freightcont" type="text" class="form-control hrg_freightcont" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="notAllowCont" class="form-label">Total Harga</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                                <input readonly name="total_hargacont" min="0" id="total_hargacont" type="text" class="form-control total_hargacont" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="validationCustom01" class="form-label">Prosentase DP</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend">%</span>
                                                <input name="prodpcont" step="any" min="0" max="100" id="prodpcont" type="number" class="form-control prodpcont" required>
                                            </div>
                                            <div class="invalid-feedback">
                                                Masukkan prosentase dengan benar
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="notAllowCont" class="form-label">Total DP</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                                <input name="todpcont" min="0" id="todpcont" type="text" class="form-control todpcont" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="notAllowCont" class="form-label">Prosentase PPn</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend">%</span>
                                                <input name="proppncont" step="any" min="0" max="100" id="proppncont" type="number" class="form-control proppncont" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="notAllowCont" class="form-label">Total PPn</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                                <input name="toppncont" min="0" id="toppncont" type="text" class="form-control toppncont" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button id="btn-modal-curah" type="submit" class="btn btn-primary">Tambah</button>
                                            <button type="button" id="btn-batal" class="btn btn btn-light-dark btn-batal" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i>Batal</button>
                                        </div>
                                    </form>
                                </div>
                                {{-- <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing mx-auto">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">                                
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Tabel Detail Invoice DP</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <div class="col-lg-12">
                                        <div class="statbox widget box box-shadow">
                                            <div class="widget-content widget-content-area">
                                                <table id="style-4" class="table style-4 dt-table-hover" style="width:100%;">
                                                    <thead style="border-bottom: none;">
                                                        <tr>
                                                            <th>PO Muat</th>
                                                            <th>Total Harga</th>
                                                            <th>Subtotal</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>162002101</td>
                                                            <td>1.200.000</td>
                                                            <td>1.200.000</td>
                                                            <td class="text-center"><span class="shadow-none badge badge-success">Success</span></td>
                                                            <td class="text-center">
                                                                <a href="#exampleModalhps" class="bs-tooltip" data-bs-toggle="modal" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                            </div>
                        </div>
                    </div>
                    @endforeach
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
                    {{-- <script src="{{asset('plugins/table/datatable/custom_miscellaneous.js')}}"></script> --}}

                    <script>
                        var f1 = flatpickr(document.getElementById('basicFlatpickr'), {
                            defaultDate: new Date()
                        });
                    </script>

                    <script type='text/javascript'>
                        $(document).ready(function() {
                            var id_track = $("#id_track_i").val();

                            var formatter = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            });
                            @foreach($invdp as $tdp)
                            $(".modal").on("show.bs.modal", function() {
                                $('.cb_bypo').val('');
                                $('.cb_bypo option[value=""]').prop('selected', true);
                                $('.ttdb').val('0');
                                $('.hrg_freight').val('0');
                                $('.total_harga').val('0');
                                $('.prodp').val('0');
                                $('.todp').val('0');
                                $('.proppn').val('0');
                                $('.toppn').val('0');
                                $('.cb_bypo').val('');
                                $('.cb_bypocont option[value=""]').prop('selected', true);
                                $('.ttdbcont').val('0');
                                $('.hrg_freightcont').val('0');
                                $('.total_hargacont').val('0');
                                $('.prodpcont').val('0');
                                $('.todpcont').val('0');
                                $('.proppncont').val('0');
                                $('.toppncont').val('0');
                                $('.cb_bypocont').val('');
                            });
                            $('input[name="prodp"], input[name="prodpcont"]').on('click', function() {
                                if ($(this).val() === '0') {
                                    $(this).val('');
                                }
                            });
                            $('input[name="proppn"], input[name="proppncont"]').on('click', function() {
                                if ($(this).val() === '0') {
                                    $(this).val('');
                                }
                            });
                            $(".btn-batal").click(function(event) {
                                if (event.target === this) {
                                    var modalId = $(this).closest('.modal').attr('id');
                                    $('#' + modalId).modal('hide');
                                    $('#' + modalId).on('hidden.bs.modal', function() {});
                                }
                            });
                            @endforeach
                            $('.cb_bypo').change(function() {
                                var selectedId = $(this).val();
                                var url = "{{ route('getDetailPO', [':id_track']) }}"
                                    .replace(':id_track', selectedId);
                                if (selectedId !== '') {
                                    $.ajax({
                                        url: url,
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function(response) {
                                            var data = response[0];
                                            console.log(response);
                                            $("#ttdb").empty();
                                            $("#hrg_freight").empty();
                                            $('#tgl_muat').empty();
                                            if (response.length > 0) {
                                                for (var i = 0; i < response.length; i++) {
                                                    $('input[name=ttdb]').val(parseFloat(response[i].total_muat).toFixed(0));
                                                    $('input[name=hrg_freight]').val(formatter.format(response[i].oa_kpl_kayu).replace('Rp', ''));
                                                    $('input[name=tgl_muat]').val(response[i].tgl_muat)
                                                    var hrg_freight = response[i].oa_kpl_kayu;
                                                    var total_tonase = response[i].total_muat;
                                                    var total = hrg_freight * total_tonase;
                                                    $('input[name=total_harga]').val(formatter.format(total).replace('Rp', ''));
                                                    console.log(muat);
                                                    console.log(harga);
                                                    console.log(total);
                                                    console.log(response);
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
                                    $('#ttdb').val('');
                                    $('#hrg_freight').val('');
                                }
                            });
                            $('.cb_bypocont').change(function() {
                                var selectedId = $(this).val();
                                var url = "{{ route('getDetailPOCont', [':id_track']) }}"
                                    .replace(':id_track', selectedId);
                                if (selectedId !== '') {
                                    $.ajax({
                                        url: url,
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function(response) {
                                            var data = response[0];
                                            console.log(response);
                                            $("#ttdbcont").empty();
                                            $("#hrg_freightcont").empty();
                                            $('#tgl_muatcont').empty();
                                            if (response.length > 0) {
                                                for (var i = 0; i < response.length; i++) {
                                                    $('input[name=ttdbcont]').val(parseFloat(response[i].total_muat).toFixed(0));
                                                    $('input[name=hrg_freightcont]').val(formatter.format(response[i].oa_container).replace('Rp', ''));
                                                    $('input[name=tgl_muatcont]').val(response[i].tgl_muat)
                                                    var hrg_freight = response[i].oa_container;
                                                    var total_tonase = response[i].total_muat;
                                                    var total = hrg_freight * total_tonase;
                                                    $('input[name=total_hargacont]').val(formatter.format(total).replace('Rp', ''));
                                                    console.log(total_tonase);
                                                    console.log(hrg_freight);
                                                    console.log(total);
                                                    console.log(response);
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
                                    $('#ttdbcont').val('');
                                    $('#hrg_freightcont').val('');
                                    $('#tgl_muatcont').val('');
                                }
                            });
                            $('.prodp, .proppn').on('input', function() {
                                var modal = $(this).closest('.modal');
                                var prodp = parseFloat(modal.find('.prodp').val()) || 0;
                                var proppn = parseFloat(modal.find('.proppn').val()) || 0;
                                var total_harga = parseFloat(modal.find('.total_harga').val().replace(/\D/g, '')) || 0;
                                var subtotal = $('.sub_total').val();
                                var total_dp = (total_harga * prodp) / 100;
                                var total_ppn = (total_dp * proppn) / 100;

                                modal.find('.todp').val(formatter.format(total_dp).replace('Rp', ''));
                                modal.find('.toppn').val(formatter.format(total_ppn).replace(',', '.').replace('Rp', ''));
                            });
                            $('.prodpcont, .proppncont').on('input', function() {
                                var modal = $(this).closest('.modal');
                                var prodp = parseFloat(modal.find('.prodpcont').val()) || 0;
                                var proppn = parseFloat(modal.find('.proppncont').val()) || 0;
                                var total_harga = parseFloat(modal.find('.total_hargacont').val().replace(/\D/g, '')) || 0;
                                var subtotal = $('.sub_totalcont').val();
                                var total_dp = (total_harga * prodp) / 100;
                                var total_ppn = (total_harga * proppn) / 100;

                                modal.find('.todpcont').val(formatter.format(total_dp).replace('Rp', ''));
                                modal.find('.toppncont').val(formatter.format(total_ppn).replace('Rp', ''));
                            });

                            // function updateValues() {
                            //     var prodp = parseFloat($('#prodp').val()) || 0;
                            //     var proppn = parseFloat($('#proppn').val()) || 0;
                            //     var total_harga = parseFloat($('#total_harga').val().replace(/\D/g, '')) || 0;
                            //     var total_dp = (total_harga * prodp) / 100;
                            //     var total_ppn = (total_harga * proppn) / 100;

                            //     $('#todp').val(formatter.format(total_dp).replace('Rp', ''));
                            //     $('#toppn').val(formatter.format(total_ppn).replace('Rp', ''));
                            // }

                            // $('#prodp, #proppn').on('input', function () {
                            //     updateValues();
                            // });

                            // updateValues();

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