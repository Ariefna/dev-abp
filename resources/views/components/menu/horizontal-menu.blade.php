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
                            <a href="{{getRouterValue();}}/dashboard/analytics">
                                <img src="{{Vite::asset('resources/images/logo.svg')}}" class="navbar-logo" alt="logo">
                            </a>
                        </div>
                        <div class="nav-item theme-text">
                            <a href="{{getRouterValue();}}/dashboard/analytics" class="nav-link"> CORK </a>
                        </div>
                    </div>
                    <div class="nav-item sidebar-toggle">
                        <div class="btn-toggle sidebarCollapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                        </div>
                    </div>
                </div>
                <div class="shadow-bottom"></div>
                <ul class="list-unstyled menu-categories" id="accordionExample">
                    <li class="menu {{ Request::is('*/dashboard/*') ? "active" : "" }}">
                        <a href="#dashboard" data-bs-toggle="dropdown" aria-expanded="{{ Request::is('*/dashboard/*') ? "true" : "false" }}" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>Dashboard</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="dropdown-menu submenu list-unstyled" id="dashboard" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('dashboard.index') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/dashboard/DashboardController"> Analytics </a>
                            </li>
                            {{-- <li class="{{ Request::routeIs('sales') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/dashboard/sales"> Sales </a>
                            </li> --}}
                        </ul>
                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>APPLICATIONS</span></div>
                    </li>

                    <li class="menu {{ Request::is('*/master/*') ? "active" : "" }}">
                        <a href="#master" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                                <span>Master</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="dropdown-menu submenu list-unstyled" id="master" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('barang.index') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/master/barang"> Barang </a>
                            </li>                            
                            <li class="{{ Request::routeIs('customer.index') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/master/customer"> Customer </a>
                            </li>
                            <li class="{{ Request::routeIs('kapal.index') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/master/kapal"> Kapal </a>
                            </li>
                            <li class="{{ Request::routeIs('penerima.index') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/master/penerima"> Penerima </a>
                            </li>
                            <li class="{{ Request::routeIs('pol.index') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/master/pol"> Port Of Loading </a>
                            </li>
                            <li class="{{ Request::routeIs('pod.index') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/master/pod"> Port Of Destination </a>
                            </li>
                            <li class="{{ Request::routeIs('gudang-muat.index') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/master/gudang-muat"> Gudang Muat </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>USER INTERFACE</span></div>
                    </li>

                    <li class="menu {{ Request::is('*/document/*') ? "active" : "" }}">
                        <a href="#document" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                <span>Document</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="dropdown-menu submenu list-unstyled" id="document" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('penawaran-harga.index') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/document/penawaran-harga"> Penawaran Harga </a>
                            </li>
                            <li class="{{ Request::routeIs('purchase-order.index') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/document/purchase-order"> Purchase Order </a>
                            </li>
                            <li class="{{ Request::routeIs('tracking.index') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/document/tracking"> Tracking </a>
                            </li>                                                        
                            {{-- <li class="{{ Request::routeIs('surat-perintah-kerja') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/document/surat-perintah-kerja"> Surat Perintah Kerja </a>
                            </li> --}}
                            <li class="{{ Request::routeIs('dooring.index') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/document/dooring"> Dooring </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu {{ Request::is('*/monitoring/*') ? "active" : "" }}">
                        <a href="#document" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                                <span>Monitoring</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="dropdown-menu submenu list-unstyled" id="monitoring" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('mon-tracking.index') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/monitoring/mon-tracking"> Monitoring Tracking </a>
                            </li>
                            <li class="{{ Request::routeIs('mon-dooring.index') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/monitoring/mon-dooring"> Monitoring Doring </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu {{ Request::is('*/element/*') ? "active" : "" }}">
                        <a href="#elements" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <img src="{{Vite::asset('resources/images/rupiah.png')}}" alt="rupiah" width="24" height="24">
                                <span>Finance</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="dropdown-menu submenu list-unstyled" id="elements" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('invoice-dp.index') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/finance/invoice-dp"> Invoice DP </a>
                            </li>
                            <li class="{{ Request::routeIs('invoice-pelunasan.index') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/finance/invoice-pelunasan"> Invoice Pelunasan </a>
                            </li>
                            <li class="{{ Request::routeIs('alerts') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}*alerts"> Laporan Keuangan </a>
                            </li>                            
                        </ul>
                    </li>

                    <li class="menu {{ Request::is('*/report/*') ? "active" : "" }}">
                        <a href="#document" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                                <span>Report History</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="dropdown-menu submenu list-unstyled" id="report" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('penawaran-harga.index') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/report/a"> Monitoring Tracking </a>
                            </li>
                            <li class="{{ Request::routeIs('purchase-order.index') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/report/b"> Monitoring Doring </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>TABLES AND FORMS</span></div>
                    </li>

                    <li class="menu {{ Request::routeIs('table') ? 'active' : '' }} {{ Request::is('*/datatables/*') ? "active" : "" }}">
                        <a href="#tables" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                <span>User Role</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="dropdown-menu submenu list-unstyled" id="tables" data-bs-parent="#accordionExample">

                            <li class="{{ Request::routeIs('table') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}*"> Menu User </a>
                            </li>
                            <li class="{{ Request::routeIs('table') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}*"> Create User </a>
                            </li>

                            {{-- <li class="sub-submenu dropend {{ Request::is('*/datatables/*') ? "active" : "" }}">
                                <a href="#datatable" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle collapsed"> Datatable <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                                <ul class="dropdown-menu list-unstyled sub-submenu" id="datatable" data-bs-parent="#tables"> 
                                    <li class="{{ Request::routeIs('basic') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/datatables/basic"> Basic </a>
                                    </li>
                                    <li class="{{ Request::routeIs('striped-table') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/datatables/striped-table"> Striped </a>
                                    </li>
                                    <li class="{{ Request::routeIs('custom') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/datatables/custom"> Custom </a>
                                    </li>
                                    <li class="{{ Request::routeIs('miscellaneous') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/datatables/miscellaneous"> Miscellaneous </a>
                                    </li>
                                </ul>
                            </li> --}}
                            
                        </ul>
                    </li>

                    {{-- <li class="menu {{ Request::is('*/form/*') ? "active" : "" }}">
                        <a href="#forms" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                                <span>Forms</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="dropdown-menu submenu list-unstyled" id="forms" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('basic') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/basic"> Basic </a>
                            </li>
                            <li class="{{ Request::routeIs('input-group-basic') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/input-group-basic"> Input Group </a>
                            </li>
                            <li class="{{ Request::routeIs('layouts') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/layouts"> Layouts </a>
                            </li>
                            <li class="{{ Request::routeIs('validation') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/validation"> Validation </a>
                            </li>
                            <li class="{{ Request::routeIs('input-mask') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/input-mask"> Input Mask </a>
                            </li>
                            <li class="{{ Request::routeIs('tom-select') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/tom-select"> Tom Select </a>
                            </li>
                            <li class="{{ Request::routeIs('tagify') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/tagify"> Tagify </a>
                            </li>
                            <li class="{{ Request::routeIs('touchspin') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/touchspin"> TouchSpin </a>
                            </li>
                            <li class="{{ Request::routeIs('maxlength') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/maxlength"> Maxlength </a>
                            </li>                          
                            <li class="{{ Request::routeIs('checkbox') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/checkbox"> Checkbox </a>
                            </li>
                            <li class="{{ Request::routeIs('radio') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/radio"> Radio </a>
                            </li>
                            <li class="{{ Request::routeIs('switches') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/switches"> Switches </a>
                            </li>
                            <li class="{{ Request::routeIs('wizard') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/wizard"> Wizards </a>
                            </li>
                            <li class="{{ Request::routeIs('fileupload') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/fileupload"> File Upload </a>
                            </li>
                            <li class="{{ Request::routeIs('quill') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/quill"> Quill Editor </a>
                            </li>
                            <li class="{{ Request::routeIs('markdown') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/markdown"> Markdown Editor </a>
                            </li>
                            <li class="{{ Request::routeIs('date-time-picker') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/date-time-picker"> Date Time Picker </a>
                            </li>
                            <li class="{{ Request::routeIs('slider') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/slider"> Slider </a>
                            </li>
                            <li class="{{ Request::routeIs('clipboard') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/clipboard"> Clipboard </a>
                            </li>
                            <li class="{{ Request::routeIs('autocomplete') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/form/autocomplete"> Auto Complete </a>
                            </li>
                        </ul>
                    </li> --}}

                    {{-- <li class="menu {{ Request::is('*/page/*') ? "active" : "" }} {{ Request::is('*/user/*') ? "active" : "" }}">
                        <a href="#pages" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                <span>Pages</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="dropdown-menu submenu list-unstyled" id="pages" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('knowledge-base') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/page/knowledge-base"> Knowledge Base </a>
                            </li>
                            <li class="{{ Request::routeIs('faq') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/page/faq"> FAQ </a>
                            </li>
                            <li class="{{ Request::routeIs('contact-us') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/page/contact-us"> Contact Form </a>
                            </li>
                            <li class="{{ Request::routeIs('profile') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/user/profile"> Users </a>
                            </li>
                            <li class="{{ Request::routeIs('settings') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/user/settings"> Account Settings </a>
                            </li>
                            <li>
                                <a href="{{getRouterValue();}}/page/404"> Error </a>
                            </li>
                            <li>
                                <a href="{{getRouterValue();}}/page/maintenance"> Maintanence </a>
                            </li>
                            <li class="sub-submenu dropend">
                                <a href="#login" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle collapsed"> Sign In <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                                <ul class="dropdown-menu list-unstyled sub-submenu" id="login" data-bs-parent="#pages"> 
                                    <li>
                                        <a href="{{getRouterValue();}}/authentication/boxed/signin"> Boxed </a>
                                    </li>
                                    <li>
                                        <a href="{{getRouterValue();}}/authentication/cover/signin"> Cover </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sub-submenu dropend">
                                <a href="#signup" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle collapsed"> Sign Up <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                                <ul class="dropdown-menu list-unstyled sub-submenu" id="signup" data-bs-parent="#pages"> 
                                    <li>
                                        <a href="{{getRouterValue();}}/authentication/boxed/signup"> Boxed </a>
                                    </li>
                                    <li>
                                        <a href="{{getRouterValue();}}/authentication/cover/signup"> Cover </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sub-submenu dropend">
                                <a href="#unlock" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle collapsed"> Unlock <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                                <ul class="dropdown-menu list-unstyled sub-submenu" id="unlock" data-bs-parent="#pages"> 
                                    <li>
                                        <a href="{{getRouterValue();}}/authentication/boxed/lockscreen"> Boxed </a>
                                    </li>
                                    <li>
                                        <a href="{{getRouterValue();}}/authentication/cover/lockscreen"> Cover </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sub-submenu dropend">
                                <a href="#reset" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle collapsed"> Reset <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                                <ul class="dropdown-menu list-unstyled sub-submenu" id="reset" data-bs-parent="#pages"> 
                                    <li>
                                        <a href="{{getRouterValue();}}/authentication/boxed/password-reset"> Boxed </a>
                                    </li>
                                    <li>
                                        <a href="{{getRouterValue();}}/authentication/cover/password-reset"> Cover </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sub-submenu dropend">
                                <a href="#twoStep" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle collapsed"> Two Step <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                                <ul class="dropdown-menu list-unstyled sub-submenu" id="twoStep" data-bs-parent="#pages"> 
                                    <li>
                                        <a href="{{getRouterValue();}}/authentication/boxed/2-step-verification"> Boxed </a>
                                    </li>
                                    <li>
                                        <a href="{{getRouterValue();}}/authentication/cover/2-step-verification"> Cover </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li> --}}

                    {{-- <li class="menu {{ Request::routeIs('maps') ? 'active' : '' }} {{ Request::routeIs('charts') ? 'active' : '' }} {{ Request::routeIs('widgets') ? 'active' : '' }} {{ Request::is('*/layout/*') ? "active" : "" }}">
                        <a href="#more" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                <span>More</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="dropdown-menu submenu list-unstyled" id="more" data-bs-parent="#accordionExample">

                            <li class="{{ Request::routeIs('maps') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/maps"> Maps </a>
                            </li>
                            <li class="{{ Request::routeIs('charts') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/charts"> Charts </a>
                            </li>
                            <li class="{{ Request::routeIs('widgets') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/widgets"> Widgets </a>
                            </li>
                            <li class="sub-submenu dropend {{ Request::is('*/layout/*') ? "active" : "" }}">
                                <a href="#layouts" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle collapsed"> Layouts <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                                <ul class="dropdown-menu list-unstyled sub-submenu" id="layouts" data-bs-parent="#more"> 
                                    <li class="{{ Request::routeIs('blank') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/layout/blank"> Blank Page </a>
                                    </li>
                                    <li class="{{ Request::routeIs('empty') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/layout/empty"> Empty Page </a>
                                    </li>
                                    <li class="{{ Request::routeIs('fullWidth') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/layout/full-width"> Full Width </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a target="_blank" href="https://designreset.com/cork/documentation/laravel/index.html"> Documentation </a>
                            </li>
                            <li>
                                <a target="_blank" href="https://designreset.com/cork/documentation/laravel/changelog.html"> Changelog </a>
                            </li>
                            
                        </ul>
                    </li> --}}

                </ul>
                
            </nav>

        </div>