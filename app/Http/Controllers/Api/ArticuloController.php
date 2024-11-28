<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Articulos;
use Illuminate\Http\Request;

class ArticuloController extends Controller
{
    public function index()
    {
        return response()->json(Articulos::all(), 200);
    }

    public function store(Request $request)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'marca' => 'required|string|max:255',
            'imagen' => 'nullable|image|max:2048', // Si envías imágenes
        ]);

        // Subir la imagen si se envió
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('posts', 'public');
            $validatedData['imagen'] = $path;
        }

        // Crear el artículo
        $articulo = Articulos::create($validatedData);

        return response()->json([
            'message' => 'Artículo creado con éxito',
            'articulo' => $articulo,
        ], 201);
    }


    public function update(Request $request, $id)
{
    // Validar los datos de entrada
    $request->validate([
        'nombre' => 'string|max:255',
        'descripcion' => 'string',
        'marca' => 'string|max:255',
        'precio' => 'numeric',
        'imagen' => 'string', // O manejo de archivo si es necesario
    ]);

    // Encontrar el artículo por ID
    $articulo = Articulos::findOrFail($id);

    // Actualizar los datos del artículo
    $articulo->nombre = $request->input('nombre', $articulo->nombre);
    $articulo->descripcion = $request->input('descripcion', $articulo->descripcion);
    $articulo->marca = $request->input('marca', $articulo->marca);
    $articulo->precio = $request->input('precio', $articulo->precio);

    // Si hay una nueva imagen, actualizar el campo
    if ($request->has('imagen')) {
        $articulo->imagen = $request->input('imagen');
    }

    // Guardar los cambios en la base de datos
    $articulo->save();

    // Retornar la respuesta con los datos actualizados
    return response()->json([
        'message' => 'Artículo actualizado con éxito',
        'articulo' => $articulo,
    ], 200);
}

    
    
    public function destroy($id)
    {
        $articulo = Articulos::find($id);
        if (!$articulo) {
            return response()->json(['error' => 'Artículo no encontrado'], 404);
        }
        $articulo->delete();
        return response()->json(['message' => 'Artículo eliminado'], 200);
    }
}
