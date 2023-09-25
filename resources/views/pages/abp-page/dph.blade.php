<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{asset('plugins/table/datatable/datatables.css')}}">
        {{-- @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
        @vite(['resources/scss/light/plugins/table/datatable/custom_dt_custom.scss']) --}}
        @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
        @vite(['resources/scss/dark/plugins/table/datatable/custom_dt_custom.scss'])
        @vite(['resources/scss/light/assets/components/timeline.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])
        @vite(['resources/scss/light/assets/components/modal.scss'])
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
                <li class="breadcrumb-item active" aria-current="page">Penawaran Harga</li>
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
                            <h4>Tabel Penawaran Harga</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area" disabled>
                    <table id="tbl_1" class="table tbl_1 dt-table-hover">
                        <thead>
                            <tr>
                                <th> Id </th>
                                <th>Nama Penanggung Jawab</th>
                                <th>Nama Perusahaan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($phtbl as $phs)
                            <tr>
                                <td>{{ $phs->id_penawaran }}</td>
                                <td>{{ $phs->nama_pic }}</td>
                                <td>{{ $phs->nama_customer }}</td>
                                <td class="text-center">{!! $phs->status == 2 ? '<span class="shadow-none badge badge-success">Approved</span>' : ($phs->status == 3 ? '<span class="shadow-none badge badge-warning">Not Approved</span>' : '') !!}</td>
                                <td class="text-center">
                                    <a href="{{ route('penawaran-harga.edit', ['id_penawaran' => $phs->id_penawaran]) }}" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                                    {!! $phs->status == 3 ? '<a href="'. route('penawaran-harga.approve', ['id_penawaran' => $phs->id_penawaran]) .'" id="approve-link" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve" data-original-title="Approve"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg></a>' : ($phs->status == 2 ? '':'') !!}
                                    <a href="{{route('penawaran-harga.generatepdf', ['id_penawaran' => $phs->id_penawaran])}}" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Print" data-original-title="Print"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer">
                                                        <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                                        <rect x="6" y="14" width="12" height="8"></rect>
                                                    </svg></a>    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>                    
                </div>
            </div>
        </div>        
        @if (count($ph->where('status', 1)) >= 1 && count($detailph->where('status', 1 )) >= 1)
        <div id="alertIcon" class="col-lg-12 mb-2">
            <div class="widget-content widget-content-area">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" data-bs-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                    <strong>Selesaikan penawaran harga ini terlebih dahulu!</strong> 
                </div>
            </div>
        </div>
        @else
        @endif    
        {{-- form penawaran harga --}}    
        <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Form Penawaran Harga</h4>
                        </div>
                    </div>
                </div>
                
                <div class="widget-content widget-content-area" disabled style="padding: 1.5%;">
                    <form class="row g-3 needs-validation" disabled action="{{ route('penawaran-harga.save') }}"  method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="col-md-6">
                            <label for="validationCustom01" class="form-label">Nama </label>
                            <input name="nama_pic" id="nama_cst" type="text" class="form-control" id="validationCustom03" placeholder="Masukkan nama" required>
                            <div class="invalid-feedback">
                                Form nama tidak boleh kosong
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationDefault04" class="form-label">Customer</label>
                            <select name="cst_id" class="form-select" id="validationDefault04" required>
                                <option selected disabled value="">Pilih...</option>
                                @foreach ($customer as $cst)
                                    <option value="{{ $cst->id }}">{{ $cst->nama_customer }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Pilih customer terlebih dahulu
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="validationCustom03" class="form-label">Alamat</label>
                            <input name="alamat_cst" id="alamat" type="text" class="form-control" id="validationCustom03" placeholder="Masukkan alamat" required>
                            <div class="invalid-feedback">
                                Form alamat tidak boleh kosong
                            </div>
                        </div>
                            <div class="col-md-12">
                                <label for="validationCustom03" class="form-label">Ketentuan</label>
                                <textarea name="kt" class="form-control" id="t_ktt" rows="10" required>
                                </textarea>
                                <div class="invalid-feedback">
                                    Form ketentuan tidak boleh kosong
                                </div>
                            </div>
                            @foreach ($detail as $dt)
                                <input type="text" style="display: none;" name="id_detail" value="{{ $dt->id_detail_ph }}">
                            @endforeach
                        <div class="col-12">
                            @if (count($ph->where('status', 1)) >= 1)
                                <button class="btn btn-primary" disabled type="submit">Selesaikan terlebih dahulu form penawaran harga</button>
                            @else
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            @endif
                        </div>
                    </form>                
                </div>
            </div>
        </div>
        {{-- table penawaran harga --}}
        <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Tabel Document Penawaran Harga</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="col-lg-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area">
                                <table id="style-3" class="table style-3 dt-table-hover">
                                    <thead>
                                        <tr>
                                            <th> Id </th>
                                            <th>Nama Penanggung Jawab</th>
                                            <th>Nama Perusahaan</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ph as $phs)
                                        <tr>
                                            <td>{{ $phs->id_penawaran }}</td>
                                            <td>{{ $phs->nama_pic }}</td>
                                            <td>{{ $phs->nama_customer }}</td>
                                            <td class="text-center"><span class="shadow-none badge badge-danger">{{ $phs->status == 1 ? 'Pending' : '' }}</span></td>
                                            <td class="text-center">
                                                <ul class="table-controls">
                                                    <li><a href="#editph-{{ $phs->id_penawaran }}" class="bs-tooltip" data-bs-toggle="modal" data-bs-placement="top" title="Edit" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-8 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a></li>
                                                    <li><a href="#hapusph-{{ $phs->id_penawaran }}" class="bs-tooltip" data-bs-toggle="modal" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a></li>
                                                </ul>
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

        {{-- form detail penawaran harga --}}
        <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Form Detail Penawaran Harga</h4>
                        </div>
                    </div>
                </div>
                
                <div class="widget-content widget-content-area" style="padding: 1.5%;">
                    <form class="row g-3 needs-validation" action="{{ route('penawaran-harga.store') }}"  method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="col-md-6">
                            <label for="validationDefault04" class="form-label">PT Penerima</label>
                            <select class="form-select" id="validationDefault01" required>
                                <option selected disabled value="">Pilih...</option>
                                
                                @foreach ($penerima as $pen)
                                    {{-- <input type="text" style="display: none;" name="id_detail" value="{{ $dt->id_detail_ph }}"> --}}
                                    <option>{{ $pen->id_pt_penerima }}--{{ $pen->nama_penerima }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Form PT Penerima tidak boleh kosong
                            </div>
                        </div>
                        @foreach ($detail as $dt)
                            <input type="text" style="display: none;" name="id_ph" value="{{ $dt->id_penawaran }}">
                        @endforeach
                        <div class="col-md-6">
                            <label for="validationCustom03" class="form-label">Estate</label>
                            <select name="id_pen-est" class="form-select" id="sel_emp" required>
                                <option disabled selected value="">Pilih...</option>
                            </select>
                            <div class="invalid-feedback">
                                Form estate tidak boleh kosong
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom01" class="form-label">OA Kapal Kayu </label>
                            <input name="oa_kk" type="number" value="0" class="form-control" id="validationCustom01" placeholder="Masukkan harga" required>
                            <div class="invalid-feedback">
                                Form harga tidak boleh kosong
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom01" class="form-label">OA Container </label>
                            <input name="oa_cont" type="number" value="0" class="form-control" id="validationCustom01" placeholder="Masukkan harga" required>
                            <div class="invalid-feedback">
                                Form harga tidak boleh kosong
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> 
        {{-- table detail penawaran harga --}}
        <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Tabel Detail Penawaran Harga</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="col-lg-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area">
                                <table id="tbl_3" class="table tbl_3 dt-table-hover">
                                    <thead>
                                        <tr>
                                            <th>Estate</th>
                                            <th>OA Kapal Kayu</th>
                                            <th>OA Container</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detailph as $dtl)
                                        <tr>
                                            <td>{{ $dtl->estate }}</td>
                                            <td>{{ $dtl->oa_kpl_kayu }}</td>
                                            <td>{{ $dtl->oa_container }}</td>
                                            <td class="text-center"><span class="shadow-none badge badge-danger">{{ $dtl->status == 1 ? 'Pending' : '' }}</span></td>
                                            <td class="text-center">
                                                <a href="#editphd-{{ $dtl->id_detail_ph }}" class="bs-tooltip" data-bs-toggle="modal" data-bs-placement="top" title="Edit" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-8 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                                                <a href="#hapusphd-{{ $dtl->id_detail_ph }}" class="bs-tooltip" data-bs-toggle="modal" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                                                
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
        {{-- simpan penawaran-harga --}}
        <div class="d-grid gap-2 col-6 mx-auto">
            @foreach ($detail as $dt)
                {{-- <input type="text" style="display: none;" name="id_ph" value="{{ $dt->id_penawaran }}"> --}}
                <form class="row g-3 needs-validation" action="{{ route('penawaran-harga.destroy', ['penawaran_harga' => $dt->id_penawaran]) }}"  method="POST" enctype="multipart/form-data" novalidate>
                    @method('DELETE')
                    @csrf
                    @if (count($ph->where('status', 1)) >= 1 && count($detailph->where('status', 1 )) >= 1)
                        <button class="btn btn-success mb-4" type="submit">Simpan Penawaran Harga</button>
                    @else
                        <button disabled class="btn btn-success mb-4" type="submit">Simpan Penawaran Harga</button>
                    @endif
                </form>
            @endforeach
        </div>
        {{-- modal edit & hapus --}}
        @foreach ($ph as $phs)
        <div class="modal fade bd-example-modal-xl" id="editph-{{ $phs->id_penawaran }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit penawaran harga</h5>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" action="{{ route('penawaran-harga.updateph', ['id_penawaran' => $phs->id_penawaran]) }}"  method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            <div class="col-md-6">
                                <label for="validationCustom01" class="form-label">Nama </label>
                                <input name="nama_pic" value="{{ $phs->nama_pic }}" id="nama_cst" type="text" class="form-control" id="validationCustom03" placeholder="Masukkan nama" required>
                                <div class="invalid-feedback">
                                    Form nama tidak boleh kosong
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="validationDefault04" class="form-label">Customer</label>
                                <select name="cst_id" class="form-select" id="cbe_cst" required>
                                    <option selected disabled value="">Pilih...</option>
                                    @foreach ($customer as $cst)
                                        <option {{ $cst->id == $phs->id ? 'selected' : '' }} value="{{ $cst->id }}">{{ $cst->nama_customer }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Pilih customer terlebih dahulu
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="validationCustom03" class="form-label">Alamat</label>
                                <input name="alamat_cst" value="{{ $phs->alamat }}" id="e_alamat" type="text" class="form-control" id="validationCustom03" placeholder="Masukkan alamat" required>
                                <div class="invalid-feedback">
                                    Form alamat tidak boleh kosong
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="validationCustom03" class="form-label">Ketentuan</label>
                                <textarea name="kt" class="form-control" id="t_ktt" rows="10" required>{{ $phs->ketentuan }}</textarea>
                                <div class="invalid-feedback">
                                    Form ketentuan tidak boleh kosong
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Update</button>
                                <button type="button" class="btn btn btn-light-dark close" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i>Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-l" id="hapusph-{{ $phs->id_penawaran }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-l modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h5>Apakah anda yakin ingin hapus data ini?</h5>
                        <form class="row g-3 needs-validation" action="{{ route('penawaran-harga.removedph', ['id_penawaran' => $phs->id_penawaran]) }}"  method="POST">
                            @method('DELETE')
                            @csrf
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-primary">Iya hapus data ini!</button>
                                <button type="button" class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i>Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @foreach ($detailph as $phd)
        <div class="modal fade bd-example-modal-xl" id="editphd-{{ $phd->id_detail_ph }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit detail penawaran harga</h5>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" action="{{ route('penawaran-harga.updatephd', ['id_detail_ph' => $phd->id_detail_ph]) }}"  method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            <div class="col-md-6">
                                <label for="validationDefault04" class="form-label">PT Penerima</label>
                                <select disabled class="form-select" id="cbe_pt" required>
                                    <option selected disabled value="">Pilih...</option>
                                    
                                    @foreach ($penerima as $pen)
                                        {{-- <input type="text" style="display: none;" name="id_detail" value="{{ $dt->id_detail_ph }}"> --}}
                                        <option {{ $pen->id_pt_penerima == $phd->id_pt_penerima ? 'selected' : '' }}>{{ $pen->id_pt_penerima }}--{{ $pen->nama_penerima }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Form PT Penerima tidak boleh kosong
                                </div>
                            </div>
                            @foreach ($detail as $dt)
                                <input type="text" style="display: none;" name="id_ph" value="{{ $dt->id_penawaran }}">
                            @endforeach
                            <div class="col-md-6">
                                <label for="validationCustom03" class="form-label">Estate</label>
                                <select disabled name="id_pen" class="form-select" id="cbe_est" required>
                                    <option disabled value="">Pilih...</option>
                                    @foreach ($estate as $est)
                                        <option disabled {{ $est->id_pt_penerima == $phd->id_pt_penerima ? 'selected' : '' }} value="{{ $est->id_penerima }}">{{ $est->estate }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Form estate tidak boleh kosong
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="validationCustom01" class="form-label">OA Kapal Kayu </label>
                                <input name="oa_kk" type="number" value="{{ $phd->oa_kpl_kayu }}" class="form-control" id="validationCustom01" placeholder="Masukkan harga" required>
                                <div class="invalid-feedback">
                                    Form harga tidak boleh kosong
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="validationCustom01" class="form-label">OA Container </label>
                                <input name="oa_cont" type="number" value="{{ $phd->oa_container }}" class="form-control" id="validationCustom01" placeholder="Masukkan harga" required>
                                <div class="invalid-feedback">
                                    Form harga tidak boleh kosong
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Update</button>
                                <button type="button" class="btn btn btn-light-dark close" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i>Batal</button>
                            </div>                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-l" id="hapusphd-{{ $phd->id_detail_ph }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-l modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h5>Apakah anda yakin ingin hapus data ini?</h5>
                        <form class="row g-3 needs-validation" action="{{ route('penawaran-harga.removedphd', ['id_detail_ph' => $phd->id_detail_ph]) }}"  method="POST">
                            @method('DELETE')
                            @csrf
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-primary">Iya hapus data ini!</button>
                                <button type="button" class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i>Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>            

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        @vite(['resources/assets/js/forms/bootstrap_validation/bs_validation_script.js'])
        <script type="module" src="{{asset('plugins/global/vendors.min.js')}}"></script>
        @vite(['resources/assets/js/custom.js'])
        <script type="module" src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        
        <script type='text/javascript'>
            $(document).ready(function() {
                function ketentuanVal() {
                    var val = "1. Harga di atas Sudah termasuk biaya perset B/L\n" +
                            "2. Harga di atas Belum termasuk asuransi\n" +
                            "3. Harga di atas Belum termasuk PPN 11%\n" +
                            "4. Harga di atas Non Negotiable\n" +
                            "5. Barang yang sudah tiba harus sudah di bongkar sebelum masa free time demorage berakhir, segala biaya yang timbul akibat kelalaian yang sengaja atau tidak sengaja adalah tanggung jawab shipper\n" +
                            "6. Harga di atas adalah termasuk biaya bongkar barang dengan tenaga buruh\n" +
                            "7. Pembayaran : Uang muka 50% setelah selesai muat  dan Pelunasan 50% 30 hari setelah terima BAP\n" +
                            "8. Untuk tujuan Pontianak, apabila terjadi force majure, di mana akan membutuhkan gudang, akan muncul tambahan biaya sebesar 100.000/ton (Sewa gudang, Handling, trucking)";
                    $('#t_ktt').val(val);
                }
                function btnBatal(){
                    $(".modal").click(function(event) {
                        if (event.target === this) {
                            $(this).hide();
                            window.location.reload();
                        }
                    });
                    $(".close").click(function(event) {
                            if (event.target === this) {
                                $(this).hide();
                                window.location.reload();
                            }
                    });
                }
                $('#validationDefault04').change(function() {
                    var selectedId = $(this).val();

                    if (selectedId !== '') {
                        $.ajax({
                            url: "{{ route('getDetails', ['id' => ':id']) }}".replace(':id', selectedId),
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                if (response.length > 0) {
                                    var data = response[0];
                                    $('#alamat').val(data.alamat);
                                }
                            },
                            error: function() {
                                console.log(response);
                            }
                        });
                    } else {
                        $('#alamat').val('');
                    }
                });
                $('#validationDefault01').change(function() {
                    var selectedId = $(this).val();
                    // $('#sel_emp').find('option').not(':first').remove();
                    if (selectedId !== '') {
                        $.ajax({
                            url: "{{ route('getPenDetails', ['id' => ':id']) }}".replace(':id', selectedId),
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                var data = response[0];
                                $("#sel_emp").empty();
                                if (response.length > 0) {
                                    for (var i=0; i<response.length; i++) {
                                        var option = "<option value='"+response[i].id_penerima+"' required>"+response[i].estate+"</option>";
                                        $("#sel_emp").append(option); 
                                    }
                                }else{
                                    var option = "<option required value='"+response[i].id_penerima+"'>"+response[i].estate+"</option>";
                                        $("#sel_emp").append(option); 
                                }
                            },
                            error: function() {
                                console.log(response);
                            }
                        });
                    } else {
                        // var option = "<option required value='"+0+"'>"+Pilih...+"</option>";
                        // $("#sel_emp").append(option); 
                    }
                });
                $('#cbe_cst').change(function() {
                    var selectedId = $(this).val();

                    if (selectedId !== '') {
                        $.ajax({
                            url: "{{ route('getDetails', ['id' => ':id']) }}".replace(':id', selectedId),
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                if (response.length > 0) {
                                    var data = response[0];
                                    $('#e_alamat').val(data.alamat);
                                }
                            },
                            error: function() {
                                console.log(response);
                            }
                        });
                    } else {
                        $('#e_alamat').val('');
                    }
                });                
                $('#cbe_pt').change(function() {
                    var selectedId = $(this).val();
                    // $('#sel_emp').find('option').not(':first').remove();
                    if (selectedId !== '') {
                        $.ajax({
                            url: "{{ route('getPenDetails', ['id' => ':id']) }}".replace(':id', selectedId),
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                var data = response[0];
                                $("#cbe_est").empty();
                                if (response.length > 0) {
                                    for (var i=0; i<response.length; i++) {
                                        var option = "<option value='"+response[i].id_penerima+"' required>"+response[i].estate+"</option>";
                                        $("#cbe_est").append(option); 
                                    }
                                }else{
                                    var option = "<option required value='"+response[i].id_penerima+"'>"+response[i].estate+"</option>";
                                        $("#cbe_est").append(option); 
                                }
                            },
                            error: function() {
                                console.log(response);
                            }
                        });
                    } else {
                        // var option = "<option required value='"+0+"'>"+Pilih...+"</option>";
                        // $("#sel_emp").append(option); 
                    }
                });                
                $('#approve-link').click(function() {

                    // Get the link's href attribute
                    var href = $(this).attr('href');

                    // Send a POST request to the href using AJAX
                    $.ajax({
                        type: 'POST',
                        url: href,
                        data: {
                            "_token": "{{ csrf_token() }}", // Include the CSRF token
                        },
                        success: function(response) {
                            // Handle the success response as needed
                            // For example, you can refresh the page or update UI elements
                            location.reload(); // Reload the page after approval
                        },
                        error: function(error) {
                            // Handle errors if any
                            console.error(error);
                        }
                    });
                });
                ketentuanVal();
                btnBatal()
            });
        </script>

    <script type="module">
        // var e;
        const c1 = $('#style-1').DataTable({
            headerCallback:function(e, a, t, n, s) {
                e.getElementsByTagName("th")[0].innerHTML=`
                <div class="form-check form-check-primary d-block">
                    <input class="form-check-input chk-parent" type="checkbox" id="form-check-default">
                </div>`
            },
            columnDefs:[{
                targets:0, width:"30px", className:"", orderable:!1, render:function(e, a, t, n) {
                    return `
                    <div class="form-check form-check-primary d-block">
                        <input class="form-check-input child-chk" type="checkbox" id="form-check-default">
                    </div>`
                }
            }],
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
            },
            "lengthMenu": [5, 10, 20, 50],
            "pageLength": 10
        });

        multiCheck(c1);

        const c2 = $('#style-2').DataTable({
            headerCallback:function(e, a, t, n, s) {
                e.getElementsByTagName("th")[0].innerHTML=`
                <div class="form-check form-check-primary d-block new-control">
                    <input class="form-check-input chk-parent" type="checkbox" id="form-check-default">
                </div>`
            },
            columnDefs:[ {
                targets:0, width:"30px", className:"", orderable:!1, render:function(e, a, t, n) {
                    return `
                    <div class="form-check form-check-primary d-block new-control">
                        <input class="form-check-input child-chk" type="checkbox" id="form-check-default">
                    </div>`
                }
            }],
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
            },
            "lengthMenu": [5, 10, 20, 50],
            "pageLength": 10 
        });

        multiCheck(c2);

        const c3 = $('#style-3').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [5, 10, 20, 50],
            "pageLength": 10
        });

        multiCheck(c3);
    </script>
    <script type="module">
        $(document).ready(function () {
            const f1 = $('#tbl_3').DataTable({
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                "oLanguage": {
                    "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
                },
                "stripeClasses": [],
                "lengthMenu": [5, 10, 20, 50],
                "pageLength": 10
            });
        });
    </script>
    <script type="module">
        $(document).ready(function () {
            $('#tbl_1').DataTable({
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                "oLanguage": {
                    "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
                },
                "stripeClasses": [],
                "lengthMenu": [5, 10, 20, 50],
                "pageLength": 10
            });
        });
    </script>    
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>    