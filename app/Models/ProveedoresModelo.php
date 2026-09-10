<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProveedoresModelo extends Model
{
    use HasFactory;

    protected $table = 'proveedor';
    public $timestamps = false;
    protected $primaryKey = 'id_proveedor';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'id_proveedor',
        'id_tipo_documento',
        'nit',
        'razon_social',
        'contacto',
        'telefono',
        'correo',
        'estado',
        'tipo'
    ];
}