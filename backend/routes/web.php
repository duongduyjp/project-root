<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\Master\CustomerController;
use App\Http\Controllers\Master\ItemController;
use App\Http\Controllers\Master\YardController;
use App\Http\Controllers\Master\ShelfController;
use App\Http\Controllers\sites\SiteController;



Route::resource('sites', SiteController::class);

Route::get('/', function () {
    return view('home');
});

Route::get('/car', function () {
    return view('car');
});

Route::get('/estimates', function () {
    return view('estimates');
});

Route::get('/orders', function () {
    return view('orders');
});

Route::get('/acceptances', function () {
    return view('acceptances');
});

Route::get('/stocks', function () {
    return view('stocks');
});

// Master routes
Route::prefix('master')->name('master.')->group(function () {
    // Shelf routes
    Route::get('/shelf', [ShelfController::class, 'index'])->name('shelf.index');
    Route::get('/shelf/create', [ShelfController::class, 'create'])->name('shelf.create');
    Route::post('/shelf', [ShelfController::class, 'store'])->name('shelf.store');
    Route::get('/shelf/{shelf}/edit', [ShelfController::class, 'edit'])->name('shelf.edit');
    Route::put('/shelf/{shelf}', [ShelfController::class, 'update'])->name('shelf.update');
    Route::delete('/shelf/{shelf}', [ShelfController::class, 'destroy'])->name('shelf.destroy');

    // Customer routes
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/customer/{customer}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/customer/{customer}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customer/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');

    // Items
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
    Route::post('/items/import', [ItemController::class, 'import'])->name('items.import');

    // Yard routes
    Route::get('/yard', [YardController::class, 'index'])->name('yard.index');
    Route::get('/yard/create', [YardController::class, 'create'])->name('yard.create');
    Route::post('/yard', [YardController::class, 'store'])->name('yard.store');
    Route::get('/yard/{yard}/edit', [YardController::class, 'edit'])->name('yard.edit');
    Route::put('/yard/{yard}', [YardController::class, 'update'])->name('yard.update');
    Route::delete('/yard/{yard}', [YardController::class, 'destroy'])->name('yard.destroy');

    // Other master routes
    Route::get('/office', [MasterController::class, 'office'])->name('office');
    Route::get('/car-type', [MasterController::class, 'carType'])->name('car_type');

    // Site routes
    Route::resource('sites', SiteController::class);
    Route::get('/week1', [SiteController::class, 'index'])->name('week1.index');
    Route::get('/week1/create', [SiteController::class, 'create'])->name('week1.create');
    Route::post('/week1', [SiteController::class, 'store'])->name('week1.store');
    Route::get('/week1/{site}/edit', [SiteController::class, 'edit'])->name('week1.edit');
    Route::put('/week1/{site}', [SiteController::class, 'update'])->name('week1.update');
    Route::delete('/week1/{site}', [SiteController::class, 'destroy'])->name('week1.destroy');
});
