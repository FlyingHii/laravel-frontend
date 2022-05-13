<?php
use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Manifera\Theme\Http\Controllers\Pages'
], function () {
    Route::get('/', 'Home@index')->defaults('_config', [
        'view'=>'theme::frontend.home'
    ])->name('theme::frontend.home');
});
