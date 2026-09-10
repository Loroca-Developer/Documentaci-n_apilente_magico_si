<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class consultaModelo extends Model
{
    //
    use HasFactory;
    protected $table = 'consulta';
    public $timestamps = false;  
    public $incrementing = true;
    protected $primaryKey = 'id_consulta';  
    protected $keyType = 'int';
    protected $fillable = [
        'id_cliente',
        'id_usuario',
        'id_historia',
        'fecha_hora',
        'motivo',
        'resultado_examen',
        'diagnostico',
        'recomendaciones'
    ];
}
