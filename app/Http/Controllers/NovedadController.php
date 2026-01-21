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
    // Validación de los datos
    $request->validate([
        'titulo' => 'required|string|max:255',
        'descripcion' => 'required|string|max:1000',
        'vehiculo_id' => 'required|integer',
        'imagenes.*' => 'nullable|image|mimes:jpg,jpeg,png|max:10240', // máximo 10MB por imagen
    ]);

    $token = Session::get('token');

    // Preparar la petición HTTP con token
    $httpRequest = Http::withToken($token);

    // Adjuntar imágenes si existen
    if ($request->hasFile('imagenes')) {
        foreach ($request->file('imagenes') as $index => $file) {
            $httpRequest = $httpRequest->attach(
                "imagenes[$index]", // nombre del campo con índice
                file_get_contents($file->getRealPath()), 
                $file->getClientOriginalName()
            );
        }
    }

    // Adjuntar los campos normales como multipart
    $httpRequest = $httpRequest->asMultipart([
        [
            'name' => 'titulo',
            'contents' => $request->titulo
        ],
        [
            'name' => 'descripcion',
            'contents' => $request->descripcion
        ],
        [
            'name' => 'vehiculo_id',
            'contents' => $request->vehiculo_id
        ],
    ]);

    // Enviar la petición POST al backend
    $response = $httpRequest->post('https://rallycarbacken-production.up.railway.app/api/novedades');

    // Manejo de la respuesta
    if ($response->successful()) {
        return redirect()->route('novedad.index')
                         ->with('success', 'Novedad creada exitosamente.');
    }

    // Si falla, mostrar el error del backend
    return back()->with('error', 'Error al registrar la novedad: ' . $response->body());
}

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
