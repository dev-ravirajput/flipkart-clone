<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\BrandController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::prefix('admin')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('category/add', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('admin.edit.category');
    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('admin.update.category');
    Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.delete.category');

    Route::prefix('/sub-category')->group(function (){
        Route::get('/', [SubcategoryController::class, 'index'])->name('admin.subcategory');
        Route::get('/add', [SubcategoryController::class, 'create'])->name('admin.subcategory.add');
        Route::post('/store', [SubcategoryController::class, 'store'])->name('admin.subcategory.store');
        Route::get('/edit/{id}', [SubcategoryController::class, 'edit'])->name('admin.subcategory.edit');
        Route::post('/update/{id}', [SubcategoryController::class, 'update'])->name('admin.subcategory.update');
        Route::delete('/delete/{id}', [SubcategoryController::class, 'destroy'])->name('admin.subcategory.delete');
    });

    Route::prefix('/brands')->group(function (){
        Route::get('/', [BrandController::class, 'index'])->name('admin.brands');
        Route::get('/add', [BrandController::class, 'create'])->name('admin.brands.add');
        Route::post('/store', [BrandController::class, 'store'])->name('admin.brands.store');
    });
});

