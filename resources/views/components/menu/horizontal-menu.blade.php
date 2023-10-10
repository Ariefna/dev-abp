{{-- 

/**
*
* Created a new component <x-menu.horizontal-menu/>.
* 
*/

--}}


<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">

        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                <div class="nav-item theme-logo">
                    <a href="{{ getRouterValue() }}/dashboard/analytics">
                        <img src="{{ Vite::asset('resources/images/logo.svg') }}" class="navbar-logo" alt="logo">
                    </a>
                </div>
                <div class="nav-item theme-text">
                    <a href="{{ getRouterValue() }}/dashboard/analytics" class="nav-link"> CORK </a>
                </div>
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-chevrons-left">
                        <polyline points="11 17 6 12 11 7"></polyline>
                        <polyline points="18 17 13 12 18 7"></polyline>
                    </svg>
                </div>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu {{ Request::is('*/dashboard/*') ? 'active' : '' }}">
                <a href="#dashboard" data-bs-toggle="dropdown"
                    aria-expanded="{{ Request::is('*/dashboard/*') ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span>Dashboard</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="dropdown-menu submenu list-unstyled" id="dashboard" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('dashboard.index') ? 'active' : '' }}">
                        <a href="{{ getRouterValue() }}/dashboard/analytics"> Analytics </a>
                    </li>
                    {{-- <li class="{{ Request::routeIs('sales') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/dashboard/sales"> Sales </a>
                            </li> --}}
                </ul>
            </li>

            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-minus">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg><span>APPLICATIONS</span></div>
            </li>
            @if (in_array('master-barang', Session::get('admin_menus')) ||
                    in_array('master-customer', Session::get('admin_menus')) ||
                    in_array('master-kapal', Session::get('admin_menus')) ||
                    in_array('master-penerima', Session::get('admin_menus')) ||
                    in_array('master-pod', Session::get('admin_menus')) ||
                    Session::get('role') == 'superadmin')
                <li class="menu {{ Request::is('*/master/*') ? 'active' : '' }}">
                    <a href="#master" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-layers">
                                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                <polyline points="2 17 12 22 22 17"></polyline>
                                <polyline points="2 12 12 17 22 12"></polyline>
                            </svg>
                            <span>Master</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="dropdown-menu submenu list-unstyled" id="master"
                        data-bs-parent="#accordionExample">
                        @if (in_array('master-barang', Session::get('admin_menus')) || Session::get('role') == 'superadmin')
                            <li class="{{ Request::routeIs('barang.index') ? 'active' : '' }}">
                                <a href="{{ getRouterValue() }}/master/barang"> Barang </a>
                            </li>
                        @endif
                        @if (in_array('master-customer', Session::get('admin_menus')) || Session::get('role') == 'superadmin')
                            <li class="{{ Request::routeIs('customer.index') ? 'active' : '' }}">
                                <a href="{{ getRouterValue() }}/master/customer"> Customer </a>
                            </li>
                        @endif
                        @if (in_array('master-kapal', Session::get('admin_menus')) || Session::get('role') == 'superadmin')
                            <li class="{{ Request::routeIs('kapal.index') ? 'active' : '' }}">
                                <a href="{{ getRouterValue() }}/master/kapal"> Kapal </a>
                            </li>
                        @endif
                        @if (in_array('master-penerima', Session::get('admin_menus')) || Session::get('role') == 'superadmin')
                            <li class="{{ Request::routeIs('penerima.index') ? 'active' : '' }}">
                                <a href="{{ getRouterValue() }}/master/penerima"> Penerima </a>
                            </li>
                        @endif
                        @if (in_array('master-pol', Session::get('admin_menus')) || Session::get('role') == 'superadmin')
                            <li class="{{ Request::routeIs('pol.index') ? 'active' : '' }}">
                                <a href="{{ getRouterValue() }}/master/pol"> Port Of Loading </a>
                            </li>
                        @endif
                        @if (in_array('master-pod', Session::get('admin_menus')) || Session::get('role') == 'superadmin')
                            <li class="{{ Request::routeIs('pod.index') ? 'active' : '' }}">
                                <a href="{{ getRouterValue() }}/master/pod"> Port Of Destination </a>
                            </li>
                        @endif
                        @if (in_array('master-gudang-muat', Session::get('admin_menus')) || Session::get('role') == 'superadmin')
                            <li class="{{ Request::routeIs('gudang-muat.index') ? 'active' : '' }}">
                                <a href="{{ getRouterValue() }}/master/gudang-muat"> Gudang Muat </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg><span>USER INTERFACE</span></div>
            </li>
            @if (in_array('document-penawaran-harga', Session::get('admin_menus')) ||
                    in_array('document-purchase-order', Session::get('admin_menus')) ||
                    in_array('document-surat-perintah-kerja', Session::get('admin_menus')) ||
                    in_array('document-tracking', Session::get('admin_menus')) ||
                    in_array('document-dooring', Session::get('admin_menus')) ||
                    Session::get('role') == 'superadmin')
                <li class="menu {{ Request::is('*/document/*') ? 'active' : '' }}">
                    <a href="#document" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            <span>Document</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="dropdown-menu submenu list-unstyled" id="document"
                        data-bs-parent="#accordionExample">
                        <li class="{{ Request::routeIs('penawaran-harga.index') ? 'active' : '' }}">
                            <a href="{{ getRouterValue() }}/document/penawaran-harga"> Penawaran Harga </a>
                        </li>
                        <li class="{{ Request::routeIs('purchase-order.index') ? 'active' : '' }}">
                            <a href="{{ getRouterValue() }}/document/purchase-order"> Purchase Order </a>
                        </li>
                        <li class="{{ Request::routeIs('tracking.index') ? 'active' : '' }}">
                            <a href="{{ getRouterValue() }}/document/tracking"> Tracking </a>
                        </li>
                        {{-- <li class="{{ Request::routeIs('surat-perintah-kerja') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/document/surat-perintah-kerja"> Surat Perintah Kerja </a>
                            </li> --}}
                        <li class="{{ Request::routeIs('dooring.index') ? 'active' : '' }}">
                            <a href="{{ getRouterValue() }}/document/dooring"> Dooring </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (in_array('monitoring-mon-tracking', Session::get('admin_menus')) ||
                    in_array('monitoring-mon-dooring', Session::get('admin_menus')) ||
                    Session::get('role') == 'superadmin')
                <li class="menu {{ Request::is('*/monitoring/*') ? 'active' : '' }}">
                    <a href="#monitoring" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay">
                                <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1">
                                </path>
                                <polygon points="12 15 17 21 7 21 12 15"></polygon>
                            </svg>
                            <span>Monitoring</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="dropdown-menu submenu list-unstyled" id="monitoring"
                        data-bs-parent="#accordionExample">
                        @if (in_array('monitoring-mon-tracking', Session::get('admin_menus')) || Session::get('role') == 'superadmin')
                            <li class="{{ Request::routeIs('mon-tracking.index') ? 'active' : '' }}">
                                <a href="{{ getRouterValue() }}/monitoring/mon-tracking"> Monitoring Tracking </a>
                            </li>
                        @endif

                        @if (in_array('monitoring-mon-dooring', Session::get('admin_menus')) || Session::get('role') == 'superadmin')
                            <li class="{{ Request::routeIs('mon-dooring.index') ? 'active' : '' }}">
                                <a href="{{ getRouterValue() }}/monitoring/mon-dooring"> Monitoring Doring </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (in_array('finance-invoice-dp', Session::get('admin_menus')) ||
                    in_array('finance-invoice-pelunasan', Session::get('admin_menus')) ||
                    Session::get('role') == 'superadmin')
                <li class="menu {{ Request::is('*/finance/*') ? 'active' : '' }}">
                    <a href="#finance" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <img src="{{ Vite::asset('resources/images/rupiah.png') }}" alt="rupiah"
                                width="24" height="24">
                            <span>Finance</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="dropdown-menu submenu list-unstyled" id="finance"
                        data-bs-parent="#accordionExample">
                        <li class="{{ Request::routeIs('invoice-dp.index') ? 'active' : '' }}">
                            <a href="{{ getRouterValue() }}/finance/invoice-dp"> Invoice DP </a>
                        </li>
                        <li class="{{ Request::routeIs('invoice-pelunasan.index') ? 'active' : '' }}">
                            <a href="{{ getRouterValue() }}/finance/invoice-pelunasan"> Invoice Pelunasan </a>
                        </li>
                        {{-- <li class="{{ Request::routeIs('alerts') ? 'active' : '' }}">
                            <a href="{{ getRouterValue() }}*alerts"> Laporan Keuangan </a>
                        </li> --}}
                    </ul>
                </li>
            @endif
            @if (in_array('monitoring-mon-tracking', Session::get('admin_menus')) ||
                    in_array('monitoring-mon-dooring', Session::get('admin_menus')) ||
                    Session::get('role') == 'superadmin')
                <li class="menu {{ Request::is('*/report/*') ? 'active' : '' }}">
                    <a href="#report" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                <polyline points="2 17 12 22 22 17"></polyline>
                                <polyline points="2 12 12 17 22 12"></polyline>
                            </svg>
                            <span>Report History</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="dropdown-menu submenu list-unstyled" id="report"
                        data-bs-parent="#accordionExample">
                        @if (in_array('monitoring-mon-tracking', Session::get('admin_menus')) || Session::get('role') == 'superadmin')
                            <li class="{{ Request::routeIs('mon-tracking-h.index') ? 'active' : '' }}">
                                <a href="{{ getRouterValue() }}/report/mon-tracking"> Monitoring Tracking </a>
                            </li>
                        @endif

                        @if (in_array('monitoring-mon-dooring', Session::get('admin_menus')) || Session::get('role') == 'superadmin')
                            <li class="{{ Request::routeIs('mon-dooring-h.index') ? 'active' : '' }}">
                                <a href="{{ getRouterValue() }}/report/mon-dooring"> Monitoring Doring </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            {{-- @if (in_array('monitoring-mon-tracking', Session::get('admin_menus')) ||
                in_array('monitoring-mon-dooring', Session::get('admin_menus')) ||
                Session::get('role') == 'superadmin')
                <li class="menu {{ Request::is('*/report/*') ? 'active' : '' }}">
                    <a href="#document" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span>User Role</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="dropdown-menu submenu list-unstyled" id="report"
                        data-bs-parent="#accordionExample">
                        @if (in_array('monitoring-mon-tracking', Session::get('admin_menus')) || Session::get('role') == 'superadmin')
                            <li class="{{ Request::routeIs('penawaran-harga.index') ? 'active' : '' }}">
                                <a href="{{ getRouterValue() }}/report/a"> Monitoring Tracking </a>
                            </li>
                        @endif

                        @if (in_array('monitoring-mon-dooring', Session::get('admin_menus')) || Session::get('role') == 'superadmin')
                            <li class="{{ Request::routeIs('purchase-order.index') ? 'active' : '' }}">
                                <a href="{{ getRouterValue() }}/report/b"> Monitoring Doring </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif             --}}
            {{-- <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg><span>TABLES AND FORMS</span></div>
            </li> --}}
            @if (in_array('userrole-menu-user', Session::get('admin_menus')) ||
                    in_array('userrole-create-user', Session::get('admin_menus')) ||
                    Session::get('role') == 'superadmin')
                <li class="menu {{ Request::is('*/userrole/*') ? 'active' : '' }}">
                    <a href="#userrole" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span>User Role</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="dropdown-menu submenu list-unstyled" id="userrole"
                        data-bs-parent="#accordionExample">
                        @if (in_array('userrole-menu-user', Session::get('admin_menus')) || Session::get('role') == 'superadmin')
                            <li class="{{ Request::routeIs('menuuser.index') ? 'active' : '' }}">
                                <a href="{{ getRouterValue() }}/userrole/menuuser"> Menu User </a>
                            </li>
                        @endif
                        @if (in_array('userrole-create-user', Session::get('admin_menus')) || Session::get('role') == 'superadmin')
                            <li class="{{ Request::routeIs('createuser.index') ? 'active' : '' }}">
                                <a href="{{ getRouterValue() }}/userrole/createuser"> Create User </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif


        </ul>

    </nav>

</div>
