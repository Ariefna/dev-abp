<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
        </x-slot>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <x-slot:headerFiles>
            <!--  BEGIN CUSTOM STYLE FILE  -->
            <link rel="stylesheet" href="{{asset('plugins/table/datatable/datatables.css')}}">
            @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
            @vite(['resources/scss/light/plugins/table/datatable/custom_dt_custom.scss'])
            @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
            @vite(['resources/scss/dark/plugins/table/datatable/custom_dt_custom.scss'])
            @vite(['resources/scss/light/assets/components/timeline.scss'])
            @vite(['resources/scss/light/assets/components/modal.scss'])
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

                <!-- Modal Tambah Data -->
                <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahModalLabel">Tambah Data Menu Halaman</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('menuuser.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{$role}}" name="akses_group_id">
                                    <div class="form-group">
                                        <label for="nama_menu_halaman">Nama Menu Halaman</label>
                                        <select class="form-control" id="nama_menu_halaman" name="nama_menu_halaman" required>
                                            @foreach($mastermenu as $menu)
                                            <option value="{{ $menu->id }}">{{ $menu->nama_menu_halaman }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i>Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>

                <!-- BREADCRUMB -->
                <div class="page-meta">
                    <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">User Role</li>
                            <li class="breadcrumb-item active" aria-current="page">Data Menu User</li>
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
                                        <h4>Form Data Hak Akses</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area" style="padding: 2%;">
                                <form class="row g-3 needs-validation" action="{{ route('menuuser.index') }}" method="GET" enctype="multipart/form-data" novalidate>
                                    <div class="col-md-12">
                                        <label for="nama_menu_halaman" class="form-label">Nama Role</label>
                                        <select name="role" class="form-select" id="role" required>
                                            <option value="0" @if ($role==="0" ) selected @endif>Superadmin</option>
                                            @foreach ($aksesgroup as $itemaksesgroup)
                                            <option value="{{ $itemaksesgroup->akses_group_id }}" @if ($role==$itemaksesgroup->akses_group_id) selected @endif>
                                                {{ $itemaksesgroup->nama }}
                                            </option>
                                            @endforeach
                                        </select>

                                        <div class="invalid-feedback">
                                            Form nama role tidak boleh kosong
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="submit">Cari</button>
                                        <a href="#tambahModal" class="btn btn-primary" data-bs-toggle="modal" data-bs-placement="top" title="Tambah Akses Halaman">Tambah Akses Halaman</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header justify-content-center">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <div class="d-flex justify-content-between mb-2">
                                            <h4>Tabel Data Menu Halaman</h4>
                                            {{-- <a href="#tambahModal" class="btn btn-primary" data-bs-toggle="modal" data-bs-placement="top" title="Tambah Akses Halaman">Tambah Akses Halaman</a> --}}
                                        </div>
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
                                                        <th>Nama Halaman</th>
                                                        @if ($role !== "0")
                                                        <th class="text-center dt-no-sorting">Action</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($menuuser as $mnuser)
                                                    <tr>
                                                        <td>{{ $mnuser->id }}</td>
                                                        <td>{{ $mnuser->nama_menu_halaman }}</td>
                                                        @if ($role !== "0")
                                                        <td class="text-center">
                                                            <ul class="table-controls">
                                                                @if(in_array('userrole-menu-user-UPDATE', Session::get('nama_action')) || Session::get('role') == 'superadmin')
                                                                <li><a href="#exampleModal-{{ $mnuser->id }}" class="bs-tooltip" data-bs-toggle="modal" data-bs-placement="top" title="Edit" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-8 mb-1">
                                                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                        </svg></a></li>
                                                                @endif
                                                                @if(in_array('userrole-menu-user-DELETE', Session::get('nama_action')) || Session::get('role') == 'superadmin')
                                                                <li><a href="#exampleModalhps-{{ $mnuser->id }}" class="bs-tooltip" data-bs-toggle="modal" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1">
                                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                        </svg></a></li>
                                                                @endif
                                                            </ul>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @foreach ($menuuser as $mnuser)
                                            <div class="modal fade bd-example-modal-xl" id="exampleModal-{{ $mnuser->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit data Menu</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="row g-3 needs-validation" action="{{ route('menuuser.update', ['menuuser' => $mnuser->id]) }}" method="POST" enctype="multipart/form-data" novalidate>
                                                                @csrf
                                                                <input type="hidden" value="{{$role}}" name="akses_group_id">
                                                                <input type="hidden" value="{{$mnuser->id}}" name="menu_halaman_id">
                                                                
                                                                @method('PUT')
                                                                <div class="col-md-12">
                                                                    <label for="nama_menu" class="form-label">Nama Menu</label>
                                                                    <input value="{{ $mnuser->nama_menu_halaman }}" readonly='true' name="nama_menu_halaman" type="text" class="form-control" id="nama_menu_halaman" placeholder="Masukkan nama menu" required>
                                                                    <div class="invalid-feedback">
                                                                        Form nama menu tidak boleh kosong
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label class="form-label">Aksi Menu</label>
                                                                    @foreach($actions as $action)
                                                                    @if($action->menu_halaman_id == $mnuser->id)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="id_action[]" value="{{ $action->id }}" {{ $role === "0" || $action->akses ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="nama_action_{{ $action->id }}">
                                                                            {{ $action->nama_action }}
                                                                        </label>
                                                                    </div>
                                                                    @endif
                                                                    @endforeach
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i>Batal</button>
                                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade bd-example-modal-l" id="exampleModalhps-{{ $mnuser->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-l modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <h5>Apakah anda yakin ingin hapus data ini?</h5>
                                                            <form class="row g-3 needs-validation" action="{{ route('menuuser.destroy', ['menuuser' => $mnuser->id]) }}" method="POST">
                                                                <input type="hidden" value="{{$role}}" name="akses_group_id">
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
                    <script src="{{asset('plugins/sweetalerts2/sweetalerts2.min.js')}}"></script>
                    @vite(['resources/assets/js/forms/bootstrap_validation/bs_validation_script.js'])
                    <script type="module" src="{{asset('plugins/global/vendors.min.js')}}"></script>
                    @vite(['resources/assets/js/custom.js'])
                    <script type="module" src="{{asset('plugins/table/datatable/datatables.js')}}"></script>

                    <script type="module">
                        // var e;
                        const c1 = $('#style-1').DataTable({
                            headerCallback: function(e, a, t, n, s) {
                                e.getElementsByTagName("th")[0].innerHTML = `
                    <div class="form-check form-check-primary d-block">
                        <input class="form-check-input chk-parent" type="checkbox" id="form-check-default">
                    </div>`
                            },
                            columnDefs: [{
                                targets: 0,
                                width: "30px",
                                className: "",
                                orderable: !1,
                                render: function(e, a, t, n) {
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
                                "oPaginate": {
                                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                                },
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
                            headerCallback: function(e, a, t, n, s) {
                                e.getElementsByTagName("th")[0].innerHTML = `
                    <div class="form-check form-check-primary d-block new-control">
                        <input class="form-check-input chk-parent" type="checkbox" id="form-check-default">
                    </div>`
                            },
                            columnDefs: [{
                                targets: 0,
                                width: "30px",
                                className: "",
                                orderable: !1,
                                render: function(e, a, t, n) {
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
                                "oPaginate": {
                                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                                },
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
                                "oPaginate": {
                                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                                },
                                "sInfo": "Showing page _PAGE_ of _PAGES_",
                                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                                "sSearchPlaceholder": "Cari...",
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