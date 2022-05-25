<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\C_pages;
use App\Http\Controllers\C_users;
use App\Http\Controllers\C_users_member;
use App\Http\Controllers\C_auth;
use App\Http\Controllers\C_system_menu;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\SatuanBarangController;
use App\Http\Controllers\LokasiBarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PermintaanBarang;



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

$router->group(['prefix' => 'login'], function () use ($router) {
    Route::get('/', [C_pages::class, 'loginPage']);
});

$router->group(['prefix' => 'logout'], function () use ($router) {
    Route::get('/', [C_auth::class, 'logoutPage']);
});

$router->group(['prefix' => 'admin', 'as'=>'admin.', 'middleware' => ['authSession', 'getTrustee']], function () use ($router) {
    Route::get('/', [C_pages::class, 'cpanel']);

    $router->group(['prefix' => 'users'], function () use ($router) {
        Route::get('/', [C_pages::class, 'pageUsers']);
        Route::get('/form', [C_users::class, 'form']);
        Route::get('/form/{id}', [C_users::class, 'form']);
    
        $router->group(['prefix' => 'parent'], function () use ($router) {
            Route::get('/', [C_pages::class, 'pageUsersParent']);
        });

        $router->group(['prefix' => 'member'], function () use ($router) {
            Route::get('/', [C_pages::class, 'pageUsersMember']);
            Route::get('/form', [C_users_member::class, 'form']);
            Route::get('/form/{id}', [C_users_member::class, 'form']);
        });
    });
    
    $router->group(['prefix' => 'system_group'], function () use ($router) {
        Route::get('/', [C_pages::class, 'pageSystemGroup']);
    });
    
    $router->group(['prefix' => 'system_member'], function () use ($router) {
        Route::get('/', [C_pages::class, 'pageSystemMember']);
    });
    
    $router->group(['prefix' => 'system_role'], function () use ($router) {
        Route::get('/', [C_pages::class, 'pageSystemRole']);
    });
    
    $router->group(['prefix' => 'system_menu'], function () use ($router) {
        Route::get('/', [C_pages::class, 'pageSystemMenu']);
        Route::get('/form', [C_system_menu::class, 'form']);
        Route::get('/form/{id}', [C_system_menu::class, 'form']);
    });
    
    $router->group(['prefix' => 'departemen'], function () use ($router) {
        Route::get('/', [DepartemenController::class, 'page']);
        Route::get('/form', [DepartemenController::class, 'form']);
        Route::get('/form/{id}', [DepartemenController::class, 'form']);
    });

    $router->group(['prefix' => 'satuan_barang'], function () use ($router) {
        Route::get('/', [SatuanBarangController::class, 'page']);
        Route::get('/form', [SatuanBarangController::class, 'form']);
        Route::get('/form/{id}', [SatuanBarangController::class, 'form']);
    });

    $router->group(['prefix' => 'lokasi_barang'], function () use ($router) {
        Route::get('/', [LokasiBarangController::class, 'page']);
        Route::get('/form', [LokasiBarangController::class, 'form']);
        Route::get('/form/{id}', [LokasiBarangController::class, 'form']);
    });

    $router->group(['prefix' => 'customer'], function () use ($router) {
        Route::get('/', [CustomerController::class, 'page']);
        Route::get('/form', [CustomerController::class, 'form']);
        Route::get('/form/{id}', [CustomerController::class, 'form']);
    });

    $router->group(['prefix' => 'barang'], function () use ($router) {
        Route::get('/', [BarangController::class, 'page']);
        Route::get('/form', [BarangController::class, 'form']);
        Route::get('/form/{id}', [BarangController::class, 'form']);
    });

    $router->group(['prefix' => 'permintaan_barang'], function () use ($router) {
        Route::get('/', [PermintaanBarang::class, 'page']);
        Route::get('/form', [PermintaanBarang::class, 'form']);
        Route::get('/formDetail/{id}', [PermintaanBarangForm::class, 'formDetail']);
    });

});

$router->group(['prefix' => '/'], function () use ($router) {
    Route::get('/', [C_pages::class, 'loginPage']);
});

