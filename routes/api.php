<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\C_auth;
use App\Http\Controllers\C_users;
use App\Http\Controllers\C_users_member;
use App\Http\Controllers\C_system_group;
use App\Http\Controllers\C_system_member;
use App\Http\Controllers\C_system_menu;
use App\Http\Controllers\C_system_role;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\SatuanBarangController;
use App\Http\Controllers\LokasiBarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PermintaanBarang;




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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->group(['prefix' => 'auth'], function () use ($router) {
        Route::post('/login', [C_auth::class, 'login']);
        Route::post('/update', [C_auth::class, 'update']);
        Route::post('/delete', [C_auth::class, 'delete']);
    });

    $router->group(['prefix' => 'users'], function () use ($router) {
        Route::get('/read', [C_users::class, 'getData']);
        Route::get('/store', [C_users::class, 'getStore']);
        Route::post('/create', [C_users::class, 'create']);
        Route::post('/update', [C_users::class, 'update']);
        Route::post('/delete', [C_users::class, 'delete']);
        
        $router->group(['prefix' => 'member'], function () use ($router) {
            Route::get('/read', [C_users_member::class, 'getData']);
            Route::get('/store', [C_users_member::class, 'getStore']);
            Route::post('/create', [C_users_member::class, 'create']);
            Route::post('/update', [C_users_member::class, 'update']);
            Route::post('/delete', [C_users_member::class, 'delete']);
        });
    });

    $router->group(['prefix' => 'system_group'], function () use ($router) {
        Route::get('/read', [C_system_group::class, 'getData']);
        Route::get('/store', [C_system_group::class, 'getStore']);
        Route::get('/store/{id}', [C_system_group::class, 'getStore']);
        Route::post('/create', [C_system_group::class, 'create']);
        Route::post('/update', [C_system_group::class, 'update']);
        Route::post('/delete', [C_system_group::class, 'delete']);
    });

    $router->group(['prefix' => 'system_member'], function () use ($router) {
        Route::get('/read', [C_system_member::class, 'getData']);
        Route::get('/store', [C_system_member::class, 'getStore']);
        Route::get('/store/{id}', [C_system_member::class, 'getStore']);
        Route::post('/create', [C_system_member::class, 'create']);
        Route::post('/update', [C_system_member::class, 'update']);
        Route::post('/delete', [C_system_member::class, 'delete']);
        Route::post('/deleteByGroup', [C_system_member::class, 'deleteByGroup']);
    });

    $router->group(['prefix' => 'system_menu'], function () use ($router) {
        Route::get('/read', [C_system_menu::class, 'getData']);
        Route::get('/store', [C_system_menu::class, 'getStore']);
        Route::get('/store/{id}', [C_system_menu::class, 'getStore']);
        Route::post('/create', [C_system_menu::class, 'create']);
        Route::post('/update', [C_system_menu::class, 'update']);
        Route::post('/delete', [C_system_menu::class, 'delete']);
        Route::post('/deleteByGroup', [C_system_menu::class, 'deleteByGroup']);
        Route::post('/update/position', [C_system_menu::class, 'reorder']);
    });

    $router->group(['prefix' => 'system_role'], function () use ($router) {
        Route::get('/read', [C_system_role::class, 'getData']);
        Route::get('/store', [C_system_role::class, 'getStore']);
        Route::get('/store/{id}', [C_system_role::class, 'getStore']);
        Route::post('/create', [C_system_role::class, 'create']);
        Route::post('/update', [C_system_role::class, 'update']);
        Route::post('/delete', [C_system_role::class, 'delete']);
        Route::post('/deleteByGroup', [C_system_role::class, 'deleteByGroup']);
    });

    $router->group(['prefix' => 'departemen'], function () use ($router) {
        Route::get('/read', [DepartemenController::class, 'getData']);
        Route::get('/store', [DepartemenController::class, 'getStore']);
        Route::get('/store/{id}', [DepartemenController::class, 'getStore']);
        Route::post('/create', [DepartemenController::class, 'create']);
        Route::post('/update', [DepartemenController::class, 'update']);
        Route::post('/delete', [DepartemenController::class, 'delete']); 
        Route::post('/post', [DepartemenController::class, 'posting']);
       
    });

    $router->group(['prefix' => 'departemen'], function () use ($router) {
        Route::get('/read', [DepartemenController::class, 'getData']);
        Route::get('/store', [DepartemenController::class, 'getStore']);
        Route::get('/store/{id}', [DepartemenController::class, 'getStore']);
        Route::post('/create', [DepartemenController::class, 'create']);
        Route::post('/update', [DepartemenController::class, 'update']);
        Route::post('/delete', [DepartemenController::class, 'delete']); 
        Route::post('/post', [DepartemenController::class, 'posting']);
       
    });

    $router->group(['prefix' => 'satuan_barang'], function () use ($router) {
        Route::get('/read', [SatuanBarangController::class, 'getData']);
        Route::get('/store', [SatuanBarangController::class, 'getStore']);
        Route::get('/store/{id}', [SatuanBarangController::class, 'getStore']);
        Route::post('/create', [SatuanBarangController::class, 'create']);
        Route::post('/update', [SatuanBarangController::class, 'update']);
        Route::post('/delete', [SatuanBarangController::class, 'delete']); 
        Route::post('/post', [SatuanBarangController::class, 'posting']);
       
    });

    $router->group(['prefix' => 'lokasi_barang'], function () use ($router) {
        Route::get('/read', [LokasiBarangController::class, 'getData']);
        Route::get('/store', [LokasiBarangController::class, 'getStore']);
        Route::get('/store/{id}', [LokasiBarangController::class, 'getStore']);
        Route::post('/create', [LokasiBarangController::class, 'create']);
        Route::post('/update', [LokasiBarangController::class, 'update']);
        Route::post('/delete', [LokasiBarangController::class, 'delete']); 
        Route::post('/post', [LokasiBarangController::class, 'posting']);
    });

    $router->group(['prefix' => 'customer'], function () use ($router) {
        Route::get('/read', [CustomerController::class, 'getData']);
        Route::get('/store', [CustomerController::class, 'getStore']);
        Route::get('/store_id', [CustomerController::class, 'getDataAuto']);
        Route::post('/create', [CustomerController::class, 'create']);
        Route::post('/update', [CustomerController::class, 'update']);
        Route::post('/delete', [CustomerController::class, 'delete']); 
        Route::post('/post', [CustomerController::class, 'posting']);
    });

    $router->group(['prefix' => 'barang'], function () use ($router) {
        Route::get('/read', [BarangController::class, 'getData']);
        Route::get('/store', [BarangController::class, 'getStore']);
        Route::get('/store/{id}', [BarangController::class, 'getStore']);
        Route::get('/store_name', [BarangController::class, 'getDataAuto']);
        Route::post('/create', [BarangController::class, 'create']);
        Route::post('/update', [BarangController::class, 'update']);
        Route::post('/delete', [BarangController::class, 'delete']); 
        Route::post('/post', [BarangController::class, 'posting']);
    });

    $router->group(['prefix' => 'permintaan_barang'], function () use ($router) {
        Route::get('/read', [PermintaanBarang::class, 'getData']);
        Route::get('/store', [PermintaanBarang::class, 'getStore']);
        Route::get('/store/{id}', [PermintaanBarang::class, 'getStore']);
        Route::post('/create', [PermintaanBarang::class, 'create']);
        Route::post('/update', [PermintaanBarang::class, 'update']);
        Route::post('/delete', [PermintaanBarang::class, 'delete']); 
        Route::post('/post', [PermintaanBarang::class, 'posting']);
    });
   
});