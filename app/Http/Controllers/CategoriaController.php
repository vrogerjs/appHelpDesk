<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\CategoriaResponsable;
use App\Models\Responsable;
use Illuminate\Http\Request;
use App\Models\Tipouser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    public function index1()
    {
        $idtipouser = Auth::user()->tipouser_id;
        $tipouser = Tipouser::find($idtipouser);

        $modulo = "categoria";
        return view('categoria.index', compact('tipouser', 'modulo'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buscar = $request->busca;

        $categorias = Categoria::where('borrado', '0')
            ->where(function ($query) use ($buscar) {
                $query->where('name', 'like', '%' . $buscar . '%');
                $query->orwhere('descripcion', 'like', '%' . $buscar . '%');
            })
            ->orderBy('id', 'desc')->paginate(10);

        return [
            'pagination' => [
                'total' => $categorias->total(),
                'current_page' => $categorias->currentPage(),
                'per_page' => $categorias->perPage(),
                'last_page' => $categorias->lastPage(),
                'from' => $categorias->firstItem(),
                'to' => $categorias->lastItem(),
            ],
            'categorias' => $categorias
        ];
    }

    public function verResponsables($id)
    {
        $responsables = DB::table('categorias_responsables')
            ->join('categorias', 'categorias.id', '=', 'categorias_responsables.categoria_id')
            ->join('responsables', 'responsables.id', '=', 'categorias_responsables.responsable_id')
            ->orderBy('categorias_responsables.id', 'desc')
            ->where('categorias_responsables.categoria_id', $id)
            ->select('categorias_responsables.id', 'categorias_responsables.categoria_id', 'categorias_responsables.responsable_id', 'categorias.id as idcategoria', 'categorias.name as categoria', 'responsables.id as idresponsable', 'responsables.apellidos', 'responsables.nombres')
            ->paginate(15);

        // $cburesponsables = DB::table('categorias_responsables')
        //     ->join('categorias', 'categorias.id', '=', 'categorias_responsables.categoria_id')
        //     ->join('responsables', 'responsables.id', '=', 'categorias_responsables.responsable_id')
        //     ->orderBy('categorias_responsables.id', 'desc')
        //     ->where('categorias_responsables.categoria_id','!=', $id)
        //     ->select('categorias_responsables.id', 'categorias_responsables.categoria_id', 'categorias_responsables.responsable_id', 'categorias.id as idcategoria', 'categorias.name as categoria', 'responsables.id as idresponsable', 'responsables.apellidos', 'responsables.nombres')
        //     ->paginate(15);

        $cburesponsables = Responsable::where('borrado', '0')->where('activo', '1')->orderBy('nombres')->get();

        return ['responsables' => $responsables, 'cburesponsables' => $cburesponsables];
    }

    public function asignarResponsables(Request $request, $categoria_id)
    {

        $categoria_id = $request->categoria_id;
        $responsable_id = $request->responsable_id;

        $result = '1';
        $msj = '';
        $selector = '';

        // $resp = DB::select("SELECT count(*) as cont FROM categorias_responsables where categoria_id=" . $categoria_id . " and responsable_id=" . $responsable_id . ";");

        $resp = CategoriaResponsable::where('categoria_id',$categoria_id)->where('responsable_id',$responsable_id)->count();

        // $dato->imagencomunicado = $imagencomunicado;


        // $resp = CategoriaResponsable::whereColumn([
        //     ['categoria_id', $categoria_id],
        //     ['responsable_id', $responsable_id]
        // ])->count();

        $input1  = array('responsable_id' => $responsable_id);
        $reglas1 = array('responsable_id' => 'required');

        $validator1 = Validator::make($input1, $reglas1);

        if ($validator1->fails()) {
            $result = '0';
            $msj = 'Debe seleccionar el nombre de un responsable.';
            $selector = 'txtnameE';
        } elseif($resp > 0){
            $result = '0';
            $msj = 'Seleccione a otro responsable, el seleccionado ya esta asignado a dicha categoría.';
            $selector = 'txtnameE';
        } else {

            $newCategoriaResponsable = new CategoriaResponsable();

            $newCategoriaResponsable->categoria_id = $categoria_id;
            $newCategoriaResponsable->responsable_id = $responsable_id;
            $newCategoriaResponsable->save();

            $msj = 'La asignación se realizo con éxito.';
        }


        return response()->json(["result" => $result, 'msj' => $msj, 'selector' => $selector]);
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

        $name = $request->name;
        $descripcion = $request->descripcion;
        $activo = $request->activo;

        $result = '1';
        $msj = '';
        $selector = '';

        $input1  = array('name' => $name);
        $reglas1 = array('name' => 'required|unique:categorias');

        $input2  = array('descripcion' => $descripcion);
        $reglas2 = array('descripcion' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);

        if ($validator1->fails()) {
            $result = '0';
            $msj = 'Debe ingresar el nombre de la Categoria u otro nombre.';
            $selector = 'txttitulo';
        } elseif ($validator2->fails()) {
            $result = '0';
            $msj = 'Debe ingresar la descripción de la Categoria.';
            $selector = 'txtdescripcion';
        } else {

            $newCategoria = new Categoria();

            $newCategoria->name = $name;
            $newCategoria->descripcion = $descripcion;
            $newCategoria->activo = $activo;
            $newCategoria->borrado = '0';
            $newCategoria->save();

            $msj = 'Nueva Categoria Registrada con Éxito';
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

        $name = $request->name;
        $descripcion = $request->descripcion;
        $activo = $request->activo;

        $result = '1';
        $msj = '';
        $selector = '';

        $input1  = array('name' => $name);
        $reglas1 = array('name' => 'required');

        $input2  = array('descripcion' => $descripcion);
        $reglas2 = array('descripcion' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);

        if ($validator1->fails()) {
            $result = '0';
            $msj = 'Debe ingresar el nombre de la Categoria u otro nombre.';
            $selector = 'txtnameE';
        } elseif ($validator2->fails()) {
            $result = '0';
            $msj = 'Debe ingresar la descripcion del Categoria.';
            $selector = 'txtdescripcionE';
        } else {

            $categoria = Categoria::findOrFail($id);

            $categoria->name = $name;
            $categoria->descripcion = $descripcion;
            $categoria->activo = $activo;

            $categoria->save();

            $msj = 'La categoria ha sido modificado con éxito.';
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

        $categoria = Categoria::findOrFail($id);

        $categoria->borrado = '1';
        $categoria->save();

        $msj = 'Categoria eliminado exitosamente.';

        return response()->json(["result" => $result, 'msj' => $msj]);
    }

    public function altabaja($id, $estado)
    {
        $result = '1';
        $msj = '';
        $selector = '';

        $categoria = Categoria::findOrFail($id);
        $categoria->activo = $estado;
        $categoria->save();

        if (strval($estado) == "0") {
            $msj = 'La Categoria fue Desactivada exitosamente.';
        } elseif (strval($estado) == "1") {
            $msj = 'La Categoria fue Activada exitosamente.';
        }

        return response()->json(["result" => $result, 'msj' => $msj, 'selector' => $selector]);
    }
}
