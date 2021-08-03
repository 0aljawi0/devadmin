<?php

use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\RoleManagement;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified'])->prefix('admin')->group(function(){

    // Dashboard
    Route::get('dashboard', [Dashboard::class, 'index'])->name('dashboard');

    // Roles
    Route::get('roles', [RoleManagement::class, 'index'])->name('roles.index');
    Route::post('roles', [RoleManagement::class, 'store'])->name('roles.store');
    Route::put('roles/{role}', [RoleManagement::class, 'update'])->name('roles.update');
    Route::delete('roles/{role}', [RoleManagement::class, 'destroy'])->name('roles.destroy');
    Route::post('roles-bulk', [RoleManagement::class, 'destroy_bulk'])->name('roles.destroy.bulk');

    // Manages
    Route::put('manages/{manage}', [RoleManagement::class, 'update_manage'])->name('manages.update');

});
