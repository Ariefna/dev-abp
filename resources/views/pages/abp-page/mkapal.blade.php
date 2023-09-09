<x-base-layout :scrollspy="true">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{asset('plugins/table/datatable/datatables.css')}}">
        {{-- <link rel="stylesheet" type="text/css" href="{{asset('plugins/tomSelect/tom-select.default.min.css')}}">
        @vite(['resources/scss/dark/plugins/tomSelect/custom-tomSelect.scss']) --}}
        @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
        @vite(['resources/scss/light/plugins/table/datatable/custom_dt_custom.scss'])
        @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
        @vite(['resources/scss/dark/plugins/table/datatable/custom_dt_custom.scss'])
        @vite(['resources/scss/light/assets/components/timeline.scss'])
        @vite(['resources/scss/light/assets/components/modal.scss'])
        @vite(['resources/scss/dark/assets/components/modal.scss'])

        
        <!--  END CUSTOM STYLE FILE  -->
        
        {{-- <style>
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
        </style> --}}
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-slot:scrollspyConfig>
        data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
    </x-slot>
    <div class="overlay"></div>
    <div class="cs-overlay"></div>
    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Master</li>
                <li class="breadcrumb-item active" aria-current="page">Data Kapal</li>
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
                            <h4>Form Data Kapal</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area" style="padding: 1.5%;">
                    <form class="row g-3 needs-validation" action="{{ route('kapal.store') }}"  method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="col-md-4">
                            <label for="validationDefault04" class="form-label">PT Pelayaran</label>                            
                            <select name="cport_kpl" class="form-select" id="validationDefault04" name="validationDefault04" required>
                                <option selected disabled value="">Pilih...</option>
                                @foreach ($compport as $cp)
                                    <option value="{{ $cp->id_company_port }}">{{ $cp->nama }}</option>
                                @endforeach
                            </select>
                            <a href="#exampleModalcp" class="btn btn-warning mb-2 mt-2" class="bs-tooltip" data-bs-toggle="modal" data-bs-placement="top" title="Tambah" data-original-title="Tambah"> Tambah Data PT Pelayaran</a>
                        </div>
                        <div class="col-md-2">
                            <label for="validationCustom04" class="form-label">No. Telepon</label>
                            <div class="input-group has-validation">
                                <input readonly name="no_telp" id="no_telpon" type="number" class="form-control" placeholder="Masukkan no telepon" required>
                                <div class="invalid-feedback">
                                    Form no telepon tidak boleh kosong
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="validationDefault04" class="form-label">Kode Kapal</label>
                            <select name="kode_kpl" class="form-select" required>
                                <option selected disabled value="">Pilih...</option>
                                <option value="KLM">KLM</option>
                                <option value="KM">KM</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom04" class="form-label">Nama Kapal</label>
                            <div class="input-group has-validation">
                                <input name="nama_kpl" id="nama" type="text" class="form-control" id="validationCustom04" placeholder="Masukkan nama kapal" required>
                                <div class="invalid-feedback">
                                    Form nama kapal tidak boleh kosong
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="validationCustom03" class="form-label">Alamat</label>
                            <input readonly name="alamat_kpl" id="alamat" type="text" class="form-control" id="validationCustom03" placeholder="Masukkan alamat" required>
                            <div class="invalid-feedback">
                                Form alamat tidak boleh kosong
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Simpan Data Kapal</button>
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
                            <h4>Tabel Master Data Kapal</h4>
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
                                            <th>PT Pelayaran</th>
                                            <th>Kode Kapal</th>
                                            <th>Nama Kapal</th>
                                            <th class="text-center dt-no-sorting">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kapal as $kpl)
                                        <tr>
                                            <td>{{ $kpl->id }}</td>
                                            <td>{{ $kpl->nama }}</td>
                                            <td>{{ $kpl->kode_kapal }}</td>
                                            <td>{{ $kpl->nama_kapal }}</td>
                                            <td class="text-center">
                                                <ul class="table-controls">
                                                    <li><a href="javascript:void(0);" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="View"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye p-1 br-8 mb-1"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a></li>
                                                    <li><a href="#exampleModal-{{ $kpl->id }}" id="edit_modal-{{ $kpl->id }}" class="bs-tooltip"  data-bs-toggle="modal" data-bs-placement="top" title="Edit" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-8 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a></li>
                                                    <li><a href="#exampleModalhps-{{ $kpl->id }}" class="bs-tooltip" data-bs-toggle="modal" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="modal fade bd-example-modal-xl" id="exampleModalcp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Tambah data PT Pelayaran</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form class="row g-3 needs-validation" action="{{ route('company_port.store') }}"  method="POST" enctype="multipart/form-data" novalidate>
                                                    @csrf
                                                    <div class="col-md-3">
                                                        <label for="validationDefault03" class="form-label">Nama PT Pelayaran</label>                            
                                                        <input name="nama" id="t_notelp" type="text" class="form-control" placeholder="Masukkan nama PT Pelayaran" required>
                                                        <div class="invalid-feedback">
                                                            Form nama tidak boleh kosong
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="validationDefault03" class="form-label">No. Telepon</label>
                                                        <div class="input-group has-validation">
                                                            <input name="no_telp" id="t_notelp" type="number" class="form-control" placeholder="Masukkan no telepon" required>
                                                            <div class="invalid-feedback">
                                                                Form no telepon tidak boleh kosong
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="validationCustom03" class="form-label">Alamat</label>
                                                        <input name="alamat" id="t_alamat" type="text" class="form-control" id="validationCustom03" placeholder="Masukkan alamat" required>
                                                        <div class="invalid-feedback">
                                                            Form alamat tidak boleh kosong
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                                        <button type="button" id="btn_batal_e-{{ $kpl->id }}" class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i>Batal</button>
                                                    </div>
                                                </form>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @foreach ($kapal as $kpl)
                                <div class="modal fade bd-example-modal-xl" id="exampleModal-{{ $kpl->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit data kapal</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form class="row g-3 needs-validation" action="{{ route('kapal.update', ['kapal' => $kpl->id]) }}"  method="POST" enctype="multipart/form-data" novalidate>
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="col-md-3">
                                                        <label for="validationDefault03" class="form-label">PT Pelayaran</label>                            
                                                        <select name="cport_kpl" class="form-select" id="validationDefault03-{{ $kpl->id }}" name="validationDefault03" required>
                                                            {{-- <option disabled value="">Pilih...</option> --}}
                                                            @foreach ($compport as $cp)
                                                                <option {{ $cp->id_company_port == $kpl->id_company_port ? 'selected' : '' }} value="{{ $cp->id_company_port }}">{{ $cp->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="validationDefault03" class="form-label">No. Telepon</label>
                                                        <div class="input-group has-validation">
                                                            <input readonly name="no_telp" id="e_no_telpon-{{ $kpl->id }}" type="number" class="form-control" placeholder="Masukkan no telepon" value="{{ $kpl->no_telp }}" required>
                                                            <div class="invalid-feedback">
                                                                Form no telepon tidak boleh kosong
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="validationDefault04" class="form-label">Kode Kapal</label>
                                                        <select name="kode_kpl" class="form-select" required>
                                                            {{-- <option disabled value="">Pilih...</option> --}}
                                                            <option value="KLM" {{ $kpl->kode_kapal == 'KLM' ? 'selected' : ''}}>KLM</option>
                                                            <option value="KM" {{ $kpl->kode_kapal == 'KM' ? 'selected' : ''}}>KM</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="validationCustom04" class="form-label">Nama Kapal</label>
                                                        <div class="input-group has-validation">
                                                            <input value="{{ $kpl->nama_kapal }}" name="nama_kpl" id="nama" type="text" class="form-control" id="validationCustom04" placeholder="Masukkan nama kapal" required>
                                                            <div class="invalid-feedback">
                                                                Form nama kapal tidak boleh kosong
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="validationCustom03" class="form-label">Alamat</label>
                                                        <input readonly value="{{ $kpl->alamat }}" name="alamat_kpl" id="e_alamat-{{ $kpl->id }}" type="text" class="form-control" id="validationCustom03" placeholder="Masukkan alamat" required>
                                                        <div class="invalid-feedback">
                                                            Form alamat tidak boleh kosong
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                                        <button type="button" id="btn_batal_e-{{ $kpl->id }}" class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i>Batal</button>
                                                    </div>
                                                </form>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade bd-example-modal-l" id="exampleModalhps-{{ $kpl->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-l modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <h5>Apakah anda yakin ingin hapus data ini?</h5>
                                                <form class="row g-3 needs-validation" action="{{ route('kapal.destroy', ['kapal' => $kpl->id]) }}"  method="POST">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>            

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        @vite(['resources/assets/js/forms/bootstrap_validation/bs_validation_script.js'])
        <script type="module" src="{{asset('plugins/global/vendors.min.js')}}"></script>
        @vite(['resources/assets/js/custom.js'])
        <script type="module" src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        {{-- <script src="{{asset('plugins/tomSelect/tom-select.base.js')}}"></script>
        <script src="{{asset('plugins/tomSelect/custom-tom-select.js')}}"></script>
        <script src="{{asset('plugins/input-mask/jquery.inputmask.bundle.min.js')}}"></script>
        <script src="{{asset('plugins/input-mask/input-mask.js')}}"></script> --}}
        
        <script type='text/javascript'>
            $(document).ready(function() {
                // var originalData = {};
                $('#validationDefault04').change(function() {
                    var selectedId = $(this).val();

                    if (selectedId !== '') {
                        $.ajax({
                            url: "{{ route('getKapalDetails', ['id' => ':id']) }}".replace(':id', selectedId),
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                if (response.length >= 0) {
                                    var data = response[0];
                                    console.log(data);
                                    $('#alamat').val(data.alamat);
                                    $('#no_telpon').val(data.no_telp);
                                    if (data.hasOwnProperty('alamat')) {
                                        $('#alamat').val(data.alamat);
                                    }
                                    if (data.hasOwnProperty('no_telpon')) {
                                        $('#no_telpon').val(data.no_telpon);
                                    }
                                    
                                }
                            },
                            error: function() {
                                // Handle error if needed
                            }
                        });
                    } else {
                        // Clear input fields when no option is selected
                        $('#alamat').val('');
                        $('#no_telpon').val('');
                    }
                });
                @foreach($kapal as $kpl)
                    $('#edit_modal-{{ $kpl->id }}').click(function() {
                        $('#validationDefault03-{{ $kpl->id }}').change(function() {
                            var selectedId = $(this).val();

                            if (selectedId !== '') {
                                $.ajax({
                                    url: "{{ route('getEditDetails', ['id' => ':id']) }}".replace(':id', selectedId),
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(response) {
                                        console.log(response);
                                        if (response.length >= 0) {
                                            var data = response[0];
                                            console.log(data);
                                            $('#e_alamat-{{ $kpl->id }}').val(data.alamat || '');
                                            $('#e_no_telpon-{{ $kpl->id }}').val(data.no_telp);
                                        }
                                        // window.location.reload();
                                    },
                                    error: function() {
                                        alert('error');
                                    }
                                });
                            } else {
                                // Clear input fields when no option is selected
                                $('#e_alamat').val('');
                                $('#e_no_telpon').val('');
                            }
                        });                        
                    });
                    $(".modal").click(function(event) {
                        if (event.target === this) {
                            $(this).hide();
                            window.location.reload();
                        }
                    });
                    $("#btn_batal_e-{{ $kpl->id }}").click(function(event) {
                        if (event.target === this) {
                            $(this).hide();
                            window.location.reload();
                        }
                    });
                @endforeach
            });
            feather.replace();
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
                "pageLength": 10,
                "responsive": true
            });
    
            multiCheck(c3);
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>    