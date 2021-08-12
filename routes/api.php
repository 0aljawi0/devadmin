<?php

use App\Http\Controllers\Admin\Settings\Images;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function() {

    Route::get('all-images', [Images::class, 'all_images'])->name('all-images');
    Route::post('upload-image', [Images::class, 'upload_image'])->name('upload-image');

    Route::post('editor-image', [Images::class, 'editor_image'])->name('editor-image');

});
