<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    echo 'Helo World!';
});

Route::get('/show_data', [MainController::class, 'showData']);