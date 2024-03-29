<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\TaskAssignment;
use App\Task;
use App\User;
use App\Teacher;
use App\Cicle;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TaskAssignmentController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taskAssignments = TaskAssignment::all();
        return response()->json(['Solicitudes de tareas' => $taskAssignments->toArray()], $this->successStatus);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'task_id'=>'required',
            'user_id'=>'required',
            'cicle_id'=>'required',
            
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);       
        }
        $taskAssignments = TaskAssignment::create($input);
        return response()->json(['Solicitudes de tareas' => $taskAssignments->toArray()], $this->successStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
{
    $taskAssignment = TaskAssignment::find($id);
    if (is_null($taskAssignment)) {
        return response()->json(['error' => 'La tarea asignada no existe'], 401);
    }
    return response()->json(['Solicitud de tarea' => $taskAssignment->toArray()], $this->successStatus);
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaskAssignment $taskAssignment)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'task_id'=>'required',
            'user_id'=>'required',
            'cicle_id'=>'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);       
        }
        $taskAssignment->task_id= $input['task_id'];
        $taskAssignment->user_id = $input['user_id'];
        $taskAssignment->cicle_id= $input['cicle_id'];
        $taskAssignment->assigned_at = $input['assigned_at'];
        $taskAssignment->due_date= $input['due_date'];
        $taskAssignment->completed_at = $input['completed_at'];
        $taskAssignment->feedback= $input['feedback'];
        $taskAssignment->save();

        return response()->json(['Solicitud de tarea' => $taskAssignment->toArray()], $this->successStatus);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskAssignment $taskAssignment)
    {
        $taskAssignment->delete();
        return response()->json(['Solicitud de tarea borrada' => $taskAssignment->toArray()], $this->successStatus);
    }

    public function requestStudentToTask($userId, $taskId)
{
    if (!auth()->check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    } else {
        $student = DB::table('students')
              ->where('user_id', $userId)
              ->first();
        $assignment = new TaskAssignment;
        $assignment->student_id = $userId;
        $assignment->student_name = $student->firstname;
	$cicle = DB::table('cicles')
              ->where('id', $student->cicle_id)
              ->first();
        $assignment->cicle_student = $cicle->name;
	$assignment->cicle_id = $cicle->id;
        $assignment->task_id = $taskId;
        $assignment->save();

        return response()->json(['message' => 'Tarea solicitada por el alumno']);
    }
}

public function getStudentsByTaskId($taskId)
{
    $taskAssignments = DB::table('task_assignments')
        ->join('students', 'students.user_id', '=', 'task_assignments.student_id')
        ->select('task_assignments.id', 'task_assignments.student_name', 'students.surname', 'task_assignments.cicle_student','task_assignments.assigned_at')
        ->where('task_assignments.task_id', $taskId)
        ->get();

    return response()->json([
        'Estudiantes que solicitan la tarea con id' => $taskId,
        'Estudiantes' => $taskAssignments->toArray()
    ], $this->successStatus);
}
public function updateAssignedAt($assignmentId)
{
    $taskAssignment = TaskAssignment::find($assignmentId);
    if (!$taskAssignment) {
        return response()->json(['error' => 'No se encontro la tarea asignada'], 404);
    }
    $taskAssignment->update([
        'assigned_at' => now()
    ]);
    return response()->json(['message' => 'Fecha de asignacion actualizada exitosamente']);
}

public function unassignTaskFromStudent($assignmentId)
{
    $taskAssignment = TaskAssignment::find($assignmentId);
    if (!$taskAssignment) {
        return response()->json(['error' => 'No se encontro la tarea asignada'], 404);
    }
    $taskAssignment->update([
        'assigned_at' => null
    ]);
    return response()->json(['message' => 'Tarea desasignacion exitosamente']);

}

public function removeTaskFromStudent($userId, $taskId)
{
    if (!auth()->check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }else{
        $assignment = TaskAssignment::where('student_id', $userId)
                                    ->where('task_id', $taskId)
                                    ->first();
        if($assignment){
            $assignment->delete();
            return response()->json(['message' => 'Tarea desasignada del alumno']);
        }else{
            return response()->json(['message' => 'La tarea no está asignada a este alumno']);
        }
    }
}

public function getTasksForCicle()
{
    $user = auth()->user();
    
    if (!$user->isStudent()) {
        return response()->json(['error' => 'El usuario no es un estudiante'], 401);
    }
    
    $student = Student::where('user_id', $user->id)->first();
    $cicleId = $student->cicle_id;    
    // Obtener todas las asignaciones de tareas que pertenecen a ese estudiante
    $taskAssignments = TaskAssignment::where('student_id', $student->user_id)->get();

    // Obtener todas las tareas que pertenecen a ese ciclo escolar
    $tasks = Task::where('cicle_id', $cicleId)->get();

    // Devolver una respuesta JSON que incluya los datos del estudiante y las tareas asignadas
    return response()->json([
        'estudiante' => $student,
        'tareas' => $tasks,
        'tareas_asignadas' => $taskAssignments
    ], $this->successStatus);
}

public function assignTeacherToTask($assignmentId)
{
    // Verifica si el usuario autenticado es un administrador
    $user = auth()->user();
    if (!$user || $user->type !== 'admin') {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Encuentra la tarea de la asignación
    $assignment = TaskAssignment::find($assignmentId);
    if (!$assignment) {
        return response()->json(['error' => 'Task Assignment not found'], 404);
    }

    // Encuentra el ciclo de la tarea de la asignación
    $cicleId = $assignment->cicle_id;

    // Encuentra el profesor que corresponde a ese ciclo
    $teacher = DB::table('teachers')
        ->where('cicle_id', $cicleId)
        ->first();

    if (!$teacher) {
        return response()->json(['error' => 'No teacher found for this cicle'], 404);
    }

    // Asigna el id del profesor al campo teacher_id de la tabla task_assignments
    $assignment->teacher_id = $teacher->id;
    $assignment->save();

    return response()->json(['message' => 'Teacher assigned to task assignment']);
}

public function unassignTeacherFromTask($assignmentId)
{
    // Verifica si el usuario autenticado es un administrador
    $user = auth()->user();
    if (!$user || $user->type !== 'admin') {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Encuentra la tarea de la asignación
    $assignment = TaskAssignment::find($assignmentId);
    if (!$assignment) {
        return response()->json(['error' => 'Task Assignment not found'], 404);
    }

    // Asigna el campo teacher_id de la tabla task_assignments a null
    $assignment->teacher_id = null;
    $assignment->save();

    return response()->json(['message' => 'Teacher unassigned from task assignment']);
}

}
