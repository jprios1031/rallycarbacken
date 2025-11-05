<?php

namespace App\Http\Controllers;

use App\Models\Novedad;
use App\Models\Imagenes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NovedadController extends Controller
{
    /**
     * Mostrar todas las novedades con vehículo e imágenes.
     */
    public function index()
    {
        $novedades = Novedad::with(['vehiculo', 'imagenes'])->get();
        return response()->json($novedades, 200);
    }

    /**
     * Crear una novedad con múltiples imágenes.
     */
    public function store(Request $request)
    {
    $request->validate([
    'titulo' => 'required|string|max:255',
    'descripcion' => 'required|string|max:1000',
    'vehiculo_id' => 'required|exists:vehiculos,id',
    'imagenes.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validar cada imagen
]);

$novedad = Novedad::create([
    'titulo' => $request->titulo,
    'descripcion' => $request->descripcion,
    'vehiculo_id' => $request->vehiculo_id,
]);

if ($request->hasFile('imagenes')) {
    foreach ($request->file('imagenes') as $file) {
        $path = $file->store('imagenes_novedades', 'public');
        Imagenes::create([
            'novedad_id' => $novedad->id,
            'ruta' => $path,
        ]);
    }
}


        // Devolver la novedad con imágenes
        $novedad->load('imagenes', 'vehiculo');

        return response()->json([
            'message' => 'Novedad creada correctamente',
            'data' => $novedad,
        ], 201);
    }

    /**
     * Mostrar una novedad específica con vehículo e imágenes.
     */
    public function show($id)
    {
        $novedad = Novedad::with(['vehiculo', 'imagenes'])->find($id);

        if (!$novedad) {
            return response()->json(['message' => 'Novedad no encontrada'], 404);
        }

        return response()->json($novedad, 200);
    }

    /**
     * Actualizar novedad (opcionalmente imágenes).
     */
    public function update(Request $request, $id)
    {
        $novedad = Novedad::find($id);

        if (!$novedad) {
            return response()->json(['message' => 'Novedad no encontrada'], 404);
        }

        $request->validate([
            'titulo' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string|max:1000',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'imagenes.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $novedad->update($request->only(['titulo', 'descripcion', 'vehiculo_id']));

        // Guardar nuevas imágenes si se envían
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $file) {
                $path = $file->store('imagenes_novedades', 'public');
                Imagenes::create([
                    'novedad_id' => $novedad->id,
                    'ruta' => $path,
                ]);
            }
        }

        $novedad->load('imagenes', 'vehiculo');

        return response()->json([
            'message' => 'Novedad actualizada correctamente',
            'data' => $novedad,
        ], 200);
    }

    /**
     * Eliminar novedad y sus imágenes.
     */
    public function destroy($id)
    {
        $novedad = Novedad::with('imagenes')->find($id);

        if (!$novedad) {
            return response()->json(['message' => 'Novedad no encontrada'], 404);
        }

        // Eliminar imágenes del storage
        foreach ($novedad->imagenes as $img) {
            Storage::disk('public')->delete($img->ruta);
            $img->delete();
        }

        $novedad->delete();

        return response()->json(['message' => 'Novedad eliminada correctamente'], 200);
    }
}
