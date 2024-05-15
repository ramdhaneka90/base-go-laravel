<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Command
Route::prefix('command')->group(function () {

    // Storage Link
    Route::get('storage-link', function () {
        Artisan::call('storage:link');
    });

    // Config Cache
    Route::get('config-cache', function () {
        Artisan::call('config:cache');
    });

    // Optimize
    Route::get('optimize', function () {
        Artisan::call('optimize');
    });

});

// Global Routes
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('logout', 'AuthController@logout')->name('logout');

// Guest Routes
Route::group(['middleware' => ['guest']], function () {
    Route::get('login', 'AuthController@showLogin')->name('login');
    Route::post('login', 'AuthController@login');
});

// Auth Routes
Route::group(['middleware' => ['verified', 'auth', 'acl']], function () {

    // Home
    Route::get('home', 'HomeController@index')->name('home');
    Route::get('dashboard', 'HomeController@index')->name('dashboard');

    // Master
    Route::prefix('master')->group(function () {

        // Region
        Route::resource('region', 'RegionController', ['names' => 'region']);

        // Area
        Route::resource('area', 'AreaController', ['names' => 'area']);

        // Divison
        Route::resource('division', 'DivisionController', ['names' => 'division']);

        // Position
        Route::resource('position', 'PositionController', ['names' => 'position']);

        // Menu
        Route::resource('menu', 'MenuController', ['names' => 'menu']);
        Route::put('menu/order/save', 'MenuController@saveOrder')->name('menu.saveOrder');

        // Role
        Route::resource('role', 'RoleController', ['names' => 'role']);
        Route::get('role/menus', 'RoleController@getMenus')->name('role.menus');

        // Akses Data
        Route::resource('akses-data', 'AksesDataController', ['names' => 'aksesData']);

        // User
        Route::prefix('user')->group(function () {
            Route::get('change-password', 'UserController@formChangePassword')->name('user.changePassword');
            Route::post('save-change-password', 'UserController@changePassword')->name('user.saveChangePassword');
            Route::get('reset-password', 'UserController@resetPassword')->name('user.resetPassword');
        });
        Route::resource('user', 'UserController', ['names' => 'user']);
    });

    // Tools
    Route::prefix('tools')->group(function () {

        // Log Activity
        Route::resource('log-aktivitas', 'ActivityLogController', ['names' => 'activitylog']);
        Route::get('log-aktivitas/detail', 'ActivityLogController@detail')->name('activitylog.detail');

    });
});
