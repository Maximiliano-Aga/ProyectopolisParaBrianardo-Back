<?php

use App\Http\Controllers\AsistenciasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\EstadosAsistenciaController;
use App\Http\Controllers\InscripcionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ContadorAsistenciasController;

/* Public Routes (No authentication required) */

/* Auth */
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

/* Roles */
Route::get('roles', [RolesController::class, 'index']);

/* Authenticated Routes (Requires Sanctum token) */
Route::middleware('auth:sanctum')->group(function () {
    // NUEVA RUTA: Reporte de Asistencias por Alumno
    Route::get('reportes/asistencias/{userId}/{materiaId}', [ContadorAsistenciasController::class, 'getSummary']);

    /* Logout */
    Route::post('logout', [AuthController::class, 'logout']);

    /* Usuarios */
    Route::prefix('usuarios')->group(function () {
        Route::get('/', [UsuariosController::class, 'index'])->middleware('role:admin');
        Route::get('/{id}', [UsuariosController::class, 'show'])->middleware('role:admin');
    });

    /* Carreras */
    Route::prefix('carreras')->group(function () {
        Route::get('/', [CarreraController::class, 'index'])->middleware('role:admin|profesor|estudiante');
        Route::post('/', [CarreraController::class, 'store'])->middleware('role:admin');
        Route::get('/{id}', [CarreraController::class, 'show'])->middleware('role:admin|profesor|estudiante');
        Route::put('/{id}', [CarreraController::class, 'update'])->middleware('role:admin');
        Route::delete('/{id}', [CarreraController::class, 'destroy'])->middleware('role:admin');
    });
    Route::get('carrerasConMaterias', [CarreraController::class, 'carrerasConMaterias'])->middleware('role:admin|profesor|estudiante');

    /* Materias */
    Route::prefix('materias')->group(function () {
        Route::get('/', [MateriaController::class, 'index'])->middleware('role:admin|profesor|estudiante');
        Route::post('/', [MateriaController::class, 'store'])->middleware('role:admin');
        Route::get('/{id}', [MateriaController::class, 'show'])->middleware('role:admin|profesor|estudiante');
        Route::put('/{id}', [MateriaController::class, 'update'])->middleware('role:admin');
        Route::delete('/{id}', [MateriaController::class, 'destroy'])->middleware('role:admin');
        Route::get('usuario/{userId}',[MateriaController::class, 'getMateriasPorUsuario'])->middleware('role:estudiante');

    });

    /* Inscripciones */
    Route::prefix('inscripciones')->group(function () {
        Route::get('/', [InscripcionController::class, 'index'])->middleware('role:admin|profesor|estudiante');
        Route::post('/', [InscripcionController::class, 'store'])->middleware('role:admin|estudiante');
        Route::get('/{id}', [InscripcionController::class, 'show'])->middleware('role:admin|profesor|estudiante');
        Route::put('/{id}', [InscripcionController::class, 'update'])->middleware('role:admin');
        Route::delete('/{id}', [InscripcionController::class, 'destroy'])->middleware('role:admin');
    });
    Route::get('inscripcionesPendientes', [InscripcionController::class, 'inscripcionesPendientes'])->middleware('role:admin');
    Route::get('inscripcionesPorMateria/{idMateria}', [InscripcionController::class, 'inscripcionPorIdMateria'])->middleware('role:admin|profesor');

    /* Asistencias */
    Route::prefix('asistencias')->group(function () {
        Route::get('/', [AsistenciasController::class, 'index'])->middleware('role:admin|profesor|estudiante');
        Route::post('/', [AsistenciasController::class, 'store'])->middleware('role:admin|profesor');
        Route::get('/{id}', [AsistenciasController::class, 'show'])->middleware('role:admin|profesor|estudiante');
        Route::put('/{id}', [AsistenciasController::class, 'update'])->middleware('role:admin|profesor');
        Route::delete('/{id}', [AsistenciasController::class, 'destroy'])->middleware('role:admin');
    });

    /* Asistencias estados */
    Route::prefix('estados_asistencias')->group(function () {
        Route::get('/', [AsistenciasController::class, 'index'])->middleware('role:admin|profesor|estudiante');
        Route::post('/', [AsistenciasController::class, 'store'])->middleware('role:admin');
        Route::get('/{id}', [AsistenciasController::class, 'show'])->middleware('role:admin|profesor|estudiante');
        Route::put('/{id}', [AsistenciasController::class, 'update'])->middleware('role:admin');
        Route::delete('/{id}', [AsistenciasController::class, 'destroy'])->middleware('role:admin');
    });

});