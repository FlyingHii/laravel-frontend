<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'    => 'admin/catalog/',
    'namespace' => 'Manifera\Catalog\Http\Controllers\Admin'
], function () {
    Route::group([
        'prefix'    => 'product',
        'namespace' => 'Product'
    ], function () {
        Route::get('create', 'Index@create')->defaults('_config', [
            'view' => 'catalog::admin.product.create'
        ])->name('catalog::admin.product.create');

        Route::post('create', 'Action@create')->defaults('_config', [
        ])->name('catalog::admin.product.action.create');

        Route::get('/', 'Index@index')->defaults('_config', [
            'view' => 'catalog::admin.product.index'
        ])->name('catalog::admin.products');

        Route::get('edit/{id}', 'Index@edit')->defaults('_config', [
            'view' => 'catalog::admin.product.edit'
        ])->name('catalog::admin.product.edit');

        Route::post('edit/{id}', 'Action@edit')->defaults('_config', [
            'model' => Manifera\Catalog\Model\Product::class
        ])->name('catalog::admin.product.action.edit');
    });
});

Route::group([
    'prefix'    => 'catalog/',
    'namespace' => 'Manifera\Catalog\Http\Controllers\Frontend'
], function () {
    Route::group([
        'prefix'    => 'product',
        'namespace' => 'Product'
    ], function () {
        Route::get('/{sku}', 'Index@index')->defaults('_config', [
            'view' => 'catalog::frontend.product.index'
        ])->name('catalog::frontend.products.index');
    });
});
