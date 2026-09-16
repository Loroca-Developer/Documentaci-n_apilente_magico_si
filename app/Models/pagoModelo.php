<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class pagoModelo extends Model
{
    use HasFactory;
    protected $table = 'pago';
    public $timestamps = false;
    protected $primaryKey = 'id_pagos';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'id_venta',
        'fecha_pago',
        'monto',
        'metodo_pago',
        'monto_recibido',
        'cambio'
    ];
}
