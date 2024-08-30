<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin/logout',[AdminController::class, 'admin_logout'])->name('admin.logout');
Route::post('/admin/login', [AdminController::class, 'admin_login_submit'])->name('admin.login');
Route::get('/admin/login', [AdminController::class, 'admin_login'])->name('admin.login')->middleware('check-login');

Route::middleware('admin')->group(function (){
    Route::get('/admin/dashboard',[AdminController::class, 'admin_dashboard'])->name('admin.dashboard');
});



require __DIR__.'/auth.php';
