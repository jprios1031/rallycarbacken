<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
  public function index()
{
    $query = User::with(['vehiculo']);

    if (request()->has('search')) {
        $search = request()->input('search');
        $query->where('name', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%');
    }

    $users = $query->get();  // <-- usa la consulta con filtro aquí

    return response()->json($users, 200);
}
    public function store(Request $request)
{

    // Validar los datos
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6',
        'vehiculo_id' => 'nullable|integer|exists:vehiculos,id',
        'role_id' => 'nullable|integer|exists:roles,id',
    ]);

    // Crear el usuario
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'vehiculo_id' => $request->vehiculo_id,
        'role_id' => $request->role_id,
    ]);

    // Asociar vehículo si existe
    if ($request->vehiculo_id) {
        $vehiculo = Vehiculo::find($request->vehiculo_id);
        if ($vehiculo) {
            $vehiculo->user_id = $user->id;
            $vehiculo->save();
        }
        else {
            Log::warning("Vehículo con ID {$request->vehiculo_id} no encontrado para el usuario {$user->id}");
        }
    }

    return response()->json($user->load('vehiculo'), 201);
}

    public function show(string $id)
    {
        $user = User::with('vehiculo')->find($id);

        return $user
            ? response()->json($user, 200)
            : response()->json(['message' => 'Usuario no encontrado'], 404);
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        //  Validar los datos actualizados
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'vehiculo_id' => 'nullable|integer|exists:vehiculos,id',
            'role_id' => 'nullable|integer|exists:roles,id',
        ]);

        //  Actualizar usuario
        $user->update($request->only(['name', 'email', 'vehiculo_id', 'role_id']));

        //  Sincronizar relación con el vehículo
        if ($request->vehiculo_id) {
            $vehiculo = Vehiculo::find($request->vehiculo_id);
            if ($vehiculo) {
                $vehiculo->user_id = $user->id;
                $vehiculo->save();
            }
        }

        return response()->json($user->load('vehiculo'), 200);
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        //  Desvincular el vehículo antes de eliminar el usuario
        if ($user->vehiculo_id) {
            $vehiculo = Vehiculo::find($user->vehiculo_id);
            if ($vehiculo) {
                $vehiculo->user_id = null;
                $vehiculo->save();
            }
        }

        // Eliminar usuario
        $user->delete();

        return response()->json(['message' => 'Usuario eliminado'], 200);
    }
}
