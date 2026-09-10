<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosModelo extends Model
{
    use HasFactory;

    protected $table = 'producto';
    public $timestamps = false;
    protected $primaryKey = 'id_producto';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'id_producto',
        'id_categoria',
        'codigo_producto',
        'nombre',
        'descripcion',
        'precio_venta',
        'estado',
        'fecha_creacion',
        'stock_actual',
        'stock_minimo',
    ];
}