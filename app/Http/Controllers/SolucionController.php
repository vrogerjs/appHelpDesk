<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Incidencia;
use App\Models\Oficina;
use App\Models\Tipouser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SolucionController extends Controller
{
    public function index1()
    {
        if (accesoUser([1, 2, 3])) {
            $idtipouser = Auth::user()->tipouser_id;
            $tipouser = Tipouser::find($idtipouser);

            $modulo = "solucion";
            return view('solucion.index', compact('tipouser', 'modulo'));
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

        if ($idtipouser == 1) {
            $solucions = DB::table('solucions')
                ->join('incidencias', 'incidencias.id', '=', 'solucions.incidencia_id')
                ->join('users as us', 'us.id', '=', 'solucions.user_id')
                ->join('categorias', 'categorias.id', '=', 'incidencias.categoria_id')
                ->join('users', 'users.id', '=', 'incidencias.user_id')
                ->where('incidencias.estado', '1')
                ->where(function ($query) use ($buscar) {
                    $query->where('incidencias.motivo', 'like', '%' . $buscar . '%');
                    $query->orWhere('incidencias.detalle', 'like', '%' . $buscar . '%');
                })
                ->orderBy('solucions.id', 'desc')
                ->select('solucions.detalle as soldetalle', 'solucions.fecsolucion', 'incidencias.id', 'incidencias.motivo', 'incidencias.detalle', 'incidencias.fecincidencia', 'incidencias.estado', 'incidencias.prioridad', 'incidencias.activo', 'incidencias.borrado', 'incidencias.categoria_id', 'incidencias.oficina', 'incidencias.user_id', 'categorias.id as idcategoria', 'categorias.name as categoria', 'users.nombres', 'us.nombres as usernombre')
                ->paginate(15);
        } elseif ($idtipouser == 2) {
            $solucions = DB::table('solucions')
                ->join('incidencias', 'incidencias.id', '=', 'solucions.incidencia_id')
                ->join('users as us', 'us.id', '=', 'solucions.user_id')
                ->join('categorias', 'categorias.id', '=', 'incidencias.categoria_id')
                ->join('users', 'users.id', '=', 'incidencias.user_id')
                ->where('incidencias.estado', '1')
                ->where('solucions.user_id', $iduser)
                ->where(function ($query) use ($buscar) {
                    $query->where('incidencias.motivo', 'like', '%' . $buscar . '%');
                    $query->orWhere('incidencias.detalle', 'like', '%' . $buscar . '%');
                })
                ->orderBy('solucions.id', 'desc')
                ->select('solucions.detalle as soldetalle', 'solucions.fecsolucion', 'incidencias.id', 'incidencias.motivo', 'incidencias.detalle', 'incidencias.fecincidencia', 'incidencias.estado', 'incidencias.prioridad', 'incidencias.activo', 'incidencias.borrado', 'incidencias.categoria_id', 'incidencias.oficina', 'incidencias.user_id', 'categorias.id as idcategoria', 'categorias.name as categoria', 'users.nombres', 'us.nombres as usernombre')
                ->paginate(15);
        } else {
            $solucions = DB::table('solucions')
                ->join('incidencias', 'incidencias.id', '=', 'solucions.incidencia_id')
                ->join('users as us', 'us.id', '=', 'solucions.user_id')
                ->join('categorias', 'categorias.id', '=', 'incidencias.categoria_id')
                ->join('users', 'users.id', '=', 'incidencias.user_id')
                ->where('incidencias.estado', '1')
                ->where('incidencias.user_id', $iduser)
                ->where(function ($query) use ($buscar) {
                    $query->where('incidencias.motivo', 'like', '%' . $buscar . '%');
                    $query->orWhere('incidencias.detalle', 'like', '%' . $buscar . '%');
                })
                ->orderBy('solucions.id', 'desc')
                ->select('solucions.detalle as soldetalle', 'solucions.fecsolucion', 'incidencias.id', 'incidencias.motivo', 'incidencias.detalle', 'incidencias.fecincidencia', 'incidencias.estado', 'incidencias.prioridad', 'incidencias.activo', 'incidencias.borrado', 'incidencias.categoria_id', 'incidencias.oficina', 'incidencias.user_id', 'categorias.id as idcategoria', 'categorias.name as categoria', 'users.nombres', 'us.nombres as usernombre')
                ->paginate(15);
        }



        return [
            'pagination' => [
                'total' => $solucions->total(),
                'current_page' => $solucions->currentPage(),
                'per_page' => $solucions->perPage(),
                'last_page' => $solucions->lastPage(),
                'from' => $solucions->firstItem(),
                'to' => $solucions->lastItem(),
            ],
            'solucions' => $solucions
        ];
    }
}
