<?php
use Illuminate\Support\Facades\Route;
Route::group([
    'prefix'=>'admin',
    'namespace' => 'Manifera\Admin\Http'
], function () {
    Route::get('/', 'Index@index')->defaults('_config', [
        'view' => 'admin.index'
    ]);
});
