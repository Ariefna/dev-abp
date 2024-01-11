<?php
use App\Http\Controllers\RoleController;


// Route::get('/', function () {
//     return view('welcome', ['title' => 'This is Title', 'breadcrumb' => 'This Breadcrumb']);
// });

/**
 * =======================
 *      LTR ROUTERS
 * =======================
 */


$prefixRouters = [
    'modern-light-menu', 'modern-dark-menu', 'collapsible-menu', 'horizontal-light-menu', 'horizontal-dark-menu'
];



foreach ($prefixRouters as $prefixRouter) {
    Route::prefix('horizontal-dark-menu')->group(function () {
        Route::get('/hash-password', function () {
            $password = "admin";
            $hashedPassword = Hash::make($password);
        
            return $hashedPassword;
        });
        
        // Route::get('/sss', function () {
        //     return view('welcome', ['title' => 'this is ome ', 'breadcrumb' => 'This Breadcrumb']);
        // });
        Route::get('/login', function () {
            return view('auth.login', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
        })->name('login');
        Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
        Route::middleware(['web', 'CheckNamaSession'])->group(function () {
            // Rute untuk proses logout
            Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

            /**
             * ==============================
             *       @Router -  Dashboard
             * ==============================
             */
            
            Route::prefix('dashboard')->group(function () {
                Route::get('/analytics', function () {
                    return view('pages.dashboard.analytics', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('analytics');
                Route::resource('/analytics', \App\Http\Controllers\DashboardController::class);
                Route::match(['get', 'post'], '/analytics/addsisatrack/{no_po}', [\App\Http\Controllers\DashboardController::class, 'addsisatrack'])->name('analytics.addsisatrack');
                Route::match(['get', 'post'], '/analytics/addsisadoor/{id_dooring}', [\App\Http\Controllers\DashboardController::class, 'addsisadoor'])->name('analytics.addsisadoor');
                Route::get('/sales', function () {
                    return view('pages.dashboard.sales', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('sales');
            });

            /**
             * ==============================
             *       @Router -  Master
             * ==============================
             */

            Route::prefix('testing')->group(function () {
                Route::get('/try', function () {
                    return view('pages.abp-page.try', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('trying');
            });

            Route::prefix('master')->group(function () {
                Route::get('/customer', function () {
                    return view('pages.abp-page.mcustomer', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('customer.index');
                Route::resource('/customer', \App\Http\Controllers\CustomerController::class);
                // Route::put('/customer/{customer}', [CustomerController::class, 'update'])->name('customer.update');
                // Route::post('/data-insert', [CustomerController::class, 'store'])->name('data.insert');
                // Route::resource('customer', ); 
                Route::get('/barang', function () {
                    return view('pages.abp-page.mbarang', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('barang.index');
                Route::resource('/barang', \App\Http\Controllers\BarangController::class);
                // Route::delete('/barang/{barang}', [\App\Http\Controllers\BarangController::class, 'softDelete'])->name('barang.softDelete');

                Route::get('/kapal', function () {
                    return view('pages.abp-page.mkapal', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('kapal.index');
                Route::resource('/kapal', \App\Http\Controllers\KapalController::class);
                Route::get('/kapal/cport/getDetails/{id}', [\App\Http\Controllers\KapalController::class, 'getDetails'])->name('getKapalDetails');
                Route::get('/kapal/cport/getEditDetails/{id}', [\App\Http\Controllers\KapalController::class, 'getEditDetails'])->name('getEditDetails');
                Route::resource('/company_port', \App\Http\Controllers\CompanyPortController::class);

                Route::get('/penerima', function () {
                    return view('pages.abp-page.mpenerima', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('penerima.index');                    
                Route::resource('/penerima', \App\Http\Controllers\PenerimaController::class);
                Route::resource('/pt_penerima', \App\Http\Controllers\PTpenerimaController::class);
                Route::resource('/grup', \App\Http\Controllers\GrupController::class);
                // Route::get('/penerima/pen/getPenDetails/{id}', [\App\Http\Controllers\PenerimaController::class, 'getPenDetails'])->name('getPenerimaDetails');
                // Route::get('/penerima/pen/getGroDetails/{id}', [\App\Http\Controllers\PenerimaController::class, 'getGroDetails'])->name('getGroupDetails');


                Route::get('/gudang-muat', function () {
                    return view('pages.abp-page.mgudangmuat', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('gudang-muat.index');
                Route::resource('/gudang-muat', \App\Http\Controllers\GudangMuatController::class);

                Route::get('/pol', function () {
                    return view('pages.abp-page.mpol', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('pol');
                Route::resource('/pol', \App\Http\Controllers\POLController::class);

                Route::get('/pod', function () {
                    return view('pages.abp-page.mpod', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('pod');
                Route::resource('/pod', \App\Http\Controllers\PODController::class);                       
            });

            /**
             * ==============================
             *       @Router -  Document
             * ==============================
             */

            Route::prefix('document')->group(function () {
                Route::get('/penawaran-harga', function () {
                    return view('pages.abp-page.dph', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('penawaran-harga');
                Route::resource('/penawaran-harga', \App\Http\Controllers\PHController::class);
                Route::get('/penawaran-harga/ph/getDetails/{id}', [\App\Http\Controllers\PHController::class, 'getDetails'])->name('getDetails');
                Route::get('/penawaran-harga/ph/getPenDetails/{id}', [\App\Http\Controllers\PHController::class, 'getPenDetails'])->name('getPenDetails');
                Route::post('/penawaran-harga/save', [\App\Http\Controllers\PHController::class, 'save'])->name('penawaran-harga.save');
                Route::match(['get', 'post'], '/penawaran-harga/approve/{id_penawaran}', [\App\Http\Controllers\PHController::class, 'approve'])->name('penawaran-harga.approve');
                Route::match(['get', 'post'], '/penawaran-harga/removed/{id_penawaran}', [\App\Http\Controllers\PHController::class, 'removed'])->name('penawaran-harga.removed');
                Route::match(['get', 'post'], '/penawaran-harga/edit/{id_penawaran}', [\App\Http\Controllers\PHController::class, 'edit'])->name('penawaran-harga.edit');   
                Route::match(['get', 'post'], '/penawaran-harga/updateph/{id_penawaran}', [\App\Http\Controllers\PHController::class, 'updateph'])->name('penawaran-harga.updateph');
                Route::match(['get', 'post','delete'], '/penawaran-harga/removedph/{id_penawaran}', [\App\Http\Controllers\PHController::class, 'removedph'])->name('penawaran-harga.removedph');
                Route::match(['get', 'post'], '/penawaran-harga/updatephd/{id_detail_ph}', [\App\Http\Controllers\PHController::class, 'updatephd'])->name('penawaran-harga.updatephd');
                Route::match(['get', 'post','delete'], '/penawaran-harga/removedphd/{id_detail_ph}', [\App\Http\Controllers\PHController::class, 'removedphd'])->name('penawaran-harga.removedphd');            
                Route::match(['get', 'post'], '/penawaran-harga/document/{id_penawaran}', [\App\Http\Controllers\PHController::class, 'generatepdf'])->name('penawaran-harga.generatepdf');
                
                Route::get('/purchase-order', function () {
                    return view('pages.abp-page.dpo', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('purchase-order.index');
                Route::resource('/purchase-order', \App\Http\Controllers\POController::class);
                Route::get('/purchase-order/po/getCustomerDetails/{id}', [\App\Http\Controllers\POController::class, 'getCustomerDetails'])->name('getCustomerDetails');
                Route::get('/purchase-order/po/getEstateDetails/{id}', [\App\Http\Controllers\POController::class, 'getEstateDetails'])->name('getEstateDetails');
                Route::get('/purchase-order/po/getDetailOA/{id}', [\App\Http\Controllers\POController::class, 'getDetailOA'])->name('getDetailOA');
                Route::match(['get', 'post'], '/purchase-order/approve/{po_muat}', [\App\Http\Controllers\POController::class, 'approve'])->name('purchase-order.approve');
                Route::match(['get', 'post'], '/purchase-order/removed/{po_muat}', [\App\Http\Controllers\POController::class, 'removed'])->name('purchase-order.removed');
                Route::get('/purchase-order/po/downloadpo/{path}', [\App\Http\Controllers\POController::class, 'downloadpo'])->name('downloadpo');

                Route::get('/surat-perintah-kerja', function () {
                    return view('pages.abp-page.dspk', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('surat-perintah-kerja');

                Route::get('/tracking', function () {
                    return view('pages.abp-page.tra', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('tracking.index');
                Route::resource('/tracking', \App\Http\Controllers\DocTrackingController::class);
                Route::get('/tracking/tr/getPo/{id}', [\App\Http\Controllers\DocTrackingController::class, 'getPo'])->name('getPo');
                Route::match(['get', 'post'], '/tracking/savecontainer', [\App\Http\Controllers\DocTrackingController::class, 'savecontainer'])->name('tracking.savecontainer');
                Route::match(['get', 'post'], '/tracking/savecurah', [\App\Http\Controllers\DocTrackingController::class, 'savecurah'])->name('tracking.savecurah');
                Route::match(['put'], '/tracking/cek/batal', [\App\Http\Controllers\DocTrackingController::class, 'batal'])->name('tracking.batal');
                Route::put('/tracking/tr/deletedata/{id_track}/{id_detail_track}/{tonase}', [\App\Http\Controllers\DocTrackingController::class, 'deletedata'])->name('tracking.deletedata');

                Route::get('/dooring', function () {
                    return view('pages.abp-page.dor', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('dooring.index');            
                Route::resource('/dooring', \App\Http\Controllers\DooringController::class);
                Route::get('/dooring/dr/getKapalDooring/{id}/{voyage}', [\App\Http\Controllers\DooringController::class, 'getKapalDooring'])
                        ->where('voyage', '(.*)') // Use a wildcard pattern for 'voyage'
                        ->name('getKapalDooring');
                Route::get('/dooring/dr/getContainer/{id}', [\App\Http\Controllers\DooringController::class, 'getContainer'])->name('getContainer');            
                Route::get('/dooring/dr/getPoDooring/{id}', [\App\Http\Controllers\DooringController::class, 'getPoDooring'])->name('getPoDooring');
                Route::match(['get', 'post'], '/dooring/savecurah', [\App\Http\Controllers\DooringController::class, 'savecurah'])->name('dooring.savecurah');
                Route::match(['get', 'post'], '/dooring/savecontainer', [\App\Http\Controllers\DooringController::class, 'savecontainer'])->name('dooring.savecontainer');
                // Route::match(['delete'], '/dooring/deletedata/{$id}/{$tonase}', [\App\Http\Controllers\DooringController::class, 'deletedata'])->name('dooring.deletedata');
                Route::put('/dooring/dr/deletedata/{id_dooring}/{id_detail_door}/{tonase}', [\App\Http\Controllers\DooringController::class, 'deletedata'])->name('dooring.deletedata');
                // Route::match(['PUT', 'PATCH'], '/dooring/deletedata/{id}/{tonase}', [\App\Http\Controllers\DooringController::class, 'updatedata'])->name('dooring.updatedata');
            });

            /**
             * ==============================
             *       @Router -  Monitoring
             * ==============================
             */
            
            Route::prefix('monitoring')->group(function () {
                Route::get('/mon-tracking', function () {
                    return view('pages.abp-page.montracking', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('mon-tracking.index');
                Route::get('/mon-tracking/print/{id_detail_track}', [\App\Http\Controllers\MTrackingController::class, 'print'])->name('monitoring.tracking.print');
                Route::get('/mon-tracking/print/spk/{id_detail_track}', [\App\Http\Controllers\MTrackingController::class, 'printSPK'])->name('monitoring.tracking.spk');
                Route::resource('/mon-tracking', \App\Http\Controllers\MTrackingController::class);
                Route::get('/mon-tracking/tr/getPoDate/{id}', [\App\Http\Controllers\MTrackingController::class, 'getPoDate'])->name('getPoDate');
                // Route::get('/mon-tracking/tr/getPoKapal/{id_track}/{id}/{voyage}', [\App\Http\Controllers\MTrackingController::class, 'getPoKapal'])->name('getPoKapal');
                Route::get('/mon-tracking/tr/getPoKapal/{id_track}/{id}/{voyage}', [\App\Http\Controllers\MTrackingController::class, 'getPoKapal'])
                    ->where('voyage', '(.*)') // Use a wildcard pattern for 'voyage'
                    ->name('getPoKapal');
                Route::get('/mon-tracking/tr/downloadspktrack/{path}', [\App\Http\Controllers\MTrackingController::class, 'downloadspktrack'])->name('downloadspktrack');
                Route::put('/mon-tracking', [\App\Http\Controllers\MTrackingController::class, 'update'])->name('mon-tracking.update');
                // Route::get('/mon-tracking/download/spk-dooring/{filename}', [\App\Http\Controllers\MTrackingController::class, 'download'])->name('monitoring.down.dooring');
                // Route::put('edit/{id}','ProductController@update')->name('product.update');
                // Route::match(['post'], '/mon-tracking/mt/tambahdt', [\App\Http\Controllers\MTrackingController::class, 'tambahdt'])->name('mon-tracking.tambahdt');
                Route::get('/mon-dooring', function () {
                    return view('pages.abp-page.mondooring', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('mon-dooring.index');
                Route::get('/mon-dooring/print/spk/{id_detail_door}', [\App\Http\Controllers\MDooringController::class, 'printSPK'])->name('monitoring.dooring.spk');
                Route::resource('/mon-dooring', \App\Http\Controllers\MDooringController::class);
                Route::put('/mon-dooring', [\App\Http\Controllers\MDooringController::class, 'update'])->name('mon-dooring.update');
                Route::get('/mon-dooring/dr/downloadfile/{path}', [\App\Http\Controllers\MDooringController::class, 'downloadfile'])->name('downloadfile');
            });

            // routes/web.php

            Route::prefix('report')->group(function () {
                // Define a route for /mon-tracking
                Route::get('/mon-tracking', [\App\Http\Controllers\MTrackingController::class, 'history'])->name('mon-tracking-h.index');
                Route::get('/mon-dooring', [\App\Http\Controllers\MDooringController::class, 'history'])->name('mon-dooring-h.index');
            });


            Route::prefix('finance')->group(function () {
                Route::get('/invoice-dp', function () {
                    return view('pages.abp-page.idp', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('invoice-dp.index');
                Route::resource('/invoice-dp', \App\Http\Controllers\InvoiceDPController::class);
                Route::get('/invoice-dp/dp/getOptionsPO/{id_track}', [\App\Http\Controllers\InvoiceDPController::class, 'getOptionsPO'])->name('getOptionsPO');
                Route::get('/invoice-dp/dp/getDetailPO/{id_track}', [\App\Http\Controllers\InvoiceDPController::class, 'getDetailPO'])->name('getDetailPO');
                Route::get('/invoice-dp/dp/getDetailPOCont/{id_track}', [\App\Http\Controllers\InvoiceDPController::class, 'getDetailPOCont'])->name('getDetailPOCont');
                Route::get('/invoice-dp/get-invoice-number/{id}', [\App\Http\Controllers\InvoiceDPController::class, 'getInvoiceNumber'])->name('getInvoiceNumber');
                Route::get('/invoice-dp/gen/generate', [\App\Http\Controllers\InvoiceDPController::class, 'generate'])->name('generate');
                Route::match(['get', 'post'], '/invoice-dp/approve/{id_invoice_dp}', [\App\Http\Controllers\InvoiceDPController::class, 'approve'])->name('invoice-dp.approve');
                Route::match(['get', 'post'], '/invoice-dp/delete/{id_invoice_dp}', [\App\Http\Controllers\InvoiceDPController::class, 'delete'])->name('invoice-dp.delete');
                Route::match(['get', 'post'], '/invoice-dp/deletedetail/{id_detail_dp}', [\App\Http\Controllers\InvoiceDPController::class, 'deletedetail'])->name('invoice-dp.deletedetail');
                Route::match(['get', 'post'], '/invoice-dp/savecurahidp', [\App\Http\Controllers\InvoiceDPController::class, 'savecurahidp'])->name('invoice-dp.savecurahidp');
                Route::match(['get', 'post'], '/invoice-dp/savecontaineridp', [\App\Http\Controllers\InvoiceDPController::class, 'savecontaineridp'])->name('invoice-dp.savecontaineridp');
                Route::match(['get', 'post'], '/invoice-dp/print/{id_invoice_dp}', [\App\Http\Controllers\InvoiceDPController::class, 'printInvoiceDp'])->name('invoice-dp.print');
                // Route::get('/invoice-dp/print/{id_invoice_dp}', [\App\Http\Controllers\InvoiceDPController::class, 'printInvoiceDp'])->name('invoice-dp.printInvoiceDp');

                Route::get('/invoice-pelunasan', function () {
                    return view('pages.abp-page.ipl', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('invoice-pelunasan.index');            
                Route::resource('/invoice-pelunasan', \App\Http\Controllers\InvoiceLunasController::class);
                Route::match(['get'], '/invoice-pelunasan/cb-tipe-inv/{tipe_inv}', [\App\Http\Controllers\InvoiceLunasController::class, 'tipeinv'])->name('invoice-dp.tipeinv');
                Route::match(['get'], '/invoice-pelunasan/cb-kapal/{cb_kapal}', [\App\Http\Controllers\InvoiceLunasController::class, 'cbkapal'])->name('invoice-dp.cbkapal');
                Route::match(['get'], '/invoice-pelunasan/get-invoice-number/{id}', [\App\Http\Controllers\InvoiceLunasController::class, 'getInvoiceNumber'])->name('invoice-dp.getInvoiceNumber');
                Route::match(['get'], '/invoice-pelunasan/calculate/{id_track}', [\App\Http\Controllers\InvoiceLunasController::class, 'calculate'])->name('invoice-dp.calculate');
                Route::match(['get'], '/invoice-pelunasan/detail/{id}', [\App\Http\Controllers\InvoiceLunasController::class, 'detail'])->name('invoice-dp.detail');
                Route::match(['get', 'post'], '/invoice-pelunasan/store', [\App\Http\Controllers\InvoiceLunasController::class, 'store'])->name('invoice-pelunasan.store');
                Route::match(['get', 'post'], '/invoice-pelunasan/delete/{id}', [\App\Http\Controllers\InvoiceLunasController::class, 'delete'])->name('invoice-pelunasan.delete');
                Route::match(['get', 'post'], '/invoice-pelunasan/deletedetail/{id}', [\App\Http\Controllers\InvoiceLunasController::class, 'deletedetail'])->name('invoice-pelunasan.deletedetail');
                Route::post('/invoice-pelunasan-detail/save', [\App\Http\Controllers\InvoiceLunasController::class, 'detailstore'])->name('invoice-pelunasan-detail.detailstore');
                Route::match(['get', 'post'], '/invoice-pelunasan/approvetimbang/{id_invoice_pel}', [\App\Http\Controllers\InvoiceLunasController::class, 'approvetimbang'])->name('invoice-pelunasan.approvetimbang');
                Route::match(['get', 'post'], '/invoice-pelunasan/approvedooring/{id_invoice_pel}', [\App\Http\Controllers\InvoiceLunasController::class, 'approvedooring'])->name('invoice-pelunasan.approvedooring');
                Route::match(['get', 'post'], '/invoice-pelunasan/print/{id}', [\App\Http\Controllers\InvoiceLunasController::class, 'print'])->name('invoice-pelunasan.print');
               
                // Route::post('/invoice-pelunasan/store', [\App\Http\Controllers\InvoiceLunasController::class, 'store'])->name('store');
            });

            /**
             * ==============================
             *       @Router -  User Role
             * ==============================
             */

             Route::prefix('userrole')->group(function () {
                Route::post('/menuuser/add', [\App\Http\Controllers\MenuUserController::class, 'add'])->name('menuuser.add');
                Route::get('/menuuser', function () {
                    return view('pages.abp-page.menuuser', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('menuuser.index');
                Route::resource('/menuuser', \App\Http\Controllers\MenuUserController::class);
                // Route::delete('/menuuser/{id}/{grupid}', [\App\Http\Controllers\MenuUserController::class, 'destroy'])->name('menuuser.destroy');                
                Route::get('/createuser', function () {
                    return view('pages.abp-page.user', ['title' => 'Adhipramana Bahari Perkasa', 'breadcrumb' => 'This Breadcrumb']);
                })->name('createuser.index');
                Route::resource('/createuser', \App\Http\Controllers\CreateUserController::class);
                Route::post('/createuser/addrole', [\App\Http\Controllers\CreateUserController::class, 'tambahrole'])->name('createuser.addrole');
            });
        });
        
        /**
         * ==============================
         *        @Router -  Apps
         * ==============================
         */
        
        Route::prefix('app')->group(function () {
            Route::get('/calendar', function () {
                return view('pages.app.calendar', ['title' => 'Javascript Calendar | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
            })->name('calendar');
            Route::get('/chat', function () {
                return view('pages.app.chat', ['title' => 'Chat Application | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
            })->name('chat');
            Route::get('/contacts', function () {
                return view('pages.app.contacts', ['title' => 'Contact Profile | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
            })->name('contacts');
            Route::get('/mailbox', function () {
                return view('pages.app.mailbox', ['title' => 'Mailbox | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
            })->name('mailbox');
            Route::get('/notes', function () {
                return view('pages.app.notes', ['title' => 'Notes | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
            })->name('notes');
            Route::get('/scrumboard', function () {
                return view('pages.app.scrumboard', ['title' => 'Scrum Task Board | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('scrumboard');
            Route::get('/todo-list', function () {
                return view('pages.app.todolist', ['title' => 'Todo List | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
            })->name('todolist');
        
            // Blog
        
            Route::prefix('/blog')->group(function () {
                Route::get('/create', function () {
                    return view('pages.app.blog.create', ['title' => 'Blog Create | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('blog-create');
                Route::get('/edit', function () {
                    return view('pages.app.blog.edit', ['title' => 'Blog Edit | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('blog-edit');
                Route::get('/grid', function () {
                    return view('pages.app.blog.grid', ['title' => 'Blog | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('blog-grid');
                Route::get('/list', function () {
                    return view('pages.app.blog.list', ['title' => 'Blog List | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('blog-list');
                Route::get('/post', function () {
                    return view('pages.app.blog.post', ['title' => 'Post Content | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('blog-post');
            });
        
            // Ecommerce
            Route::prefix('/ecommerce')->group(function () {
                Route::get('/add', function () {
                    return view('pages.app.ecommerce.add', ['title' => 'Ecommerce Create | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('ecommerce-add');
                Route::get('/detail', function () {
                    return view('pages.app.ecommerce.detail', ['title' => 'Ecommerce Product Details | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('ecommerce-detail');
                Route::get('/edit', function () {
                    return view('pages.app.ecommerce.edit', ['title' => 'Ecommerce Edit | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('ecommerce-edit');
                Route::get('/list', function () {
                    return view('pages.app.ecommerce.list', ['title' => 'Ecommerce List | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('ecommerce-list');
                Route::get('/shop', function () {
                    return view('pages.app.ecommerce.shop', ['title' => 'Ecommerce Shop | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('ecommerce-shop');
            });
        
            // Invoice
        
            Route::prefix('/invoice')->group(function () {
                Route::get('/add', function () {
                    return view('pages.app.invoice.add', ['title' => 'Invoice Add | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('invoice-add');
                Route::get('/edit', function () {
                    return view('pages.app.invoice.edit', ['title' => 'Invoice Edit | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('invoice-edit');
                Route::get('/list', function () {
                    return view('pages.app.invoice.list', ['title' => 'Invoice List | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('invoice-list');
                Route::get('/preview', function () {
                    return view('pages.app.invoice.preview', ['title' => 'Invoice Preview | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('invoice-preview');
            });
        });
        
        /**
         * ==============================
         *    @Router -  Authentication
         * ==============================
         */
        
        Route::prefix('authentication')->group(function () {
            // Boxed
            
            Route::prefix('/boxed')->group(function () {
                Route::get('/2-step-verification', function () {
                    return view('pages.authentication.boxed.2-step-verification', ['title' => '2 Step Verification Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('2Step');
                Route::get('/lockscreen', function () {
                    return view('pages.authentication.boxed.lockscreen', ['title' => 'LockScreen Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('lockscreen');
                Route::get('/password-reset', function () {
                    return view('pages.authentication.boxed.password-reset', ['title' => 'Password Reset Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('password-reset');
                Route::get('/signin', function () {
                    return view('pages.authentication.boxed.signin', ['title' => 'SignIn Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('signin');
                Route::get('/signup', function () {
                    return view('pages.authentication.boxed.signup', ['title' => 'SignUp Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('signup');
            });
            
            
            // Cover

            Route::prefix('/cover')->group(function () {
                Route::get('/2-step-verification', function () {
                    return view('pages.authentication.cover.2-step-verification', ['title' => '2 Step Verification Boxed | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('2Step');
                Route::get('/lockscreen', function () {
                    return view('pages.authentication.cover.lockscreen', ['title' => 'LockScreen Boxed | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('lockscreen');
                Route::get('/password-reset', function () {
                    return view('pages.authentication.cover.password-reset', ['title' => 'Password Reset Boxed | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('password-reset');
                Route::get('/signin', function () {
                    return view('pages.authentication.cover.signin', ['title' => 'SignIn Boxed | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('signin');
                Route::get('/signup', function () {
                    return view('pages.authentication.cover.signup', ['title' => 'SignUp Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('signup');
            });
            
        });
        
        /**
         * ==============================
         *     @Router -  Components
         * ==============================
         */
        
        Route::prefix('component')->group(function () {
            Route::get('/accordion', function () {
                return view('pages.component.accordion', ['title' => 'Accordions | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('accordion');
            Route::get('/bootstrap-carousel', function () {
                return view('pages.component.bootstrap-carousel', ['title' => 'Bootstrap Carousel | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('bootstrap-carousel');
            Route::get('/cards', function () {
                return view('pages.component.cards', ['title' => 'Card | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('cards');
            Route::get('/drag-drop', function () {
                return view('pages.component.drag-drop', ['title' => 'Dragula Drag and Drop | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('drag-drop');
            Route::get('/flags', function () {
                return view('pages.component.flags', ['title' => 'SVG Flag Icons | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('flags');
            Route::get('/fonticons', function () {
                return view('pages.component.fonticons', ['title' => 'Fonticon Icon | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('fonticons');
            Route::get('/lightbox', function () {
                return view('pages.component.lightbox', ['title' => 'Lightbox | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('lightbox');
            Route::get('/list-group', function () {
                return view('pages.component.list-group', ['title' => 'List Group | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('list-group');
            Route::get('/media-object', function () {
                return view('pages.component.media-object', ['title' => 'Media Object | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('media-object');
            Route::get('/modal', function () {
                return view('pages.component.modal', ['title' => 'Modals | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('modal');
            Route::get('/notification', function () {
                return view('pages.component.notifications', ['title' => 'Snackbar | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('notification');
            Route::get('/pricing-table', function () {
                return view('pages.component.pricing-table', ['title' => 'Pricing Tables | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('pricing-table');
            Route::get('/splide', function () {
                return view('pages.component.splide', ['title' => 'Splide | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('splide');
            Route::get('/sweetalerts', function () {
                return view('pages.component.sweetalert', ['title' => 'SweetAlert | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('sweetalerts');
            Route::get('/tabs', function () {
                return view('pages.component.tabs', ['title' => 'Tabs | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('tabs');
            Route::get('/timeline', function () {
                return view('pages.component.timeline', ['title' => 'Timeline | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('timeline');
        });
        
        /**
         * ==============================
         *     @Router -  Elements
         * ==============================
         */
        Route::prefix('element')->group(function () {
            Route::get('/alerts', function () {
                return view('pages.element.alerts', ['title' => 'Alerts | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('alerts');
            Route::get('/avatar', function () {
                return view('pages.element.avatar', ['title' => ' Avatar | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('avatar');
            Route::get('/badges', function () {
                return view('pages.element.badges', ['title' => ' Badge | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('badges');
            Route::get('/breadcrumbs', function () {
                return view('pages.element.breadcrumbs', ['title' => ' Breadcrumb | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('breadcrumbs');
            Route::get('/buttons', function () {
                return view('pages.element.buttons', ['title' => 'Bootstrap Buttons | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('buttons');
            Route::get('/buttons-group', function () {
                return view('pages.element.buttons-group', ['title' => 'Button Group | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('buttons-group');
            Route::get('/color-library', function () {
                return view('pages.element.color-library', ['title' => 'Color Library | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('color-library');
            Route::get('/dropdown', function () {
                return view('pages.element.dropdown', ['title' => ' Dropdown | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('dropdown');
            Route::get('/infobox', function () {
                return view('pages.element.infobox', ['title' => ' Infobox | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('infobox');
            Route::get('/loader', function () {
                return view('pages.element.loader', ['title' => 'Loaders | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('loader');
            Route::get('/pagination', function () {
                return view('pages.element.pagination', ['title' => 'Pagination | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('pagination');
            Route::get('/popovers', function () {
                return view('pages.element.popovers', ['title' => 'Popovers | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('popovers');
            Route::get('/progressbar', function () {
                return view('pages.element.progressbar', ['title' => 'Bootstrap Progress Bar | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('progressbar');
            Route::get('/search', function () {
                return view('pages.element.search', ['title' => ' Search | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('search');
            Route::get('/tooltips', function () {
                return view('pages.element.tooltips', ['title' => 'Tooltips | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('tooltips');
            Route::get('/treeview', function () {
                return view('pages.element.treeview', ['title' => ' Tree View | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('treeview');
            Route::get('/typography', function () {
                return view('pages.element.typography', ['title' => 'Typography | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('typography');
        });
        
        /**
         * ==============================
         *        @Router -  Forms
         * ==============================
         */
        
        Route::prefix('form')->group(function () {
            Route::get('/autocomplete', function () {
                return view('pages.form.autocomplete', ['title' => 'AutoComplete | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('autocomplete');
            Route::get('/basic', function () {
                return view('pages.form.basic', ['title' => 'Bootstrap Forms | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('basic');
            Route::get('/checkbox', function () {
                return view('pages.form.checkbox', ['title' => 'Checkbox | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('checkbox');
            Route::get('/clipboard', function () {
                return view('pages.form.clipboard', ['title' => 'Clipboard | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('clipboard');
            Route::get('/date-time-picker', function () {
                return view('pages.form.date-time-picker', ['title' => 'Date and Time Picker | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('date-time-picker');
            Route::get('/fileupload', function () {
                return view('pages.form.fileupload', ['title' => 'File Upload | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('fileupload');
            Route::get('/input-group-basic', function () {
                return view('pages.form.input-group-basic', ['title' => 'Input Group | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('input-group-basic');
            Route::get('/input-mask', function () {
                return view('pages.form.input-mask', ['title' => 'Input Mask | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('input-mask');
            Route::get('/layouts', function () {
                return view('pages.form.layouts', ['title' => 'Form Layouts | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('layouts');
            Route::get('/markdown', function () {
                return view('pages.form.markdown', ['title' => 'Markdown Editor | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('markdown');
            Route::get('/maxlength', function () {
                return view('pages.form.maxlength', ['title' => 'Bootstrap Maxlength | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('maxlength');
            Route::get('/quill', function () {
                return view('pages.form.quill', ['title' => 'Quill Editor | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('quill');
            Route::get('/radio', function () {
                return view('pages.form.radio', ['title' => 'Radio | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('radio');
            Route::get('/slider', function () {
                return view('pages.form.slider', ['title' => 'Range Slider | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('slider');
            Route::get('/switches', function () {
                return view('pages.form.switches', ['title' => 'Bootstrap Toggle | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('switches');
            Route::get('/tagify', function () {
                return view('pages.form.tagify', ['title' => 'Tagify | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('tagify');
            Route::get('/tom-select', function () {
                return view('pages.form.tom-select', ['title' => 'Bootstrap Select | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('tom-select');
            Route::get('/touchspin', function () {
                return view('pages.form.touchspin', ['title' => 'Bootstrap Touchspin | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('touchspin');
            Route::get('/validation', function () {
                return view('pages.form.validation', ['title' => 'Bootstrap Form Validation | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('validation');
            Route::get('/wizard', function () {
                return view('pages.form.wizard', ['title' => 'Wizards | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('wizard');
        });
        
        /**
         * ==============================
         *       @Router -  Layouts
         * ==============================
         */
        Route::prefix('layout')->group(function () {
            Route::get('/blank', function () {
                return view('pages.layout.blank', ['title' => 'Blank Page | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
            })->name('blank');
            Route::get('/collapsible-menu', function () {
                return view('pages.layout.collapsible-menu', ['title' => 'Collapsible Menu | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
            })->name('collapsibleMenu');
            Route::get('/full-width', function () {
                return view('pages.layout.full-width', ['title' => 'Full Width | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
            })->name('fullWidth');
            Route::get('/empty', function () {
                return view('pages.layout.empty', ['title' => 'Empty | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
            })->name('empty');
        });
        
        /**
         * ==============================
         *       @Router -  Pages
         * ==============================
         */
        
        Route::prefix('page')->group(function () {
            Route::get('/contact-us', function () {
                return view('pages.page.contact-us', ['title' => 'Contact Us | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('contact-us');
            Route::get('/404', function () {
                return view('pages.page.e-404', ['title' => 'Error | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('404');
            Route::get('/faq', function () {
                return view('pages.page.faq', ['title' => 'FAQs | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('faq');
            Route::get('/knowledge-base', function () {
                return view('pages.page.knowledge-base', ['title' => 'Knowledge Base | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('knowledge-base');
            Route::get('/maintenance', function () {
                return view('pages.page.maintanence', ['title' => 'Maintenence | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('maintenance');
        });
        
        /**
         * ==============================
         *       @Router -  Table
         * ==============================
         */
        Route::get('/table', function () {
            return view('pages.table.basic', ['title' => 'Bootstrap Tables | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
        })->name('table');
        
        
        /**
         * ======================================
         *          @Router -  Datatables
         * ======================================
         */
        Route::prefix('datatables')->group(function () {
            Route::get('/basic', function () {
                return view('pages.table.datatable.basic', ['title' => 'DataTables Basic | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('basic');
            Route::get('/custom', function () {
                return view('pages.table.datatable.custom', ['title' => 'Custom DataTables | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('custom');
            Route::get('/miscellaneous', function () {
                return view('pages.table.datatable.miscellaneous', ['title' => 'Miscellaneous DataTables | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('miscellaneous');
            Route::get('/striped-table', function () {
                return view('pages.table.datatable.striped-table', ['title' => 'DataTables Striped | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('striped-table');
        });
        
        /**
         * ==============================
         *          @Router -  Users
         * ==============================
         */
        
        Route::prefix('user')->group(function () {
            Route::get('/settings', function () {
                return view('pages.user.account-settings', ['title' => 'User Profile | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('settings');
            Route::get('/profile', function () {
                return view('pages.user.profile', ['title' => 'Account Settings | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('profile');
        });
        
        /**
         * ==============================
         *        @Router -  Widgets
         * ==============================
         */
        
        Route::get('/widgets', function () {
            return view('pages.widget.widgets', ['title' => 'Widgets | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
        })->name('widgets');
        
        /**
         * ==============================
         *      @Router -  charts
         * ==============================
         */
        
        Route::get('/charts', function () {
            return view('pages.charts', ['title' => 'Apex Chart | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
        })->name('charts');
        
        /**
         * ==============================
         *       @Router -  Maps
         * ==============================
         */
        Route::get('/maps', function () {
            return view('pages.map', ['title' => 'jVector Maps | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
        })->name('maps');

    });
}


/**
 * =======================
 *      RTL ROUTERS
 * =======================
 */
Route::prefix('rtl')->group(function () {

    $rtlPrefixRouters = [
        'modern-light-menu', 'modern-dark-menu', 'collapsible-menu', 'horizontal-light-menu', 'horizontal-dark-menu'
    ];
    
    foreach ($rtlPrefixRouters as $rtlPrefixRouter) {
        Route::prefix($rtlPrefixRouter)->group(function () {

        
            Route::get('/sss', function () {
                return view('welcome', ['title' => 'this is ome ', 'breadcrumb' => 'This Breadcrumb']);
            });

            /**
             * ==============================
             *       @Router -  Dashboard
             * ==============================
             */
            
            Route::prefix('dashboard')->group(function () {
                Route::get('/analytics', function () {
                    return view('pages-rtl.dashboard.analytics', ['title' => 'CORK Admin - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('analytics');
                Route::get('/sales', function () {
                    return view('pages-rtl.dashboard.sales', ['title' => 'Sales Admin | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('sales');
            });
            
            /**
             * ==============================
             *        @Router -  Apps
             * ==============================
             */
            
            Route::prefix('app')->group(function () {
                Route::get('/calendar', function () {
                    return view('pages-rtl.app.calendar', ['title' => 'Javascript Calendar | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('calendar');
                Route::get('/chat', function () {
                    return view('pages-rtl.app.chat', ['title' => 'Chat Application | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('chat');
                Route::get('/contacts', function () {
                    return view('pages-rtl.app.contacts', ['title' => 'Contact Profile | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('contacts');
                Route::get('/mailbox', function () {
                    return view('pages-rtl.app.mailbox', ['title' => 'Mailbox | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('mailbox');
                Route::get('/notes', function () {
                    return view('pages-rtl.app.notes', ['title' => 'Notes | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('notes');
                Route::get('/scrumboard', function () {
                    return view('pages-rtl.app.scrumboard', ['title' => 'Scrum Task Board | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('scrumboard');
                Route::get('/todo-list', function () {
                    return view('pages-rtl.app.todolist', ['title' => 'Todo List | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('todolist');
            
                // Blog
            
                Route::prefix('/blog')->group(function () {
                    Route::get('/create', function () {
                        return view('pages-rtl.app.blog.create', ['title' => 'Blog Create | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('blog-create');
                    Route::get('/edit', function () {
                        return view('pages-rtl.app.blog.edit', ['title' => 'Blog Edit | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('blog-edit');
                    Route::get('/grid', function () {
                        return view('pages-rtl.app.blog.grid', ['title' => 'Blog | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('blog-grid');
                    Route::get('/list', function () {
                        return view('pages-rtl.app.blog.list', ['title' => 'Blog List | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('blog-list');
                    Route::get('/post', function () {
                        return view('pages-rtl.app.blog.post', ['title' => 'Post Content | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('blog-post');
                });
            
                // Ecommerce
                Route::prefix('/ecommerce')->group(function () {
                    Route::get('/add', function () {
                        return view('pages-rtl.app.ecommerce.add', ['title' => 'Ecommerce Create | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('ecommerce-add');
                    Route::get('/detail', function () {
                        return view('pages-rtl.app.ecommerce.detail', ['title' => 'Ecommerce Product Details | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('ecommerce-detail');
                    Route::get('/edit', function () {
                        return view('pages-rtl.app.ecommerce.edit', ['title' => 'Ecommerce Edit | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('ecommerce-edit');
                    Route::get('/list', function () {
                        return view('pages-rtl.app.ecommerce.list', ['title' => 'Ecommerce List | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('ecommerce-list');
                    Route::get('/shop', function () {
                        return view('pages-rtl.app.ecommerce.shop', ['title' => 'Ecommerce Shop | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('ecommerce-shop');
                });
            
                // Invoice
            
                Route::prefix('/invoice')->group(function () {
                    Route::get('/add', function () {
                        return view('pages-rtl.app.invoice.add', ['title' => 'Invoice Add | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('invoice-add');
                    Route::get('/edit', function () {
                        return view('pages-rtl.app.invoice.edit', ['title' => 'Invoice Edit | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('invoice-edit');
                    Route::get('/list', function () {
                        return view('pages-rtl.app.invoice.list', ['title' => 'Invoice List | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('invoice-list');
                    Route::get('/preview', function () {
                        return view('pages-rtl.app.invoice.preview', ['title' => 'Invoice Preview | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('invoice-preview');
                });
            });
            
            /**
             * ==============================
             *    @Router -  Authentication
             * ==============================
             */
            
            Route::prefix('authentication')->group(function () {
                // Boxed
                
                Route::prefix('/boxed')->group(function () {
                    Route::get('/2-step-verification', function () {
                        return view('pages-rtl.authentication.boxed.2-step-verification', ['title' => '2 Step Verification Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('2Step');
                    Route::get('/lockscreen', function () {
                        return view('pages-rtl.authentication.boxed.lockscreen', ['title' => 'LockScreen Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('lockscreen');
                    Route::get('/password-reset', function () {
                        return view('pages-rtl.authentication.boxed.password-reset', ['title' => 'Password Reset Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('password-reset');
                    Route::get('/signin', function () {
                        return view('pages-rtl.authentication.boxed.signin', ['title' => 'SignIn Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('signin');
                    Route::get('/signup', function () {
                        return view('pages-rtl.authentication.boxed.signup', ['title' => 'SignUp Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('signup');
                });
                
                
                // Cover

                Route::prefix('/cover')->group(function () {
                    Route::get('/2-step-verification', function () {
                        return view('pages-rtl.authentication.cover.2-step-verification', ['title' => '2 Step Verification Boxed | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('2Step');
                    Route::get('/lockscreen', function () {
                        return view('pages-rtl.authentication.cover.lockscreen', ['title' => 'LockScreen Boxed | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('lockscreen');
                    Route::get('/password-reset', function () {
                        return view('pages-rtl.authentication.cover.password-reset', ['title' => 'Password Reset Boxed | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('password-reset');
                    Route::get('/signin', function () {
                        return view('pages-rtl.authentication.cover.signin', ['title' => 'SignIn Boxed | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('signin');
                    Route::get('/signup', function () {
                        return view('pages-rtl.authentication.cover.signup', ['title' => 'SignUp Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('signup');
                });
                
            });
            
            /**
             * ==============================
             *     @Router -  Components
             * ==============================
             */
            
            Route::prefix('component')->group(function () {
                Route::get('/accordion', function () {
                    return view('pages-rtl.component.accordion', ['title' => 'Accordions | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('accordion');
                Route::get('/bootstrap-carousel', function () {
                    return view('pages-rtl.component.bootstrap-carousel', ['title' => 'Bootstrap Carousel | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('bootstrap-carousel');
                Route::get('/cards', function () {
                    return view('pages-rtl.component.cards', ['title' => 'Card | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('cards');
                Route::get('/drag-drop', function () {
                    return view('pages-rtl.component.drag-drop', ['title' => 'Dragula Drag and Drop | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('drag-drop');
                Route::get('/flags', function () {
                    return view('pages-rtl.component.flags', ['title' => 'SVG Flag Icons | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('flags');
                Route::get('/fonticons', function () {
                    return view('pages-rtl.component.fonticons', ['title' => 'Fonticon Icon | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('fonticons');
                Route::get('/lightbox', function () {
                    return view('pages-rtl.component.lightbox', ['title' => 'Lightbox | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('lightbox');
                Route::get('/list-group', function () {
                    return view('pages-rtl.component.list-group', ['title' => 'List Group | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('list-group');
                Route::get('/media-object', function () {
                    return view('pages-rtl.component.media-object', ['title' => 'Media Object | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('media-object');
                Route::get('/modal', function () {
                    return view('pages-rtl.component.modal', ['title' => 'Modals | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('modal');
                Route::get('/notification', function () {
                    return view('pages-rtl.component.notifications', ['title' => 'Snackbar | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('notification');
                Route::get('/pricing-table', function () {
                    return view('pages-rtl.component.pricing-table', ['title' => 'Pricing Tables | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('pricing-table');
                Route::get('/splide', function () {
                    return view('pages-rtl.component.splide', ['title' => 'Splide | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('splide');
                Route::get('/sweetalerts', function () {
                    return view('pages-rtl.component.sweetalert', ['title' => 'SweetAlert | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('sweetalerts');
                Route::get('/tabs', function () {
                    return view('pages-rtl.component.tabs', ['title' => 'Tabs | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('tabs');
                Route::get('/timeline', function () {
                    return view('pages-rtl.component.timeline', ['title' => 'Timeline | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('timeline');
            });
            
            /**
             * ==============================
             *     @Router -  Elements
             * ==============================
             */
            Route::prefix('element')->group(function () {
                Route::get('/alerts', function () {
                    return view('pages-rtl.element.alerts', ['title' => 'Alerts | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('alerts');
                Route::get('/avatar', function () {
                    return view('pages-rtl.element.avatar', ['title' => ' Avatar | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('avatar');
                Route::get('/badges', function () {
                    return view('pages-rtl.element.badges', ['title' => ' Badge | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('badges');
                Route::get('/breadcrumbs', function () {
                    return view('pages-rtl.element.breadcrumbs', ['title' => ' Breadcrumb | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('breadcrumbs');
                Route::get('/buttons', function () {
                    return view('pages-rtl.element.buttons', ['title' => 'Bootstrap Buttons | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('buttons');
                Route::get('/buttons-group', function () {
                    return view('pages-rtl.element.buttons-group', ['title' => 'Button Group | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('buttons-group');
                Route::get('/color-library', function () {
                    return view('pages-rtl.element.color-library', ['title' => 'Color Library | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('color-library');
                Route::get('/dropdown', function () {
                    return view('pages-rtl.element.dropdown', ['title' => ' Dropdown | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('dropdown');
                Route::get('/infobox', function () {
                    return view('pages-rtl.element.infobox', ['title' => ' Infobox | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('infobox');
                Route::get('/loader', function () {
                    return view('pages-rtl.element.loader', ['title' => 'Loaders | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('loader');
                Route::get('/pagination', function () {
                    return view('pages-rtl.element.pagination', ['title' => 'Pagination | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('pagination');
                Route::get('/popovers', function () {
                    return view('pages-rtl.element.popovers', ['title' => 'Popovers | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('popovers');
                Route::get('/progressbar', function () {
                    return view('pages-rtl.element.progressbar', ['title' => 'Bootstrap Progress Bar | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('progressbar');
                Route::get('/search', function () {
                    return view('pages-rtl.element.search', ['title' => ' Search | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('search');
                Route::get('/tooltips', function () {
                    return view('pages-rtl.element.tooltips', ['title' => 'Tooltips | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('tooltips');
                Route::get('/treeview', function () {
                    return view('pages-rtl.element.treeview', ['title' => ' Tree View | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('treeview');
                Route::get('/typography', function () {
                    return view('pages-rtl.element.typography', ['title' => 'Typography | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('typography');
            });
            
            /**
             * ==============================
             *        @Router -  Forms
             * ==============================
             */
            
            Route::prefix('form')->group(function () {
                Route::get('/autocomplete', function () {
                    return view('pages-rtl.form.autocomplete', ['title' => 'AutoComplete | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('autocomplete');
                Route::get('/basic', function () {
                    return view('pages-rtl.form.basic', ['title' => 'Bootstrap Forms | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('basic');
                Route::get('/checkbox', function () {
                    return view('pages-rtl.form.checkbox', ['title' => 'Checkbox | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('checkbox');
                Route::get('/clipboard', function () {
                    return view('pages-rtl.form.clipboard', ['title' => 'Clipboard | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('clipboard');
                Route::get('/date-time-picker', function () {
                    return view('pages-rtl.form.date-time-picker', ['title' => 'Date and Time Picker | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('date-time-picker');
                Route::get('/fileupload', function () {
                    return view('pages-rtl.form.fileupload', ['title' => 'File Upload | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('fileupload');
                Route::get('/input-group-basic', function () {
                    return view('pages-rtl.form.input-group-basic', ['title' => 'Input Group | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('input-group-basic');
                Route::get('/input-mask', function () {
                    return view('pages-rtl.form.input-mask', ['title' => 'Input Mask | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('input-mask');
                Route::get('/layouts', function () {
                    return view('pages-rtl.form.layouts', ['title' => 'Form Layouts | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('layouts');
                Route::get('/markdown', function () {
                    return view('pages-rtl.form.markdown', ['title' => 'Markdown Editor | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('markdown');
                Route::get('/maxlength', function () {
                    return view('pages-rtl.form.maxlength', ['title' => 'Bootstrap Maxlength | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('maxlength');
                Route::get('/quill', function () {
                    return view('pages-rtl.form.quill', ['title' => 'Quill Editor | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('quill');
                Route::get('/radio', function () {
                    return view('pages-rtl.form.radio', ['title' => 'Radio | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('radio');
                Route::get('/slider', function () {
                    return view('pages-rtl.form.slider', ['title' => 'Range Slider | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('slider');
                Route::get('/switches', function () {
                    return view('pages-rtl.form.switches', ['title' => 'Bootstrap Toggle | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('switches');
                Route::get('/tagify', function () {
                    return view('pages-rtl.form.tagify', ['title' => 'Tagify | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('tagify');
                Route::get('/tom-select', function () {
                    return view('pages-rtl.form.tom-select', ['title' => 'Bootstrap Select | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('tom-select');
                Route::get('/touchspin', function () {
                    return view('pages-rtl.form.touchspin', ['title' => 'Bootstrap Touchspin | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('touchspin');
                Route::get('/validation', function () {
                    return view('pages-rtl.form.validation', ['title' => 'Bootstrap Form Validation | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('validation');
                Route::get('/wizard', function () {
                    return view('pages-rtl.form.wizard', ['title' => 'Wizards | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('wizard');
            });
            
            /**
             * ==============================
             *       @Router -  Layouts
             * ==============================
             */
            Route::prefix('layout')->group(function () {
                Route::get('/blank', function () {
                    return view('pages-rtl.layout.blank', ['title' => 'Blank Page | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('blank');
                Route::get('/collapsible-menu', function () {
                    return view('pages-rtl.layout.collapsible-menu', ['title' => 'Collapsible Menu | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('collapsibleMenu');
                Route::get('/full-width', function () {
                    return view('pages-rtl.layout.full-width', ['title' => 'Full Width | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('fullWidth');
                Route::get('/empty', function () {
                    return view('pages-rtl.layout.empty', ['title' => 'Empty | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('empty');
            });
            
            /**
             * ==============================
             *       @Router -  Pages
             * ==============================
             */
            
            Route::prefix('page')->group(function () {
                Route::get('/contact-us', function () {
                    return view('pages-rtl.page.contact-us', ['title' => 'Contact Us | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('contact-us');
                Route::get('/404', function () {
                    return view('pages-rtl.page.e-404', ['title' => 'Error | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('404');
                Route::get('/faq', function () {
                    return view('pages-rtl.page.faq', ['title' => 'FAQs | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('faq');
                Route::get('/knowledge-base', function () {
                    return view('pages-rtl.page.knowledge-base', ['title' => 'Knowledge Base | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('knowledge-base');
                Route::get('/maintenance', function () {
                    return view('pages-rtl.page.maintanence', ['title' => 'Maintenence | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('maintenance');
            });
            
            /**
             * ==============================
             *       @Router -  Table
             * ==============================
             */
            Route::get('/table', function () {
                return view('pages-rtl.table.basic', ['title' => 'Bootstrap Tables | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('table');
            
            
            /**
             * ======================================
             *          @Router -  Datatables
             * ======================================
             */
            Route::prefix('datatables')->group(function () {
                Route::get('/basic', function () {
                    return view('pages-rtl.table.datatable.basic', ['title' => 'DataTables Basic | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('basic');
                Route::get('/custom', function () {
                    return view('pages-rtl.table.datatable.custom', ['title' => 'Custom DataTables | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('custom');
                Route::get('/miscellaneous', function () {
                    return view('pages-rtl.table.datatable.miscellaneous', ['title' => 'Miscellaneous DataTables | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('miscellaneous');
                Route::get('/striped-table', function () {
                    return view('pages-rtl.table.datatable.striped-table', ['title' => 'DataTables Striped | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('striped-table');
            });
            
            /**
             * ==============================
             *          @Router -  Users
             * ==============================
             */
            
            Route::prefix('user')->group(function () {
                Route::get('/settings', function () {
                    return view('pages-rtl.user.account-settings', ['title' => 'User Profile | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('settings');
                Route::get('/profile', function () {
                    return view('pages-rtl.user.profile', ['title' => 'Account Settings | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('profile');
            });
            
            /**
             * ==============================
             *        @Router -  Widgets
             * ==============================
             */
            
            Route::get('/widgets', function () {
                return view('pages-rtl.widget.widgets', ['title' => 'Widgets | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('widgets');
            
            /**
             * ==============================
             *      @Router -  charts
             * ==============================
             */
            
            Route::get('/charts', function () {
                return view('pages-rtl.charts', ['title' => 'Apex Chart | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('charts');
            
            /**
             * ==============================
             *       @Router -  Maps
             * ==============================
             */
            Route::get('/maps', function () {
                return view('pages-rtl.map', ['title' => 'jVector Maps | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
            })->name('maps');

            
        });
    }
    
});