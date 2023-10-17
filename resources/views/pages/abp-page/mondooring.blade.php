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
                <li class="breadcrumb-item">Monitoring</li>
                <li class="breadcrumb-item active" aria-current="page">Dooring</li>
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
                            <h4>Update Tabel Monitoring</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area" style="padding: 1.5%;">
                    {{-- @foreach ($limitedCollection as $getpo) --}}
                    <form class="row g-3 needs-validation" action="{{ route('mon-dooring.update') }}" method="POST" enctype="multipart/form-data" novalidate>
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
                                <input name="file" accept=".jpg, .png, .pdf" class="form-control file-upload-input" style="height: 48px; padding: 0.75rem 1.25rem;" type="file" id="formFile">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustom03" class="form-label">Upload File Rekap Kebun</label>
                            <div class="mb-3">
                                <input name="file2" accept=".jpg, .png, .pdf" class="form-control file-upload-input" style="height: 48px; padding: 0.75rem 1.25rem;" type="file" id="formFile">
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
                                            <th>Susut</th>
                                            <th>Nama Kapal</th>
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
                                                        $countDetailTrackingMultiple = count($md->docDooring->docTracking->detailTrackingMultiple);

                                                        $namaKapal = '';
                                                    @endphp

                                                    @if ($countDetailTrackingMultiple > 0)
                                                        @for ($i=0; $i<$countDetailTrackingMultiple; $i++)
                                                            @if ($md->docDooring->docTracking->detailTrackingMultiple[$i]->id_kapal == $idKapal)
                                                                @php
                                                                    $namaKapal = $md->docDooring->docTracking->detailTrackingMultiple[$i]->kapal->nama_kapal;
                                                                @endphp

                                                                @if ($md->tipe == 'Container')
                                                                    @php
                                                                    $noContainer = $md->docDooring->docTracking->detailTrackingMultiple[$i]->no_container;
                                                                    @endphp
                                                                @endif
                                                            @endif
                                                        @endfor
                                                    @endif
                                                    <tr>
                                                        <td>{{ $md->docDooring->docTracking->po->detailPhs->penawaran->customer->nama_customer ?? '' }}</td>
                                                        <td>{{ $md->docDooring->docTracking->no_po ?? '' }}</td>
                                                        <td>{{ $md->docDooring->docTracking->portOfLoading->nama_pol ?? '' }} - {{ $md->docDooring->docTracking->portOfDestination->nama_pod ?? '' }}</td>
                                                        <td>{{ $md->docDooring->docTracking->po->po_kebun ?? '' }}</td>
                                                        <td>{{ $md->docDooring->docTracking->po->detailPhs->penerima->ptPenerima->nama_penerima ?? '' }}</td>
                                                        <td>{{ $md->estate }}</td>
                                                        <td>{{ $md->docDooring->docTracking->po->barang->nama_barang ?? '' }}</td>
                                                        <td>{{ number_format($md->qty_tonase , 0, ',', ',') ?? '' }}</td>
                                                        <td>KG</td>
                                                        <td>{{ number_format($md->jml_sak , 0, ',', ',') }}</td>
                                                        <td>{{ $md->tgl_muat ? date('d-M-Y', strtotime($md->tgl_muat)) : '' }}</td>
                                                        <td>{{ $md->tgl_tiba ? date('d-M-Y', strtotime($md->tgl_tiba)) : '' }}</td>
                                                        <td>{{ $md->no_tiket }}</td>
                                                        <td>{{ $noContainer }}</td>
                                                        <td>{{ $md->nopol }}</td>
                                                        <td>{{ number_format($md->qty_timbang , 0, ',', ',') }}</td>                                            
                                                        <td>{{ number_format($susut , 0, ',', ',') }}</td>
                                                        <td>{{ $namaKapal }}</td>
                                                        <td>{{ $md->docDooring->docTracking->detailTracking->td ? date('d-M-Y', strtotime($md->docDooring->docTracking->detailTracking->td)) : '' }}</td>
                                                        <td class="text-center">
                                                            {!! $md->status == 1 ? '<span class="shadow-none badge badge-success">Proses Muat</span>' :
                                                               ($md->status == 2 ? '<span class="shadow-none badge badge-warning">Selesai Muat</span>' :
                                                               ($md->status == 3 ? '<span class="shadow-none badge badge-warning">Selesai Muat</span>' : 
                                                               'Default Content')) 
                                                            !!}
                                                        </td>                                                          
                                                        <td>
                                                        {!! $md->docDooring->sb_file_name != null
                                                            ?
                                                                '<a href="'.route('downloadfile', ['path' => $md->docDooring->sb_file_name]).'" 
                                                                    class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Download BAP Dooring" data-original-title="Print">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
                                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></a>'     
                                                            : ''
                                                        !!}
                                                        {!! $md->docDooring->sr_file_name != null
                                                            ?
                                                                '<a href="'.route('downloadfile', ['path' => $md->docDooring->sr_file_name]).'" 
                                                                    class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Rekap Kebun" data-original-title="Print"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                                                </svg></a>'     
                                                            : ''
                                                        !!}
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

        <script type='text/javascript'>
            $(document).ready(function() {
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
                        extend: 'excel', 
                        className: 'btn btn-success', 
                        exportOptions: {
                            columns: ':visible'
                        },                                      
                    },            
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
                        text: 'Susut',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 16 );
                            column.visible( ! column.visible() );
                        }
                    },                    
                    {
                        text: 'Nama Kapal',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 17 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'TD',
                        className: 'btn btn-secondary toggle-vis mb-1',
                        action: function(e, dt, node, config ) {
                            var column = dt.column( 18 );
                            column.visible( ! column.visible() );
                        }
                    },
                    {
                        text: 'Status',
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
        </script>
        
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>    