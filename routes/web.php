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
Route::post('/admin/login', [AdminController::class, 'admin_login_submit'])->name('admin.login.submit');
Route::get('/admin/login', [AdminController::class, 'admin_login'])->name('admin.login')->middleware('check-login');

Route::get('/admin/forgot-password',[AdminController::class, 'admin_forgot_password'])->name('admin.forgot.password');
Route::post('/admin/forgot-password',[AdminController::class, 'admin_forgot_password_submit'])->name('admin.forgot.password.submit');

Route::get('/admin/reset-password/{token}/{email}',[AdminController::class, 'admin_reset_password'])->name('admin.reset.password');
Route::post('/admin/reset-password',[AdminController::class, 'admin_reset_password_submit'])->name('admin.reset.password.submit');

Route::middleware('admin')->group(function (){
    Route::get('/admin/dashboard',[AdminController::class, 'admin_dashboard'])->name('admin.dashboard');
});



require __DIR__.'/auth.php';
