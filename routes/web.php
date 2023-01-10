<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\ResponsableController;
use App\Http\Controllers\SolucionController;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function (Request $request) {
    $code = $request->query('code');
    if (!isset($code)) {
        return Redirect::to('http://web.regionancash.gob.pe/api/oauth/authorize?response_type=code&client_id=DDc3q7V6rIKj4rdQlrg8yT2R');
        return $code;
    } else {
        try {
            $client = new Client();
            $headers = [
                'Content-Type' => 'text/plain'
            ];
            $request = new Psr7Request('POST', 'http://web.regionancash.gob.pe/api/auth/token', $headers, $code);
            $res = $client->sendAsync($request)->wait();
            $token = json_decode($res->getBody());
            $token = $token->token;

            $data = str_replace('_', '/', str_replace('-', '+', explode('.', $token)[1]));
            $users = json_decode(base64_decode($data));
            if ($user = User::where('name', $users->user)->first()) {
                Auth::login($user);
                $modulo = "inicioAdmin";

                return view('inicio.home', compact('users', 'modulo'));
            } else {
                return view('/acceso');
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
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
