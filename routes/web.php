<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Laporan\LaporanBarangKeluarController;
use App\Http\Controllers\Laporan\LaporanBarangMasukController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LocatorController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MerekController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PindahLocatorController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\StagingAreaController;
use App\Http\Controllers\StokController;
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

    // route stok
    Route::resource('inventory/stok', StokController::class);
    Route::post('inventory/stok/data_list', [StokController::class, 'data_list']);

    // route barang
    Route::resource('inventory/barang', BarangController::class);
    Route::post('inventory/barang/data_list', [BarangController::class, 'data_list']);

    // route barang masuk
    Route::resource('transaksi/barang_masuk', BarangMasukController::class);
    Route::get('transaksi/barang_masuk/{id}/print', [BarangMasukController::class, 'print']);
    Route::post('transaksi/barang_masuk/data_list', [BarangMasukController::class, 'data_list']);
    Route::post('transaksi/barang_masuk/get_duplicate', [BarangMasukController::class, 'get_duplicate']);

    // route staging area
    Route::resource('transaksi/staging_area', StagingAreaController::class);
    Route::post('transaksi/staging_area/data_list', [StagingAreaController::class, 'data_list']);
    Route::post('transaksi/staging_area/cek_locator', [StagingAreaController::class, 'cek_locator']);

    // route pindah locator
    Route::resource('transaksi/pindah_locator', PindahLocatorController::class);
    Route::post('transaksi/pindah_locator/data_list', [PindahLocatorController::class, 'data_list']);
    Route::post('transaksi/pindah_locator/cek_locator', [PindahLocatorController::class, 'cek_locator']);

    // route laporan barang masuk
    Route::resource('laporan/barang_masuk', LaporanBarangMasukController::class);
    Route::get('laporan/barang_masuk/{tgl_mulai}/{tgl_sampai}/print', [LaporanBarangMasukController::class, 'print']);
    Route::get('laporan/barang_masuk/{tgl_mulai}/{tgl_sampai}/print_supplier', [LaporanBarangMasukController::class, 'print_supplier']);
    Route::post('laporan/barang_masuk/hasil', [LaporanBarangMasukController::class, 'hasil']);
    Route::post('laporan/barang_masuk/hasil_supplier', [LaporanBarangMasukController::class, 'hasil_supplier']);
    Route::get('laporan/barang_masuk/{supplier_id}/detail_hasil_supplier', [LaporanBarangMasukController::class, 'detail_hasil_supplier']);

    // route laporan barang keluar
    Route::resource('laporan/barang_keluar', LaporanBarangKeluarController::class);
    Route::post('laporan/barang_keluar/hasil', [LaporanBarangKeluarController::class, 'hasil']);
    Route::post('laporan/barang_keluar/hasil_pelanggan', [LaporanBarangKeluarController::class, 'hasil_pelanggan']);
    Route::get('laporan/barang_keluar/{tgl_mulai}/{tgl_sampai}/print', [LaporanBarangKeluarController::class, 'print']);
    Route::get('laporan/barang_keluar/{tgl_mulai}/{tgl_sampai}/print_pelanggan', [LaporanBarangKeluarController::class, 'print_pelanggan']);
    Route::get('laporan/barang_keluar/{pelanggan_id}/detail_hasil_pelanggan', [LaporanBarangKeluarController::class, 'detail_hasil_pelanggan']);

    // route pelanggan
    Route::resource('pos/pelanggan', PelangganController::class);
    Route::post('pos/pelanggan/data_list', [PelangganController::class, 'data_list']);

    // route kasir
    Route::resource('pos/kasir', KasirController::class);
    Route::post('pos/kasir/get_harga', [KasirController::class, 'get_harga']);
    Route::post('pos/kasir/get_stok', [KasirController::class, 'get_stok']);
    Route::post('pos/kasir/get_locator', [KasirController::class, 'get_locator']);
    Route::post('pos/kasir/get_total', [KasirController::class, 'get_total']);
});
