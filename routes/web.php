<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChapterController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::resource('chapters', ChapterController::class);
