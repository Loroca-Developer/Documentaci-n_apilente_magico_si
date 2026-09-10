<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompraModelo extends Model
{
    use HasFactory;

    protected $table = 'detalle_compra';
    public $timestamps = false;
    protected $primaryKey = 'id_detalle_compra';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'id_detalle_compra',
        'id_compra',
        'id_producto',
        'cantidad',
        'costo_unitario',
    ];
}