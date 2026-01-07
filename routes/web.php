<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\RecipeController;

Route::get('/', function () {
    return view('login');
});

Route::get('/ahome', function () {
    return view('admin.home');
})->middleware('admin');

Route::get('/inventory', [InventoryController::class, 'index'])->middleware('admin')->name('admin.inventory.index');
Route::get('/inventory/create', [InventoryController::class, 'create'])->middleware('admin')->name('admin.inventory.create');
Route::get('/inventory/{rawMaterial}/edit', [InventoryController::class, 'edit'])->middleware('admin')->name('admin.inventory.edit');
Route::put('/inventory/{rawMaterial}', [InventoryController::class, 'update'])->middleware('admin')->name('admin.inventory.update');
Route::post('/inventory', [InventoryController::class, 'store'])->middleware('admin')->name('admin.inventory.store');
Route::delete('/inventory/{rawMaterial}', [InventoryController::class, 'destroy'])->middleware('admin')->name('admin.inventory.destroy');


Route::get('/menu', [MenuController::class, 'index'])->middleware('admin')->name('admin.menu.index');
Route::get('/menu/create', [MenuController::class, 'create'])->middleware('admin')->name('admin.menu.create');
Route::post('/menu', [MenuController::class, 'store'])->middleware('admin')->name('admin.menu.store');
Route::get('/menu/{menu}/edit', [MenuController::class, 'edit'])->middleware('admin')->name('admin.menu.edit');
Route::put('/menu/{menu}/edit', [MenuController::class, 'update'])->middleware('admin')->name('admin.menu.update');
Route::delete('/menu/{menu}', [MenuController::class, 'destroy'])->middleware('admin')->name('admin.menu.destroy');


Route::get('/recipe/create/{menu}', [RecipeController::class, 'create'])->middleware('admin')->name('admin.menu.recipe.create');
Route::post('/recipe/create/{menu}', [RecipeController::class, 'store'])->middleware('admin')->name('admin.menu.recipe.store');
Route::delete('/recipe/{menu}/{recipe}', [RecipeController::class, 'destroy'])->middleware('admin')->name('admin.menu.recipe.destroy');

Route::get('/transaction', function () {
    return view('admin.home');
})->middleware('admin');

Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);
