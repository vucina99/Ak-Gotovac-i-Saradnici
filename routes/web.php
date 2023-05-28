<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TrialController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
})->middleware('guest');

Auth::routes(['register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/case', [CaseController::class, 'view']);
    Route::get('/trial', [TrialController::class, 'view']);
    Route::get('/all-trial-from/{date}', [TrialController::class, 'dateResult']);
    Route::post('/logout-form', [HomeController::class, 'logoutForm'])->name('logout-form');
});


