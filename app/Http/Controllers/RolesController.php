<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
class RolesController extends Controller
{
    //





    // Mostrar todas las ventas
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
        
           
        ]);

        $roles = Role::create($validated);

        return response()->json([
            'message' => 'Rol registrado correctamente',
            'data' => $roles
        ], 201);
    }
    public function show($id)
{
    $roles = Role::find($id);

    if (!$roles) {
        return response()->json(['message' => 'rol no encontrad'], 404);
    }

    return response()->json($roles, 200);
}


    // Actualizar una venta existente
    public function update(Request $request, $id)
    {
        $roles = Role::find($id);

        if (!$roles) {
            return response()->json(['message' => 'roles no encontrados'], 404);
        }

        $validated = $request->validate([
           'name' => 'required|string',
            'type' => 'required|string',
         
        ]);

        $roles->update($validated);

        return response()->json([
            'message' => 'Rol actualizado correctamente',
            'data' => $roles
        ], 200);
    }

    //  Eliminar una venta
    public function destroy($id)
    {
        $roles = Role::find($id);

        if (!$roles) {
            return response()->json(['message' => 'roles no encontrados'], 404);
        }

        $roles->delete();

        return response()->json(['message' => 'rol eliminado correctamente'], 200);
    }
}
