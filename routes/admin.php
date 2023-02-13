<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {
//        Institutions
    Route::get('/institutions', [AdminController::class, 'institutions']);
    Route::get('/get/type', [AdminController::class, 'getType']);
    Route::get('/get/institutions/{page}', [AdminController::class, 'getInstitutions']);
    Route::post('/create/institution', [AdminController::class, 'createInstitution']);
    Route::patch('update/activation/intitution/{id}' ,  [AdminController::class, 'updateActivationInstitution']);


//        Staff
    Route::get('/staff', [AdminController::class, 'staff']);
    Route::post('/create/staff', [AdminController::class, 'createUser']);
    Route::get('/get/users', [AdminController::class, 'getUsers']);
    Route::delete('/delete/user/{id}', [AdminController::class, 'deleteUser']);
});
