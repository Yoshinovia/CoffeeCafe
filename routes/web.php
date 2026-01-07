<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RecipeController;

use App\Http\Controllers\Kasir\KasirController;
use App\Http\Controllers\Admin\InventoryController;

Route::get('/', function () {
    return view('login');
});

Route::get('/ahome', function () {
    return view('admin.home');
})->middleware('admin');

/*
|--------------------------------------------------------------------------
| Kasir Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'kasir'])
    ->prefix('kasir')
    ->name('kasir.')
    ->group(function () {
        Route::get('/', [KasirController::class, 'dashboard'])
            ->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
    
    /*
    | Inventory
    */
    Route::resource('inventory', InventoryController::class)
        ->except(['show'])
        ->names([
            'index'   => 'inventory.index',
            'create'  => 'inventory.create',
            'store'   => 'inventory.store',
            'edit'    => 'inventory.edit',
            'update'  => 'inventory.update',
            'destroy' => 'inventory.destroy',
        ]);

    /*
    | Menu
    */
    Route::resource('menu', MenuController::class)
        ->except(['show'])
        ->names([
            'index'   => 'menu.index',
            'create'  => 'menu.create',
            'store'   => 'menu.store',
            'edit'    => 'menu.edit',
            'update'  => 'menu.update',
            'destroy' => 'menu.destroy',
        ]);

    /*
    | Recipes (belongs to menu)
    */
    Route::prefix('menu/{menu}')->name('menu.')->group(function () {

        Route::get('recipes/create', [RecipeController::class, 'create'])
            ->name('recipe.create');

        Route::post('recipes', [RecipeController::class, 'store'])
            ->name('recipe.store');

        Route::delete('recipes/{recipe}', [RecipeController::class, 'destroy'])
            ->name('recipe.destroy');
    });

    

    /*
    | Transactions
    */
    Route::get('transaction', function () {
        return view('admin.home');
    })->name('transaction.index');
});
