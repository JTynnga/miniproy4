<?php

nombrespace App\Http\Controllers;

use App\Models\Cursos;
use App\Models\Docentes;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CursosController extends Controller
{
    public function index()
    {
        return Cursos::where('estado', '=', 1)->get();
    }

    public function getById(int $id)
    {
        if (Cursos::find($id) == null) {
            return "No existe un curso con el id N° " . $id;
        }
        if (Cursos::find($id)->estado == 0) {
            return "El curso N° " . $id . " esta desactivado.";
        }
        return Cursos::find($id);
    }

    public function create(Request $body)
    {
        if ($body->nombre && $body->docente_id) {
            $nuevoCurso = new Cursos(); //Instanciado la clase
            $nuevoCurso->nombre = $body->nombre;
            // echo ($body->docente_id);

            $DocentesAll = Docentes::where('estado', '=', 1)->where('id', '=', $body->docente_id)->get();
            if (count($DocentesAll) == 0) {
                return "No existe un docente con ese 'docente_id', porfavor ingrese un 'docente_id' valido.";
            } else {
                $nuevoCurso->docente_id = $body->docente_id;
            }


            $nuevoCurso->estado = 1;
            $nuevoCurso->save();
            return "Curso Registrado Correctamente.";
        }
        return "Es nesesario ingresar un valor en el objeto de nombre: 'nombre' y 'docente_id' para ser registrar un alumno.";
    }
    public function update(Request $request, $id)
    {
        try {
            if (Cursos::find($id) != null) {
                $actualizarCurso = Cursos::find($id);
                if ($request->all()) {
                    if ($request->nombre) {
                        $actualizarCurso->nombre = $request->nombre;
                    }
                    if ($request->docente_id) {
                        $DocentesAll = Docentes::where('estado', '=', 1)->where('id', '=', $request->docente_id)->get();

                        if (count($DocentesAll) == 0) {
                            return "No existe un docente con ese 'docente_id' o esta desactivado, porfavor ingrese un 'docente_id' valido.";
                        } else {
                            $actualizarCurso->docente_id = $request->docente_id;
                        }
                    }
                    if ($request->estado) {
                        if ($request->estado == 1 || $request->estado == 0) {
                            $actualizarCurso->estado = $request->estado;
                        } else {
                            return "'estado' solo acepta los valores 0 o 1.\n 'estado' sin modificaciones.\n";
                        }
                    }
                    $actualizarCurso->save();
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
        $borrarCurso = Cursos::find($id);
        if ($borrarCurso == null) {
            return "No existe el curso N° " . $num . ".";
        }
        $borrarCurso->estado = 0;
        $borrarCurso->save();
        return "El curso N° " . $num . " ha sido eliminado.";
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