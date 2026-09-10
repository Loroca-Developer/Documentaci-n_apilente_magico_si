<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class asignarAutorizacionModelo extends Model
{
    //
    use HasFactory;
    protected $table = 'autorizacion';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'nombre'
    ];

    // relacion con el modelo de usuario
    public function usuario():BelongsTo
    {
    return $this->belongsTo(usuarioModelo::class,  'id', 'id_autorizacion');
    }

    // relacion con el modelo de rol
      public function autorizacion():BelongsTo
    {
    return $this->belongsTo(autorizacionModelo::class,  'id', 'id_sistema_usuario');
    }
} 
