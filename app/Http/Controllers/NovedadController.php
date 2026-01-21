<?php

namespace App\Http\Controllers;

use App\Models\Novedad;
use App\Models\Imagenes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NovedadController extends Controller
{
    /**
     * Listado de novedades
     */
   public function index(Request $request)
{
    $query = Novedad::with(['vehiculo', 'imagenes']);

    if ($request->has('search')) {
        $search = $request->input('search');
        $query->where('titulo', 'like', '%' . $search . '%');
    }

    $novedades = $query->get();

    return response()->json($novedades);
}
    /**
     * Crear una novedad
     */
    public function store(Request $request)
    {
        

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'imagenes.*' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $novedad = Novedad::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'vehiculo_id' => $request->vehiculo_id,
        ]);

       //  // Guardar imágenes
       //  if ($request->hasFile('imagenes')) {
       //      foreach ($request->file('imagenes') as $file) {
       //          $path = $file->store('imagenes_novedades', 'public');

       //          Imagenes::create([
       //              'ruta' => $path,
       //              'novedad_id' => $novedad->id,
       //          ]);
       //      }
       //  }

       // $novedad->load('imagenes', 'vehiculo');

        return response()->json([
            'message' => 'Novedad creada correctamente',
            'data' => $novedad,
        ], 201);
     
    } 
            
        

    /**
     * Mostrar detalle
     */
    public function show($id)
    {
        $novedad = Novedad::with(['vehiculo', 'imagenes'])->find($id);

        if (!$novedad) {
            return response()->json(['message' => 'Novedad no encontrada'], 404);
        }

        return response()->json($novedad);
    }

    /**
     * Actualizar novedad
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
            'vehiculo_id' => 'sometimes|exists:vehiculos,id',
            'imagenes.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $novedad->update($request->only(['titulo', 'descripcion', 'vehiculo_id']));

        // Nuevas imágenes
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
        ]);
    }

    /**
     * Eliminar novedad
     */
    public function destroy($id)
    {
        $novedad = Novedad::with('imagenes')->find($id);

        if (!$novedad) {
            return response()->json(['message' => 'Novedad no encontrada'], 404);
        }

        // Borrar imágenes físicas y de BD
        foreach ($novedad->imagenes as $img) {
            Storage::disk('public')->delete($img->ruta);
            $img->delete();
        }

        $novedad->delete();

        return response()->json(['message' => 'Novedad eliminada correctamente']);
    }
}
