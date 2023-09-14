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
        {{-- @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss'])
        @vite(['resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss']) --}}
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
                <li class="breadcrumb-item">Document</li>
                <li class="breadcrumb-item active" aria-current="page">Tracking</li>
            </ol>
        </nav>
    </div>
    <!-- /BREADCRUMB -->        
    <div class="row layout-top-spacing">

        @if (count($track->where('status', 1)) >= 1 && count($dtrack->where('status', 1 )) >= 1)
        <div id="alertIcon" class="col-lg-12 mb-2">
            <div class="widget-content widget-content-area">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" data-bs-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                    <strong>Selesaikan No PO ini terlebih dahulu!</strong> 
                </div>
            </div>
        </div>        
        @else
        <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Form Tracking</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area" style="padding: 1.5%;">
                    <form class="row g-3 needs-validation" action="{{ route('tracking.store') }}"  method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="col-md-3">
                            <label for="validationCustom01" class="form-label">No PO Muat</label>
                            <select class="form-select" name="no_po" id="cb_po" required>
                                <option selected disabled value="">Pilih...</option>                                
                                @foreach ($po as $po)
                                    <option value="{{ $po->po_muat }}">{{ $po->po_muat }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Form PO Muat tidak boleh kosong
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom01" class="form-label">PO Kebun</label>
                            <input disabled name="po_kebun" type="text" class="form-control" id="po_kebun" required>
                            <div class="invalid-feedback">
                                Form PO Kebun tidak boleh kosong
                            </div>
                        </div>                
                        <div class="col-md-3">
                            <label for="validationCustom03" class="form-label">Nama Kebun</label>
                            <input disabled name="nm_kebun" type="text" class="form-control" id="nm_kebun" required>
                        </div>        
                        <div class="col-md-3">
                            <label for="validationCustom01" class="form-label">No PL</label>
                            <input disabled name="no_pl" type="text" class="form-control" id="no_pl" required>
                            <div class="invalid-feedback">
                                Form PL tidak boleh kosong
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustom01" class="form-label">SIMB</label>
                            <input disabled name="simb" type="text" class="form-control" id="simb" required>
                            <div class="invalid-feedback">
                                Form SIMB tidak boleh kosong
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustom01" class="form-label">Estate</label>
                            <input disabled name="est" type="text" class="form-control" id="est" required>
                            <div class="invalid-feedback">
                                Form estate tidak boleh kosong
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustom01" class="form-label">Jenis Pupuk</label>
                            <input disabled name="brg" type="text" class="form-control" id="brg" required>
                            <div class="invalid-feedback">
                                Form jenis tidak boleh kosong
                            </div>
                        </div>                                                                        
                        <div class="col-md-6">
                            <label for="validationCustom03" class="form-label">Port Of Loading</label>
                            <select class="form-select" name="id_pol" id="validationDefault01" required>
                                <option selected disabled value="">Pilih...</option>                                
                                @foreach ($pol as $pol)
                                    <option value="{{ $pol->id }}">{{ $pol->nama_pol }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom03" class="form-label">Port Of Destination</label>
                            <select class="form-select" name="id_pod" id="validationDefault01" required>
                                <option selected disabled value="">Pilih...</option>
                                @foreach ($pod as $pod)
                                    <option value="{{ $pod->id }}">{{ $pod->nama_pod }}</option>
                                @endforeach                                
                            </select>
                        </div>                                                
                        
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
        @endif        
        <div id="basic" class="col-xl-12 col-lg-12 col-sm-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Tabel Tracking</h4>
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
                                            <th>No PO</th>
                                            <th>Rute</th>
                                            <th>Muat Curah</th>
                                            <th>Muat Container</th>
                                            <th>Total Sudah Muat</th>
                                            <th>Total Belum Muat</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($details==0)
                                            @foreach ($trackzero as $tra)
                                            <tr>
                                                <td>{{ $tra->no_po }}</td>
                                                <td>{{ $tra->nama_pol }} - {{ $tra->nama_pod }}</td>
                                                <td>{{ $tra->qty }}</td>
                                                <td>{{ $tra->qty2 }}</td>
                                                <td>0</td>
                                                <td>{{ $tra->total_qty }}</td>
                                                <td class="text-center"><span class="shadow-none badge badge-danger">{{ $tra->status == 1 ? 'Pending' : '' }}</span></td>
                                                {{-- <td class="text-center">{!! $tra->status == 1 ? '<span class="shadow-none badge badge-success">Proses Muat</span>' : ($tra->status == 2 ? '<span class="shadow-none badge badge-warning">Selesai Muat</span>' : '') !!}</td> --}}
                                                <td class="text-center">
                                                    @if($tra->qty != 0)
                                                        <a href="#detailcur" class="btn btn-outline-primary bs-tooltip me-2" data-bs-toggle="modal" data-placement="top" title="Add Curah">Curah</a>
                                                    @endif                                            
                                                    @if($tra->qty2 != 0)
                                                        <a href="#detailcont" class="btn btn-outline-primary bs-tooltip me-2" data-bs-toggle="modal" data-placement="top" title="Add Container">Container</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            @foreach ($track as $trac)
                                            <tr>
                                                <td>{{ $trac->no_po }}</td>
                                                <td>{{ $trac->nama_pol }} - {{ $trac->nama_pod }}</td>
                                                <td>{{ $trac->muat_curah ?? '0' }}</td>
                                                <td>{{ $trac->muat_container ?? '0' }}</td>
                                                <td>{{ $trac->muat_container + $trac->muat_curah }}</td>
                                                <td>{{ ($trac->total_qty) - ($trac->muat_curah + $trac->muat_container)}}</td>
                                                <td class="text-center"><span class="shadow-none badge badge-danger">{{ $trac->status == 1 ? 'Pending' : '' }}</span></td>
                                                <td class="text-center">
                                                    @if($trac->qty != 0)
                                                        <a href="#detailcur" class="btn btn-outline-primary bs-tooltip me-2" data-bs-toggle="modal" data-placement="top" title="Add Curah">Curah</a>
                                                    @endif                                            
                                                    @if($trac->qty2 != 0)
                                                        <a href="#detailcont" class="btn btn-outline-primary bs-tooltip me-2" data-bs-toggle="modal" data-placement="top" title="Add Container">Container</a>
                                                    @endif
                                                </td>
                                            </tr>
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
        <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Tabel Detail Tracking</h4>
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
                                        @foreach ($dtrack as $tra)
                                        <tr>
                                            <td>{{ $tra->tgl_muat }}</td>
                                            <td>{{ $tra->nama_gudang }}</td>
                                            <td>{{ $tra->nopol }}</td>
                                            <td>{{ $tra->no_container }}</td>
                                            <td>{{ $tra->no_segel }}</td>
                                            <td>{{ $tra->qty_tonase }}</td>
                                            <td>{{ $tra->jml_sak }}</td>
                                            <td>{{ $tra->qty_timbang }}</td>
                                            <td>{{ $tra->no_sj }}</td>
                                            <td class="text-center"><span class="shadow-none badge badge-danger">{{ $tra->status == 1 ? 'Pending' : '' }}</span></td>
                                            <td class="text-center">
                                                <a href="" class="bs-tooltip" data-bs-toggle="modal" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
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
        <div class="modal fade bd-example-modal-xl" id="detailcont" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5>Tambah Detail Tracking Kapal Container</h5>
                        {{-- @if ($lastcont) --}}
                        <form class="row g-3 needs-validation" action="{{ route('tracking.savecontainer') }}"  method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            @foreach ($trackzero as $tra)
                                <input name="id_track" value="{{ $tra->id_track }}" type="hidden" class="form-control" id="validationCustom01" required>
                            @endforeach
                            <div class="col-md-3">
                                <label for="validationCustom04" class="form-label">Tanggal Muat</label>
                                <div class="input-group has-validation">
                                    <input name="tgl_muat" id="basicFlatpickr" value="2022-09-04" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select Date..">
                                </div>
                            </div>      
                            @if ($lastcont)
                            <div class="col-md-3">                       
                                <label for="validationCustom03" class="form-label">Gudang Muat</label>
                                <select class="form-select" name="id_gudang" id="validationDefault01" required>
                                    <option selected disabled value="">Pilih...</option>                                    
                                        @foreach ($gudang as $gd)
                                            <option {{ $lastcont->id_gudang == $gd->id_gudang ? 'selected' : '' }} value="{{ $gd->id_gudang }}">{{ $gd->nama_gudang }}</option>
                                        @endforeach                                    
                                </select>
                            </div>                                                
                            <div class="col-md-3">
                                <label for="validationCustom03" class="form-label">Kapal</label>
                                <select class="form-select" name="id_kapal" id="validationDefault01" required>
                                    <option selected disabled value="">Pilih...</option>
                                    @foreach ($kapal as $kpl)
                                        <option {{ $lastcont->id_kapal == $kpl->id ? 'selected' : '' }} value="{{ $kpl->id }}">{{ $kpl->kode_kapal }} {{ $kpl->nama_kapal }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom03" class="form-label">Voyage</label>
                                <input name="voyage" type="text" value="{{ $lastcont->voyage }}" class="form-control" id="validationCustom01" placeholder="Masukkan Voyage" required>
                            </div>
                            <div class="col-md-4">
                                <label for="validationCustom03" class="form-label">Nopol</label>
                                <input name="nopol" type="text" class="form-control" id="validationCustom01" placeholder="Masukkan Nopol" required>
                            </div>
                            <div class="col-md-4">
                                <label for="validationCustom04" class="form-label">No Container</label>
                                <div class="input-group has-validation">
                                    <input name="no_container" value="{{ $lastcont->no_container }}" type="text" value="" class="form-control" id="validationCustom01" placeholder="Masukkan Nomor Container" required>
                                </div>
                            </div>                                                
                            <div class="col-md-4">
                                <label for="validationCustom03" class="form-label">No Segel</label>
                                <input name="no_segel" value="{{ $lastcont->no_segel }}" type="text" class="form-control" id="validationCustom01" placeholder="Masukkan No Segel" required>
                            </div>
                            @elseif ($lastcont==0)
                            <div class="col-md-3">                       
                                <label for="validationCustom03" class="form-label">Gudang Muat</label>
                                <select class="form-select" name="id_gudang" id="validationDefault01" required>
                                    <option selected disabled value="">Pilih...</option>                                    
                                        @foreach ($gudang as $gd)
                                            <option value="{{ $gd->id_gudang }}">{{ $gd->nama_gudang }}</option>
                                        @endforeach
                                </select>
                            </div>                                                
                            <div class="col-md-3">
                                <label for="validationCustom03" class="form-label">Kapal</label>
                                <select class="form-select" name="id_kapal" id="validationDefault01" required>
                                    <option selected disabled value="">Pilih...</option>
                                    @foreach ($kapal as $kpl)
                                        <option value="{{ $kpl->id }}">{{ $kpl->kode_kapal }} {{ $kpl->nama_kapal }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom03" class="form-label">Voyage</label>
                                <input name="voyage" type="text" value="" class="form-control" id="validationCustom01" placeholder="Masukkan Voyage" required>
                            </div>
                            <div class="col-md-4">
                                <label for="validationCustom03" class="form-label">Nopol</label>
                                <input name="nopol" type="text" class="form-control" id="validationCustom01" placeholder="Masukkan Nopol" required>
                            </div>
                            <div class="col-md-4">
                                <label for="validationCustom04" class="form-label">No Container</label>
                                <div class="input-group has-validation">
                                    <input name="no_container" value="" type="text" value="" class="form-control" id="validationCustom01" placeholder="Masukkan Nomor Container" required>
                                </div>
                            </div>                                                
                            <div class="col-md-4">
                                <label for="validationCustom03" class="form-label">No Segel</label>
                                <input name="no_segel" value="" type="text" class="form-control" id="validationCustom01" placeholder="Masukkan No Segel" required>
                            </div>
                            @endif
                            <div class="col-md-3">
                                @if ($lastcont)
                                    @foreach ($getcontqty as $tra)
                                        <label for="notAllowCont" class="form-label">Quantity Tonase</label>
                                        <div class="input-group">
                                            <input name="qty_tonase" step="any" min="0" id="qty_cont" type="number" class="form-control qty_cont" placeholder="QTY Tonase" required>
                                            <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                        </div>          
                                        <span class="shadow-none badge badge-danger mt-2">Sisa: {{ $tra->qty_tonase_sisa }}</span><div class="notAllowCont"></div>
                                        <input name="qty_cont_total" id="qty_cont_total" value="{{ $tra->qty_tonase_sisa }}" type="hidden" step="any" min="0">
                                        <input type="hidden" name="qty_cont_ada" id="qty_sisa_cont" value="0" step="any" min="0">
                                    @endforeach
                                @elseif($lastcont==0)
                                    @foreach ($zerocont as $tra)
                                        <label for="notAllowCont" class="form-label">Quantity Tonase</label>
                                        <div class="input-group">
                                            <input name="qty_tonase" step="any" min="0" id="qty_cont" type="number" class="form-control qty_cont" placeholder="QTY Tonase" required>
                                            <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                        </div>          
                                        <span class="shadow-none badge badge-danger mt-2">Sisa: {{ $tra->qty2 }}</span><div class="notAllowCont"></div>
                                        <input name="qty_cont_total" id="qty_cont_total" value="{{ $tra->qty2 }}" type="hidden" step="any" min="0">
                                        <input name="qty_cont_emp" id="qty_sisa_cont" value="0" type="hidden" step="any" min="0">
                                    @endforeach
                                @endif                                                 
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom03" class="form-label">Jumlah Sak</label>
                                <input name="jml_sak" type="number" class="form-control" id="validationCustom01" placeholder="Jumlah Sak" required>
                            </div>                            
                            <div class="col-md-3">
                                <label for="validationCustom03" class="form-label">Quantity Timbangan</label>
                                <div class="input-group">
                                    <input name="qty_timbang" step="any" min="0" type="number" class="form-control" placeholder="QTY Timbang" required>
                                    <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom03" class="form-label">Upload File Surat Timbang</label>
                                <div class="mb-3">
                                    <input name="file_tbg" accept=".jpg, .png, .pdf" class="form-control file-upload-input" style="height: 48px; padding: 0.75rem 1.25rem;" type="file" id="formFile">
                                </div>
                            </div>                            
                            <div class="col-md-6">
                                <label for="validationCustom04" class="form-label">No Surat Jalan</label>
                                <div class="input-group has-validation">
                                    <input name="no_sj" type="text" value="" class="form-control" id="validationCustom01" placeholder="Masukkan Nomor Container" required>
                                </div>
                            </div>                            
                            <div class="col-md-6">
                                <label for="validationCustom03" class="form-label">Upload File Surat Jalan</label>
                                <div class="mb-3">
                                    <input name="file" accept=".jpg, .png, .pdf" class="form-control file-upload-input" style="height: 48px; padding: 0.75rem 1.25rem;" type="file" id="formFile">
                                </div>
                            </div>                            
                            <div class="modal-footer justify-content-center">
                                <button type="submit" id="btn-modal-cont" class="btn btn-primary">Tambah</button>
                                <button type="button" class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i>Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-xl" id="detailcur" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5>Tambah Detail Tracking Kapal Curah</h5>
                        <form name="modal-tracking-ada" class="row g-3 needs-validation" action="{{ route('tracking.savecurah') }}"  method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            @foreach ($trackzero as $tra)
                                <input name="id_track" value="{{ $tra->id_track }}" type="hidden" class="form-control" id="validationCustom01" required>
                            @endforeach
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <label for="validationCustom04" class="form-label">Tanggal Muat</label>
                                <div class="input-group has-validation">
                                    <input name="tgl_muat" id="basicFlatpickr" value="2022-09-04" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select Date..">
                                </div>
                            </div>
                            @if ($lastcurah)     
                            <div class="col-lg-3 col-md-6 col-sm-12">                       
                                <label for="validationCustom03" class="form-label">Gudang Muat</label>
                                <select class="form-select" name="id_gudang" id="validationDefault01" required>
                                    <option selected disabled value="">Pilih...</option>                                    
                                        @foreach ($gudang as $gd)
                                            <option {{ $lastcurah->id_gudang == $gd->id_gudang ? 'selected' : '' }} value="{{ $gd->id_gudang }}">{{ $gd->nama_gudang }}</option>
                                        @endforeach                                    
                                </select>
                            </div>                                                
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <label for="validationCustom03" class="form-label">Kapal</label>
                                <select class="form-select" name="id_kapal" id="validationDefault01" required>
                                    <option selected disabled value="">Pilih...</option>
                                    @foreach ($kapal as $kpl)
                                        <option {{ $lastcurah->id_kapal == $kpl->id ? 'selected' : '' }} value="{{ $kpl->id }}">{{ $kpl->kode_kapal }} {{ $kpl->nama_kapal }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @elseif($lastcurah==0)
                            <div class="col-lg-3 col-md-6 col-sm-12">                       
                                <label for="validationCustom03" class="form-label">Gudang Muat</label>
                                <select class="form-select" name="id_gudang" id="validationDefault01" required>
                                    <option selected disabled value="">Pilih...</option>                                    
                                        @foreach ($gudang as $gd)
                                            <option value="{{ $gd->id_gudang }}">{{ $gd->nama_gudang }}</option>
                                        @endforeach                                    
                                </select>
                            </div>                                                
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <label for="validationCustom03" class="form-label">Kapal</label>
                                <select class="form-select" name="id_kapal" id="validationDefault01" required>
                                    <option selected disabled value="">Pilih...</option>
                                    @foreach ($kapal as $kpl)
                                        <option value="{{ $kpl->id }}">{{ $kpl->kode_kapal }} {{ $kpl->nama_kapal }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <label for="validationCustom03" class="form-label">Nopol</label>
                                <input name="nopol" type="text" class="form-control" id="validationCustom01" placeholder="Masukkan Nopol" required>
                            </div>                            
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                @if ($lastcurah)
                                    @foreach ($getcurahqty as $tra)
                                        <label for="validationMessage" class="form-label">Quantity Tonase </label>
                                        <div class="input-group">
                                            <input name="qty_tonase" id="qty_curah" type="number" step="any" min="0" class="form-control qty_curah" placeholder="QTY Tonase" required>
                                            <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                        </div>
                                        <span class="shadow-none badge badge-danger mt-2">Sisa: {{ $tra->qty_tonase_sisa }}</span><div class="validationMessage"></div>
                                        <input name="qty_curah_total" id="qty_curah_total" value="{{ $tra->qty_tonase_sisa }}" type="hidden" step="any" min="0">
                                        <input type="hidden" name="qty" id="qty_sisa_curah" step="any" min="0">
                                        
                                    @endforeach
                                @elseif($lastcurah==0)
                                    @foreach ($zerocurah as $tra)
                                        <label for="validationMessage" class="form-label">Quantity Tonase</label>
                                        <div class="input-group">
                                            <input name="qty_tonase" id="qty_curah" type="number" value="0" step="any" min="0" class="form-control qty_curah" placeholder="QTY Tonase" required>
                                            <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                        </div>
                                        <span class="shadow-none badge badge-danger mt-2">Sisa: {{ $tra->qty }}</span>
                                        <input name="qty_curah_total" id="qty_curah_total" value="{{ $tra->qty }}" type="hidden" step="any" min="0">
                                        <input name="qty_sisa_curah" id="qty_sisa_curah" value="0" type="hidden" step="any" min="0">
                                        <div class="validationMessage"></div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <label for="validationCustom03" class="form-label">Jumlah Sak</label>
                                <input name="jml_sak" type="number" class="form-control" id="validationCustom01" placeholder="Jumlah Sak" required>
                            </div>                            
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <label for="validationCustom03" class="form-label">Quantity Timbangan</label>
                                <div class="input-group">
                                    <input name="qty_timbang" step="any" min="0" type="number" class="form-control" placeholder="QTY Timbang" required>
                                    <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <label for="validationCustom03" class="form-label">Upload File Surat Timbang</label>
                                <div class="mb-3">
                                    <input name="file_tbg" accept=".jpg, .png, .pdf" class="form-control file-upload-input" style="height: 48px; padding: 0.75rem 1.25rem;" type="file" id="formFile">
                                </div>
                            </div>                            
                            <div class="col-md-6">
                                <label for="validationCustom04" class="form-label">No Surat Jalan</label>
                                <div class="input-group has-validation">
                                    <input name="no_sj" type="text" value="" class="form-control" id="validationCustom01" placeholder="Masukkan Nomor Container" required>
                                </div>
                            </div>                            
                            <div class="col-md-6">
                                <label for="validationCustom03" class="form-label">Upload File Surat Jalan</label>
                                <div class="mb-3">
                                    <input name="file" accept=".jpg, .png, .pdf" class="form-control file-upload-input" style="height: 48px; padding: 0.75rem 1.25rem;" type="file" id="formFile">
                                </div>
                            </div>                            
                            <div class="modal-footer justify-content-center">
                                <button id ="btn-modal-curah" type="submit" class="btn btn-primary">Tambah</button>
                                <button type="button" class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i>Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-grid gap-2 col-6 mx-auto">
            @foreach ($track as $tra)
                {{-- <input type="text" style="display: none;" name="id_ph" value="{{ $dt->id_penawaran }}"> --}}
                <form class="row g-3 needs-validation" action="{{ route('tracking.destroy', ['tracking' => $tra->id_track]) }}"  method="POST" enctype="multipart/form-data" novalidate>
                    @method('DELETE')
                    @csrf
                    @if (count($track->where('status', 1)) >= 1 && count($dtrack->where('status', 1 )) >= 1)
                        <input type="hidden" value="{{ $tra->total_all_sisa }}" name="qty_sisa_simpan">
                        <button class="btn btn-success mb-4" type="submit">Simpan Tracking Ini</button>
                    @else
                        <button disabled class="btn btn-success mb-4" type="submit">Simpan Tracking Ini</button>
                    @endif
                </form>
            @endforeach
        </div>                                 
        {{-- <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Tabel Tracking</h4>
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
                                            <th>QTY PO</th>
                                            <th>Rute</th>
                                            <th>Gudang Muat</th>
                                            <th>PT Kebun</th>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tbl_po as $tra)
                                        <tr>
                                            <td>{{ $tra->nama_customer }}</td>
                                            <td>{{ $tra->total_qty }}</td>
                                            <td>{{ $tra->nama_pol }} - {{ $tra->nama_pod }}</td>
                                            <td>{{ $tra->nama_gudang }}</td>
                                            <td>{{ $tra->nama_penerima }}</td>
                                            <td>{{ $tra->nama_barang }}</td>
                                            <td>{{ $tra->no_pl }}</td>
                                            <td>{{ $tra->po_muat }}</td>
                                            <td>{{ $tra->po_kebun }}</td>
                                            <td>{{ $tra->qty_muat }}</td>
                                            <td>{{ $tra->jml_bag }}</td>
                                            <td>{{ $tra->qty_timbang }}</td>
                                            <td>{{ $tra->nopol }}</td>
                                            <td>{{ $tra->no_container }}</td>
                                            <td>{{ $tra->kode_kapal }} {{ $tra->nama_kapal }} {{ $tra->voyage }}</td>
                                            <td>{{ $tra->tgl_muat }}</td>                                            
                                            <td>{{ $tra->td }}</td>
                                            <td>{{ $tra->td_jkt }}</td>
                                            <td>{{ $tra->eta }}</td>
                                            <td class="text-center">{!! $tra->status == 1 ? '<span class="shadow-none badge badge-success">Proses Muat</span>' : ($tra->status == 2 ? '<span class="shadow-none badge badge-warning">Selesai Muat</span>' : '') !!}</td>
                                        </tr>
                                        @endforeach                                                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
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
            var f2 = flatpickr(document.getElementById('td'), {
                defaultDate: new Date()
            });
            var f3 = flatpickr(document.getElementById('td_jkt'), {
                defaultDate: new Date()
            });
            var f4 = flatpickr(document.getElementById('eta'), {
                defaultDate: new Date()
            });
        </script>
        <script type='text/javascript'>
            $(document).ready(function() {
                // $('#btn-modal-curah').click(function(e){
                //     e.preventDefault();
                //     var qty_curah_input = $('#qty_curah').val();
                //     var qty_curah_total = $('#qty_curah_total').val();
                //     console.log(qty_curah_input);
                //     console.log(qty_curah_total);
                //     var sisa = qty_curah_total - qty_curah_input;
                //     console.log(parseFloat(sisa));
                //     parseFloat($('#qty_sisa_curah').val(sisa));
                //     $('form[name="modal-tracking-empty"]').submit();
                // });
                // $('#btn-modal-tracking-ada').click(function(e){
                //     e.preventDefault();
                //     var qty_curah_input2 = $('#qty_curah2').val();
                //     var qty_curah_total2 = $('#qty_curah_total2').val();
                //     if (qty_curah_input2 < qty_curah_total2) {
                //         var sisa = qty_curah_total2-qty_curah_input2;
                //         $('#qty_sisa2').val(sisa);
                //         $('#qty_sisa').val(sisa);
                //     }
                //     console.log(qty_curah_input2);
                //     console.log(qty_curah_total2);
                //     $('form[name="modal-tracking-ada"]').submit();
                // });                
                $('.qty_curah').on('input', function(){
                    var inputVal = parseFloat($(this).val()); // Get the value of the input field as a number
                    // var totalQtyCurah = parseFloat($(this).data('total-qty-curah'));
                    var totalQtyCurah = parseFloat($('#qty_curah_total').val()) || 0;
                    var $validationMessage = $(this).closest('.input-group').siblings('.validationMessage'); // Find the validation message div
        
                    if (isNaN(inputVal)) {
                        $validationMessage.text('Please enter a valid number');
                        $('#btn-modal-curah').attr('disabled', false);
                        parseFloat($('#qty_sisa_curah').val(totalQtyCurah - inputVal));
                    }else if (inputVal > totalQtyCurah) {
                        $validationMessage.text('Tonase lebih dari sisa muat');
                        $('#btn-modal-curah').attr('disabled', true);
                        parseFloat($('#qty_sisa_curah').val(totalQtyCurah - inputVal));
                    } else {
                        $validationMessage.text('');
                        $('#btn-modal-curah').attr('disabled', false);
                        parseFloat($('#qty_sisa_curah').val(totalQtyCurah - inputVal));
                    }
                });

                $('.qty_curah').on('click', function() {
                    $(this).val('');
                });


                $('.qty_cont').on('input', function(){
                    var inputVal = parseFloat($(this).val());
                    var totalQtyCont = parseFloat($('#qty_cont_total').val()) || 0;
                    var $validationMessage = $(this).closest('.input-group').siblings('.notAllowCont');
        
                    if (isNaN(inputVal)) {
                        $validationMessage.text('Please enter a valid number');
                        $('#btn-modal-cont').attr('disabled', false);                        
                        parseFloat($('#qty_sisa_cont').val(totalQtyCont - inputVal));                        
                    }else if (inputVal > totalQtyCont) {
                        $validationMessage.text('Tonase lebih dari sisa muat');
                        $('#btn-modal-cont').attr('disabled', true);                        
                        parseFloat($('#qty_sisa_cont').val(totalQtyCont - inputVal));                                                
                    } else {
                        $validationMessage.text('');
                        $('#btn-modal-cont').attr('disabled', false);                        
                        parseFloat($('#qty_sisa_cont').val(totalQtyCont - inputVal));                                                
                    }
                });

                $('.qty_cont').on('click', function() {
                    $(this).val('');
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
                                        for (var i=0; i<response.length; i++) {

                                            $('#po_kebun').val(response[i].po_kebun);
                                            $('#nm_kebun').val(response[i].nama_penerima);
                                            $('#no_pl').val(response[i].no_pl);
                                            $('#simb').val(response[i].simb);
                                            $('#est').val(response[i].estate);
                                            $('#brg').val(response[i].nama_barang);
                                        }
                                    }else{
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
                        text: 'QTY PO',
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
                        text: 'Gudang Muat',
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
                        text: 'Jenis Pupuk',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 5 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'NO. PL',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 6 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'SO/DO/SPK/CA',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 7 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'PO Kebun',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 8 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'QTY Muat',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 9 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'QTY Bag',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 10 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'QTY Timbang',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 11 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'Nopol',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 12 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'No Container',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 13 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'Nama Kapal',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 14 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'Tanggal Muat',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 15 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'TD',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 16 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'TD JKT',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 17 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'TA',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 18 );
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
        
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>    