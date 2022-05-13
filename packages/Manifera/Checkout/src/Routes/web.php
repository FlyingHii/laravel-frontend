<?php
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'checkout',
    'namespace' => 'Manifera\Checkout\Http\Controllers',
    'middleware' => ['web']
], function () {
    Route::group([
        'prefix' => 'cart',
        'namespace' => 'Cart'
    ], function () {
        Route::get('/', 'Index@add')->defaults('_config', [
            'view'=>'checkout::cart.index'
        ])->name('checkout::cart.index');

        Route::post('add', 'Action@add')->defaults('_config', [
        ])->name('checkout::cart.add');
    });
});
