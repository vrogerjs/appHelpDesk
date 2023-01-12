<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Incidencia;
use App\Models\Oficina;
use App\Models\Solucion;
use App\Models\Tipouser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;


class IncidenciaController extends Controller
{
    public function index1()
    {
        if (accesoUser([1, 2, 3])) {
            $idtipouser = Auth::user()->tipouser_id;
            $tipouser = Tipouser::find($idtipouser);

            $modulo = "incidencia";
            return view('incidencia.index', compact('tipouser', 'modulo'));
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
        $idtipouser = Auth::user()->tipouser_id;
        $iduser = Auth::user()->id;
        $nomuser = Auth::user()->nombres;

        $data = json_encode(Session::all());
        $data = json_decode($data);

        if (isset($data->directory)) {
            $directorySession = $data->directory;
        } else {
            $directorySession = null;
        }

        // $directorySession = '18';

        $client = new Client();
        $request = new Psr7Request('GET', 'http://web.regionancash.gob.pe/admin/rh/api/contract/0/10?peopleId=' . $directorySession . '&active=1');
        $res = $client->sendAsync($request)->wait();
        $res->getBody();
        $oficinasAPI = json_decode($res->getBody());
        // $oficinasAPI = $oficinasAPI->data[0]->dependency;

        if ($idtipouser == 1) {
            $incidencias = DB::table('incidencias')
                ->join('categorias', 'categorias.id', '=', 'incidencias.categoria_id')
                ->join('users', 'users.id', '=', 'incidencias.user_id')
                ->where('incidencias.estado', '0')
                ->where(function ($query) use ($buscar) {
                    $query->where('incidencias.motivo', 'like', '%' . $buscar . '%');
                    $query->orWhere('incidencias.detalle', 'like', '%' . $buscar . '%');
                })
                ->orderBy('incidencias.id', 'desc')
                ->select('incidencias.id', 'incidencias.motivo', 'incidencias.detalle', 'incidencias.fecincidencia', 'incidencias.estado', 'incidencias.prioridad', 'incidencias.activo', 'incidencias.borrado', 'incidencias.categoria_id', 'incidencias.oficina', 'incidencias.user_id', 'categorias.id as idcategoria', 'categorias.name as categoria', 'users.nombres')
                ->paginate(15);
        } elseif ($idtipouser == 2) {
            $incidencias = DB::table('incidencias')
                ->join('categorias', 'categorias.id', '=', 'incidencias.categoria_id')
                ->join('users', 'users.id', '=', 'incidencias.user_id')
                ->join('categorias_responsables', 'categorias.id', '=', 'categorias_responsables.categoria_id')
                ->join('responsables', 'responsables.id', '=', 'categorias_responsables.responsable_id')
                ->where('incidencias.estado', '0')
                //   ->where(DB::raw("CONCAT('responsables.nombres',' ','responsables.apellidos')"), 'like', '%' . $nomuser . '%')
                ->where('responsables.nombres', $nomuser)
                ->where(function ($query) use ($buscar) {
                    $query->where('incidencias.motivo', 'like', '%' . $buscar . '%');
                    $query->orWhere('incidencias.detalle', 'like', '%' . $buscar . '%');
                })
                ->select('incidencias.id', 'incidencias.motivo', 'incidencias.detalle', 'incidencias.fecincidencia', 'incidencias.estado', 'incidencias.prioridad', 'incidencias.activo', 'incidencias.borrado', 'incidencias.categoria_id', 'incidencias.oficina', 'incidencias.user_id', 'categorias.id as idcategoria', 'categorias.name as categoria', 'users.nombres')
                ->paginate(15);
        } else {
            $incidencias = DB::table('incidencias')
                ->join('categorias', 'categorias.id', '=', 'incidencias.categoria_id')
                ->join('users', 'users.id', '=', 'incidencias.user_id')
                ->where('incidencias.estado', '0')
                ->where('incidencias.user_id', $iduser)
                ->where(function ($query) use ($buscar) {
                    $query->where('incidencias.motivo', 'like', '%' . $buscar . '%');
                    $query->orWhere('incidencias.detalle', 'like', '%' . $buscar . '%');
                })
                ->orderBy('incidencias.id', 'desc')
                ->select('incidencias.id', 'incidencias.motivo', 'incidencias.detalle', 'incidencias.fecincidencia', 'incidencias.estado', 'incidencias.prioridad', 'incidencias.activo', 'incidencias.borrado', 'incidencias.categoria_id', 'incidencias.oficina', 'incidencias.user_id', 'categorias.id as idcategoria', 'categorias.name as categoria', 'users.nombres')
                ->paginate(15);
        }

        $categorias = Categoria::where('borrado', '0')->where('activo', '1')->orderBy('name')->get();

        $oficinas = Oficina::where('borrado', '0')->where('activo', '1')->orderBy('oficina')->get();

        return [
            'pagination' => [
                'total' => $incidencias->total(),
                'current_page' => $incidencias->currentPage(),
                'per_page' => $incidencias->perPage(),
                'last_page' => $incidencias->lastPage(),
                'from' => $incidencias->firstItem(),
                'to' => $incidencias->lastItem(),
            ],
            'incidencias' => $incidencias,
            'categorias' => $categorias,
            'oficinas' => $oficinas,
            'nomuser' => $nomuser,
            'data' => $data,
            'oficinasAPI' => $oficinasAPI
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
        $motivo = $request->motivo;
        $detalle = $request->detalle;
        $prioridad = $request->prioridad;
        $categoria_id = $request->categoria_id;
        $oficina = $request->oficina;
        $activo = $request->activo;
        $date = Carbon::now();

        $result = '1';
        $msj = '';
        $selector = '';

        $input1  = array('motivo' => $motivo);
        $reglas1 = array('motivo' => 'required');

        $input2  = array('detalle' => $detalle);
        $reglas2 = array('detalle' => 'required');

        $input3  = array('categoria_id' => $categoria_id);
        $reglas3 = array('categoria_id' => 'required');

        // $input4  = array('oficina' => $oficina);
        // $reglas4 = array('oficina' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        // $validator4 = Validator::make($input4, $reglas4);

        if ($validator3->fails()) {
            $result = '0';
            $msj = 'Seleccion la Categoría.';
            $selector = 'cbucategoria';
        } elseif ($validator1->fails()) {
            $result = '0';
            $msj = 'Debe ingresar el título de la Incidencia.';
            $selector = 'txtmotivo';
        } elseif ($validator2->fails()) {
            $result = '0';
            $msj = 'Debe ingresar el detalle de la incidencia.';
            $selector = 'txtdetalle';
        } else {

            $newIncidencia = new Incidencia();

            $newIncidencia->motivo = $motivo;
            $newIncidencia->detalle = $detalle;
            $newIncidencia->fecincidencia = $date;
            $newIncidencia->estado = '0';
            $newIncidencia->prioridad = $prioridad;
            $newIncidencia->categoria_id = $categoria_id;
            $newIncidencia->oficina = $oficina;
            $newIncidencia->user_id = Auth::user()->id;
            $newIncidencia->activo = $activo;
            $newIncidencia->borrado = '0';
            $newIncidencia->save();

            $msj = 'Nueva Incidencia Registrada con Éxito';
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
        $detalle = $request->detalle;
        $date = Carbon::now();

        $result = '1';
        $msj = '';
        $selector = '';

        $input1  = array('detalle' => $detalle);
        $reglas1 = array('detalle' => 'required');

        $validator1 = Validator::make($input1, $reglas1);

        if ($validator1->fails()) {
            $result = '0';
            $msj = 'Debe de ingresar la solución de forma detallada.';
            $selector = 'cbucategoriaE';
        } else {

            $updateIncidencia = Incidencia::findOrFail($id);
            $updateIncidencia->estado = '1';
            $updateIncidencia->save();


            $newSolucion = new Solucion();
            $newSolucion->detalle = $detalle;
            $newSolucion->fecsolucion = $date;
            $newSolucion->incidencia_id = $id;
            $newSolucion->user_id = Auth::user()->id;
            $newSolucion->activo = '1';
            $newSolucion->borrado = '0';
            $newSolucion->save();

            $msj = 'La solución al ticket de incidencia fue registrada.';
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

        $incidencia = Incidencia::findOrFail($id);
        $iconCategoria = Incidencia::where('id', $incidencia->id)->get();

        foreach ($iconCategoria as $key => $dato) {
            $icono = Incidencia::findOrFail($dato->id);
            $imagen = Incidencia::findOrFail($dato->id);
            Storage::disk('incidencias-icon')->delete($icono->icono);
            Storage::disk('incidencias-image')->delete($imagen->imagen);
        }

        $incidencia->borrado = '1';
        $incidencia->save();

        $msj = 'Incidencia eliminado exitosamente.';

        return response()->json(["result" => $result, 'msj' => $msj]);
    }

    public function altabaja($id, $estado)
    {
        $result = '1';
        $msj = '';
        $selector = '';

        $incidencia = Incidencia::findOrFail($id);
        $incidencia->activo = $estado;
        $incidencia->save();

        if (strval($estado) == "0") {
            $msj = 'La Incidencia fue Desactivada exitosamente.';
        } elseif (strval($estado) == "1") {
            $msj = 'La Incidencia fue Activada exitosamente.';
        }

        return response()->json(["result" => $result, 'msj' => $msj, 'selector' => $selector]);
    }
}
