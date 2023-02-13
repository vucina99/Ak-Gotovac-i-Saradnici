<?php

use App\Http\Controllers\CaseController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'case'], function () {
    Route::get('/get/type', [CaseController::class, 'getCaseTypes']);
    Route::post('/get/cases', [CaseController::class, 'getCases']);
    Route::post('/get/institutions', [CaseController::class, 'getInstitutions']);
    Route::post('/get/persons', [CaseController::class, 'getPersons']);
    Route::post('/create/case', [CaseController::class, 'createCase']);
    Route::post('/files/upload', [CaseController::class, 'filesUpload']);
    Route::post('/update/files', [CaseController::class, 'updateFiles']);
    Route::get('/get/case/{id}', [CaseController::class, 'getCaseById']);
    Route::delete('/remove/file/{id}', [CaseController::class, 'removeFile']);
    Route::patch('/edit/{id}', [CaseController::class, 'updateCase']);
    Route::delete('/delete/case/{id}', [CaseController::class, 'deleteCase']);


});
