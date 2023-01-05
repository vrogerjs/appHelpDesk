<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipouser extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion', 'nivel', 'activo', 'borrado'];
}
