<?php

use App\Http\Controllers\AgenController;
use App\Models\User;
use Spatie\Permission\Models\Role;  
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DistributorController;



// Route::get('/setup-role', function () {
//     Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
//     Role::firstOrCreate(['name' => 'distributor', 'guard_name' => 'web']);

//     $admin = User::find(1); // ganti dengan ID user admin kamu
//     if ($admin && !$admin->hasRole('admin')) {
//         $admin->assignRole('admin');
//     }

//     return 'Role berhasil dibuat dan diberikan!';
// });


// Route::get('/force-logout', function () {
//     Auth::logout();
//     request()->session()->invalidate();
//     request()->session()->regenerateToken();
//     return 'Kamu sudah logout dan session direset';
// });

//Route Login
Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'showLoginForm'])->name('loginForm');  
    Route::post('/login', [UserController::class, 'login'])->name('login');
    Route::post('/register', [UserController::class, 'register'])->name('register');
});
Route::post('/logout', [UserController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/sales', [DashboardController::class, 'dashboardSales'])->name('dashboard.sales');

    // Route Data distributor (admin)
    Route::get('/distributor/index', [DistributorController::class, 'index'])->name('distributor.index');
    Route::get('/distributor/{id}/edit', [DistributorController::class, 'edit'])->name('distributor.edit');
    

    //Route data agen
    Route::get('/agen', [AgenController::class, 'index'])->name('agen.index');


    //Route data distributor
    Route::get('/profile', [DistributorController::class, 'profile'])->name('distributor.profile');
    Route::put('/profile/update', [DistributorController::class, 'update'])->name('distributor.update');
    Route::get('/distributor/create', [DistributorController::class, 'create'])->name('distributor.create');
    Route::post('/distributor', [DistributorController::class, 'store'])->name('distributor.store');
    Route::patch('/admin/approval/{user}', [DistributorController::class, 'toggleApproval'])->name('admin.approval.toggle');
    Route::delete('/admin/distributor/{user}', [DistributorController::class, 'destroy'])->name('admin.distributor.destroy');
    
    
    //Route stok
    Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
    Route::get('/stok/create', [StokController::class, 'create'])->name('stok.create');
    Route::post('/stok/store', [StokController::class, 'store'])->name('stok.store');
    
    //Route penjualan
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');
    Route::post('/penjualan/store', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('/penjualan/filter', [PenjualanController::class, 'filter'])->name('penjualan.filter');
    Route::get('/penjualan/print-range', [PenjualanController::class, 'printRange'])->name('penjualan.print.range');

    //Route penerima
    Route::get('/penerima', [PenerimaController::class, 'index'])->name('penerima.index');
    Route::get('/penerima/create', [PenerimaController::class, 'create'])->name('penerima.create');
    Route::post('/penerima/store', [PenerimaController::class, 'store'])->name('penerima.store');
    Route::get('/penerima/{id}/edit', [PenerimaController::class, 'edit'])->name('penerima.edit');
    Route::put('/penerima/{id}', [PenerimaController::class, 'update'])->name('penerima.update');
    Route::delete('/penerima/delete/{id}', [PenerimaController::class, 'destroy'])->name('penerima.destroy');
});




