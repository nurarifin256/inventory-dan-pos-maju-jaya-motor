<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LocatorController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MerekController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $title = 'Dashboard';
    return view('dashboard', compact('title'));
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    // route jabatan
    Route::resource('akses/jabatan', JabatanController::class);
    Route::post('akses/jabatan/data_list', [JabatanController::class, 'data_list']);
    Route::post('akses/jabatan/edit_akses', [JabatanController::class, 'edit_akses']);
    Route::get('/akses/jabatan/{id}/data_akses', [JabatanController::class, 'data_akses']);

    // route akun
    Route::resource('akses/akun', AkunController::class);
    Route::post('akses/akun/data_list', [AkunController::class, 'data_list']);

    // route menu
    Route::resource('menu', MenuController::class);
    Route::post('menu/data_list', [MenuController::class, 'data_list']);

    // route rak
    Route::resource('inventory/rak', RakController::class);
    Route::post('inventory/rak/data_list', [RakController::class, 'data_list']);

    // route level
    Route::resource('inventory/level', LevelController::class);
    Route::post('inventory/level/data_list', [LevelController::class, 'data_list']);

    // route locator
    Route::resource('inventory/locator', LocatorController::class);
    Route::post('inventory/locator/data_list', [LocatorController::class, 'data_list']);

    // route kategori barang
    Route::resource('inventory/kategori', KategoriController::class);
    Route::post('inventory/kategori/data_list', [KategoriController::class, 'data_list']);

    // route supplier
    Route::resource('inventory/supplier', SupplierController::class);
    Route::post('inventory/supplier/data_list', [SupplierController::class, 'data_list']);

    // route merek
    Route::resource('inventory/merek', MerekController::class);
    Route::post('inventory/merek/data_list', [MerekController::class, 'data_list']);
});
