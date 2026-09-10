<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProveedoresModelo as ProveedoresModelo;
use Illuminate\Support\Facades\Validator;

class ProveedoresControlador extends Controller
{
    // Funcion Listar: trae todos los datos de la tabla
    public function index()
    {
        $proveedores = ProveedoresModelo::all();

        if ($proveedores->isEmpty()) {
            $data = [
                'message' => 'No hay proveedores registrados',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        return response()->json($proveedores, 200);
    }

    // Permite enviar datos o crear registros
    public function store(Request $request)
    {
        $validacion = Validator::make($request->all(), [
            'id_proveedor' => 'required',
            'id_tipo_documento' => 'required',
            'nit' => 'required',
            'razon_social' => 'required',
            'contacto' => 'required',
            'telefono' => 'required',
            'correo' => 'required',
            'estado' => 'required',
            'tipo' => 'required'

        ]);

        if ($validacion->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validacion->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $proveedores = ProveedoresModelo::create([
            'id_proveedor' => $request->id_proveedor,
            'id_tipo_documento' => $request->id_tipo_documento,
            'nit' => $request->nit,
            'razon_social' => $request->razon_social,
            'contacto' => $request->contacto,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'estado' => $request->estado,
            'tipo' => $request->tipo
        ]);

        if (!$proveedores) {
            $data = [
                'message' => 'Error al crear el proveedor',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Proveedores creado correctamente',
            'proveedor' => $proveedores,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $proveedores = ProveedoresModelo::find($id);
        if (!$proveedores) {
            $data = [
                'message' => 'Proveedores no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'proveedor' => $proveedores,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $proveedores = ProveedoresModelo::find($id);
        if (!$proveedores) {
            $data = [
                'message' => 'Proveedores no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $proveedores->delete();

        $data = [
            'message' => 'Proveedores eliminado correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id_proveedor)
    {
        $proveedores = ProveedoresModelo::find($id_proveedor);
        if (!$proveedores) {
            $data = [
                'message' => 'Proveedores no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validacion = Validator::make($request->all(), [
            'id_proveedor' => 'required',
            'id_tipo_documento' => 'required',
            'nit' => 'required',
            'razon_social' => 'required',
            'contacto' => 'required',
            'telefono' => 'required',
            'correo' => 'required',
            'estado' => 'required',
            'tipo' => 'required'
        ]);

        if ($validacion->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validacion->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $proveedores->id_proveedor = $request->id_proveedor;
        $proveedores->id_tipo_documento = $request->id_tipo_documento;
        $proveedores->nit = $request->nit;
        $proveedores->razon_social = $request->razon_social;
        $proveedores->contacto = $request->contacto;
        $proveedores->telefono = $request->telefono;
        $proveedores->correo = $request->correo;
        $proveedores->estado = $request->estado;
        $proveedores->tipo = $request->tipo;
        $proveedores->save();

        $data = [
            'message' => 'Proveedores actualizado correctamente',
            'proveedor' => $proveedores,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}