<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComprasModelo as ComprasModelo;
use Illuminate\Support\Facades\Validator;

class ComprasControlador extends Controller
{
    // Funcion Listar: trae todos los datos de la tabla
    public function index()
    {
        $compras = ComprasModelo::all();

        if ($compras->isEmpty()) {
            $data = [
                'message' => 'No hay compras registradas',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        return response()->json($compras, 200);
    }

    // Permite enviar datos o crear registros
    public function store(Request $request)
    {
        $validacion = Validator::make($request->all(), [
            'id_compra' => 'required',
            'id_proveedor' => 'required',
            'fecha_compra' => 'required',
            'num_comprobante' => 'required',
            'estado' => 'required'
        ]);

        if ($validacion->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validacion->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $compras = ComprasModelo::create([
            'id_proveedor' => $request->id_proveedor,
            'fecha_compra' => $request->fecha_compra,
            'num_comprobante' => $request->num_comprobante,
            'estado' => $request->estado
        ]);

        if (!$compras) {
            $data = [
                'message' => 'Error al crear la compra',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Compra creada correctamente',
            'compra' => $compras,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $compras = ComprasModelo::find($id);
        if (!$compras) {
            $data = [
                'message' => 'Compra no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'compra' => $compras,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $compras = ComprasModelo::find($id);
        if (!$compras) {
            $data = [
                'message' => 'Compra no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $compras->delete();

        $data = [
            'message' => 'Compra eliminada correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id_compra)
    {
        $compras = ComprasModelo::find($id_compra);
        if (!$compras) {
            $data = [
                'message' => 'Compra no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validacion = Validator::make($request->all(), [
            'id_compra' => 'required',
            'id_proveedor' => 'required',
            'fecha_compra' => 'required',
            'num_comprobante' => 'required',
            'estado' => 'required'
        ]);

        if ($validacion->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validacion->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $compras->id_compra = $request->id_compra;
        $compras->id_proveedor = $request->id_proveedor;
        $compras->fecha_compra = $request->fecha_compra;
        $compras->num_comprobante = $request->num_comprobante;
        $compras->estado = $request->estado;
        $compras->save();

        $data = [
            'message' => 'Compra actualizada correctamente',
            'compra' => $compras,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}