    <link rel="stylesheet" href="{{asset('plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/flatpickr/flatpickr.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/noUiSlider/nouislider.min.css')}}">
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
                                            <td>{{ $data['invoice_date'] ?? '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td>INVOICE No</td>
                                            <td>{{ $data['invoice_no'] ?? '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td>TERMS</td>
                                            <td>{{ $data['terms'] ?? '-'}}</td>
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
                                            <td>: {{ $data['no_po'] ?? '-'}}</td>
                                            <td>Pelayaran</td>
                                            <td>: {{ $data['pelayaran'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tujuan</td>
                                            <td>: {{ $data['tujuan1'] ?? ''}} - {{ $data['tujuan2'] ?? ''}}</td>
                                            <td>Tipe Job</td>
                                            <td>: {{ $data['tipe_job'] }}</td>
                                        </tr>
                                        @foreach ($data['kapal'] as $key => $kapal)
                                            <tr>
                                                <td>
                                                    @if ($key == 0)
                                                        VOY #
                                                    @endif
                                                </td>
                                                <td>: {{ $kapal['name'] }}</td>
                                                <td>
                                                    @if ($key == 0)
                                                        ETD
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($key == 0)
                                                        :
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        <!-- <tr>
                                            <td></td>
                                            <td>: KLM Budi Jaya</td>
                                        </tr> -->
                                        <tr>
                                            <td>Total Cont.</td>
                                            <td>: {{ $data['total-cont'] }} KG</td>
                                            <td>
                                                Stuff Date
                                            </td>
                                            <td>: </td>
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
                                        @foreach ($data['description'] as $desc)
                                            <tr>
                                                <td>{{ $desc['name'] }}</td>
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
                                        @php
                                            $subtotal = 0;
                                        @endphp
                                        @foreach ($data['description'] as $desc)
                                            <tr>
                                                <td>Harga Cont.</td>
                                                <td>Rp. {{ $desc['total_tonase'] * $desc['harga_brg'] }}</td>
                                            </tr>
                                            @php
                                                $subtotal += $desc['total_tonase'] * $desc['harga_brg'];
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <td>Subtotal</td>
                                            <td>Rp. {{ $subtotal }}</td>
                                        </tr>
                                        <tr>
                                            <td>PPN 1,1%</td>
                                            <td>Rp. {{ $desc['prosentase_ppn'] * $subtotal / 100 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Invoice</td>
                                            <td>
                                                <b>Rp. {{ $desc['prosentase_ppn'] * $subtotal / 100 + $subtotal}}</b>
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
                    {{ $data['bank']['nama_bank'] }} <br />
                    a/c {{ $data['bank']['account_number'] }} <br />
                    a/n {{ $data['bank']['a/n'] }}<br />
                </b></h5>
            </p>
        </div>
        <div id="basic" class="col-lg-6 col-sm-6 col-6 layout-spacing">
            <p>
                Surabaya, {{ date('d F Y', strtotime($data['invoice_date'])) }} <br/>
                Hormat Kami,
            </p>
        </div>
    </div>            

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
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