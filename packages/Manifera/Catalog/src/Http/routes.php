<?php
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'admin/catalog/',
    'namespace' => 'Manifera\Catalog\Http\Controllers\Admin'
], function () {


    Route::group([
        'prefix' => 'products'
    ], function () {
        Route::get('/', 'Product\Index@index')->defaults('_config', [
            'view'=>'admin::product.index'
        ])->name('admin::catalog.products');

        Route::get('edit/{id}', 'Product\Index@edit')->defaults('_config', [
            'view'=>'admin::product.edit'
        ])->name('admin::catalog.products.edit');

        Route::post('edit/{id}', 'Product\Index@update')->defaults('_config', [
            'model' => Manifera\Catalog\Model\Product::class
        ])->name('admin::catalog.products.update');
    });
});
