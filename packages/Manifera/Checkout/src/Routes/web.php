<?php
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'Checkout',
    'namespace' => 'Manifera\Checkout\Http\Controllers'
], function () {
    Route::group([
        'prefix' => 'cart',
        'namespace' => 'Cart'
    ], function () {
        Route::get('/', 'Index@add')->defaults('_config', [
            'view'=>'checkout::cart.index'
        ])->name('checkout::catalog.products');

        Route::post('add', 'Action@add')->defaults('_config', [
        ])->name('checkout::catalog.products');
    });
});
