<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function index()
{
    $query = Vehiculo::with(['user']);

    if (request()->has('search')) {
        $search = request()->input('search');
        $query->where('placa', 'like', '%' . $search . '%')
              ->orWhere('marca', 'like', '%' . $search . '%')
              ->orWhere('modelo', 'like', '%' . $search . '%');
    }

    $vehiculos = $query->get();

    return response()->json($vehiculos, 200);
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'placa' => 'required|string|max:20|unique:vehiculos',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $vehiculo = Vehiculo::create($validated);

        return response()->json($vehiculo->load('user'), 201);
    }

    public function show(string $id)
    {
        $vehiculo = Vehiculo::with('user')->find($id);

        if (!$vehiculo) {
            return response()->json(['message' => 'Vehículo no encontrado'], 404);
        }

        return response()->json($vehiculo, 200);
    }
    
public function edit($id)
{
    $vehiculo = Vehiculo::find($id);

    if (!$vehiculo) {
        return response()->json(['message' => 'Vehículo no encontrado'], 404);
    }

    return response()->json($vehiculo, 200);
}
    public function update(Request $request, string $id)
    {
        $vehiculo = Vehiculo::find($id);

        if (!$vehiculo) {
            return response()->json(['message' => 'Vehículo no encontrado'], 404);
        }

        $validated = $request->validate([
            'placa' => 'required|string|max:20|unique:vehiculos,placa,' . $vehiculo->id,
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $vehiculo->update($validated);

        return response()->json($vehiculo->load('user'), 200);
    }

    public function destroy(string $id)
    {
        $vehiculo = Vehiculo::find($id);

        if (!$vehiculo) {
            return response()->json(['message' => 'Vehículo no encontrado'], 404);
        }

        $vehiculo->delete();

        return response()->json(['message' => 'Vehículo eliminado correctamente'], 200);
    }
}
