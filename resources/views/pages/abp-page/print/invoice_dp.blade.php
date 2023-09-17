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
                <li class="breadcrumb-item active" aria-current="page">Invoice DP</li>
            </ol>
        </nav>
    </div>
    <!-- /BREADCRUMB -->        
    <div class="row layout-top-spacing">
        <h1>PT Adhipramana Bahari Perkasa</h1>
        <p>
            Pergudangan Pakal Indah, Jl Raya Pakal no 16 Blok A7 <br />
            Surabaya, Indonesia <br />
            Telp +6231 7433099
        </p>
        <div id="basic" class="col-lg-6 col-sm-6 col-6 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Bill To</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="col-lg-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area">
                                <table id="style-3" class="table style-3 dt-table-hover" style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td>{{ $data['nama_customer'] ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $data['kota_customer'] ?? '-'}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="basic" class="col-lg-6 col-sm-6 col-6 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Invoice</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="col-lg-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area">
                                <table id="style-3" class="table style-3 dt-table-hover" style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td>INVOICE DATE</td>
                                            <td>15 Sept 2023</td>
                                        </tr>
                                        <tr>
                                            <td>INVOICE No</td>
                                            <td>ABP/2023/09/0031</td>
                                        </tr>
                                        <tr>
                                            <td>TERMS</td>
                                            <td>30 Days</td>
                                        </tr>
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
                <div class="widget-content widget-content-area">
                    <div class="col-lg-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area">
                                <table id="style-3" class="table style-3 dt-table-hover" style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td>JOB #</td>
                                            <td>: JO23</td>
                                            <td>Pelayaran</td>
                                            <td>: PT Anugrah Jaya Indah</td>
                                        </tr>
                                        <tr>
                                            <td>Tujuan</td>
                                            <td>: GRESIK-PANGKALAN BUN</td>
                                            <td>Tipe Job</td>
                                            <td>: DOOR TO DOOR</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>: GRESIK-PANGKALAN BUN</td>
                                            <td>ETD</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>VOY #</td>
                                            <td>: KLM Budi Jaya</td>
                                            <td>Stuff Date</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>: KLM Budi Jaya</td>
                                        </tr>
                                        <tr>
                                            <td>Total Count</td>
                                            <td>: 1.170.850 KG</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div id="basic" class="col-lg-6 col-sm-6 col-6 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="col-lg-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area">
                                <table id="style-3" class="table style-3 dt-table-hover" style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td>JOB #</td>
                                            <td>: JO23</td>
                                        </tr>
                                        <tr>
                                            <td>Tujuan</td>
                                            <td>: GRESIK-PANGKALAN BUN</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>: GRESIK-PANGKALAN BUN</td>
                                        </tr>
                                        <tr>
                                            <td>VOY #</td>
                                            <td>: KLM Budi Jaya</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>: KLM Budi Jaya</td>
                                        </tr>
                                        <tr>
                                            <td>Total Count</td>
                                            <td>: 1.170.850 KG</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="basic" class="col-lg-6 col-sm-6 col-6 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="col-lg-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area">
                                <table id="style-3" class="table style-3 dt-table-hover" style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td>Pelayaran</td>
                                            <td>: PT Anugrah Jaya Indah</td>
                                        </tr>
                                        <tr>
                                            <td>Tipe Job</td>
                                            <td>: DOOR TO DOOR</td>
                                        </tr>
                                        <tr>
                                            <td>ETD</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Stuff Date</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div id="basic" class="col-lg-6 col-sm-6 col-6 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Description</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="col-lg-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area">
                                <table id="style-3" class="table style-3 dt-table-hover" style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td>Freight PO 1620000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="basic" class="col-lg-6 col-sm-6 col-6 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Amount</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="col-lg-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area">
                                <table id="style-3" class="table style-3 dt-table-hover" style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td>Harga Cont.</td>
                                            <td>Rp. 200.868.000</td>
                                        </tr>
                                        <tr>
                                            <td>Harga Cont.</td>
                                            <td>Rp. 200.868.000</td>
                                        </tr>
                                        <tr>
                                            <td>Harga Cont.</td>
                                            <td>Rp. 200.868.000</td>
                                        </tr>
                                        <tr>
                                            <td>Subtotal</td>
                                            <td>Rp. 200.868.000</td>
                                        </tr>
                                        <tr>
                                            <td>PPN 1,1%</td>
                                            <td>Rp. 200.868.000</td>
                                        </tr>
                                        <tr>
                                            <td>Total Invoice</td>
                                            <td>
                                                <b>Rp. 200.868.000</b>
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
        <div id="basic" class="col-lg-6 col-sm-6 col-6 layout-spacing">
            <p>
                <h5>Note :</h5>
                <h5><b>
                    BCA KCP Pucang Anom Surabaya <br />
                    a/c 064.22.77.888<br />
                    a/n PT. Adhipramana Perkasa<br />
                </b></h5>
            </p>
        </div>
        <div id="basic" class="col-lg-6 col-sm-6 col-6 layout-spacing">
            <p>
                Surabaya, 15 September 2023 <br/>
                Hormat Kami,
            </p>
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

        <script>
            var f1 = flatpickr(document.getElementById('basicFlatpickr'), {
                defaultDate: new Date()
            });
        </script>

        <script type='text/javascript'>
            $(document).ready(function() {

            });
        </script>
        
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>    