<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprasModelo extends Model
{
    use HasFactory;

    protected $table = 'compra';
    public $timestamps = false;
    protected $primaryKey = 'id_compra';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'id_compra',
        'id_proveedor',
        'fecha_compra',
        'num_comprobante',
        'estado',
    ];
}