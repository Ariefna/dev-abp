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
                    <form class="row g-3 needs-validation" action="{{ route('invoice-dp.store') }}"  method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="col-md-4">
                            <label for="validationCustom01" class="form-label">Invoice Date</label>
                            <input name="tgl_inv_dp" id="basicFlatpickr" value="2022-09-04" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select Date..">
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustom01" class="form-label">No PO Muat</label>
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
                        <div class="col-md-4">
                            <label for="validationCustom01" class="form-label">Invoice No</label>
                            <input name="invoice_no" type="text" class="form-control" id="invoice_no" placeholder="Autofill no invoice dp terakhir dari po + 1" required>
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
                                            <td class="text-center"><span class="shadow-none badge badge-danger">Pending</span></td>
                                            <td class="text-center">
                                                <a href="#modalInvPel-{{ $tdp->id_track }}" class="bs-tooltip"  data-bs-toggle="modal" data-bs-placement="top" title="Tambah Detail" data-original-title="Tambah Detail"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg></a>
                                                <a href="javascript:void(0);" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Print" data-original-title="Print"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg></a>
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
        <div class="modal fade bd-example-modal-xl" id="modalInvPel-{{ $tdp->id_track }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    {{-- <div class="modal-body"> --}}
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Detail Invoice Pelunasan</h5>
                        </div>
                        <div class="modal-body">
                            <form name="modal-tracking-ada" class="row g-3 needs-validation" action=""  method="POST" enctype="multipart/form-data" novalidate>
                                @csrf
                                <input type="text" name="id_track_i" id="id_track_i" value="{{ $tdp->id_track }}">
                                <div class="col-md-3">
                                    <label for="validationCustom04" class="form-label">PO Muat</label>
                                    <select class="form-select" name="cb_bypo" id="cb_bypo" required>
                                        <option selected disabled value="">Pilih...</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Pilih PO Muat
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="notAllowCont" class="form-label">Total Tonase by Date</label>
                                    <div class="input-group">
                                        <input name="ttdb" step="any" min="0" id="ttdb" type="number" class="form-control qty_cont" required>
                                        <span class="input-group-text" id="inputGroupPrepend">KG</span>
                                    </div>     
                                </div>
                                <div class="col-md-3">
                                    <label for="notAllowCont" class="form-label">Harga Freight</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                        <input name="hrg_freight" step="any" min="0" id="hrg_freight" type="number" class="form-control qty_cont" required>
                                    </div>     
                                </div>                                
                                <div class="col-md-3">
                                    <label for="notAllowCont" class="form-label">Total Harga</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                        <input name="total_harga" min="0" id="total_harga" type="text" class="form-control" required>
                                    </div>     
                                </div>                                
                                <div class="col-md-2">
                                    <label for="notAllowCont" class="form-label">Prosentase DP</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">%</span>
                                        <input name="qty_tonase" step="any" min="0" id="qty_cont" type="number" class="form-control qty_cont" required>
                                    </div>     
                                </div>
                                <div class="col-md-4">
                                    <label for="notAllowCont" class="form-label">Total DP</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                        <input name="qty_tonase" step="any" min="0" id="qty_cont" type="number" class="form-control qty_cont" required>
                                    </div>     
                                </div>
                                <div class="col-md-2">
                                    <label for="notAllowCont" class="form-label">Prosentase PPn</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">%</span>
                                        <input name="qty_tonase" step="any" min="0" id="qty_cont" type="number" class="form-control qty_cont" required>
                                    </div>     
                                </div>
                                <div class="col-md-4">
                                    <label for="notAllowCont" class="form-label">Total PPn</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                                        <input name="qty_tonase" step="any" min="0" id="qty_cont" type="number" class="form-control qty_cont" required>
                                    </div>     
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <button id ="btn-modal-curah" type="submit" class="btn btn-primary">Tambah</button>
                                    <button type="button" class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i>Batal</button>
                                </div>
                            </form>
                        </div>
                        <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing mx-auto">
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
                        </div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>        
        @endforeach
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

        <script type='text/javascript'>
            $(document).ready(function() {

                    var formatter = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0 // Set the number of decimal places to 0 for whole numbers
                    });

                    var id_track = $("#id_track_i").val();

                    // Send an AJAX request to fetch options based on id_track
                    $.get("/horizontal-dark-menu/finance/invoice-dp/dp/getOptionsPO/" + id_track, function (data) {
                        // Populate the select options with the retrieved data
                        var select = $("#cb_bypo");
                        select.empty(); // Clear existing options
                        select.append($('<option>', {
                            value: '',
                            text: 'Pilih...',
                            disabled: true,
                            selected: true
                        }));

                        // Loop through the data and append options to the select
                        $.each(data, function (key, value) {
                            // var text = (value.no_container === null) ? value.oa_kpl_kayu : value.oa_container;
                            select.append($('<option>', {
                                value: key.id_track,
                                // text: value.no_po+' ('+value.formatted_tgl_muat+')'+value.oa_kpl_kayu+value.oa_container+value.total_muat
                                text: value.no_po + '(' + value.formatted_tgl_muat + ')'
                            }));
                        });
                    });

                    $('#cb_bypo').change(function() {
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
                                    $("#ttdb").empty();
                                    $("#hrg_freight").empty();
                                    if (response.length > 0) {
                                        for (var i=0; i<response.length; i++) {
                                            var text = (response[i].no_container === null) ? response[i].oa_kpl_kayu : response[i].oa_container;
                                            $('#ttdb').val(response[i].total_muat);
                                            $('#hrg_freight').val(text);
                                            var muat = parseFloat($('#ttdb').val());
                                            var harga = parseFloat($('#hrg_freight').val());
                                            var total = harga * muat;
                                            $('#total_harga').val(formatter.format(total).replace('Rp', ''));
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
                            $('#ttdb').val('');
                            $('#hrg_freight').val('');
                        }
                    });
                    // function updateValues() {
                    //     var ttdb = parseFloat($('#ttdb').val()) || 0; // Parse float or default to 0
                    //     var hrg_freight = parseFloat($('#hrg_freight').val()) || 0; // Parse float or default to 0
                    //     var total_harga = ttdb * hrg_freight;

                    //     $('#total_harga').val(total_harga.toFixed(2)); // Display total_harga with two decimal places
                    //     console.log(total_harga);
                    // }
                    // updateValues();

                    // $('#ttdb, #hrg_freight').on('input', updateValues);
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
        
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>    