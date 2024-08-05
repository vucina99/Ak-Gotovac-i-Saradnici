<?php

use App\Http\Controllers\CaseController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'case'], function () {
    Route::get('/get/type', [CaseController::class, 'getCaseTypes']);
    Route::post('/get/cases', [CaseController::class, 'getCases']);
    Route::post('/get/institutions', [CaseController::class, 'getInstitutions']);
    Route::post('/get/persons', [CaseController::class, 'getPersons']);
    Route::post('/create/case', [CaseController::class, 'createCase'])->middleware("adminHttp");
    Route::post('/files/upload', [CaseController::class, 'filesUpload'])->middleware("adminHttp");
    Route::post('/update/files', [CaseController::class, 'updateFiles'])->middleware("adminHttp");
    Route::get('/get/case/{id}', [CaseController::class, 'getCaseById']);
    Route::delete('/remove/file/{id}', [CaseController::class, 'removeFile'])->middleware("adminHttp");
    Route::patch('/edit/{id}', [CaseController::class, 'updateCase'])->middleware("adminHttp");
    Route::delete('/delete/case/{id}', [CaseController::class, 'deleteCase'])->middleware("adminHttp");

    Route::patch('/edit-file-path/{id}', [CaseController::class, 'updateFilePath'])->middleware("adminHttp");

    Route::post('/check/existing/name', [CaseController::class, 'checkExistingName'])->middleware("adminHttp");

});
