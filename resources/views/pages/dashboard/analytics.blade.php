<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
        </x-slot>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <x-slot:headerFiles>
            <!--  BEGIN CUSTOM STYLE FILE  -->
            <link rel="stylesheet" href="{{asset('plugins/apex/apexcharts.css')}}">

            @vite(['resources/scss/light/assets/components/list-group.scss'])
            @vite(['resources/scss/light/assets/widgets/modules-widgets.scss'])

            @vite(['resources/scss/dark/assets/components/list-group.scss'])
            @vite(['resources/scss/dark/assets/widgets/modules-widgets.scss'])
            <!--  END CUSTOM STYLE FILE  -->
            </x-slot>
            <!-- END GLOBAL MANDATORY STYLES -->

            <!-- Analytics -->

            <div class="row layout-top-spacing">
                @if (Session::get('role') == 'superadmin')
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-card-five">
                        <div class="widget-content">
                            <div class="account-box">

                                <div class="info-box">
                                    <div class="icon">
                                        <span>
                                            <img src="{{Vite::asset('resources/images/uang-dp.png')}}" alt="money-bag">
                                        </span>
                                    </div>

                                    <div class="balance-info">
                                        <h6 style="color: blue;">Total DP</h6>
                                        <p>Rp. {{ number_format($totaldp, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="card-bottom-section">
                                    <div></div>
                                    {{-- <a href="#">View Report</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-card-five">
                        <div class="widget-content">
                            <div class="account-box">

                                <div class="info-box">
                                    <div class="icon">
                                        <span>
                                            <img src="{{Vite::asset('resources/images/uang-pelunasan.png')}}" alt="money-bag">
                                        </span>
                                    </div>

                                    <div class="balance-info">
                                        <h6 style="color: blue;">Total Pelunasan</h6>
                                        <p>Rp. {{ number_format($totalpel, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="card-bottom-section">
                                    <div></div>
                                    {{-- <a href="#">View Report</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-card-five">
                        <div class="widget-content">
                            <div class="account-box">

                                <div class="info-box">
                                    <div class="icon">
                                        <span>
                                            <img src="{{Vite::asset('resources/images/money-bags.png')}}" alt="money-bag">
                                        </span>
                                    </div>

                                    <div class="balance-info">
                                        <h6 style="color: blue;">Total Purchase Order</h6>
                                        <p>Rp. {{ number_format($totalpo, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="card-bottom-section">
                                    <div></div>
                                    {{-- <a href="#">View Report</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-chart-three title="Grafik Pendapatan"/>
        </div> --}}
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    {{-- <x-widgets._w-chart-one title="Grafik Pendapatan"/> --}}
                    <div class="widget widget-chart-one">
                        <div class="widget-heading">
                            <h5 class="">Grafik Pendapatan</h5>
                            {{-- <div class="task-action">
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" id="revenue" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                            </a>
                            <div class="dropdown-menu left" aria-labelledby="revenue" style="will-change: transform;">
                                <a class="dropdown-item" href="javascript:void(0);">Weekly</a>
                                <a class="dropdown-item" href="javascript:void(0);">Monthly</a>
                                <a class="dropdown-item" href="javascript:void(0);">Yearly</a>
                            </div>
                        </div>
                    </div> --}}
                        </div>
                        <div class="col-md-3">
                            <form id="filterForm" action="{{ route('analytics.index') }}" method="get">
                                <label for="yearFilter" class="form-label">Filter by Year:</label>
                                <select class="form-select" id="yearFilter" name="yearFilter" onchange="filterByYear()">
                                    <?php
                                    $currentYear = date("Y");
                                    for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
                                        $selected = ($year == ($_GET['yearFilter'] ?? $currentYear)) ? 'selected' : '';
                                        echo "<option value=\"$year\" $selected>$year</option>";
                                    }
                                    ?>
                                </select>
                                <button type="submit" style="display: none;"></button>
                            </form>
                        </div>
                        <div class="col-md-9"></div>

                        <div class="widget-content">
                            <div id="revenueMonthly"></div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-card-five title="Profit" balance="$41,741.42" percentage="+ 13.6%" button="View Report" link="javascript:void(0);"/>
        </div>
        
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-card-five title="Income" balance="$41,741.42" percentage="+ 13.6%" button="View Report" link="javascript:void(0);"/>
        </div>  

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-card-five title="Passiva" balance="$41,741.42" percentage="+ 13.6%" button="View Report" link="javascript:void(0);"/>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-card-five title="Outcome" balance="$41,741.42" percentage="+ 13.6%" button="View Report" link="javascript:void(0);"/>
        </div> --}}

                {{-- <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-card-five title="Total Balance" balance="$41,741.42" percentage="+ 13.6%" button="View Report" link="javascript:void(0);"/>
        </div> --}}

                {{-- <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-chart-three title="Revenue Streams"/>
        </div>
    
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-activity-five title="Daily Activity"/>
        </div> --}}

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-table-two">

                        <div class="widget-heading">
                            <h5 class="">Monitoring Tracking</h5>
                        </div>

                        <div class="widget-content">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="th-content">No PO</div>
                                            </th>
                                            <th>
                                                <div class="th-content">Total Belum Muat</div>
                                            </th>
                                            <th>
                                                <div class="th-content">Status</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    @if(in_array('dashboard-analytics-READ', Session::get('nama_action')) || Session::get('role') == 'superadmin')
                                    <tbody>
                                        @foreach($tbl_po->where('qty_sisa','!=',0) as $trab)
                                        <tr>
                                            <td><a href="{{ route('analytics.addsisatrack', ['no_po' => $trab->no_po]) }}">
                                                    <div class="td-content"><span class="">{{ $trab->no_po }}</span></div>
                                                </a></td>
                                            <td><a href="{{ route('analytics.addsisatrack', ['no_po' => $trab->no_po]) }}">
                                                    <div class="td-content"><span class="">{{ number_format($trab->qty_sisa, 0, ',', '.') }}&nbsp;KG</span></div>
                                                </a></td>
                                            <td>
                                                <div class="td-content"><span class="badge badge-danger">Sisa Muat</span></div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="d-grid gap-4 col-12 mx-auto">
                            {{-- <a href="" class="btn btn-outline-secondary mb-4">View All</a> --}}
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-table-two">

                        <div class="widget-heading">
                            <h5 class="">Monitoring Dooring</h5>
                        </div>

                        <div class="widget-content">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="th-content">No PO</div>
                                            </th>
                                            <th>
                                                <div class="th-content">Total Belum Dooring</div>
                                            </th>
                                            <th>
                                                <div class="th-content">Status</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    @if(in_array('dashboard-analytics-READ', Session::get('nama_action')) || Session::get('role') == 'superadmin')
                                    <tbody>
                                        @foreach($tbl_dor->where('qty_sisa','!=',0) as $trab)
                                        <tr>
                                            <td><a href="{{ route('analytics.addsisadoor', ['id_dooring' => $trab->id_dooring]) }}">
                                                    <div class="td-content"><span class="">{{ $trab->no_po }}</span></div>
                                                </a></td>
                                            <td><a href="{{ route('analytics.addsisadoor', ['id_dooring' => $trab->id_dooring]) }}">
                                                    <div class="td-content"><span class="">{{ number_format($trab->qty_sisa, 0, ',', '.') }}&nbsp;KG</span></div>
                                                </a></td>
                                            <td>
                                                <div class="td-content"><span class="badge badge-danger">Sisa Dooring</span></div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="d-grid gap-4 col-12 mx-auto">
                            {{-- <a href="" class="btn btn-outline-secondary mb-4">View All</a> --}}
                        </div>
                    </div>
                </div>

                {{-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-table-two title="Monitoring Marketing"/>
        </div> --}}

                {{-- <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
            <x-widgets._w-hybrid-one title="Followers" chart-id="hybrid_followers"/>
        </div>
    
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-five title="Figma Design"/>
        </div>
    
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-card-one title="Jimmy Turner"/>
        </div>
    
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-card-two title="Dev Summit - New York"/>
        </div> --}}
                @else
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-table-two">

                        <div class="widget-heading">
                            <h5 class="">Monitoring Tracking</h5>
                        </div>

                        <div class="widget-content">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="th-content">No PO</div>
                                            </th>
                                            <th>
                                                <div class="th-content">Total Belum Muat</div>
                                            </th>
                                            <th>
                                                <div class="th-content">Status</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    @if(in_array('dashboard-analytics-READ', Session::get('nama_action')) || Session::get('role') == 'superadmin')
                                    <tbody>
                                        @foreach($tbl_po->where('qty_sisa','!=',0) as $trab)
                                        <tr>
                                            <td><a href="{{ route('analytics.addsisatrack', ['no_po' => $trab->no_po]) }}">
                                                    <div class="td-content"><span class="">{{ $trab->no_po }}</span></div>
                                                </a></td>
                                            <td><a href="{{ route('analytics.addsisatrack', ['no_po' => $trab->no_po]) }}">
                                                    <div class="td-content"><span class="">{{ number_format($trab->qty_sisa, 0, ',', '.') }}</span></div>
                                                </a></td>
                                            <td>
                                                <div class="td-content"><span class="badge badge-danger">Sisa Muat</span></div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="d-grid gap-4 col-12 mx-auto">
                            {{-- <a href="" class="btn btn-outline-secondary mb-4">View All</a> --}}
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-table-two">

                        <div class="widget-heading">
                            <h5 class="">Monitoring Dooring</h5>
                        </div>

                        <div class="widget-content">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="th-content">No PO</div>
                                            </th>
                                            <th>
                                                <div class="th-content">Total Belum Dooring</div>
                                            </th>
                                            <th>
                                                <div class="th-content">Status</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    @if(in_array('dashboard-analytics-READ', Session::get('nama_action')) || Session::get('role') == 'superadmin')
                                    <tbody>
                                        @foreach($tbl_dor->where('qty_sisa','!=',0) as $trab)
                                        <tr>
                                            <td><a href="{{ route('analytics.addsisadoor', ['id_dooring' => $trab->id_dooring]) }}">
                                                    <div class="td-content"><span class="">{{ $trab->no_po }}</span></div>
                                                </a></td>
                                            <td><a href="{{ route('analytics.addsisadoor', ['id_dooring' => $trab->id_dooring]) }}">
                                                    <div class="td-content"><span class="">{{ number_format($trab->qty_sisa, 0, ',', '.') }}</span></div>
                                                </a></td>
                                            <td>
                                                <div class="td-content"><span class="badge badge-danger">Sisa Dooring</span></div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="d-grid gap-4 col-12 mx-auto">
                            {{-- <a href="" class="btn btn-outline-secondary mb-4">View All</a> --}}
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!--  BEGIN CUSTOM SCRIPTS FILE  -->
            <x-slot:footerFiles>
                <script src="{{asset('plugins/apex/apexcharts.min.js')}}"></script>

                {{-- Analytics --}}
                {{-- @vite(['resources/assets/js/widgets/_wSix.js']) --}}
                {{-- @vite(['resources/assets/js/widgets/_wChartThree.js']) --}}
                {{-- @vite(['resources/assets/js/widgets/_wChartOne.js']) --}}
                {{-- @vite(['resources/assets/js/widgets/_wHybridOne.js']) --}}
                {{-- @vite(['resources/assets/js/widgets/_wActivityFive.js']) --}}
                @php
                $labels = array();
                $currentYear = $_GET['yearFilter'] ?? date("Y");

                for ($bulan = 1; $bulan <= 12; $bulan++) { $monthLabel=date("M", strtotime("2022-$bulan-01")); $labels[]="$monthLabel-$currentYear" ; } @endphp <script>
                    function filterByYear() {
                    // Submit the form when the year is selected
                    document.getElementById("filterForm").submit();
                    }
                    window.addEventListener("load", function(){
                    try {

                    let getcorkThemeObject = sessionStorage.getItem("theme");
                    let getParseObject = JSON.parse(getcorkThemeObject)
                    let ParsedObject = getParseObject;

                    if (ParsedObject.settings.layout.darkMode) {

                    var Theme = 'dark';

                    Apex.tooltip = {
                    theme: Theme
                    // custom: function({ series, seriesIndex, dataPointIndex, w }) {
                    // const currencySymbol = 'Rp.'; // Your currency symbol
                    // return currencySymbol + w.globals.series[seriesIndex][dataPointIndex];
                    // }
                    }

                    /**
                    ==============================
                    | @Options Charts Script |
                    ==============================
                    */

                    /*
                    =================================
                    Revenue Monthly | Options
                    =================================
                    */
                    var options1 = {
                    chart: {
                    fontFamily: 'Nunito, sans-serif',
                    height: 365,
                    type: 'area',
                    zoom: {
                    enabled: false
                    },
                    dropShadow: {
                    enabled: true,
                    opacity: 0.2,
                    blur: 10,
                    left: -7,
                    top: 22
                    },
                    toolbar: {
                    show: false
                    },
                    },
                    colors: ['#3498db',
                    // '#e74c3c',
                    // '#2ecc71'
                    ],
                    dataLabels: {
                    enabled: false
                    },
                    markers: {
                    discrete: [
                    {
                    seriesIndex: 2,
                    dataPointIndex: 11,
                    fillColor: '#000',
                    strokeColor: '#000',
                    size: 4
                    }]
                    },
                    stroke: {
                    show: true,
                    curve: 'smooth',
                    width: 2,
                    lineCap: 'square'
                    },
                    series: [
                    {
                    name: 'Pendapatan',
                    data: [
                    @foreach ($datagrafikPendapatan as $year => $total)
                    {{$total}},
                    @endforeach
                    ]
                    },
                    // {
                    // name: 'Biaya',
                    // data: [
                    // foreach ($datagrafikBiaya as $year => $total)
                    // {{$total}},
                    // endforeach
                    // ]
                    // },
                    // {
                    // name: 'Profit',
                    // data: [
                    // foreach ($datagrafikProfit as $year => $total)
                    // {{$total}},
                    // endforeach
                    // ]
                    // }
                    ],
                    labels: <?php echo json_encode($labels); ?>,
                    xaxis: {
                    axisBorder: {
                    show: false
                    },
                    axisTicks: {
                    show: false
                    },
                    crosshairs: {
                    show: true
                    },
                    labels: {
                    offsetX: 0,
                    offsetY: 5,
                    style: {
                    fontSize: '12px',
                    fontFamily: 'Nunito, sans-serif',
                    cssClass: 'apexcharts-xaxis-title',
                    },
                    }
                    },
                    yaxis: {
                    labels: {
                    formatter: function(value, index) {
                    return value.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });
                    },
                    offsetX: -15,
                    offsetY: 0,
                    style: {
                    fontSize: '12px',
                    fontFamily: 'Nunito, sans-serif',
                    cssClass: 'apexcharts-yaxis-title',
                    },
                    }
                    },
                    grid: {
                    borderColor: '#191e3a',
                    strokeDashArray: 5,
                    xaxis: {
                    lines: {
                    show: true
                    }
                    },
                    yaxis: {
                    lines: {
                    show: false,
                    }
                    },
                    padding: {
                    top: 50,
                    right: 0,
                    bottom: 0,
                    left: 5
                    },
                    },
                    legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    offsetY: -50,
                    fontSize: '16px',
                    fontFamily: 'Quicksand, sans-serif',
                    markers: {
                    width: 10,
                    height: 10,
                    strokeWidth: 0,
                    strokeColor: '#fff',
                    fillColors: undefined,
                    radius: 12,
                    onClick: undefined,
                    offsetX: -5,
                    offsetY: 0
                    },
                    itemMargin: {
                    horizontal: 10,
                    vertical: 20
                    }

                    },
                    tooltip: {
                    theme: Theme,
                    enabled: true,
                    marker: {
                    show: true,
                    },
                    x: {
                    show: false,
                    }
                    },
                    fill: {
                    type:"gradient",
                    gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    inverseColors: !1,
                    opacityFrom: .19,
                    opacityTo: .05,
                    stops: [100, 100]
                    }
                    },
                    responsive: [{
                    breakpoint: 575,
                    options: {
                    legend: {
                    offsetY: -50,
                    },
                    },
                    }]
                    }

                    }


                    /**
                    ==============================
                    | @Render Charts Script |
                    ==============================
                    */

                    /*
                    ================================
                    Revenue Monthly | Render
                    ================================
                    */
                    var chart1 = new ApexCharts(
                    document.querySelector("#revenueMonthly"),
                    options1
                    );

                    chart1.render();


                    } catch(e) {
                    console.log(e);
                    }
                    })
                    </script>
                    </x-slot>
                    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>