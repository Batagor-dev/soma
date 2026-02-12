<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::view('/', 'welcome');


// Public routes (tanpa authentication)
Route::get('/', function () {
    return redirect('/login');
});
// Authentication routes (ditangani oleh Fortify)
// Fortify akan menangani: /login, /register, /forgot-password, /reset-password, dll.

// Protected routes untuk user yang sudah login
Route::middleware(['auth', 'verified'])->group(function () {
    // Route khusus untuk admin (Super Admin dan Admin)
    Route::middleware(['role:Super Admin|Admin'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
        // User management
        Route::get('/user/role/{user}', [App\Http\Controllers\UserController::class, 'role'])->name('user.role');
        Route::post('/user/roleaction/{user}', [App\Http\Controllers\UserController::class, 'roleaction'])->name('user.roleaction');
        Route::resource('/user', App\Http\Controllers\UserController::class);
        
        // Role & Permission management
        Route::post('/role/showaction/{role}', [App\Http\Controllers\RoleController::class, 'showaction'])->name('role.showaction');
        Route::resource('/role', App\Http\Controllers\RoleController::class);
        Route::resource('/permissiongroup', App\Http\Controllers\PermissionGroupController::class)->except('show');
        Route::resource('/permission', App\Http\Controllers\PermissionController::class)->except('show');
        
        // Menu management
        Route::resource('/menu', App\Http\Controllers\MenuController::class)->except('show');
        
        
        // Content management
        Route::resource('/setting', App\Http\Controllers\SettingController::class)->only(['index', 'store']);
    });
    
    // Routes untuk semua user yang sudah login (baik admin maupun user biasa)
    // Contoh: User profile page
    // Route::get('/my-profile', [ProfileController::class, 'index'])->name('my.profile');
});