<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gasto;

class GastosController extends Controller
{
  public function index()
{

    $query = Gasto::query();

    if (request()->has('search')) {
        $search = request()->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('tipo', 'like', '%' . $search . '%')
              ->orWhere('descripcion', 'like', '%' . $search . '%')
              ->orWhere('precio', 'like', '%' . $search . '%');
        });
    }

    $gastos = $query->get();

    return response()->json($gastos, 200);
}
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|string',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
           
        ]);

        $gasto = Gasto::create($validated);

        return response()->json([
            'message' => 'Gasto registrado correctamente',
            'data' => $gasto
        ], 201);
    }
    public function show($id)
    {
        $gasto = Gasto::find($id);

        if (!$gasto) {
            return response()->json(['message' => 'Gasto no encontrado'], 404);
        }

        return response()->json($gasto, 200);
    }
    public function update(Request $request, $id)
    {
        $gasto = Gasto::find($id);

        if (!$gasto) {
            return response()->json(['message' => 'Gasto no encontrado'], 404);
        }

        $validated = $request->validate([
            'tipo' => 'required|string',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
         
        ]);

        $gasto->update($validated);

        return response()->json([
            'message' => 'Gasto actualizado correctamente',
            'data' => $gasto
        ], 200);
    }
    public function destroy($id)
    {
        $gasto = Gasto::find($id);

        if (!$gasto) {
            return response()->json(['message' => 'Gasto no encontrado'], 404);
        }

        $gasto->delete();

        return response()->json(['message' => 'Gasto eliminado correctamente'], 200);
    }
}




