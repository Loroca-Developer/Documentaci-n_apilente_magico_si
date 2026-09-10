<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\usuarioModelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validar los datos de entrada
        $validacion = Validator::make($request->all(), [
            'correo' => 'required|email',
            'contrasenia' => 'required|string|min:6',
        ]);

        if ($validacion->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validacion->errors(),
                'message' => 'Error de validación',
            ], 422);
        }

        // CORRECCIÓN: Buscar al usuario filtrando en la tabla relacionada 'datos_personales'
        $user = usuarioModelo::whereHas('datosPersonales', function ($query) use ($request) {
            $query->where('correo', $request->correo);
        })->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Correo no encontrado',
            ], 401);
        }


        // // AGREGA ESTA LÍNEA TEMPORALMENTE
        // dd([
        //     'id' => $user->id,
        //     'contrasenia_length' => strlen($user->contrasenia),
        //     'contrasenia_raw' => $user->contrasenia,
        // ]);

        // Verificar contraseña (recuerda que en la BD debe estar encriptada con Hash::make)
        if (!Hash::check($request->contrasenia, $user->contrasenia)) {
            return response()->json([
                'success' => false,
                'message' => 'Contraseña incorrecta',
            ], 401);
        }

        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el token: ' . $e->getMessage(),
            ], 500);
        }

        $user->load('autorizacion');

        $responseData = [
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'correo' => $user->correo, // Esto funciona gracias a tu accesor getCorreoAttribute
                    'autorizacion' => $user->autorizacion->map(function ($autorizacion) {
                        return [
                            'id' => $autorizacion->id,
                            'nombre' => $autorizacion->nombre,
                        ];
                    })
                ],
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60
            ]
        ];

        $cookie = cookie::make('jwt_token', $token, JWTAuth::factory()->getTTL(), '/', null, false, true, false, 'lax');
        return response()->json($responseData, 200)->withCookie($cookie);
    }
    public function logout(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            if (!$token) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token no proporcionado',
                ], 400);
            }
            JWTAuth::invalidate($token);
            $cookie = cookie::forget('jwt_token');
            return response()->json([
                'success' => true,
                'message' => 'Sesión cerrada correctamente',
            ], 200)->withCookie($cookie);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cerrar sesión: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function me(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate(); // Obtener el usuario autenticado a partir del token
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado',
                ], 401);
            }
            $user->load('autorizacion');
            return response()->json([
                'success' => true,
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'correo' => $user->correo,
                        'autorizacion' => $user->autorizacion->map(function ($autorizacion) {
                            return [
                                'id' => $autorizacion->id,
                                'nombre' => $autorizacion->nombre,

                            ];
                        })
                    ]
                ]
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el usuario autenticado: ' . $e->getMessage(),
            ], 401);
        }
    }
    public function refresh(Request $request)
    {
        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());
            $cookie = cookie::make('jwt_token', $token, JWTAuth::factory()->getTTL(), '/', null, false, true, false, 'lax');
            return response()->json([
                'success' => true,
                'data' => [
                    'token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => JWTAuth::factory()->getTTL() * 60
                ]
            ], 200)->withCookie($cookie);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al refrescar el token: ' . $e->getMessage(),
            ], 500);
        }
    }
}
