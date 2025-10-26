<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarreraController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MateriaController;

// Carrera Routes

Route::apiResource('/carreras', CarreraController::class);
Route::get('carrerasConMaterias', [CarreraController::class, 'carrerasConMaterias']);

// Materia Routes
Route::apiResource('/materias', MateriaController::class);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Authenticated Routes (Requires Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {

        return $request->user();

    });
    Route::post('/logout', [AuthController::class, 'logout']);



});