<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetalleCompraModelo as DetalleCompraModelo;
use Illuminate\Support\Facades\Validator;

class DetalleCompraControlador extends Controller
{
    // Funcion Listar: trae todos los datos de la tabla
    public function index()
    {
        $detalleCompras = DetalleCompraModelo::all();

        if ($detalleCompras->isEmpty()) {
            $data = [
                'message' => 'No hay detalles de compra registrados',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        return response()->json($detalleCompras, 200);
    }

    // Permite enviar datos o crear registros
    public function store(Request $request)
    {
        // FIX: se agregó "exists" para id_compra e id_producto, así Laravel valida
        // que ambos existan en sus tablas ANTES de intentar el insert. Esto evita
        // que el error crudo de MySQL (foreign key constraint fails) llegue al
        // usuario y en su lugar devuelve un 400 con un mensaje claro.
        $validacion = Validator::make($request->all(), [
            'id_compra' => 'required|exists:compra,id_compra',
            'id_producto' => 'required|exists:producto,id_producto',
            'cantidad' => 'required|numeric|min:1',
            'costo_unitario' => 'required|numeric|min:0',
        ]);

        if ($validacion->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validacion->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $detalleCompras = DetalleCompraModelo::create([
            'id_compra' => $request->id_compra,
            'id_producto' => $request->id_producto,
            'cantidad' => $request->cantidad,
            'costo_unitario' => $request->costo_unitario,
        ]);

        if (!$detalleCompras) {
            $data = [
                'message' => 'Error al crear el detalle de compra',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Detalle de compra creado correctamente',
            'detalle_compra' => $detalleCompras,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id_detalle_compra)
    {
        $detalleCompras = DetalleCompraModelo::find($id_detalle_compra);
        if (!$detalleCompras) {
            $data = [
                'message' => 'Detalle de compra no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'detalle_compra' => $detalleCompras,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id_detalle_compra)
    {
        $detalleCompras = DetalleCompraModelo::find($id_detalle_compra);
        if (!$detalleCompras) {
            $data = [
                'message' => 'Detalle de compra no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $detalleCompras->delete();

        $data = [
            'message' => 'Detalle de compra eliminado correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id_detalle_compra)
    {
        $detalleCompras = DetalleCompraModelo::find($id_detalle_compra);
        if (!$detalleCompras) {
            $data = [
                'message' => 'Detalle de compra no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        // FIX: misma validación de existencia aquí, para que un UPDATE tampoco
        // pueda dejar el registro apuntando a una compra o producto inexistente.
        $validacion = Validator::make($request->all(), [
            'id_compra' => 'required|exists:compra,id_compra',
            'id_producto' => 'required|exists:producto,id_producto',
            'cantidad' => 'required|numeric|min:1',
            'costo_unitario' => 'required|numeric|min:0',
        ]);

        if ($validacion->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validacion->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $detalleCompras->id_compra = $request->id_compra;
        $detalleCompras->id_producto = $request->id_producto;
        $detalleCompras->cantidad = $request->cantidad;
        $detalleCompras->costo_unitario = $request->costo_unitario;
        $detalleCompras->save();

        $data = [
            'message' => 'Detalle de compra actualizado correctamente',
            'detalle_compra' => $detalleCompras,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}