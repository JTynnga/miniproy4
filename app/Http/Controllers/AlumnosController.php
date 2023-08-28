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
        return Alumnos::where('state', '=', 1)->get();
    }

    public function getById(int $id)
    {
        if (Alumnos::find($id) == null) {
            return "No existe un alumno con el id N° " . $id;
        }
        if (Alumnos::find($id)->state == 0) {
            return "El alumno N° " . $id . " esta desactivado.";
        }
        return Alumnos::find($id);
    }

    public function create(Request $body)
    {
        if ($body->name) {
            $nuevoAlumno = new Alumnos(); //Instanciado la clase
            $nuevoAlumno->name = $body->name;
            // $nuevoAlumno->create($body->all());
            $nuevoAlumno->state = 1;
            $nuevoAlumno->save();
            return "Alumno Registrado Correctamente.";
        }
        return "Es nesesario ingresar un valor en el objeto de nombre: 'name' para ser registrar un alumno.";
    }
    public function update(Request $request, $id)
    {
        try {
            if (Alumnos::find($id) != null) {
                $actualizarAlumno = Alumnos::find($id);
                if ($request->all()) {
                    if ($request->name) {
                        $actualizarAlumno->name = $request->name;
                    }
                    if ($request->state) {
                        if ($request->state == 1 || $request->state == 0) {
                            $actualizarAlumno->state = $request->state;
                        } else {
                            return "'state' solo acepta los valores 0 o 1.\n 'state' sin modificaciones.\n";
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
            return "Es nesesario ingresar un valor en el objeto de nombre: 'name' para ser actualizado, en formato JSON";
        }
    }
    public function delete($id)
    {
        $num = $id;
        $borrarAlumno = Alumnos::find($id);
        if ($borrarAlumno == null) {
            return "No existe el alumno N° " . $num . ".";
        }
        $borrarAlumno->state = 0;
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
