<?php
use Illuminate\Support\Facades\Route;
Route::get('/', '\App\Http\Controllers\Index@index')->defaults('_config', [
    'view'=>'master'
]);
