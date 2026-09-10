<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class autorizacionUsuarioModelo extends Model
{
    use HasFactory;
    protected $table = 'autorizacion_usuario';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    public $primaryKey = null; 
    protected $fillable = [
        'id_autorizacion',
        'id_sistema_usuario',
    ];
}
