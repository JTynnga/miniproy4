<?php

namespace App\Http\Controllers;

use App\Models\Docentes;
use Exception;
use Illuminate\Http\Request;

class DocentesController extends Controller
{
    public function index()
    {
        return Docentes::where('estado', '=', 1)->get();
    }

    public function getById(int $id)
    {
        if (Docentes::find($id) == null) {
            return "No existe un docente con el id N° " . $id;
        }
        if (Docentes::find($id)->estado == 0) {
            return "El docente N° " . $id . " esta desactivado.";
        }
        return Docentes::find($id);
    }

    public function create(Request $body)
    {
        if ($body->nombre) {
            $nuevoDocente = new Docentes(); //Instanciado la clase
            $nuevoDocente->nombre = $body->nombre;
            // $nuevoDocente->create($body->all());
            $nuevoDocente->estado = 1;
            $nuevoDocente->save();
            return "Docente Registrado Correctamente.";
        }
        return "Es nesesario ingresar un valor en el objeto de nombre: 'nombre' para ser registrar un docente.";
    }
    public function update(Request $request, $id)
    {
        try {
            if (Docentes::find($id) != null) {
                $actualizarDocente = Docentes::find($id);
                if ($request->all()) {
                    if ($request->nombre) {
                        $actualizarDocente->nombre = $request->nombre;
                    }
                    if ($request->estado) {
                        if ($request->estado == 1 || $request->estado == 0) {
                            $actualizarDocente->estado = $request->estado;
                        } else {
                            return "'estado' solo acepta los valores 0 o 1.\n 'estado' sin modificaciones.\n";
                        }
                    }

                    $actualizarDocente->save();
                    return "Registro " . $id . " se ha actualizado.";
                }
                return "No hubo actualizaciones.";
            } else {
                return "No existe un registro con ese id.";
            }
        } catch (Exception $e) {
            return "Es nesesario ingresar un valor en el objeto de nombre: 'nombre' para ser actualizado, en formato JSON";
        }
    }
    public function delete($id)
    {
        $num = $id;
        $borrarDocente = Docentes::find($id);
        if ($borrarDocente == null) {
            return "No existe el docente N° " . $num . ".";
        }
        $borrarDocente->estado = 0;
        $borrarDocente->save();
        return "El docente N° " . $num . " ha sido eliminado.";
    }
    public function noIdExp()
    {
        return "Es nesesario especificar un Id en la route.";
    }
    public function wrongMethod()
    {
        return "Metodo no aceptado. Metodos permitidos:  PUT, DELETE";
    }
    public function wrongMethodId()
    {
        return "Metodo no aceptado. Metodos permitidos: GET, PUT, DELETE";
    }
}
