<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;

class VentasController extends Controller
{
    // Mostrar todas las ventas
   public function index()
{
    $query = Venta::query();

    if (request()->has('search')) {
        $search = request()->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('tipo', 'like', '%' . $search . '%')
              ->orWhere('descripcion', 'like', '%' . $search . '%')
              ->orWhere('cantidad', 'like', '%' . $search . '%')
              ->orWhere('precio', 'like', '%' . $search . '%');
        });
    }

    $ventas = $query->get(); // corregido: usar query y no all()
    return response()->json($ventas, 200);
}
    // Registrar una nueva venta
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|string',
            'descripcion' => 'required|string',
            'cantidad' =>  'required|integer',
            'precio' => 'required|numeric|min:0',
           
        ]);

        $venta = Venta::create($validated);

        return response()->json([
            'message' => 'Venta registrada correctamente',
            'data' => $venta
        ], 201);
    }
    public function show($id)
{
    $venta = Venta::find($id);

    if (!$venta) {
        return response()->json(['message' => 'Venta no encontrada'], 404);
    }

    return response()->json($venta, 200);
}


    //  Actualizar una venta existente
    public function update(Request $request, $id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            return response()->json(['message' => 'Venta no encontrada'], 404);
        }

        $validated = $request->validate([
            'tipo' => 'required|string',
            'descripcion' => 'required|string',
            'cantidad' =>  'required|integer',
            'precio' => 'required|numeric|min:0',
         
        ]);

        $venta->update($validated);

        return response()->json([
            'message' => 'Venta actualizada correctamente',
            'data' => $venta
        ], 200);
    }

    //Eliminar una venta
    public function destroy($id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            return response()->json(['message' => 'Venta no encontrada'], 404);
        }

        $venta->delete();

        return response()->json(['message' => 'Venta eliminada correctamente'], 200);
    }
}
