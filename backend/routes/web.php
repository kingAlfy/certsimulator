<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});
Route::get('/sample', function () {
    return 'sample';
});

require __DIR__.'/auth.php';
