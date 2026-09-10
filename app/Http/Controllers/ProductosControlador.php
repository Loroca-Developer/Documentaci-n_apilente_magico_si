<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductosModelo as ProductosModelo;
use Illuminate\Support\Facades\Validator;

class ProductosControlador extends Controller
{
    // Funcion Listar: trae todos los datos de la tabla
    public function index()
    {
        $productos = ProductosModelo::all();

        if ($productos->isEmpty()) {
            $data = [
                'message' => 'No hay productos registrados',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        return response()->json($productos, 200);
    }

    // Permite enviar datos o crear registros
    public function store(Request $request)
    {
        $validacion = Validator::make($request->all(), [
            'id_producto' => 'required',
            'id_categoria' => 'required',
            'codigo_producto' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio_venta' => 'required',
            'estado' => 'required',
            'fecha_creacion' => 'required',
            'stock_actual' => 'required',
            'stock_minimo' => 'required'

        ]);

        if ($validacion->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validacion->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $productos = ProductosModelo::create([
            'id_producto' => $request->id_producto,
            'id_categoria' => $request->id_categoria,
            'codigo_producto' => $request->codigo_producto,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_venta' => $request->precio_venta,
            'estado' => $request->estado,
            'fecha_creacion' => $request->fecha_creacion,
            'stock_actual' => $request->stock_actual,
            'stock_minimo' => $request->stock_minimo
        ]);

        if (!$productos) {
            $data = [
                'message' => 'Error al crear el producto',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Producto creado correctamente',
            'producto' => $productos,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $productos = ProductosModelo::find($id);
        if (!$productos) {
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'producto' => $productos,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $productos = ProductosModelo::find($id);
        if (!$productos) {
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $productos->delete();

        $data = [
            'message' => 'Producto eliminado correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id_producto)
    {
        $productos = ProductosModelo::find($id_producto);
        if (!$productos) {
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validacion = Validator::make($request->all(), [
            'id_producto' => 'required',
            'id_categoria' => 'required',
            'codigo_producto' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio_venta' => 'required',
            'estado' => 'required',
            'fecha_creacion' => 'required',
            'stock_actual' => 'required',
            'stock_minimo' => 'required'
        ]);

        if ($validacion->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validacion->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $productos->id_producto = $request->id_producto;
        $productos->id_categoria = $request->id_categoria;
        $productos->codigo_producto = $request->codigo_producto;
        $productos->nombre = $request->nombre;
        $productos->descripcion = $request->descripcion;
        $productos->precio_venta = $request->precio_venta;
        $productos->estado = $request->estado;
        $productos->fecha_creacion = $request->fecha_creacion;
        $productos->stock_actual = $request->stock_actual;
        $productos->stock_minimo = $request->stock_minimo;
        $productos->save();

        $data = [
            'message' => 'Producto actualizado correctamente',
            'producto' => $productos,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}

