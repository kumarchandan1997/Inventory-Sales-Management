<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\AdminController;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', [HomeController::class, 'redirectUser'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

   // Admin routes
    Route::middleware('role:admin')->group(function () {
         Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::resource('products', ProductController::class);
    });

    Route::middleware(['auth', 'role:salesperson,admin'])->group(function () {

        Route::get('/sales-orders/create', [SalesOrderController::class, 'create'])->name('sales-orders.create');
        Route::post('/sales-orders', [SalesOrderController::class, 'store'])->name('sales-orders.store');
        Route::get('/sales-orders/{order}/pdf', [SalesOrderController::class, 'downloadPdf'])->name('sales-orders.pdf');
    });


    // Salesperson routes
    Route::middleware('role:salesperson,admin')->group(function () {
        Route::get('/sales', function () {
            return view('sales.dashboard');
        });
         Route::get('/my-orders', [SalesOrderController::class, 'myOrders'])->name('orders.my');
    });

require __DIR__.'/auth.php';
