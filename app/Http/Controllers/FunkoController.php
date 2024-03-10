<?php

namespace App\Http\Controllers\Funkos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Funko;
use App\Models\Categoria;

class FunkoController extends Controller
{


public function index(Request $request)
{
    // Añadiendole el scope
    $funkos = Funko::search($request->search)->orderBy('id', 'asc')->paginate(4);
    // Devolvemos la vista con los funkos
    return view('funkos.index')->with('funkos', $funkos);
}

public function show($id)
{
    // Buscamos el funko por su id
    $funko = Funko::find($id);
    // Devolvemos el funko
    return view('funkos.show')->with('funko', $funko);
}

public function create()
{
    $categorias = Categoria::all();
    return view('funkos.create')->with('categorias', $categorias);
}

public function store(Request $request)
{
    // Validación de datos
    $request->validate([
        
        'modelo' => 'min:4|max:120|required',
        'descripcion' => 'min:1|max:200|required',
        'precio' => 'required|regex:/^\d{1,13}(\.\d{1,2})?$/',
        'stock' => 'required|integer',
        'categoria' => 'required|exists:categorias,id', // Asegúrate de que la columna 'id' sea la correcta en value del formulario (autovalida que exista en la tabla categorias)
    ]);
    try {
        // Creamos el funko
        $funko = new Funko($request->all());
        // Asignamos la categoría
        $funko->categoria_id = $request->categoria;
        // salvamos el funko
        $funko->save();
        // Devolvemos el funko creado
        flash('Funko ' . $funko->modelo . '  creado con éxito.')->success()->important();
        return redirect()->route('funkos.index'); // Volvemos a la vista de funkos
    } catch (Exception $e) {
        flash('Error al crear el Funko' . $e->getMessage())->error()->important();
        return redirect()->back(); // volvemos a la anterior
    }
}

public function edit($id)
{
    // Buscamos el funko por su id
    $funko = Funko::find($id);
    // Buscamos las categorias
    $categorias = Categoria::all();
    // Devolvemos el funko
    return view('funkos.edit')
        ->with('funko', $funko)
        ->with('categorias', $categorias);
}

public function update(Request $request, $id)
{
    // Validación de datos
    $request->validate([
       
        'modelo' => 'min:4|max:120|required',
        'descripcion' => 'min:1|max:200|required',
        'precio' => 'required|regex:/^\d{1,13}(\.\d{1,2})?$/',
        'stock' => 'required|integer',
        'categoria' => 'required|exists:categorias,id',
    ]);
    try {
        // Buscamos el funko por su id
        $funko = Funko::find($id);
        // Actualizamos el funko
        $funko->update($request->all());
        // Asignamos la categoría
        $funko->categoria_id = $request->categoria;
        // salvamos el funko
        $funko->save();
        // Devolvemos el funko actualizado
        flash('Funko ' . $funko->modelo . '  actualizado con éxito.')->warning()->important();
        return redirect()->route('funkos.index'); // Volvemos a la vista de funkos
    } catch (Exception $e) {
        flash('Error al actualizar el Funko' . $e->getMessage())->error()->important();
        return redirect()->back(); // volvemos a la anterior
    }
}

public function editImage($id)
{
    // Buscamos el funko por su id
    $funko = Funko::find($id);
    // Devolvemos el funko
    return view('funkos.image')->with('funko', $funko);
}

public function updateImage(Request $request, $id)
{
    // Validación de datos
    $request->validate([
        'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);
    try {
        // Buscamos el funko por su id
        $funko = Funko::find($id);
        // Aquí hay que hacer lo de la imagen
        if ($funko->imagen != Funko::$IMAGE_DEFAULT && Storage::exists($funko->imagen)) {
            // Eliminamos la imagen
            Storage::delete($funko->imagen);
        }
        // Guardamos la imagen
        $imagen = $request->file('imagen');
        $extension = $imagen->getClientOriginalExtension();
        $fileToSave = $funko->uuid . '.' . $extension;
        $funko->imagen = $imagen->storeAs('funkos', $fileToSave, 'public'); // Guardamos la imagen en el disco storage/app/public/funkos
        // salvamos el funko
        $funko->save();
        // Devolvemos el funko actualizado
        flash('Funko ' . $funko->modelo . '  actualizado con éxito.')->warning()->important();
        return redirect()->route('funkos.index'); // Volvemos a la vista de funkos
    } catch (Exception $e) {
        flash('Error al actualizar el Funko' . $e->getMessage())->error()->important();
        return redirect()->back(); // volvemos a la anterior
    }
}

public function destroy($id)
{
    try {
        // Buscamos el funko por su id
        $funko = Funko::find($id);
        // Aquí hay que hacer lo de la imagen
        if ($funko->imagen != Funko::$IMAGE_DEFAULT && Storage::exists($funko->imagen)) {
            // Eliminamos la imagen
            Storage::delete($funko->imagen);
        }
        // salvamos el funko
        $funko->delete();
        // Devolvemos el funko actualizado
        flash('Funko ' . $funko->modelo . '  eliminado con éxito.')->error()->important();
        return redirect()->route('funkos.index'); // Volvemos a la vista de funkos
    } catch (Exception $e) {
        flash('Error al eliminar el Funko' . $e->getMessage())->error()->important();
        return redirect()->back(); // volvemos a la anterior
    }
}
}
