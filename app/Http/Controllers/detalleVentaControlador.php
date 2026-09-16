<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\detalleVentaModelo;
use Illuminate\Support\Facades\Validator;

class detalleVentaControlador extends Controller
{
    public function index()
    {
        $detalle_venta = detalleVentaModelo::all();

        if ($detalle_venta->isEmpty()) {
            $data = [
                'message' => 'No hay detalles de venta',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        return response()->json($detalle_venta, 200);
    }

    public function store(Request $request)
    {
        $validacion = Validator::make($request->all(), [
           'id_venta'=>'required',
           'id_producto'=>'required',
           'cantidad'=>'required',
           'precio_unitario'=>'required'
        ]);

        if ($validacion->fails()) {
            $data = [
                'message' => 'Error al validar el detalle de venta',
                'errors' => $validacion->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $detalle_venta = detalleVentaModelo::create([
            'id_venta' => $request->id_venta,
            'id_producto' => $request->id_producto,
            'cantidad' => $request->cantidad,
            'precio_unitario' => $request->precio_unitario
        ]);

        if (!$detalle_venta) {
            $data = [
                'message' => 'Error al crear el detalle de venta',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Detalle de venta creado correctamente',
            'detalleVenta' => $detalle_venta,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function show($id_detalle)
    {
        $detalle_venta = detalleVentaModelo::find($id_detalle);
        if (!$detalle_venta) {
            $data = [
                'message' => 'Error, detalle de venta no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $data = [
            'detalleVenta' => $detalle_venta,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id_detalle)
    {
        $detalle_venta = detalleVentaModelo::find($id_detalle);
        if (!$detalle_venta) {
            $data = [
                'message' => 'Detalle de venta no encontrado',
                'status' => 404 // verifica si la ruta existe
            ];

            return response()->json($data, 404);
        }

        $detalle_venta->delete();

        $data = [
            'message' => 'Detalle de venta eliminado correctamente',
            'status' => 200 // solicitud exitosa
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id_detalle)
    {
        $detalle_venta = detalleVentaModelo::find($id_detalle);
        if (!$detalle_venta) {
            $data = [
                'message' => 'Detalle de venta no encontrado',
                'status' => 404 // verifica si la ruta existe
            ];

            return response()->json($data, 404);
        }

        $validacion = Validator::make($request->all(), [
            'id_venta' => 'required',
            'id_producto' => 'required',
            'cantidad' => 'required',
            'precio_unitario' => 'required'
        ]);

        if ($validacion->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validacion->errors(),
                'status' => 400 // verifica si la ruta existe
            ];

            return response()->json($data, 400);
        }

        $detalle_venta->id_venta = $request->id_venta;
        $detalle_venta->id_producto = $request->id_producto;
        $detalle_venta->cantidad = $request->cantidad;
        $detalle_venta->precio_unitario = $request->precio_unitario;
        $detalle_venta->save();

        $data = [
            'message' => 'Detalle de venta actualizado correctamente',
            'detalleVenta' => $detalle_venta,
            'status' => 200 // solicitud exitosa
        ];

        return response()->json($data, 200);
    }
}
