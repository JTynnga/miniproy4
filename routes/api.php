<?php

use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\CursosAlumnosController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\DocentesController;
use App\Http\Middleware\Prueba01;
use App\Http\Middleware\VerifyCreate;
use App\Models\Alumnos;
use App\Models\CursosAlumnos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// ->middleware(Prueba01::class);->middleware(VerifyCreate::class);

Route::get('/alumnos', [AlumnosController::class, 'index']);
Route::get('/alumnos/{id}', [AlumnosController::class, 'getById']);
Route::post('/alumnos', [AlumnosController::class, 'create']);
Route::put('/alumnos/{id}', [AlumnosController::class, 'update']);
Route::delete('/alumnos/{id}', [AlumnosController::class, 'delete']);

Route::match(['put', 'delete'], '/alumnos', [AlumnosController::class, 'noIdExp']);
Route::match(['options', 'patch'], '/alumnos', [AlumnosController::class, 'wrongMethod']);
Route::match(['post', 'patch', 'options'], '/alumnos/{id}', [AlumnosController::class, 'wrongMethodId']);

Route::get('/docentes', [DocentesController::class, 'index']);
Route::get('/docentes/{id}', [DocentesController::class, 'getById']);
Route::post('/docentes', [DocentesController::class, 'create']);
Route::put('/docentes/{id}', [DocentesController::class, 'update']);
Route::delete('/docentes/{id}', [DocentesController::class, 'delete']);

Route::match(['put', 'delete'], '/docentes', [DocentesController::class, 'noIdExp']);
Route::match(['options', 'patch'], '/docentes', [DocentesController::class, 'wrongMethod']);
Route::match(['post', 'patch', 'options'], '/docentes/{id}', [DocentesController::class, 'wrongMethodId']);

Route::get('/cursos', [CursosController::class, 'index']);
Route::get('/cursos/{id}', [CursosController::class, 'getById']);
Route::post('/cursos', [CursosController::class, 'create']);
Route::put('/cursos/{id}', [CursosController::class, 'update']);
Route::delete('/cursos/{id}', [CursosController::class, 'delete']);

Route::match(['put', 'delete'], '/cursos', [CursosController::class, 'noIdExp']);
Route::match(['options', 'patch'], '/cursos', [CursosController::class, 'wrongMethod']);
Route::match(['post', 'patch', 'options'], '/cursos/{id}', [CursosController::class, 'wrongMethodId']);

Route::get('/matriculas', [CursosAlumnosController::class, 'index']);
Route::get('/matriculas/{id}', [CursosAlumnosController::class, 'getById']);
Route::post('/matriculas', [CursosAlumnosController::class, 'create']);
Route::put('/matriculas/{id}', [CursosAlumnosController::class, 'update']);
Route::delete('/matriculas/{id}', [CursosAlumnosController::class, 'delete']);

Route::match(['put', 'delete'], '/matriculas', [CursosAlumnosController::class, 'noIdExp']);
Route::match(['options', 'patch'], '/matriculas', [CursosAlumnosController::class, 'wrongMethod']);
Route::match(['post', 'patch', 'options'], '/matriculas/{id}', [CursosAlumnosController::class, 'wrongMethodId']);

Route::get('/asistencias', [CursosAlumnosController::class, 'noIdExp']);
// Route::get('/asistencias/{id}', [CursosAlumnosController::class, 'asistencia']);
Route::match(['put', 'post'], '/asistencias/{id}', [CursosAlumnosController::class, 'asistencia']);
Route::delete('/asistencias/{id}', [CursosAlumnosController::class, 'asistenciaDelete']);

Route::match(['put', 'delete'], '/asistencias', [CursosAlumnosController::class, 'noIdExp']);
Route::match(['options', 'patch'], '/asistencias', [CursosAlumnosController::class, 'wrongMethod']);
Route::match(['get', 'patch', 'options'], '/asistencias/{id}', [CursosAlumnosController::class, 'wrongMethodId2']);
