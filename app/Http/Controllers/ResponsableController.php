<?php

namespace App\Http\Controllers;

use App\Models\Responsable;
use Illuminate\Http\Request;
use App\Models\Tipouser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ResponsableController extends Controller
{
    public function index1()
    {
        $idtipouser = Auth::user()->tipouser_id;
        $tipouser = Tipouser::find($idtipouser);

        $modulo = "responsable";
        return view('responsable.index', compact('tipouser', 'modulo'));
    }
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $buscar = $request->busca;

        $responsables = Responsable::where('borrado', '0')
        ->where(function ($query) use ($buscar) {
            $query->where('apellidos', 'like', '%' . $buscar . '%');
            $query->orwhere('nombres', 'like', '%' . $buscar . '%');
            $query->orwhere('cargo', 'like', '%' . $buscar . '%');
        })
        ->orderBy('id', 'desc')->paginate(10);

        return [
            'pagination' => [
                'total' => $responsables->total(),
                'current_page' => $responsables->currentPage(),
                'per_page' => $responsables->perPage(),
                'last_page' => $responsables->lastPage(),
                'from' => $responsables->firstItem(),
                'to' => $responsables->lastItem(),
            ],
            'responsables' => $responsables
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
        
        $apellidos = $request->apellidos;
        $nombres = $request->nombres;
        $cargo = $request->cargo;
        $activo = $request->activo;

        $result = '1';
        $msj = '';
        $selector = '';
    
        $input1  = array('apellidos' => $apellidos);
        $reglas1 = array('apellidos' => 'required|unique:responsables');

        $input2  = array('nombres' => $nombres);
        $reglas2 = array('nombres' => 'required');

        $input3  = array('cargo' => $cargo);
        $reglas3 = array('cargo' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);

        if ($validator1->fails()) {
            $result = '0';
            $msj = 'Debe ingresar los apellidos del Responsable.';
            $selector = 'txtapellidos';
        } elseif ($validator2->fails()) {
            $result = '0';
            $msj = 'Debe ingresar los nombres del Responsable.';
            $selector = 'txtnombres';
        } elseif ($validator3->fails()) {
            $result = '0';
            $msj = 'Debe ingresar el cargo del Responsable.';
            $selector = 'txtcargo';
        }else {

            $newResponsable = new Responsable();

            $newResponsable->apellidos = $apellidos;
            $newResponsable->nombres = $nombres;
            $newResponsable->cargo = $cargo;
            $newResponsable->activo = $activo;
            $newResponsable->borrado = '0';
            $newResponsable->save();

            $msj = 'Nuevo Responsable Registrado con Éxito';
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
       
        $apellidos = $request->apellidos;
        $nombres = $request->nombres;
        $cargo = $request->cargo;
        $activo = $request->activo;

        $result = '1';
        $msj = '';
        $selector = '';

        $input1  = array('apellidos' => $apellidos);
        $reglas1 = array('apellidos' => 'required');

        $input2  = array('nombres' => $nombres);
        $reglas2 = array('nombres' => 'required');

        $input3  = array('cargo' => $cargo);
        $reglas3 = array('cargo' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);

        if ($validator1->fails()) {
            $result = '0';
            $msj = 'Debe ingresar los apellidos del Responsable.';
            $selector = 'txtapellidosE';
        } elseif ($validator2->fails()) {
            $result = '0';
            $msj = 'Debe ingresar los nombres del Responsable.';
            $selector = 'txtnombresE';
        } elseif ($validator3->fails()) {
            $result = '0';
            $msj = 'Debe ingresar el cargo del Responsable.';
            $selector = 'txtcargoE';
        }else {

            $responsable = Responsable::findOrFail($id);

            $responsable->apellidos = $apellidos;
            $responsable->nombres = $nombres;
            $responsable->cargo = $cargo;
            $responsable->activo = $activo;

            $responsable->save();

            $msj = 'El responsable ha sido modificado con éxito.';
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
        $selector = '';

        $responsable = Responsable::findOrFail($id);

        $responsable->borrado = '1';
        $responsable->save();

        $msj = 'Responsable eliminado exitosamente.';

        return response()->json(["result" => $result, 'msj' => $msj]);
    }

    public function altabaja($id, $estado)
    {
        $result = '1';
        $msj = '';
        $selector = '';

        $responsable = Responsable::findOrFail($id);
        $responsable->activo = $estado;
        $responsable->save();

        if (strval($estado) == "0") {
            $msj = 'La Responsable fue Desactivado exitosamente.';
        } elseif (strval($estado) == "1") {
            $msj = 'La Responsable fue Activado exitosamente.';
        }

        return response()->json(["result" => $result, 'msj' => $msj, 'selector' => $selector]);
    }
}
