<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class facturaModelo extends Model
{
    use HasFactory;
    protected $table = 'factura';
    public $timestamps = false;
    protected $primaryKey = 'id_factura';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'fecha_emision',
        'id_pago',
        'num_factura'
    ];  
}
