<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriasModelo extends Model
{
    use HasFactory;

    protected $table = 'cat_producto';
    public $timestamps = false;
    protected $primaryKey = 'id_categoria';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'id_categoria',
        'nombre_categoria',
        'descripcion',
        'estado'
    ];
}