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
            .toggle-code-snippet { margin-bottom: 0px; }
            body.dark .toggle-code-snippet { margin-bottom: 0px; }
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
                    <form class="row g-3 needs-validation" action="{{ route('invoice-pelunasan.store') }}"  method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="col-md-3">
                            <label for="validationCustom01" class="form-label">Invoice Date</label>
                            <input name="tgl_inv_dp" id="basicFlatpickr" value="2022-09-04" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select Date..">
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
                            <input name="invoice_no" type="text" class="form-control" id="invoice_no" placeholder="Autofill no invoice dp terakhir dari po + 1" readonly>
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
                            <h4>Tabel Invoice Pelunasan</h4>
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
                                            @if ($tdp->status == 1)
                                                <td class="text-center"><span class="shadow-none badge badge-danger">Pending</span></td>
                                            @elseif($tdp->status == 3)
                                                <td class="text-center"><span class="shadow-none badge badge-success">Approved Dooring</span></td>
                                            @elseif($tdp->status == 2)
                                                <td class="text-center"><span class="shadow-none badge badge-success">Approved Timbang Dooring</span></td>
                                            @endif
                                            <td class="text-center">
                                                @if ($tdp->status == 1)
                                                <a href="#modalIPLcur" data-id-track="{{$tdp->id_track }}" data-id-invoice-pel="{{$tdp->id_invoice_pel }}" class="bs-tooltip"  data-bs-toggle="modal" data-bs-placement="top" title="Tambah Detail" data-original-title="Tambah Detail"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg></a>
                                                @endif
                                                <!-- <a href="#modalDetailInvoice" data-id-track="{{$tdp->id_track }}" data-id-invoice-pel="{{$tdp->id_invoice_pel }}" class="bs-tooltip" data-bs-toggle="modal" data-bs-placement="top" title="Detail" data-original-title="Print"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></a> -->
                                                <a href="#modalDetailInvoice{{ $tdp->id_invoice_pel }}" class="bs-tooltip" data-bs-toggle="modal" data-bs-placement="top" title="Detail" data-original-title="Print">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
        <polyline points="14 2 14 8 20 8"></polyline>
        <line x1="16" y1="13" x2="8" y2="13"></line>
        <line x1="16" y1="17" x2="8" y2="17"></line>
        <polyline points="10 9 9 9 8 9"></polyline>
    </svg>
</a>

                                                <a href="/invoice-pelunasan/delete/{{ $tdp->id_track }}" class="bs-tooltip" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                                                <div class="p-1"></div>
                                                <a href="javascript:void(0);" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Print Tonase Dooring" data-original-title="Print"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg></a>
                                                <a href="javascript:void(0);" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Print Timbang Dooring" data-original-title="Print"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg></a>
                                                <a href="javascript:void(0);" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Print Real Dooring" data-original-title="Print"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg></a>
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
        <div class="modal fade bd-example-modal-xl" id="modalDetailInvoice{{ $tdp->id_invoice_pel }}" tabindex="-1" role="dialog" aria-labelledby="modalIDPdetail" aria-hidden="true">
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
            <th>Total PPN Dooring</th>
            <th>Total Tonase Timbang Dooring</th>
            <th>Total Harga Timbang Dooring</th>
            <th>Total PPN Timbang Dooring</th>
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
                    <td>{{number_format($item->total_tonase_dooring , 2, ',', '.')}}</td>
                    <td>{{number_format($item->total_harga_dooring , 2, ',', '.')}}</td>
                    <td>{{number_format($item->total_ppn_dooring , 2, ',', '.')}}</td>
                    <td>{{number_format($item->total_tonase_timbang , 2, ',', '.')}}</td>
                    <td>{{number_format($item->total_harga_timbang , 2, ',', '.')}}</td>
                    <td>{{number_format($item->total_ppn_timbang , 2, ',', '.')}}</td>
                    <td>{{number_format($item->total_invoice_adjusted , 2, ',', '.') ?? 0}}</td>
                    <td class="text-center">
                        @if ($tdp->status == 1 && $item->status == 1)
                        <a href="{{route('invoice-pelunasan.deletedetail',['id'=>$item->id_detail_pel])}}" class="bs-tooltip" data-bs-placement="top" title="Delete" data-original-title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </a>
                        @endif
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>

                    </div>
                    <div class="modal-footer">
                        @if ($tdp->status == 1)
                            <a class="btn btn-success" href="{{ route('invoice-pelunasan.approvetimbang', ['id_invoice_pel' => $tdp->id_invoice_pel]) }}">Approve Timbang Dooring</a>
                            <a class="btn btn-success" href="{{ route('invoice-pelunasan.approvedooring', ['id_invoice_pel' => $tdp->id_invoice_pel]) }}">Approve Dooring</a>
                        @endif                            
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="modal fade bd-example-modal-xl" id="modalIPLcur" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Detail Invoice Pelunasan</h5>
                        </div>
                        <div class="modal-body">
                            <form name="modal-tracking-ada" class="row g-3 needs-validation" action="{{ route('invoice-pelunasan-detail.detailstore') }}"  method="POST" enctype="multipart/form-data" novalidate>
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
                                        <input name="ttdb" step="any" min="0" id="ttdb" type="number" class="form-control qty_cont" required readonly>
                                        <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                    </div>     
                                </div>
                                <div class="col-md-6">
                                    <label for="notAllowCont" class="form-label">Total Tonase Timbang Dooring</label>
                                    <div class="input-group">
                                        <input name="tttd" step="any" min="0" id="tttd" type="number" class="form-control qty_cont" required readonly>
                                        <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                    </div>     
                                </div>                                
                                <div class="col-md-6">
                                    <label for="notAllowCont" class="form-label">Total Harga Dooring</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                        <input name="TotalHargaDooring" min="0" id="TotalHargaDooring" type="text" class="form-control" required readonly>
                                    </div>     
                                </div>                            
                                <div class="col-md-6">
                                    <label for="notAllowCont" class="form-label">Total Harga Timbang Dooring</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                        <input name="TotalHargaTimbangDooring" min="0" id="TotalHargaTimbangDooring" type="text" class="form-control" required readonly>
                                    </div>     
                                </div>      
                                
                                <div class="col-md-3">
                                    <label for="notAllowCont" class="form-label">Harga Freight</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                        <input name="hrg_freight" step="any" min="0" id="hrg_freight" type="number" class="form-control qty_cont" required readonly>
                                    </div>     
                                </div>                               
                                <div class="col-md-3">
                                    <label for="notAllowCont" class="form-label">Prosentase PPn</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">%</span>
                                        <input name="prosentaseppn" step="any" min="0" value="0" id="prosentaseppn" type="number" class="form-control qty_cont" required>
                                    </div>     
                                </div>
                                <div class="col-md-3">
                                    <label for="notAllowCont" class="form-label">Total PPn Dooring</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                        <input name="totalppndoring" step="any" min="0" value="0" id="totalppndoring" type="number" class="form-control qty_cont" required>
                                    </div>     
                                </div>
                                <div class="col-md-3">
                                    <label for="notAllowCont" class="form-label">Total PPn Timbang</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                        <input name="totalppntimbang" step="any" min="0" value="0" id="totalppntimbang" type="number" class="form-control qty_cont" required>
                                    </div>     
                                </div>  
                                <div class="modal-footer justify-content-center">
                                    <button id ="btn-modal-curah" type="submit" class="btn btn-primary">Tambah</button>
                                    <button type="button" class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i>Batal</button>
                                </div>
                            </form>
                        </div>
                        {{-- <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing mx-auto">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">                                
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Tabel Detail Invoice Pelunasan</h4>
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
                    {{-- </div> --}}
                </div>
            </div>
        </div>   


        {{-- <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing">
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
                                <table id="style-4" class="table style-4 dt-table-hover" style="width:100%;">
                                    <thead style="border-bottom: none;">
                                        <tr>
                                            <th>Tgl Muat</th>
                                            <th>Gudang Muat</th>
                                            <th>Nopol</th>
                                            <th>No Container</th>
                                            <th>No Segel</th>
                                            <th>Tonase</th>
                                            <th>SAK</th>
                                            <th>Timbangan</th>
                                            <th>No Surat Jalan</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>                 --}}
        {{-- <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Tabel Dooring</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="col-lg-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area">
                                <table id="show-hide-col" class="table show-hide-col dt-table-hover" style="width:100%;">
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
                                            <th>Nama Kapal</th>
                                            <th>TD</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>     --}}
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
{{-- 
        <script type='text/javascript'>
            $(document).ready(function() {

                    var formatter = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0 // Set the number of decimal places to 0 for whole numbers
                    });

                    var id_track = $("#id_track_i").val();

                    // Send an AJAX request to fetch options based on id_track
                    // $.get("/horizontal-dark-menu/finance/invoice-dp/dp/getOptionsPO/" + id_track, function (data) {
                    //     var select = $("#cb_bypo");
                    //     select.empty(); 
                    //     select.append($('<option>', {
                    //         value: '',
                    //         text: 'Pilih...',
                    //         disabled: true,
                    //         selected: true
                    //     }));

                    //     $.each(data, function (key, value) {
                    //         select.append($('<option>', {
                    //             value: key.id_track,
                    //             text: value.no_po + '(' + value.formatted_tgl_muat + ')'
                    //         }));
                    //     });
                    // });

                    // $('#cb_bypo').change(function() {
                    //     var selectedId = $(this).val();
                    //     var url = "{{ route('getDetailPO', [':id_track']) }}"
                    //             .replace(':id_track', selectedId);
                    //     if (selectedId !== '') {
                    //         $.ajax({
                    //             url: url,
                    //             type: 'GET',
                    //             dataType: 'json',
                    //             success: function(response) {
                    //                 var data = response[0];
                    //                 $("#ttdb").empty();
                    //                 $("#hrg_freight").empty();
                    //                 if (response.length > 0) {
                    //                     for (var i=0; i<response.length; i++) {
                    //                         var text = (response[i].no_container === null) ? response[i].oa_kpl_kayu : response[i].oa_container;
                    //                         $('#ttdb').val(response[i].total_muat);
                    //                         $('#hrg_freight').val(text);
                    //                         var muat = parseFloat($('#ttdb').val());
                    //                         var harga = parseFloat($('#hrg_freight').val());
                    //                         var total = harga * muat;
                    //                         $('#total_harga').val(formatter.format(total).replace('Rp', ''));
                    //                     }
                    //                 }else{
                    //                     console.log("no data");
                    //                 }
                    //             },
                    //             error: function(xhr, status, error) {
                    //                 console.log("AJAX Error: " + error);
                    //             }
                    //         });
                    //     } else {
                    //         $('#ttdb').val('');
                    //         $('#hrg_freight').val('');
                    //     }
                    // });
            });
        </script> --}}
        <script>
            var table = $('#show-hide-col').DataTable( {
                "dom": "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                "oLanguage": {
                    "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
                },
                buttons: [                 
                    {
                        text: 'Customer',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 0 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'SPK',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 1 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'Rute',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 2 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'PO Kebun',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 3 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'PT Kebun',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 4 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'Estate',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 5 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'Description Barang',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 6 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'QTY Dooring',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 7 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'KG',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 8 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'SAK',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 9 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'Date Berangkat',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 10 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'Date Tiba',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 11 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'No Tiket Timbang',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 12 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'No CONT',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 13 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'Nopol',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 14 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'QTY Timbang Kebun',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 15 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'Nama Kapal',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 16 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'TD',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 17 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'Status',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 18 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'Action',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 19 );
                            column.visible( ! column.visible() );
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
      <script type='text/javascript'>
        // $('#detail-invoice').on('click', function (event) {
        //     event.preventDefault();
        //     $('#modal-detail-invoice').modal('show');
            // var idInvoicePel = $(this).data('id-invoice-pel');
            // $.ajax({
            // url: '/horizontal-dark-menu/finance/invoice-pelunasan/detail/'+idInvoicePel, // Replace with your actual route URL
            // type: 'GET',
            // success: function (data) {
            //     console.log(data);
    // var table = $('#style-4 tbody'); // Menggunakan jQuery untuk mengakses elemen tbody
    // table.empty(); // Bersihkan baris yang sudah ada
    // $.each(data, function (index, value) {
    //     var row = '<tr>' +
    //         '<td>' + value.id_invoice_pel + '</td>' +
    //         '<td>' + value.no_po + '</td>' +
    //         '<td>' + value.total_tonase_dooring + '</td>' +
    //         '<td>' + value.total_harga_dooring + '</td>' +
    //         '<td>' + value.total_ppn_dooring + '</td>' +
    //         '<td>' + value.total_tonase_timbang_dooring + '</td>' +
    //         '<td>' + value.total_harga_timbang_dooring + '</td>' +
    //         '<td>' + value.total_ppn_timbang_dooring + '</td>' +
    //         '<td>' + value.total_dp + '</td>' +
    //         '<td class="text-center"><a href="/edit/' + value.id_detail_pel + '">Edit</a></td>' +
    //         '</tr>';
    //     table.append(row);
    // });
// }
//             error: function() {
//                 console.log('Error fetching data');
//             }
//         });
    $(document).ready(function() {
        var formatter = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            });
        
        // $('#modalDetailInvoice').on('show.bs.modal', function (event) {
        //     console.log(event);
//             var button = $(event.relatedTarget); 
//             var idInvoicePel = button.data('id-invoice-pel');
//             console.log(button);
//              $.ajax({
//             url: '/horizontal-dark-menu/finance/invoice-pelunasan/detail/'+idInvoicePel, // Replace with your actual route URL
//             type: 'GET',
//             success: function (data) {
//                 console.log(data);
//     // var table = $('#style-4 tbody'); // Menggunakan jQuery untuk mengakses elemen tbody
//     // table.empty(); // Bersihkan baris yang sudah ada
//     // $.each(data, function (index, value) {
//     //     var row = '<tr>' +
//     //         '<td>' + value.id_invoice_pel + '</td>' +
//     //         '<td>' + value.no_po + '</td>' +
//     //         '<td>' + value.total_tonase_dooring + '</td>' +
//     //         '<td>' + value.total_harga_dooring + '</td>' +
//     //         '<td>' + value.total_ppn_dooring + '</td>' +
//     //         '<td>' + value.total_tonase_timbang_dooring + '</td>' +
//     //         '<td>' + value.total_harga_timbang_dooring + '</td>' +
//     //         '<td>' + value.total_ppn_timbang_dooring + '</td>' +
//     //         '<td>' + value.total_dp + '</td>' +
//     //         '<td class="text-center"><a href="/edit/' + value.id_detail_pel + '">Edit</a></td>' +
//     //         '</tr>';
//     //     table.append(row);
//     // });
// }
//             error: function() {
//                 console.log('Error fetching data');
//             }
//         });
        // });
        $('#modalIPLcur').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var idTrack = button.data('id-track'); // Get the data-id-track attribute from the button
      var idInvoicePel = button.data('id-invoice-pel'); // Get the data-id-track attribute from the button
      

      // Set the value of the hidden input
      $('#id_track_i').val(idTrack);
      $('#idInvoicePel').val(idInvoicePel);
      
    });
    $('#prosentaseppn').on('input', function() {
        var ppn = $(this).val();
        var TotalHargaDooring = $('#TotalHargaDooring').val();
        var TotalHargaTimbangDooring = $('#TotalHargaTimbangDooring').val();
        $('#totalppndoring').val(((ppn * TotalHargaDooring) / 100).toFixed(2));
        $('#totalppntimbang').val(((ppn * TotalHargaTimbangDooring) / 100).toFixed(2));
    });
    $('#cb_bypo').change(function() {
        var selectedValue = $(this).val();
        var cbkapal = $('#cb_kapal').val(); // Get the value from the hidden input field
        // Make an AJAX request to fetch data based on the selected value
        $.ajax({
            url: '/horizontal-dark-menu/finance/invoice-pelunasan/calculate/'+selectedValue, // Replace with your actual route URL
            type: 'GET',
            data: { cbkapal: cbkapal },
            success: function(data) {
                // Update the input fields with the received data
                $('#ttdb').val(data.total_qty_tonase);
                $('#hrg_freight').val(data.hrg_frg);
                $('#tttd').val(data.total_qty_timbang);
                $('#ttrd').val(data.qty_tonase_real);
                $('#TotalHargaDooring').val(data.total_qty_tonase*data.hrg_frg);
                $('#TotalHargaTimbangDooring').val(data.total_qty_timbang*data.hrg_frg);
                $('#TotalHargaRealDooring').val(data.qty_tonase_real*data.hrg_frg);
                
                
                
                
                // Add similar lines for other input fields
            },
            error: function() {
                console.log('Error fetching data');
            }
        });
    });
    $('#cb_kapal').change(function () {
        var selectedValue = $(this).val();
        var idTrack = $('#id_track_i').val(); // Get the value from the hidden input field
        if (selectedValue) {
            // Send an Ajax request to get data for cb_bypo
            $.ajax({
                type: 'GET',
                url: '/horizontal-dark-menu/finance/invoice-pelunasan/cb-kapal/'+selectedValue, // Replace with your actual endpoint URL
                data: { 'idtrack': idTrack },
                success: function (response) {
                    // Populate the cb_bypo select field with the received data
                    // console.log(response);
                    // Populate the 'cb_po' dropdown with the response data
                    var cbbypo = $('#cb_bypo');
                    cbbypo.empty(); // Clear existing options

                    // Add new options from the response
                    cbbypo.append('<option selected disabled value="">Pilih...</option>');
                    $.each(response, function(index, value) {
                        cbbypo.append('<option value="' + value.id_dooring + '">' + value.no_po + '</option>');
                    });
                },
                error: function () {
                    console.log('Error fetching data');
                }
            });
        } else {
            // Clear the cb_bypo select field when nothing is selected in cb_kapal
            $('#cb_bypo').html('<option selected disabled value="">Pilih...</option>');
        }
    });
        $('#cb_tipe_inv').change(function() {
            var selectedValue = $(this).val();

            // Make an AJAX request
            $.ajax({
                type: 'GET',
                url: '/horizontal-dark-menu/finance/invoice-pelunasan/cb-tipe-inv/'+selectedValue, // Replace with your actual endpoint URL
                // data: { cb_tipe_inv: selectedValue },
                success: function(response) {
                    // Populate the 'cb_po' dropdown with the response data
                    var cbPo = $('#cb_po');
                    cbPo.empty(); // Clear existing options

                    // Add new options from the response
                    cbPo.append('<option selected disabled value="">Pilih...</option>');
                    $.each(response, function(index, value) {
                        cbPo.append('<option value="' + value.id_dooring + '">' + value.no_po + '</option>');
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