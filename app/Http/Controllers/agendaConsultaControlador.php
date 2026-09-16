<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgendaConsultaModelo;
use Illuminate\Support\Facades\Validator;

class AgendaConsultaControlador extends Controller
{
    public function index()
    {
        $agenda_consulta = AgendaConsultaModelo::all();

        if ($agenda_consulta->isEmpty()) {
            $data = [
                'message' => 'No hay consultas agendadas',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        return response()->json($agenda_consulta, 200);
    }

    public function store(Request $request)
    {
        $validacion = Validator::make($request->all(), [
            'fecha_hora' => 'required',
            'id_cliente' => 'required',
            'motivo' => 'required',
            'estado' => 'required'
        ]);

        if ($validacion->fails()) {
            $data = [
                'message' => 'Error al validar la consulta agendada',
                'errors' => $validacion->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $agenda_consulta = AgendaConsultaModelo::create([
            'fecha_hora' => $request->fecha_hora,
            'id_cliente' => $request->id_cliente,
            'motivo' => $request->motivo,
            'estado' => $request->estado
        ]);

        if (!$agenda_consulta) {
            $data = [
                'message' => 'Error al crear la consulta agendada',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Consulta creada correctamente',
            'agenda_consulta' => $agenda_consulta,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function show($id_agenda)
    {
        $agenda_consulta = AgendaConsultaModelo::find($id_agenda);
        if (!$agenda_consulta) {
            $data = [
                'message' => 'Error, consulta no encontrada',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $data = [
            'agenda_consulta' => $agenda_consulta,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id_agenda)
    {
        $agenda_consulta = AgendaConsultaModelo::find($id_agenda);
        if (!$agenda_consulta) {
            $data = [
                'message' => 'Consulta no encontrada',
                'status' => 404 // verifica si la ruta existe
            ];

            return response()->json($data, 404);
        }

        $agenda_consulta->delete();

        $data = [
            'message' => 'Consulta eliminada correctamente',
            'status' => 200 // solicitud exitosa
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id_agenda)
    {
        $agenda_consulta = AgendaConsultaModelo::find($id_agenda);
        if (!$agenda_consulta) {
            $data = [
                'message' => 'Consulta no encontrada',
                'status' => 404 // verifica si la ruta existe
            ];

            return response()->json($data, 404);
        }

        $validacion = Validator::make($request->all(), [
            'fecha_hora' => 'required',
            'id_cliente' => 'required',
            'motivo' => 'required',
            'estado' => 'required'
        ]);

        if ($validacion->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validacion->errors(),
                'status' => 400 // verifica si la ruta existe
            ];

            return response()->json($data, 400);
        }

        $agenda_consulta->fecha_hora = $request->fecha_hora;
        $agenda_consulta->id_cliente = $request->id_cliente;
        $agenda_consulta->motivo = $request->motivo;
        $agenda_consulta->estado = $request->estado;
        $agenda_consulta->save();

        $data = [
            'message' => 'Consulta actualizada correctamente',
            'agenda_consulta' => $agenda_consulta,
            'status' => 200 // solicitud exitosa
        ];

        return response()->json($data, 200);
    }
}
