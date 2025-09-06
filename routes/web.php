<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoaiVuonQuocGiaController;
use App\Http\Controllers\VuonQuocGiaController;
use App\Http\Controllers\BacNganhController;
use App\Http\Controllers\BacLopController;
use App\Http\Controllers\BacBoController;
use App\Http\Controllers\BacHoController;
use App\Http\Controllers\BacChiController;
use App\Http\Controllers\DongVatController;
use App\Http\Controllers\ThucVatController;

Route::get('/', function () {
    return "Hello World";
})->name('dashboard');

// Routes cho LoaiVuonQuocGia
Route::prefix('loai-vuon-quoc-gia')->name('loai-vuon-quoc-gia.')->group(function () {
    Route::get('/', [LoaiVuonQuocGiaController::class, 'index'])->name('index');
    Route::get('/create', [LoaiVuonQuocGiaController::class, 'create'])->name('create');
    Route::post('/store', [LoaiVuonQuocGiaController::class, 'store'])->name('store');
    Route::get('/{id}', [LoaiVuonQuocGiaController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [LoaiVuonQuocGiaController::class, 'edit'])->name('edit');
    Route::put('/{id}', [LoaiVuonQuocGiaController::class, 'update'])->name('update');
    Route::get('/{id}/destroy', [LoaiVuonQuocGiaController::class, 'destroy'])->name('destroy');
});

// Routes cho VuonQuocGia
Route::prefix('vuon-quoc-gia')->name('vuon-quoc-gia.')->group(function () {
    Route::get('/', [VuonQuocGiaController::class, 'index'])->name('index');
    Route::get('/create', [VuonQuocGiaController::class, 'create'])->name('create');
    Route::post('/store', [VuonQuocGiaController::class, 'store'])->name('store');
    Route::get('/{id}', [VuonQuocGiaController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [VuonQuocGiaController::class, 'edit'])->name('edit');
    Route::put('/{id}', [VuonQuocGiaController::class, 'update'])->name('update');
    Route::get('/{id}/destroy', [VuonQuocGiaController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/input-criteria', [VuonQuocGiaController::class, 'inputCriteria'])->name('input-criteria');
        Route::post('/{id}/store-criteria', [VuonQuocGiaController::class, 'storeCriteria'])->name('store-criteria');
        Route::get('/{id}/export-excel', [VuonQuocGiaController::class, 'exportExcel'])->name('export-excel');
        Route::post('/{id}/import-excel', [VuonQuocGiaController::class, 'importExcel'])->name('import-excel');
});

// Routes cho BacNganh
Route::prefix('bac-nganh')->name('bac-nganh.')->group(function () {
    Route::get('/', [BacNganhController::class, 'index'])->name('index');
    Route::get('/create', [BacNganhController::class, 'create'])->name('create');
    Route::post('/store', [BacNganhController::class, 'store'])->name('store');
    Route::get('/{id}', [BacNganhController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [BacNganhController::class, 'edit'])->name('edit');
    Route::put('/{id}', [BacNganhController::class, 'update'])->name('update');
    Route::get('/{id}/destroy', [BacNganhController::class, 'destroy'])->name('destroy');
});

// Routes cho BacLop
Route::prefix('bac-lop')->name('bac-lop.')->group(function () {
    Route::get('/', [BacLopController::class, 'index'])->name('index');
    Route::get('/create', [BacLopController::class, 'create'])->name('create');
    Route::post('/store', [BacLopController::class, 'store'])->name('store');
    Route::get('/{id}', [BacLopController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [BacLopController::class, 'edit'])->name('edit');
    Route::put('/{id}', [BacLopController::class, 'update'])->name('update');
    Route::get('/{id}/destroy', [BacLopController::class, 'destroy'])->name('destroy');
});

// Routes cho BacBo
Route::prefix('bac-bo')->name('bac-bo.')->group(function () {
    Route::get('/', [BacBoController::class, 'index'])->name('index');
    Route::get('/create', [BacBoController::class, 'create'])->name('create');
    Route::post('/store', [BacBoController::class, 'store'])->name('store');
    Route::get('/{id}', [BacBoController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [BacBoController::class, 'edit'])->name('edit');
    Route::put('/{id}', [BacBoController::class, 'update'])->name('update');
    Route::get('/{id}/destroy', [BacBoController::class, 'destroy'])->name('destroy');
});

// Routes cho BacHo
Route::prefix('bac-ho')->name('bac-ho.')->group(function () {
    Route::get('/', [BacHoController::class, 'index'])->name('index');
    Route::get('/create', [BacHoController::class, 'create'])->name('create');
    Route::post('/store', [BacHoController::class, 'store'])->name('store');
    Route::get('/{id}', [BacHoController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [BacHoController::class, 'edit'])->name('edit');
    Route::put('/{id}', [BacHoController::class, 'update'])->name('update');
    Route::get('/{id}/destroy', [BacHoController::class, 'destroy'])->name('destroy');
});

// Routes cho BacChi
Route::prefix('bac-chi')->name('bac-chi.')->group(function () {
    Route::get('/', [BacChiController::class, 'index'])->name('index');
    Route::get('/create', [BacChiController::class, 'create'])->name('create');
    Route::post('/store', [BacChiController::class, 'store'])->name('store');
    Route::get('/{id}', [BacChiController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [BacChiController::class, 'edit'])->name('edit');
    Route::put('/{id}', [BacChiController::class, 'update'])->name('update');
    Route::get('/{id}/destroy', [BacChiController::class, 'destroy'])->name('destroy');
});

// Routes cho DongVat
Route::prefix('dong-vat')->name('dong-vat.')->group(function () {
    Route::get('/', [DongVatController::class, 'index'])->name('index');
    Route::get('/create', [DongVatController::class, 'create'])->name('create');
    Route::post('/store', [DongVatController::class, 'store'])->name('store');
    Route::get('/{id}', [DongVatController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [DongVatController::class, 'edit'])->name('edit');
    Route::put('/{id}', [DongVatController::class, 'update'])->name('update');
    Route::get('/{id}/destroy', [DongVatController::class, 'destroy'])->name('destroy');

    // Routes cho upload hình ảnh
    Route::post('/{id}/upload-image', [DongVatController::class, 'uploadImage'])->name('upload-image');
    Route::post('/{id}/upload-image-from-path', [DongVatController::class, 'uploadImageFromPath'])->name('upload-image-from-path');
    Route::get('/image/{imageId}', [DongVatController::class, 'deleteImage'])->name('delete-image');
    Route::get('/{id}/images', [DongVatController::class, 'getImages'])->name('get-images');
});

// Routes cho ThucVat
Route::prefix('thuc-vat')->name('thuc-vat.')->group(function () {
    Route::get('/', [ThucVatController::class, 'index'])->name('index');
    Route::get('/create', [ThucVatController::class, 'create'])->name('create');
    Route::post('/store', [ThucVatController::class, 'store'])->name('store');
    Route::get('/{id}', [ThucVatController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [ThucVatController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ThucVatController::class, 'update'])->name('update');
    Route::get('/{id}/destroy', [ThucVatController::class, 'destroy'])->name('destroy');
    Route::get('/search', [ThucVatController::class, 'search'])->name('search');

    // Routes cho upload hình ảnh
    Route::post('/{id}/upload-image', [ThucVatController::class, 'uploadImage'])->name('upload-image');
    Route::post('/{id}/upload-image-from-path', [ThucVatController::class, 'uploadImageFromPath'])->name('upload-image-from-path');
    Route::delete('/image/{imageId}', [ThucVatController::class, 'deleteImage'])->name('delete-image');
    Route::get('/{id}/images', [ThucVatController::class, 'getImages'])->name('get-images');
});
