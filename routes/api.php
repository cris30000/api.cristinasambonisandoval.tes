<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\GraduateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ConsultaController;







/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('consulta/title/{grado}',[ConsultaController::class, 'consultaByempresa']);

Route::apiResource('companies', \App\Http\Controllers\CompanyController::class);
Route::apiResource('graduates', \App\Http\Controllers\GraduateController::class);
Route::apiResource('cities', \App\Http\Controllers\CityController::class);
Route::apiResource('departments', \App\Http\Controllers\DepartmentController::class);  
Route::apiResource('countries', \App\Http\Controllers\CountryController::class);  