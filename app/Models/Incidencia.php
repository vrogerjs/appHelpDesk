<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;

    protected $fillable = ['motivo', 'detalle', 'fecincidencia', 'estado', 'prioridad', 'oficina', 'activo', 'borrado', 'categoria_id', 'user_id'];
}
