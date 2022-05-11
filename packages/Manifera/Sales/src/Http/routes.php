<?php
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'sales',
    'namespace' => 'Manifera\Sales\Http\Controllers'
], function () {
    Route::group([
        'prefix' => 'cart',
        'namespace' => 'Cart'
    ], function () {
        Route::get('add', 'Index@add')->defaults('_config', [
            'view'=>'admin::product.index'
        ])->name('admin::catalog.products');
    });
});
