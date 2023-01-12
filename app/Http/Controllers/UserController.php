<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Solucion;
use App\Models\Tipouser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isNull;

class UserController extends Controller
{
    public function index1()
    {
        if (accesoUser([1, 2, 3])) {
            $idtipouser = Auth::user()->tipouser_id;
            $tipouser = Tipouser::find($idtipouser);

            $modulo = "user";
            return view('user.index', compact('tipouser', 'modulo'));
        } else {
            $modulo = "inicioAdmin";
            return view('inicio.home', compact('modulo'));
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buscar = $request->busca;

        $users = User::where('borrado', '0')->where('activo', '1')->orderBy('nombres')->get();

        $users = DB::table('users')
            ->join('tipousers', 'tipousers.id', '=', 'users.tipouser_id')
            ->where('users.borrado', '0')
            ->where(function ($query) use ($buscar) {
                $query->where('users.nombres', 'like', '%' . $buscar . '%');
                $query->orWhere('users.name', 'like', '%' . $buscar . '%');
                $query->orWhere('tipousers.nombre', 'like', '%' . $buscar . '%');
            })
            ->orderBy('users.id', 'desc')
            ->select('users.id', 'users.nombres', 'users.name', 'users.email', 'users.tipouser_id', 'tipousers.nombre as tipouser', 'users.activo', 'users.borrado')
            ->paginate(20);

        $tipousers = Tipouser::where('borrado', '0')->where('activo', '1')->orderBy('nombre')->get();

        return [
            'pagination' => [
                'total' => $users->total(),
                'current_page' => $users->currentPage(),
                'per_page' => $users->perPage(),
                'last_page' => $users->lastPage(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem(),
            ],
            'users' => $users,
            'tipousers' => $tipousers
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nombres = $request->nombres;
        $name = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);
        $tipouser_id = $request->tipouser_id;
        $activo = $request->activo;

        $result = '1';
        $msj = '';
        $selector = '';

        $input1  = array('nombres' => $nombres);
        $reglas1 = array('nombres' => 'required|unique:users');

        $input2  = array('name' => $name);
        $reglas2 = array('name' => 'required|unique:users');

        $input3  = array('email' => $email);
        $reglas3 = array('email' => 'required');

        $input4  = array('password' => $password);
        $reglas4 = array('password' => 'required');

        $input5  = array('tipouser_id' => $tipouser_id);
        $reglas5 = array('tipouser_id' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);

        if ($validator5->fails()) {
            $result = '0';
            $msj = 'Seleccion el Tipo de Usuario.';
            $selector = 'cbutipouser';
        } elseif ($validator1->fails()) {
            $result = '0';
            $msj = 'Ingrese los Nombres Completos del Usuario.';
            $selector = 'txtnombre';
        } elseif ($validator2->fails()) {
            $result = '0';
            $msj = 'Ingrese el username.';
            $selector = 'txtname';
        } elseif ($validator3->fails()) {
            $result = '0';
            $msj = 'Ingrese el correo electrónico del usuario.';
            $selector = 'txtemail';
        } elseif ($validator5->fails()) {
            $result = '0';
            $msj = 'Ingrese la contraseña del Usuario.';
            $selector = 'txtpassword';
        } else {

            $newUser = new User();

            $newUser->nombres = $nombres;
            $newUser->name = $name;
            $newUser->email = $email;
            $newUser->password = $password;
            $newUser->tipouser_id = $tipouser_id;
            $newUser->activo = $activo;
            $newUser->borrado = '0';
            $newUser->save();

            $msj = 'Nueva Usuario Registrada con Éxito';
        }

        return response()->json(["result" => $result, 'msj' => $msj, 'selector' => $selector]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nombres = $request->nombres;
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $tipouser_id = $request->tipouser_id;
        $activo = $request->activo;

        $result = '1';
        $msj = '';
        $selector = '';

        $input1  = array('nombres' => $nombres);
        $reglas1 = array('nombres' => 'required');

        $input2  = array('name' => $name);
        $reglas2 = array('name' => 'required');

        $input3  = array('email' => $email);
        $reglas3 = array('email' => 'required');

        $input4  = array('password' => $password);
        $reglas4 = array('password' => 'required');

        $input5  = array('tipouser_id' => $tipouser_id);
        $reglas5 = array('tipouser_id' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);


        if ($validator5->fails()) {
            $result = '0';
            $msj = 'Seleccion el Tipo de Usuario.';
            $selector = 'cbutipouserE';
        } elseif ($validator1->fails()) {
            $result = '0';
            $msj = 'Ingrese los Nombres Completos del Usuario.';
            $selector = 'txtnombreE';
        } elseif ($validator2->fails()) {
            $result = '0';
            $msj = 'Ingrese el username.';
            $selector = 'txtnameE';
        } elseif ($validator3->fails()) {
            $result = '0';
            $msj = 'Ingrese el correo electrónico del usuario.';
            $selector = 'txtemailE';
        } else {

            $updateUser = User::findOrFail($id);

            $updateUser->nombres = $nombres;
            $updateUser->name = $name;
            $updateUser->email = $email;
            if ($password != 'undefined' || $password != '' || $password != null) {
                $updateUser->password = Hash::make($password);
            }
            $updateUser->tipouser_id = $tipouser_id;
            $updateUser->activo = $activo;
            $updateUser->borrado = '0';
            $updateUser->save();

            $msj = 'El Usuario fue actualizaco con exito.';
        }


        return response()->json(["result" => $result, 'msj' => $msj, 'selector' => $selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = '1';
        $msj = '1';

        $user = User::findOrFail($id);
        $user->borrado = '1';
        $user->save();

        $msj = 'Usuario eliminado exitosamente.';

        return response()->json(["result" => $result, 'msj' => $msj]);
    }

    public function altabaja($id, $estado)
    {
        $result = '1';
        $msj = '';
        $selector = '';

        $user = User::findOrFail($id);
        $user->activo = $estado;
        $user->save();

        if (strval($estado) == "0") {
            $msj = 'El Usuario fue Desactivada exitosamente.';
        } elseif (strval($estado) == "1") {
            $msj = 'El Usuario fue Activada exitosamente.';
        }

        return response()->json(["result" => $result, 'msj' => $msj, 'selector' => $selector]);
    }
}
