<?php

use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\Content\BannerController;
use App\Http\Controllers\Admin\Content\CategoryController as ContentCategoryController;
use App\Http\Controllers\Admin\Content\FAQController;
use App\Http\Controllers\Admin\Content\MenuController;
use App\Http\Controllers\Admin\Content\PageController;
use App\Http\Controllers\Admin\Content\PostController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Market\AddressController;
use App\Http\Controllers\Admin\Market\BrandController;
use App\Http\Controllers\Admin\Market\CategoryController as MarketCategoryController;
use App\Http\Controllers\Admin\Market\DeliveryController;
use App\Http\Controllers\Admin\Market\DiscountController;
use App\Http\Controllers\Admin\Market\GalleryController;
use App\Http\Controllers\Admin\Market\GuarantyController;
use App\Http\Controllers\Admin\Market\OrderController;
use App\Http\Controllers\Admin\Market\PaymentController;
use App\Http\Controllers\Admin\Market\ProductColorController;
use App\Http\Controllers\Admin\Market\ProductController;
use App\Http\Controllers\Admin\market\PropertyController;
use App\Http\Controllers\Admin\Market\PropertyValueController;
use App\Http\Controllers\Admin\market\StoreController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\Notify\EmailController;
use App\Http\Controllers\Admin\Notify\EmailFileController;
use App\Http\Controllers\Admin\Notify\SMSController;
use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Admin\Ticket\TicketAdminController;
use App\Http\Controllers\Admin\Ticket\TicketCategoryController;
use App\Http\Controllers\Admin\Ticket\TicketController;
use App\Http\Controllers\Admin\Ticket\TicketFileController;
use App\Http\Controllers\Admin\Ticket\TicketPriorityController;
use App\Http\Controllers\Admin\User\AdminUserController;
use App\Http\Controllers\Admin\User\CustomerController;
use App\Http\Controllers\Admin\User\PermissionController;
use App\Http\Controllers\Admin\User\RoleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Website\Customer\HomeController;
use App\Http\Controllers\Website\Customer\Market\ProductController as MarketProductController;
use App\Http\Controllers\Website\Customer\Profile\CustomerProfileController;
use App\Http\Controllers\Website\Customer\Profile\CustomerTicketController;
use App\Http\Controllers\Website\Customer\SalesProcess\CartController;
use App\Http\Controllers\Website\Customer\SalesProcess\PaymentController as CustomerPaymentController;
use App\Http\Controllers\Website\Customer\SalesProcess\ProfileController;
use App\Http\Middleware\ProfileCompletion;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/


Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('', [DashboardController::class, 'index'])->name('admin');

        // Comment Routes
        Route::prefix('comment')->controller(CommentController::class)
            ->name('comment.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/show/{comment}', 'show')->name('show');
                Route::get('/status/{comment}', 'status')->name('status');
                Route::get('/approve/{comment}', 'approve')->name('approve');
                Route::post('/answer/{comment}', 'replyToComment')->name('reply-to-comment');
            });

        // Market Parts are here
        Route::prefix('market')->name('market.')->group(function () {
            // Category Routes
            Route::prefix('category')->controller(MarketCategoryController::class)
                ->name('category.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{category}', 'edit')->name('edit');
                    Route::put('/update/{category}', 'update')->name('update');
                    Route::delete('/destroy/{category}', 'destroy')->name('destroy');
                    Route::get('/status/{category}', 'status')->name('status');
                    Route::get('/show-in-menu/{category}', 'showInMenu')->name('show-in-menu');
                });


            // routes for city and province
            Route::get('provinces', [AddressController::class, 'getProvinces'])->name('provinces');
            Route::get('cities', [AddressController::class, 'getCities'])->name('cities');

            // Brand Routes
            Route::prefix('brand')->controller(BrandController::class)
                ->name('brand.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{brand}', 'edit')->name('edit');
                    Route::put('/update/{brand}', 'update')->name('update');
                    Route::delete('/destroy/{brand}', 'destroy')->name('destroy');
                    Route::get('/status/{brand}', 'status')->name('status');
                });


            // Delivery Routes
            Route::prefix('delivery')->controller(DeliveryController::class)
                ->name('delivery-method.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{delivery}', 'edit')->name('edit');
                    Route::put('/update/{delivery}', 'update')->name('update');
                    Route::delete('/destroy/{delivery}', 'destroy')->name('destroy');
                    Route::get('/status/{delivery}', 'status')->name('status');
                });


            // Discount Routes
            Route::prefix('discount')->controller(DiscountController::class)->name('discount.')->group(function () {
                Route::prefix('coupon')->group(function () {
                    // common discounts
                    Route::get('/', 'couponIndex')->name('coupon-index');
                    Route::get('/create', 'couponCreate')->name('coupon-create');
                    Route::post('/store', 'couponStore')->name('coupon-store');
                    Route::get('/edit/{coupon}', 'couponEdit')->name('coupon-edit');
                    Route::put('/update/{coupon}', 'couponUpdate')->name('coupon-update');
                    Route::delete('/destroy/{coupon}', 'couponDestroy')->name('coupon-destroy');
                    Route::get('/status/{coupon}', 'couponStatus')->name('coupon-status');
                });

                Route::prefix('common-discount')->group(function () {
                    // common discounts
                    Route::get('/', 'commonDiscountIndex')->name('common-discount-index');
                    Route::get('/create', 'commonDiscountCreate')->name('common-discount-create');
                    Route::get('/search-user', 'searchUser')->name('search-user');
                    Route::post('/store', 'commonDiscountStore')->name('common-discount-store');
                    Route::get('/edit/{discount}', 'commonDiscountEdit')->name('common-discount-edit');
                    Route::put('/update/{discount}', 'commonDiscountUpdate')->name('common-discount-update');
                    Route::delete('/destroy/{discount}', 'commonDiscountDestroy')->name('common-discount-destroy');
                    Route::get('/create', 'commonDiscountCreate')->name('common-discount-create');
                    Route::get('/status/{discount}', 'commonDiscountStatus')->name('common-discount-status');
                });

                Route::prefix('amazing-sale')->group(function () {
                    //amazing sale discounts
                    Route::get('/', 'amazingSaleIndex')->name('amazing-sale-index');
                    Route::get('/create', 'amazingSaleCreate')->name('amazing-sale-create');
                    Route::get('/search-product', 'searchProduct')->name('search-product');
                    Route::post('/store', 'amazingSaleStore')->name('amazing-sale-store');
                    Route::get('/edit/{amazingSale}', 'amazingSaleEdit')->name('amazing-sale-edit');
                    Route::put('/update/{amazingSale}', 'amazingSaleUpdate')->name('amazing-sale-update');
                    Route::delete('/destroy/{amazingSale}', 'amazingSaleDestroy')->name('amazing-sale-destroy');
                    Route::get('/status/{amazingSale}', 'amazingSaleStatus')->name('amazing-sale-status');

                    // this route should be used in ajax to retrieve all products data ( or products with the lowest sell )
                    Route::get('/products-details', 'productsDetails')->name('amazing-sale.products-details');
                });
            });


            // Order Routes
            Route::prefix('order')->controller(OrderController::class)
                ->name('order.')->group(function () {
                    Route::get('/', 'all')->name('all');
                    Route::get('/new-order', 'newOrder')->name('newOrder');
                    Route::get('/sending', 'sending')->name('sending');
                    Route::get('/unpaid', 'unpaid')->name('unpaid');
                    Route::get('/canceled', 'canceled')->name('canceled');
                    Route::get('/returned', 'returned')->name('returned');
                    Route::get('/change-delivery-status/{order}', 'changeDeliveryStatus')->name('change-delivery-status');
                    Route::get('/change-order-status/{order}', 'changeOrderStatus')->name('change-order-status');
                    Route::get('/cancel-order/{order}', 'cancelOrder')->name('cancel-order');
                    Route::get('/approve/{order}', 'approveOfflinePayment')->name('approve-offline-payment');

                    Route::delete('/destroy/{order}', 'destroy')->name('destroy');
                    Route::get('/order-details/{order}', 'orderDetails')->name('order-details'); // show order
                    Route::get('/print/{order}', 'print')->name('print'); // show order
                    Route::get('/show/{order}', 'show')->name('show');
                });

            // Payment Routes
            Route::prefix('payment')->controller(PaymentController::class)
                ->name('payment.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/payment-print', 'paymentPrint')->name('payment-print');
                    Route::get('/online', 'online')->name('online');
                    Route::get('/offline', 'offline')->name('offline');
                    Route::get('/cash', 'cash')->name('cash');
                    Route::get('/confirm', 'confirm')->name('confirm');
                    Route::get('/show/{payment}', 'show')->name('show');
                    Route::get('/payed-or-pending/{payment}', 'payedOrPending')->name('payed-or-pending');
                    Route::get('/canceled-or-returned/{payment}', 'cancelOrReturned')->name('cancel-or-returned');
                });

            // Product Routes
            Route::prefix('product')->controller(ProductController::class)
                ->name('product.')->group(function () {
                    Route::get('/', 'index')->name('index'); // show index page
//                    Route::get('/{store}', 'storedProductIndex')->name('stored-product-index');
                    Route::get('/show/{product}', 'show')->name('show'); // show product
                    Route::get('/create', 'create')->name('create'); // show create product page
//                    Route::get('/createProductForStore/{store}', 'createProductForStore')->name('create-product-for-store');
                    Route::post('/store', 'store')->name('store'); // store product in db
                    Route::get('/edit/{product}', 'edit')->name('edit'); // show edit product page
                    Route::put('/update/{product}', 'update')->name('update'); // update product
                    Route::delete('/destroy/{product}', 'destroy')->name('destroy'); // delete product
                    Route::get('/status/{product}', 'status')->name('status'); // change status of product
                    Route::get('/marketable/{product}', 'marketable')->name('marketable'); // change marketable status of the product

                    // Product Gallery Routes
                    Route::prefix('gallery')->controller(GalleryController::class)
                        ->name('gallery.')->group(function () {
                            Route::get('/{product}', 'index')->name('index');
                            Route::get('/create/{product}', 'create')->name('create');
                            Route::post('/store/{product}', 'store')->name('store');
                            Route::delete('/destroy/{gallery}', 'destroy')->name('destroy');
                        });

                    // product colors
                    Route::prefix('color')->controller(ProductColorController::class)
                        ->name('color.')->group(function () {
                            Route::get('/{product}', 'index')->name('index');
                            Route::get('/{product}/create', 'create')->name('create');
                            Route::get('/{product}/edit/{color}', 'edit')->name('edit');
                            Route::put('/{product}/update/{color}', 'update')->name('update');
                            Route::post('/{product}/store', 'store')->name('store');
                            Route::delete('/destroy/{product}/{color}', 'destroy')->name('destroy');
                            Route::get('/status/{color}', 'status')->name('status');
                        });

                    // guaranty routes
                    Route::prefix('guaranty')->controller(GuarantyController::class)
                        ->name('guaranty.')->group(function () {
                            Route::get('/{product}', 'index')->name('index');
                            Route::get('/{product}/create', 'create')->name('create');
                            Route::get('/{product}/edit/{guaranty}', 'edit')->name('edit');
                            Route::put('/{product}/update/{guaranty}', 'update')->name('update');
                            Route::post('/{product}/store', 'store')->name('store');
                            Route::delete('/destroy/{product}/{guaranty}', 'destroy')->name('destroy');
                            Route::get('/status/{guaranty}', 'status')->name('status');
                        });
                });

            //store
            Route::prefix('store')->controller(StoreController::class)
                ->name('store.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/add-to-store/{product}', 'addToStore')->name('add-to-store');
                    Route::post('/store/{product}', 'store')->name('store');
                    Route::get('/edit/{product}', 'edit')->name('edit');
                    Route::put('/update/{product}', 'update')->name('update');
                });

            // Product Category Attribute Routes
            Route::prefix('property')->controller(PropertyController::class)
                ->name('property.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/show', 'show')->name('show');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{attribute}', 'edit')->name('edit');
                    Route::put('/update/{attribute}', 'update')->name('update');
                    Route::delete('/destroy/{attribute}', 'destroy')->name('destroy');


                    //product category attribute values
                    Route::prefix('value')->controller(PropertyValueController::class)
                        ->name('value.')->group(function () {
                            Route::get('/{attribute}', 'index')->name('index');
                            Route::get('/create/{attribute}', 'create')->name('create');
                            Route::post('/store/{attribute}', 'store')->name('store');
                            Route::get('/edit/{attribute}/{value}', 'edit')->name('edit');
                            Route::put('/update/{attribute}/{value}', 'update')->name('update');
                            Route::delete('/destroy/{attribute}/{value}', 'destroy')->name('destroy');
                        });
                });


        });


        // Content Parts are here
        // Content Routes
        Route::prefix('content')->name('content.')->group(function () {
            // Category Routes
            Route::prefix('category')->controller(ContentCategoryController::class)
                ->name('category.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{postCategory}', 'edit')->name('edit');
                    Route::put('/update/{postCategory}', 'update')->name('update');
                    Route::delete('/destroy/{postCategory}', 'destroy')->name('destroy');
                    Route::get('/status/{postCategory}', 'status')->name('status');
                });

            // Post Routes
            Route::prefix('post')->controller(PostController::class)
                ->name('post.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::get('/show/{post}', 'show')->name('show');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{post}', 'edit')->name('edit');
                    Route::put('/update/{post}', 'update')->name('update');
                    Route::delete('/destroy/{post}', 'destroy')->name('destroy');
                    Route::get('/status/{post}', 'status')->name('status');
                    Route::get('/commentable/{post}', 'commentable')->name('commentable');

                });

            // Menu Routes
            Route::prefix('menu')->controller(MenuController::class)
                ->name('menu.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{menu}', 'edit')->name('edit');
                    Route::put('/update/{menu}', 'update')->name('update');
                    Route::delete('/destroy/{menu}', 'destroy')->name('destroy');
                    Route::get('/status/{menu}', 'status')->name('status');
                });

            // banner Routes
            Route::prefix('banner')->controller(BannerController::class)
                ->name('banner.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{banner}', 'edit')->name('edit');
                    Route::put('/update/{banner}', 'update')->name('update');
                    Route::delete('/destroy/{banner}', 'destroy')->name('destroy');
                    Route::get('/status/{banner}', 'status')->name('status');
                });


            // FAQ Routes
            Route::prefix('faq')->controller(FAQController::class)
                ->name('faq.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{faq}', 'edit')->name('edit');
                    Route::put('/update/{faq}', 'update')->name('update');
                    Route::delete('/destroy/{faq}', 'destroy')->name('destroy');
                    Route::get('/status/{faq}', 'status')->name('status');
                });

            // Page Builder Routes
            Route::prefix('page')->controller(PageController::class)
                ->name('page.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{page}', 'edit')->name('edit');
                    Route::put('/update/{page}', 'update')->name('update');
                    Route::delete('/destroy/{page}', 'destroy')->name('destroy');
                    Route::get('/status/{page}', 'status')->name('status');
                    Route::get('/show-in-menu/{page}', 'showInMenu')->name('show-in-menu');
                });
        });

// User Part Routes
        Route::prefix('user')->name('user.')->group(function () {
            // Admin Users Route
            Route::prefix('admin-user')->controller(AdminUserController::class)
                ->name('admin-user.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{admin}', 'edit')->name('edit');
                    Route::put('/update/{admin}', 'update')->name('update');
                    Route::delete('/destroy/{admin}', 'destroy')->name('destroy');
                    Route::get('/status/{admin}', 'status')->name('status');
                    Route::get('/activation/{admin}', 'activation')->name('activation');
                    Route::get('/roles/{admin}', 'roles')->name('roles');
                    Route::post('/roles/{admin}/store', 'rolesStore')->name('roles-store');
                    Route::get('/permissions/{admin}', 'permissions')->name('permissions');
                    Route::post('/permissions/{admin}/store', 'permissionsStore')->name('permissions-store');
                });

            // Customer Users Route
            Route::prefix('app')->controller(CustomerController::class)
                ->name('app.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{app}', 'edit')->name('edit');
                    Route::put('/update/{app}', 'update')->name('update');
                    Route::delete('/destroy/{app}', 'destroy')->name('destroy');
                    Route::get('/status/{app}', 'status')->name('status');
                    Route::get('/activation/{app}', 'activation')->name('activation');
                });

            // Role Routes
            Route::prefix('role')->controller(RoleController::class)
                ->name('role.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{role}', 'edit')->name('edit');
                    Route::put('/update/{role}', 'update')->name('update');
                    Route::delete('/destroy/{role}', 'destroy')->name('destroy');
                    Route::get('/status/{role}', 'status')->name('status');
                    Route::get('/permission-form/{role}', 'permissionForm')->name('permissionForm');
                    Route::put('/permission-update/{role}', 'permissionUpdate')->name('permissionUpdate');

                });

            // Permission Routes
            Route::prefix('permission')->controller(PermissionController::class)
                ->name('permission.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{permission}', 'edit')->name('edit');
                    Route::put('/update/{permission}', 'update')->name('update');
                    Route::delete('/destroy/{permission}', 'destroy')->name('destroy');
                    Route::get('/status/{permission}', 'status')->name('status');
                });

        });

// Notify Routes
        Route::prefix('notify')->name('notify.')->group(function () {
            // Email Routes
            Route::prefix('email')->controller(EmailController::class)
                ->name('email.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{email}', 'edit')->name('edit');
                    Route::put('/update/{email}', 'update')->name('update');
                    Route::delete('/destroy/{email}', 'destroy')->name('destroy');
                    Route::get('/status/{email}', 'status')->name('status');
                    Route::get('/send/{email}', 'sendEmail')->name('send-email');
                });

            // Email File Routes
            Route::prefix('email-file')->controller(EmailFileController::class)
                ->name('email-file.')->group(function () {
                    Route::get('/{email}', 'index')->name('index');
                    Route::get('/{email}/create', 'create')->name('create');
                    Route::post('/{email}/store', 'store')->name('store');
                    Route::get('/edit/{file}', 'edit')->name('edit');
                    Route::put('/update/{file}', 'update')->name('update');
                    Route::delete('/destroy/{file}', 'destroy')->name('destroy');
                    Route::get('/status/{file}', 'status')->name('status');
                });

            // SMS Routes
            Route::prefix('sms')->controller(SMSController::class)
                ->name('sms.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/show/{sms}', 'show')->name('show');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{message}', 'edit')->name('edit');
                    Route::put('/update/{message}', 'update')->name('update');
                    Route::delete('/destroy/{message}', 'destroy')->name('destroy');
                    Route::get('/status/{message}', 'status')->name('status');
                    Route::get('/send/{message}', 'sendSMS')->name('send-sms');

                });
        });


// Ticket Routes
        Route::prefix('ticket')->name('ticket.')->group(function () {
            // Ticket Routes
            Route::prefix('ticket')->controller(TicketController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/new-tickets', 'newTickets')->name('new-tickets');
                Route::get('/open-tickets', 'openTickets')->name('open-tickets');
                Route::get('/closed-tickets', 'closedTickets')->name('closed-tickets');
                Route::get('/show/{ticket}', 'show')->name('show');
                Route::post('/answer/{ticket}', 'answer')->name('answer');
                Route::get('/change/{ticket}', 'change')->name('change');
            });

            // Ticket Category Routes
            Route::prefix('category')->controller(TicketCategoryController::class)
                ->name('category.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/show', 'show')->name('show');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{category}', 'edit')->name('edit');
                    Route::put('/update/{category}', 'update')->name('update');
                    Route::delete('/destroy/{category}', 'destroy')->name('destroy');
                    Route::get('/status/{category}', 'status')->name('status');
                });

            // Ticket Priority Routes
            Route::prefix('priority')->controller(TicketPriorityController::class)
                ->name('priority.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/show', 'show')->name('show');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{priority}', 'edit')->name('edit');
                    Route::put('/update/{priority}', 'update')->name('update');
                    Route::delete('/destroy/{priority}', 'destroy')->name('destroy');
                    Route::get('/status/{priority}', 'status')->name('status');
                });

            // Ticket Admin Routes
            Route::prefix('admin')->controller(TicketAdminController::class)
                ->name('admin.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/set/{admin}', 'set')->name('set');

                });

            // Ticket File Routes
            Route::prefix('file')->controller(TicketFileController::class)
                ->name('file.')->group(function () {
                    Route::get('/{ticket}', 'index')->name('index');
                });
        });


        Route::prefix('setting')->controller(SettingController::class)
            ->name('setting.')->group(function () {
                // setting Routes
                Route::get('/', 'index')->name('index');
                Route::get('/edit/{setting}', 'edit')->name('edit');
                Route::put('/update/{setting}', 'update')->name('update');
                Route::delete('/destroy/{setting}', 'destroy')->name('destroy');
            });

        // notifications routes
        Route::prefix('notification')->controller(NotificationController::class)
            ->name('notification.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/read-all', 'readAll')->name('read-all');
            });
    })->middleware(['auth', 'verified']);


Route::prefix('auth')
    ->name('auth.')
    ->group(function () {

        Route::get('form', [AuthController::class, 'form'])->name('form');
        Route::get('confirm/{token}', [AuthController::class, 'loginConfirmForm'])->name('login-confirm-form');

        Route::middleware('throttle:auth-limiter')->post('/auth', [AuthController::class, 'auth'])->name('auth');
        Route::middleware('throttle:login-confirm-limiter')->post('/login-confirm/{token}', [AuthController::class, 'loginConfirm'])->name('login-confirm.token');
        Route::middleware('throttle:login-resend-otp-limiter')->get('/login-resend-otp/{token}', [AuthController::class, 'loginResendOtp'])->name('login-resend-otp');


        // register related routes
        Route::get('register-form',[AuthController::class,'registerCreate'])->name('register.create');
        Route::post('register-send-otp',[AuthController::class,'registerSendOtp'])->name('register-send-otp');

        // logout route
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

        // redirect to dashboard route
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    });


Route::prefix('customer')
    ->name('customer.')
    ->group(function () {

        Route::post('/rating/{product}', [MarketProductController::class, 'rating'])->name('product.rating');

        Route::prefix('dashboard')->middleware(ProfileCompletion::class)->name('dashboard.')->group(function () {
            Route::get('/', [AuthController::class, 'dashboard'])->name('index');

            Route::get('/tickets', [CustomerTicketController::class, 'index'])->name('ticket-customer');
            Route::get('/tickets/create', [CustomerTicketController::class, 'create'])->name('customer-ticket.create');
            Route::get('/tickets/show/{ticket}', [CustomerTicketController::class, 'show'])->name('customer-ticket.show');
            Route::post('/tickets/store', [CustomerTicketController::class, 'store'])->name('customer-ticket.store');
            Route::get('/tickets/change/{ticket}', [CustomerTicketController::class, 'change'])->name('customer-ticket.change');
            Route::post('/tickets/answer/{ticket}', [CustomerTicketController::class, 'answer'])->name('customer-ticket.answer');

            Route::prefix('profile')->controller(CustomerProfileController::class)
                ->name('profile.')->group(function () {
                    Route::get('/', 'profile')->name('profile');
                    Route::get('/order', 'order')->name('order');
                    Route::get('/address', 'address')->name('address');
                    Route::post('/add-address', 'addAddress')->name('add-address');
                    Route::put('/update-address/{address}', 'updateAddress')->name('update-address');
                    Route::get('/favorite', 'favorite')->name('favorite');
                    Route::get('/compare', 'compare')->name('compare');
                    Route::get('/delete-from-favorite/{product}', 'deleteFromFavorites')->name('delete-from-favorite');
                    Route::delete('/delete-from-compare/{product}', 'deleteFromCompare')->name('delete-from-compare');
                    Route::get('/edit-profile', 'editProfile')->name('edit-profile');
                    Route::put('/update-profile', 'updateProfile')->name('update-profile');

                });


        });


        Route::prefix('sales-process')->group(function () {
            //cart section
            Route::get('/cart', [CartController::class, 'cart'])->name('cart');
            Route::post('/cart', [CartController::class, 'updateCart'])->name('update-cart');
            Route::post('/add-to-cart/{product:slug}', [CartController::class, 'addToCart'])->name('add-to-cart');
            Route::post('/ajax-add-to-cart/{product:slug}', [CartController::class, 'ajaxAddToCart'])->name('ajax-add-to-cart');
            Route::get('/remove-from-cart/{cartItem}', [CartController::class, 'removeFromCart'])->name('remove-from-cart');


            // user profile
            Route::prefix('profile')->controller(ProfileController::class)->name('profile.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/update', 'update')->name('update');
                Route::get('/confirm/{token}', 'confirmForm')->name('confirm-form');
                Route::middleware('throttle:admin-login-confirm-limiter')->post('/confirm/{token}', 'confirm')->name('confirm');
            });

            Route::middleware('profile.completion')->group(function () {
                // address and delivery section
                Route::get('/address-and-delivery', [AddressController::class, 'addressAndDelivery'])->name('address-and-delivery');
                Route::get('/get-delivery-price', [AddressController::class, 'getDeliveryPrice'])->name('get-delivery-price');
                Route::post('/add-address', [AddressController::class, 'addAddress'])->name('add-address');
                Route::put('/update-address/{address}', [AddressController::class, 'updateAddress'])->name('update-address');
                Route::get('/get-provinces', [AddressController::class, 'getProvinces'])->name('get-provinces');
                Route::delete('/remove-address/{address}', [AddressController::class, 'removeAddress'])->name('remove-address');
                Route::get('/get-cities/{province}', [AddressController::class, 'getCities'])->name('get-cities');
                Route::post('/select-address-and-delivery', [AddressController::class, 'selectAddressAndDelivery'])->name('select-address-and-delivery');

                // payment
                Route::get('/payment', [CustomerPaymentController::class, 'payment'])->name('payment');
                Route::post('/payment-submit', [CustomerPaymentController::class, 'paymentSubmit'])->name('payment-submit');
                Route::post('/coupon-discount', [CustomerPaymentController::class, 'couponDiscount'])->name('coupon-discount');
                Route::any('/payment-callback/{order}/{onlinePayment}', [CustomerPaymentController::class, 'paymentCallback'])->name('payment-callback');
            });
        });
    });



Route::controller(HomeController::class)->group(function () {

    Route::get('/', 'home')->name('app.home');
    Route::get('/products/{category:slug?}', 'products')->name('home.products');
    Route::get('/{page:slug}', 'page')->name('app.page');
});

Route::namespace('Http\Controllers\Website\Customer\Market')->name('market.')->group(function () {
    Route::get('/product/{product:slug}', [MarketProductController::class, 'product'])->name('product');
    Route::get('/ajax-search', [MarketProductController::class, 'ajaxProductSearch'])->name('ajax-product-search');
    Route::get('/product-category/{category:slug}', [MarketProductController::class, 'productCategory'])->name('product-category');
    Route::post('/add-comment/product/{product:slug}', [MarketProductController::class, 'addComment'])->name('add-comment');
    Route::get('/add-to-favorite/product/{product:slug}', [MarketProductController::class, 'addToFavorite'])->name('add-to-favorite');
    Route::get('/add-to-compare/product/{product:slug}', [MarketProductController::class, 'addToCompare'])->name('add-to-compare');

});

