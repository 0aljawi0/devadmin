<?php

use App\Http\Controllers\Admin\ActivityLog;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\Management\RoleManagement;
use App\Http\Controllers\Admin\Management\UserManagement;
use App\Http\Controllers\Admin\Settings\Images;
use App\Http\Controllers\Admin\Settings\Logo;
use App\Http\Controllers\Admin\Settings\Pages;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified'])->prefix('admin')->group(function(){

    // Dashboard
    Route::get('dashboard', [Dashboard::class, 'index'])->name('dashboard');

    // User
    Route::get('users', [UserManagement::class, 'index'])->name('users.index');
    Route::post('users', [UserManagement::class, 'store'])->name('users.store');
    Route::put('users-profile/{user}', [UserManagement::class, 'update_profile'])->name('users.update.profile');
    Route::put('users-password/{user}', [UserManagement::class, 'update_password'])->name('users.update.password');
    Route::delete('users/{user}', [UserManagement::class, 'destroy'])->name('users.destroy');
    Route::post('users-bulk', [UserManagement::class, 'destroy_bulk'])->name('users.destroy.bulk');

    // Roles
    Route::get('roles', [RoleManagement::class, 'index'])->name('roles.index');
    Route::post('roles', [RoleManagement::class, 'store'])->name('roles.store');
    Route::put('roles/{role}', [RoleManagement::class, 'update'])->name('roles.update');
    Route::delete('roles/{role}', [RoleManagement::class, 'destroy'])->name('roles.destroy');
    Route::post('roles-bulk', [RoleManagement::class, 'destroy_bulk'])->name('roles.destroy.bulk');

    // Manages
    Route::put('manages/{manage}', [RoleManagement::class, 'update_manage'])->name('manages.update');

    // Activity Logs
    Route::get('activity-log', [ActivityLog::class, 'index'])->name('activitylog.index');

    // Images
    Route::get('images', [Images::class, 'index'])->name('images.index');
    Route::post('images', [Images::class, 'store'])->name('images.store');
    Route::delete('images/{image}', [Images::class, 'destroy'])->name('images.destroy');

    // Logo
    Route::get('logo', [Logo::class, 'index'])->name('logo.index');
    Route::post('logo', [Logo::class, 'update'])->name('logo.update');

    // Pages
    Route::get('pages', [Pages::class, 'index'])->name('pages.index');
    Route::get('pages-action', [Pages::class, 'action'])->name('pages.action');
    Route::post('pages', [Pages::class, 'store'])->name('pages.store');
    Route::put('pages/{page}', [Pages::class, 'update'])->name('pages.update');
    Route::delete('pages/{page}', [Pages::class, 'destroy'])->name('pages.destroy');
    Route::post('pages-bulk', [Pages::class, 'destroy_bulk'])->name('pages.destroy.bulk');
    Route::get('pages-status', [Pages::class, 'update_status'])->name('pages.update.status');

});
