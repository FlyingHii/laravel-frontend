<?php
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'admin/',
    'namespace' => 'Manifera\Admin\Http\Controllers'
], function () {
    Route::get('/', 'Index@index')->defaults('_config', [
        'view'=>'admin::dashboard.index'
    ])->name('admin::dashboard.index');
});