<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\consultaModelo as Consulta;
use Illuminate\Support\Facades\Validator;

class consultaControlador extends Controller
{
    //
    public function index()
    {
        $consulta = Consulta::all();

        if ($consulta->isEmpty()) {
            $data = [
                'message' => 'No hay consultas registradas',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        return response()->json($consulta, 200);
    }

    function store(Request $request)
    {
        $validacion = Validator::make($request->all(), [
            'id_cliente' => 'required',
            'id_usuario' => 'required',
            'id_historia' => 'required',
            'fecha_hora' => 'required',
            'motivo' => 'required',
            'resultado_examen' => 'nullable|string',
            'diagnostico' => 'nullable|string',
            'recomendaciones' => 'nullable|string'
        ]);

        if ($validacion->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validacion->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $consulta = Consulta::create([
            'id_cliente' => $request->id_cliente,
            'id_usuario' => $request->id_usuario,
            'id_historia' => $request->id_historia,
            'fecha_hora' => $request->fecha_hora,
            'motivo' => $request->motivo,
            'resultado_examen' => $request->resultado_examen,
            'diagnostico' => $request->diagnostico,
            'recomendaciones' => $request->recomendaciones
        ]);

        if (!$consulta) {
            $data = [
                'message' => 'Error al crear la consulta',
                'status' => 500
            ];

            return response()->json($data, 500);
        }
        $data = [
            'message' => 'Consulta creada exitosamente',
            'consulta' => $consulta,
            'status' => 201
        ];

        return response()->json($consulta, 201);
    }


    public function show($id_consulta)
    {
        $consulta = Consulta::find($id_consulta);

        if (!$consulta) {
            $data = [
                'message' => 'Consulta no encontrada',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $data = [
            'consulta' => $consulta,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id_consulta)
    {
        $consulta = Consulta::find($id_consulta);

        if (!$consulta) {
            $data = [
                'message' => 'Consulta no encontrada',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $consulta->delete();

        $data = [
            'message' => 'Consulta eliminada correctamente',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id_consulta)
    {
        $consulta = Consulta::find($id_consulta);

        if (!$consulta) {
            $data = [
                'message' => 'Consulta no encontrada',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $validacion = Validator::make($request->all(), [
            'id_cliente' => 'required',
            'id_usuario' => 'required',
            'id_historia' => 'required',
            'fecha_hora' => 'required',
            'motivo' => 'required',
            'resultado_examen' => 'nullable|string',
            'diagnostico' => 'nullable|string',
            'recomendaciones' => 'nullable|string'
        ]);

        if ($validacion->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validacion->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }
        $consulta->id_cliente = $request->id_cliente;
        $consulta->id_usuario = $request->id_usuario;
        $consulta->id_historia = $request->id_historia;
        $consulta->fecha_hora = $request->fecha_hora;
        $consulta->motivo = $request->motivo;
        $consulta->resultado_examen = $request->resultado_examen;
        $consulta->diagnostico = $request->diagnostico;
        $consulta->recomendaciones = $request->recomendaciones;

        $consulta->save();

        $data = [
            'message' => 'Consulta actualizada correctamente',
            'consulta' => $consulta,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
