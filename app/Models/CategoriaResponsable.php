<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaResponsable extends Model
{
    use HasFactory;

    protected $table = "categorias_responsables";
    protected $fillable = ['categoria_id', 'responsable_id'];
}
