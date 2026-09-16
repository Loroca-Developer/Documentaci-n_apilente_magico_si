<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/////////////////////////////////////
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
// use Illuminate\Support\Facades\Hash;

class usuarioModelo extends Authenticatable implements JWTSubject
{
    //
    use HasFactory;
    protected $table = 'usuario';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'id',
        'id_datos_personales',
        'contrasenia',
        'activar_usuario',
        'clave_idioma',
        'clave_activacion',
        'llave_reinicio',
        'hora_reinicio'
    ];

    //Ocultar Password 
    protected $hidden = [
        'contrasenia',
    ];

    //relaciones entre datos personales y usuario, es decir un usuario pertenece a un dato personal
    public function datosPersonales()
    {
        return $this->belongsTo(
            datosPersonalesModelo::class,
            'id_datos_personales',
            'id'
        );
    }
    //Relacion entre usuario y autorizacion, es decir un usuario puede tener muchas autorizaciones
    // public function autorizaciones()
    // {
    //     return $this->belongsToMany(
    //         autorizacionModelo::class,
    //         'id',
    //         'id_autorizacion',
    //         'id_sistema_usuario',
    //         'id',
    //         'id'
    //     );
    // }

    //trae el correo de la tabla datos personales, es decir el correo del usuario
    public function getCorreoAttribute()
    {
        return $this->datosPersonales->correo ?? null;
    }



    // IMPORTANTE: Laravel espera el Password, pero tu campo es 'contrasenia', así que definimos un accesor para que Laravel lo reconozca
    //confirmo que la variable contrasenia es la de mi tabla usuario. No la que tiene laravel en la migracion
    public function getAuthPassword()
    {
        return $this->contrasenia;
    }


    public function autorizacion()
    {
        return $this->belongsToMany(
            autorizacionModelo::class,
            'autorizacion_usuario',   // nombre correcto de la tabla pivote
            'id_sistema_usuario',     // columna que apunta al usuario
            'id_autorizacion'         // columna que apunta a la autorización
        );
    }

    // Metodo requerido por el JWT
    // Aqui se genera un JWT el sistema necesira saber el valor y a que ID pertenece.
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // Devuelve un array con la informacion almacenada , Estudiar que son los claims, es decir los datos que se almacenan en el JWT
    public function getJWTCustomClaims()
    {
        return [
            'datos_personales' => $this->id_datos_personales,
            'contrasenia' => $this->contrasenia,
            'activar_usuario' => $this->activar_usuario,
            'clave_idioma' => $this->clave_idioma,
            'clave_activacion' => $this->clave_activacion,
            'llave_reinicio' => $this->llave_reinicio,
            'hora_reinicio' => $this->hora_reinicio,
        ];
    }
}