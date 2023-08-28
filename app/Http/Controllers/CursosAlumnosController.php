<?php

namespace App\Http\Controllers;

use App\Models\Alumnos;
use App\Models\Cursos;
use App\Models\CursosAlumnos;
use Exception;
use Illuminate\Http\Request;

class CursosAlumnosController extends Controller
{
    public function index()
    {
        $CursosAlumnosActive = CursosAlumnos::where('state', '=', 1)->get();
        if (count($CursosAlumnosActive) == 0) {
            return "No hay matriculas activas.";
        }
        echo "Alumnos matriculados:\n";
        return $CursosAlumnosActive;
    }

    public function getById(int $id)
    {
        if (CursosAlumnos::find($id) == null) {
            return "No existe la matricula con el id N° " . $id;
        }
        if (CursosAlumnos::find($id)->state == 0) {
            return "La matricula N° " . $id . " esta desactivado.";
        }
        return CursosAlumnos::find($id);
    }

    public function create(Request $body)
    {
        if ($body->cursos_id && $body->alumnos_id) {
            $nuevoMatricula = new CursosAlumnos(); //Instanciado la clase
            $nuevoMatricula->cursos_id = $body->cursos_id;
            $nuevoMatricula->alumnos_id = $body->alumnos_id;
            // echo ($body->cursos_id);

            $CursosAll = Cursos::where('state', '=', 1)->where('id', '=', $body->cursos_id)->get();
            $AlumnosAll = Alumnos::where('state', '=', 1)->where('id', '=', $body->alumnos_id)->get();
            // echo ($CursosAll);

            if (count($CursosAll) == 0) {
                return "No existe un curso con ese 'cursos_id' o esta desactivado, porfavor ingrese un 'cursos_id' valido.";
            } else {
                $nuevoMatricula->cursos_id = $body->cursos_id;
            }
            if (count($AlumnosAll) == 0) {
                return "No existe un alumno con ese 'alumnos_id' o esta desactivado, porfavor ingrese un 'alumnos_id' valido.";
            } else {
                $nuevoMatricula->alumnos_id = $body->alumnos_id;
            }

            $nuevoMatricula->asistencia = NULL;
            $nuevoMatricula->state = 1;
            $nuevoMatricula->save();
            return "Alumno N° " . $body->alumnos_id . " matriculado Correctamente en curso " . $body->cursos_id . ".";
        }
        return "Es nesesario ingresar un valor en el objeto de nombre: 'cursos_id' y 'alumnos_id' para ser matricular a un alumno en un curso.";
    }
    public function update(Request $request, $id)
    {
        try {
            if (CursosAlumnos::find($id) != null) {
                $actualizarMatricula = CursosAlumnos::find($id);
                if ($request->all()) {
                    if ($request->alumnos_id) {
                        $AlumnosAll = Alumnos::where('state', '=', 1)->where('id', '=', $request->alumnos_id)->get();

                        if (count($AlumnosAll) == 0) {
                            return "No existe un alumno con ese 'alumnos_id' o esta desactivado, porfavor ingrese un 'alumnos_id' valido.";
                        } else {
                            $actualizarMatricula->alumnos_id = $request->alumnos_id;
                        }
                    }
                    if ($request->cursos_id) {
                        $CursosAll = Cursos::where('state', '=', 1)->where('id', '=', $request->cursos_id)->get();

                        if (count($CursosAll) == 0) {
                            return "No existe un curso con ese 'cursos_id' o esta desactivado, porfavor ingrese un 'cursos_id' valido.";
                        } else {
                            $actualizarMatricula->cursos_id = $request->cursos_id;
                        }
                    }
                    if ($request->state) {
                        if ($request->state == 1 || $request->state == 0) {
                            $actualizarMatricula->state = $request->state;
                        } else {
                            return "'state' solo acepta los valores 0 o 1.\n 'state' sin modificaciones.\n";
                        }
                    }
                    if ($request->asistencia) {
                        if ($request->asistencia == "A" || $request->asistencia == "T" || $request->asistencia == "F") {
                            $actualizarMatricula->asistencia = $request->asistencia;
                        } else {
                            return "'asistencia' solo acepta los valores 'A', 'T' o 'F'.\n 'asistencia' sin modificaciones.\n";
                        }
                    }
                    $actualizarMatricula->save();
                    return "Registro " . $id . " se ha actualizado.";
                }
                return "No hubo actualizaciones.";
            } else {
                return "No existe un registro con ese id.";
            }
        } catch (Exception $e) {
            return "Es nesesario ingresar un valor en el objeto de nombre: 'alumnos_id' y 'cursos_id' para ser actualizado, en formato JSON";
        }
    }
    public function delete($id)
    {
        $num = $id;
        $borrarMatricula = CursosAlumnos::find($id);
        if ($borrarMatricula->state == 0) {
            return "La matricula N° " . $num . " esta desactivada.";
        }
        if ($borrarMatricula == null) {
            return "No existe la matricula N° " . $num . ".";
        }
        $borrarMatricula->state = 0;
        $borrarMatricula->save();
        return "La Matricula N° " . $num . " ha sido eliminado.";
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
    public function wrongMethodId2()
    {
        return "Metodo no aceptado. Metodos permitidos: POST, PUT, DELETE";
    }

    public function asistencia(Request $request, $id)
    {
        $colocarAsistencia = CursosAlumnos::find($id);
        // echo $request->asistencia;
        if ($request->asistencia) {
            if ($request->asistencia == "A" || $request->asistencia == "T" || $request->asistencia == "F") {
                $colocarAsistencia->asistencia = $request->asistencia;
                $colocarAsistencia->save();
                return "Asistencia registrada para el id " . $id;
            } else {
                return "'asistencia' solo acepta los valores 'A', 'T' o 'F'.\n 'asistencia' sin modificaciones.\n";
            }
        }
        return "Es nesesario ingresar un valor en el objeto de nombre: 'asistencia'  para ser tomar la asistencia.";
    }
    public function asistenciaDelete($id)
    {
        $num = $id;
        $borrarAsistencia = CursosAlumnos::find($id);
        if ($borrarAsistencia->asistencia == null) {
            return "No hay una asistencia registrada.";
        }
        if ($borrarAsistencia == null) {
            return "No existe alguien matriculado con el id N° " . $num . ", por eso no se puede borrar asistencia.";
        }
        $borrarAsistencia->asistencia = null;
        $borrarAsistencia->save();
        return "Se ha eliminado la asistencia.";
    }
}
