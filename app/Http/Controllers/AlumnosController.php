<?php

namespace App\Http\Controllers;

use App\Models\Alumnos;
use Brick\Math\BigInteger;
use Exception;
use Illuminate\Http\Request;

class AlumnosController extends Controller
{
    public function index()
    {
        return Alumnos::where('estado', '=', 1)->get();
    }

    public function getById(int $id)
    {
        if (Alumnos::find($id) == null) {
            return "No existe un alumno con el id N° " . $id;
        }
        if (Alumnos::find($id)->estado == 0) {
            return "El alumno N° " . $id . " esta desactivado.";
        }
        return Alumnos::find($id);
    }

    public function create(Request $body)
    {
        if ($body->nombre) {
            $nuevoAlumno = new Alumnos(); //Instanciado la clase
            $nuevoAlumno->nombre = $body->nombre;
            // $nuevoAlumno->create($body->all());
            $nuevoAlumno->estado = 1;
            $nuevoAlumno->save();
            return "Alumno Registrado Correctamente.";
        }
        return "Es nesesario ingresar un valor en el objeto de nombre: 'nombre' para ser registrar un alumno.";
    }
    public function update(Request $request, $id)
    {
        try {
            if (Alumnos::find($id) != null) {
                $actualizarAlumno = Alumnos::find($id);
                if ($request->all()) {
                    if ($request->nombre) {
                        $actualizarAlumno->nombre = $request->nombre;
                    }
                    if ($request->estado) {
                        if ($request->estado == 1 || $request->estado == 0) {
                            $actualizarAlumno->estado = $request->estado;
                        } else {
                            return "'estado' solo acepta los valores 0 o 1.\n 'estado' sin modificaciones.\n";
                        }
                    }

                    $actualizarAlumno->save();
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
        $borrarAlumno = Alumnos::find($id);
        if ($borrarAlumno == null) {
            return "No existe el alumno N° " . $num . ".";
        }
        $borrarAlumno->estado = 0;
        $borrarAlumno->save();
        return "El alumno N° " . $num . " ha sido eliminado.";
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
