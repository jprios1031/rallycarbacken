<?php

namespace App\Http\Controllers;

use App\Models\Imagenes;
use Illuminate\Http\Request;
use App\Models\Imagen;

class ImagenController extends Controller
{
    // Guardar una nueva imagen
    public function store(Request $request)
    {
        $request->validate([
            'novedad_id' => 'required|integer|exists:novedades,id',
            'ruta' => 'required|string',
        ]);

        $imagen = Imagenes::create([
            'novedad_id' => $request->novedad_id,
            'ruta' => $request->ruta,
        ]);

        return response()->json($imagen, 201);
    }
}
