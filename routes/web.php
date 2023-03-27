<?php

use App\Http\Controllers\ArfFormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaptopController;
use App\Http\Controllers\ReplacementController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SuccessController;
use App\Http\Controllers\UploadController;
use App\Models\Desktop;
use App\Models\Laptop;
use App\Models\Tablet;
use App\Services\ArfFormService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/arf-new', [ArfFormController::class, 'index']);
    Route::get('/arf-edit/{id}', [ArfFormController::class, 'edit']);
    Route::get('/search', [SearchController::class, 'index']);
    Route::post('/search', [SearchController::class, 'view'])->name('arfform.search');
    Route::post('/arf-form', [App\Http\Controllers\ArfFormController::class, 'create'])->name('arfform.submit');
    Route::post('/arf-form/update', [App\Http\Controllers\ArfFormController::class, 'update'])->name('arfform.update');
    Route::get('/email', function() {
        return new App\Mail\ArfNotification([
            'url'  => 'google.com',
            'email' => 'asd@gmail.com',
            'name' => 'Faheem Nawaz',
            'items' => [
                ['name' => 'Laptop', 'code' => 'AZLAP123', 'brand' => 'Fujitisu', 'date_issued' => now()],
                ['name' => 'Monitor', 'code' => 'AZDTC010', 'brand' => 'HP', 'date_issued' => now()]
            ]
        ]);
    });

    Route::get('/search-asset-availability', [SearchController::class, 'searchAsset']);
    Route::get('/get-brands', [SearchController::class, 'getBrands']);

    Route::get('/upload-assets', [UploadController::class, 'index']);
    Route::post('/upload-assets', [UploadController::class, 'create'])->name('arfform.upload');
});

Auth::routes();

Route::get('/verify/{token}', [SuccessController::class, 'index'])->middleware('throttle:4,10');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});