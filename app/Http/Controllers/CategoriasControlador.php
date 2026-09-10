<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriasModelo as CategoriasModelo;
use Illuminate\Support\Facades\Validator;

class CategoriasControlador extends Controller
{
    // Funcion Listar: trae todos los datos de la tabla
    public function index()
    {
        $categorias = CategoriasModelo::all();

        if ($categorias->isEmpty()) {
            $data = [
                'message' => 'No hay categorias registradas',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        return response()->json($categorias, 200);
    }

    // Permite enviar datos o crear registros
    public function store(Request $request)
    {
        $validacion = Validator::make($request->all(), [
            'nombre_categoria' => 'required',
            'descripcion' => 'required',
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

        $categorias = CategoriasModelo::create([
            'nombre_categoria' => $request->nombre_categoria,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado
        ]);

        if (!$categorias) {
            $data = [
                'message' => 'Error al crear la categoria',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Categoria creada correctamente',
            'categoria' => $categorias,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $categorias = CategoriasModelo::find($id);
        if (!$categorias) {
            $data = [
                'message' => 'Categoria no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'categoria' => $categorias,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $categorias = CategoriasModelo::find($id);
        if (!$categorias) {
            $data = [
                'message' => 'Categoria no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $categorias->delete();

        $data = [
            'message' => 'Categoria eliminada correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id_categoria)
    {
        $categorias = CategoriasModelo::find($id_categoria);
        if (!$categorias) {
            $data = [
                'message' => 'Categoria no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validacion = Validator::make($request->all(), [
            'nombre_categoria' => 'required',
            'descripcion' => 'required',
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

        $categorias->nombre_categoria = $request->nombre_categoria;
        $categorias->descripcion = $request->descripcion;
        $categorias->estado = $request->estado;
        $categorias->save();

        $data = [
            'message' => 'Categoria actualizada correctamente',
            'categoria' => $categorias,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}