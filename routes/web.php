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
Route::get('/', [HomeController::class, 'index'])->middleware('clean.verified')->name('home');
Route::get('/home/galery', [HomeController::class, 'galery'])->name('home.galery');
// Authentication routes (ditangani oleh Fortify)
// Fortify akan menangani: /login, /register, /forgot-password, /reset-password, dll.

// Protected routes untuk user yang sudah login
Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware(['role:User'])->group(function () {
        Route::get('/profil_security/security', [App\Http\Controllers\ProfilSecurityController::class, 'security'])->name('profil_security.security');
        Route::post('/profil_security/password', [App\Http\Controllers\ProfilSecurityController::class, 'updatePassword'])->name('profil_security.password');
        Route::resource('/profil_security', App\Http\Controllers\ProfilSecurityController::class)->only(['index', 'store']);
    });
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
        
        // Account management (untuk admin mengelola akun sendiri)
        Route::get('/acount/security', [App\Http\Controllers\AcountController::class, 'security'])->name('acount.security');
        Route::post('/acount/password', [App\Http\Controllers\AcountController::class, 'updatePassword'])->name('acount.password');
        Route::resource('/acount', App\Http\Controllers\AcountController::class)->only(['index', 'store']);
        
        // Content management
        Route::resource('/setting', App\Http\Controllers\SettingController::class)->only(['index', 'store']);
        
        // Article management
        Route::resource('/article_categories', App\Http\Controllers\ArticleCategoryController::class, [
            'parameters' => ['article_categories' => 'articleCategory:slug']
        ])->except('show');
        
        Route::resource('/article', App\Http\Controllers\ArticleController::class, [
            'parameters' => ['article' => 'article:slug']
        ]);
        
        // Other management
        Route::resource('/profil', App\Http\Controllers\ProfilController::class)->except('show');
        Route::resource('/banner', App\Http\Controllers\BannerController::class)->except('show');
        Route::resource('/stuktural', App\Http\Controllers\StukturalController::class)->except('show');
        Route::resource('/galery', App\Http\Controllers\GaleryController::class)->except('show');
        Route::resource('/kegiatan', App\Http\Controllers\KegiatanController::class)->except('show');
    });
    
    // Routes untuk semua user yang sudah login (baik admin maupun user biasa)
    // Contoh: User profile page
    // Route::get('/my-profile', [ProfileController::class, 'index'])->name('my.profile');
});