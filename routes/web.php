<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\Pos\CartController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\Report\ReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\User\PermissionController;
use App\Http\Controllers\Admin\User\RoleController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\TestController;
use App\Models\Customer;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('auth.login.show');
});
Route::get('/login', [AuthController::class, 'loginView'])->name('login');

// auth routes
Route::prefix('auth')->as('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'loginView'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/sign-up', [AuthController::class, 'signupView'])->name('signup.show');
    Route::post('/sign-up', [AuthController::class, 'signup'])->name('signup');
    Route::get('/forgot-password', [AuthController::class, 'forgotPasswordView'])->name('forgot-password.show');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordView'])->name('reset-password.show');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
    Route::get('/profile', [AuthController::class, 'profileView'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/avatar', [AuthController::class, 'updateAvatar'])->name('avatar.update');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

// admin routes
Route::prefix('admin')->as('admin.')->middleware('auth')->group(function () {
    // dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::as('users.')->group(function () {
        Route::resource('roles', RoleController::class);
        Route::post('/roles/{role}/update-permissions', [RoleController::class, 'updatePermissions'])->name('roles.updatePermissions');
        Route::resource('permissions', PermissionController::class);
    });

    Route::resource('brands', BrandController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('units', UnitController::class);
    Route::resource('products', ProductController::class);
    Route::resource('customers',  CustomerController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::get('purchase/products/{id}', [PurchaseController::class, 'purchaseProducts'])->name('purchase.products');
    Route::resource('sales', SaleController::class);
    Route::get('/sales/invoice/{id}', [SaleController::class, 'invoice'])->name('sales.invoice');
    Route::get('/sales/payments/invoice/{id}', [SaleController::class, 'collectionInvoice'])->name('sales.payments.invoice');
    Route::get('/sales/payments/{id}', [SaleController::class, 'payments'])->name('sales.payments');
    Route::any('/sales/payments/create/{id}', [SaleController::class, 'paymentCollection'])->name('sales.payments.create');

    // start pos
    Route::get('/get/products', [CartController::class, 'getProducts'])->name('getProducts');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/increment', [CartController::class, 'increment']);
    Route::put('/cart/decrement', [CartController::class, 'decrement']);
    Route::put('/cart/delete', [CartController::class, 'delete']);
    Route::put('/cart/empty', [CartController::class, 'empty']);
    Route::put('/order/create', [SaleController::class, 'store']);
    Route::get('/get/customers', [CustomerController::class, 'getCustomers']);
    Route::post('/create/customers', [CustomerController::class, 'store']);
    //end pos
 //start report

    Route::get('/sale/summery', [ReportController::class, 'saleSummery'])->name('sale.summery');
    Route::get('/sale/report', [ReportController::class, 'saleReport'])->name('sale.report');
    Route::get('/inventory/report', [ReportController::class, 'inventoryReport'])->name('inventory.report');
    //end report

    // setting routes
    Route::prefix('/settings')->as('settings.')->controller(SettingController::class)->group(function () {
        Route::get('/{type}/edit', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');
        Route::prefix('/sms/providers')->as('sms.')->group(function () {
            Route::get('/{name}', 'smsProvider');
            Route::post('/update', 'updateSmsProviders')->name('providers.update');
            Route::get('/test/{provider}', [SmsController::class, 'testSms']);
        });
    });
});

// test routes
Route::get('/test', [TestController::class, 'index']);


// cta-routes routes

Route::prefix('cta-routes')->group(function () {
    Route::get('/storage-link', function () {
        Artisan::call('storage:link');
        return back()->with('message', 'Storage link created successfully.');
    });

    Route::get('/optimize-clear', function () {
        Artisan::call('optimize:clear');
        return back()->with('message', 'Application optimized and cache cleared.');
    });

    Route::get('/cache-clear', function () {
        Artisan::call('cache:clear');
        return back()->with('message', 'Application cache cleared.');
    });

    Route::get('/config-cache', function () {
        Artisan::call('config:cache');
        return back()->with('message', 'Configuration cache created successfully.');
    });

    Route::get('/migrate', function () {
        Artisan::call('migrate');
        return back()->with('message', 'Database migration completed successfully.');
    });

    Route::get('/migrate-fresh', function () {
        Artisan::call('migrate:fresh');
        return back()->with('message', 'Database migration refreshed successfully.');
    });

    Route::get('/migrate-seed', function () {
        Artisan::call('db:seed');
        return back()->with('message', 'Database seeded successfully.');
    });
});
