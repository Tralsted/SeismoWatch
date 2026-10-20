<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EarthquakeController;

Route::get('/', [EarthquakeController::class, 'index'])->name('index');
