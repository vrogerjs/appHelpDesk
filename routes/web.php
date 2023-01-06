<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\ResponsableController;
use App\Http\Controllers\SolucionController;
use Illuminate\Support\Facades\Route;

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
    return redirect('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/categorias', [CategoriaController::class, 'index1'])->name('categorias');
Route::get('/categoria/altabaja/{id}/{var}', [CategoriaController::class, 'altabaja'])->name('altabaja');
Route::resource('categoria', CategoriaController::class);

Route::get('/responsables', [ResponsableController::class, 'index1'])->name('responsables');
Route::get('/responsable/altabaja/{id}/{var}', [ResponsableController::class, 'altabaja'])->name('altabaja');
Route::resource('responsable', ResponsableController::class);

Route::get('/incidencias', [IncidenciaController::class, 'index1'])->name('incidencias');
Route::get('/incidencia/altabaja/{id}/{var}', [IncidenciaController::class, 'altabaja'])->name('altabaja');
Route::resource('incidencia', IncidenciaController::class);

Route::get('/solucions', [SolucionController::class, 'index1'])->name('solucions');
Route::get('/solucion/altabaja/{id}/{var}', [SolucionController::class, 'altabaja'])->name('altabaja');
Route::resource('solucion', SolucionController::class);


Route::get('/verResponsables/{id}', [CategoriaController::class, 'verResponsables'])->name('verResponsables');

Route::put('/asignarresponsable/{categoria_id}', [CategoriaController::class, 'asignarResponsables'])->name('asignarResponsables');

