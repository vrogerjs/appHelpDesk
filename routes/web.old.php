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

// Route::get('/', function (Request $request) {
//     // return ('http://web.regionancash.gob.pe/');
//     //return redirect('login');
//     $email = $request->query('email');
//     $password = $request->query('password');
//     if (isset($email)) {

//         return $password;
//     }
//     return Redirect::to('http://web.regionancash.gob.pe/');
// });


Route::get('/', function (Request $request) {


    $code = $request->query('code');
    if (!isset($code)) {
        return Redirect::to('http://web.regionancash.gob.pe/api/oauth/authorize?response_type=code&client_id=DDc3q7V6rIKj4rdQlrg8yT2R');
        return $code;
    } else {
        try {

            // $client_id = 'DDc3q7V6rIKj4rdQlrg8yT2R';
            // $client_secret = 'yI95SyxByeVDncEqNUMk3tsXKIxsUOXGjsuetYG6yFRfvxhY';

            // $client = new Client();
            // $headers = [
            //     'Authorization' => 'Basic ' . base64_encode("$client_id:$client_secret")
            // ];
            // $options = [
            //     'multipart' => [
            //         [
            //             'name' => 'grant_type',
            //             'contents' => 'authorization_code'
            //         ],
            //         [
            //             'name' => 'scope',
            //             'contents' => 'profile'
            //         ],
            //         [
            //             'name' => 'code',
            //             'contents' => $code
            //         ]
            //     ]
            // ];
            // $request = new Psr7Request('POST', 'http://web.regionancash.gob.pe/api/oauth/token', $headers);
            // $res = $client->sendAsync($request, $options)->wait();
            // $res = json_decode($res->getBody());

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

                // return \Redirect::route('home', ['users' => $users]);

                return Redirect::to('/home');
            } else {
                return view('/acceso');
            }

            // $headers = [
            //     'Authorization' => 'Basic ' . base64_encode("$client_id:$client_secret")
            // ];

            // $request = new Request('POST', 'http://web.regionancash.gob.pe/api/oauth/token?grant_type=authorization_code&scope=profile&code=' + $code, $headers);

            // $res = $client->sendAsync($request, $options)->wait();

            // $response = new Request('POST', 'http://web.regionancash.gob.pe/api/oauth/token', [
            //     'Authorization' => 'Authorization: Basic ' . base64_encode("$client_id:$client_secret")
            // ], [
            //     'form_params' => [
            //         'grant_type' => 'authorization_code',
            //         'scope' => 'profile',
            //         'code' => $code
            //     ]
            // ]);

            // $clientes = json_decode($response->getBody());

            // return $clientes;



            // $response = $client->request('POST', 'http://web.regionancash.gob.pe/api/oauth/token', [
            //     'Authorization' => 'Authorization: Basic ' . base64_encode("$client_id:$client_secret")
            // ], [
            //     'form_params' => [
            //         'grant_type' => 'authorization_code',
            //         'scope' => 'profile',
            //         'code' => $code
            //     ]
            // ]);

            // $clientes = json_decode($response->getBody());

            // return $clientes;




            /* $client = new Client();
            $headers = [
              'Authorization' => 'Basic YWFhYTpiYmJi'
            ];
            $options = [
              'multipart' => [
                [
                  'name' => 'grant_type',
                  'contents' => 'a'
                ],
                [
                  'name' => 'b',
                  'contents' => '120'
                ],
                [
                  'name' => 'b',
                  'contents' => '120'
                ]
            ]];
            $request = new Request('POST', 'https://reqres.in/api/login', $headers);
            $res = $client->sendAsync($request, $options)->wait();
            echo $res->getBody();

*/

            /* $headers = [
                'Content-Type' => 'application/json'
            ];
            $body = '{
                "email": "eve.holt@reqres.in",
                "password": "123124123"
            }';
            $request = new Psr7Request('POST', 'http://web.regionancash.gob.pe/api/oauth/token', $headers, $body);
            $res = $client->sendAsync($request)->wait();
            $clientes = json_decode($res->getBody());
            $res2 = json_decode($body);
    
            $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJodHRwczovL2V4YW1wbGUuY29tL2lzc3VlciIsInVwbiI6Impkb2VAcXVhcmt1cy5pbyIsImdyb3VwcyI6WyJVc2VyIiwiQWRtaW4iXSwidWlkIjoxLCJ1c2VyIjoiYWRtaW4iLCJiaXJ0aGRhdGUiOiIyMDAxLTA3LTEzIiwiaWF0IjoxNjczMjgyMTAwLCJleHAiOjE2NzMyODU3MDAsImp0aSI6Ijg1NGJiNGI3LTNiZGEtNDUyNS1hN2FiLWZiY2ZiYWI5Njc2NSJ9.TuwtGWN4Ne2N-2BTUC6bCH2Bkfy9UQKr8tE_UstR_mvQrFJ7sRHFaWd_TR-a_ru0kjPasjD5LubYU1iWavdCQhoHsJWDfbZlRQd7QZCBV9Pefruohx-zML-ecYlK5Jlfug7HRMoGQzpO43LkzlFaznkvP-cui39A41BAEDagpZMxyewlPzDuHc_Z0eqQI-NhGMNXij5PPp7m08fp_tvAWsgoF2peuDVc01JX5xiCFC1z1oX6nd6VbHhEGpWu0pPG5LM4hPl4J0HqDhZ9U2U76EcOFxjjViJg-ulKf0e9t6JXdCfv1HbJozwbUmo_-HL-MePVTF1PoNpOskKacf23MA';
    
*/


            /* $data = str_replace('_', '/', str_replace('-', '+', explode('.', $token)[1]));
            $users = json_decode(base64_decode($data));
            if ($user = User::where('name', $users->user)->first()) {
                Auth::login($user);
                return Redirect::to('/home');
            } else {
                return view('/acceso');
            }*/

            // return $user2->user;
            // return $user2->users;
            // echo $res->getBody();
        } catch (\Throwable $th) {
            //
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
