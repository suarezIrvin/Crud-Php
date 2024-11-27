<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Articulos;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $articulos = articulos::all(); // Obtiene todos los registros
        return view('posts.index', compact('articulos')); // Pasa la variable a la vista xd
    }

    public function dashboard()
{
    $articulos = articulos::all(); // Obtiene todos los registros
    return view('dashboard', compact('articulos')); // Pasa los datos a la vista
}


    public function create(){
        return view('posts.create');
    }

    public function store(Request $request){
        // Validar los datos entrantes
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'marca' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validar la imagen
        ]);

        // Guardar la imagen en el directorio de almacenamiento
        $imagePath = $request->file('imagen')->store('posts', 'public'); // Asegúrate que 'imagen' corresponde al input name

        // Crear el registro en la base de datos
        articulos::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'marca' => $request->marca,
            'precio' => $request->precio,
            'imagen' => $imagePath, // Ruta de la imagen almacenada
        ]);

        // Mostrar un mensaje de éxito
        session()->flash('message', 'Post creado exitosamente');
        
        return redirect('/dashboard');
        
    }

    public function edit($id)
{
    $articulo = Articulos::findOrFail($id);
    return view('posts.edit', compact('articulo'));
}

public function update(Request $request, Articulos $articulo)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'marca' => 'required|string|max:255',
        'precio' => 'required|numeric',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('imagen')) {
        $imagen = $request->imagen->store('articulos', 'public');

        if ($articulo->imagen) {
            Storage::disk('public')->delete($articulo->imagen);
        }
    } else {
        $imagen = $articulo->imagen;
    }

    $articulo->update([
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
        'marca' => $request->marca,
        'precio' => $request->precio,
        'imagen' => $imagen,
    ]);

    session()->flash('message', 'Artículo actualizado exitosamente');
    return redirect('/dashboard');
}


public function destroy(Articulos $articulo)
{
    Storage::delete($articulo->imagen);

    $articulo->delete();
 
    
    session()->flash('message', 'Eliminado exitosamente');
    return redirect('/dashboard');
    
    
}

}
