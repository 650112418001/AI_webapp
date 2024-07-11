<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('web', function () {
    return view('webapp');
});

Route::get('About', function () {
    return view('About');
});

Route::get('ai', function () {
    return view('ai');
});

Route::get('testai', function () {
    return view('testai');
});

Route::get('AIDetector', function () {
    return view('AIDetector');
});

Route::get('welcome', function () {
    return view('welcome');
});

Route::get('Macaws', function () {
    return view('Macaws');
});

Route::get('Conures', function () {
    return view('Conures');
});

Route::get('Cockatiels', function () {
    return view('Cockatiels');
});