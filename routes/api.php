<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ChapterController;

Route::get('/chapters', [ChapterController::class, 'index']);