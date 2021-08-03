<?php

use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\RoleManagement;
use App\Http\Controllers\Admin\UserManagement;
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

});
