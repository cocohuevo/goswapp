<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Teacher;
use App\User;
use App\Cicle;
use App\TaskAssignment;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class TeacherController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    $teachers = Teacher::all();

    // Obtener la información de la tabla de ciclos
    $cicles = Cicle::all()->pluck('name', 'id');

    // Agregar el campo cicleName a cada profesor
    $teachers = $teachers->map(function ($teacher) use ($cicles) {
        $cicleName = $cicles->get($teacher->cicle_id, 'Desconocido');
        $teacher->cicleName = $cicleName;
        return $teacher;
    });

    return response()->json(['Profesores' => $teachers->toArray()], $this->successStatus);
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
        'firstname' => 'required',
        'surname' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'mobile' => 'required',
        'cicle_id' => 'required',
    ]);
    if($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 401);       
    }
    // Crear el usuario
    $user = User::create([
        'firstname' => $input['firstname'],
        'surname' => $input['surname'],
        'email' => $input['email'],
        'password' => bcrypt($input['password']),
        'mobile' => $input['mobile'],
        'address' => $input['address'],
        'type' => 'teacher',
    ]);
    // Crear el profesor con el mismo ID del usuario
    $teacher = new Teacher([
        'firstname' => $input['firstname'],
        'surname' => $input['surname'],
        'email' => $input['email'],
        'password' => bcrypt($input['password']),
        'mobile' => $input['mobile'],
        'type' => 'teacher',
        'address' => $input['address'],
        'cicle_id' => $input['cicle_id'],
    ]);
    $user->teacher()->save($teacher);
    // Devolver la respuesta con los datos del profesor recién creado
    return response()->json(['Profesor' => $teacher->toArray()], $this->successStatus);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $teacher = Teacher::find($id);
        if (is_null($teacher)) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        return response()->json(['Profesor' => $teacher->toArray()], $this->successStatus);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    $input = $request->all();
    $validator = Validator::make($input, [
        'firstname' => 'required',
        'surname' => 'required',
        'mobile' => 'required',
        'email' => 'required|email',
    ]);

    if($validator->fails()){
        return response()->json(['error' => $validator->errors()], 401);       
    }
    $teacher = Teacher::where('user_id',$id)->first();
    if (is_null($teacher)) {
        return response()->json(['error' => 'Profesor no encontrado'], 404);
    }    $teacher->firstname= $input['firstname'];
    $teacher->surname = $input['surname'];
    $teacher->email = $input['email'];  
    $teacher->address = $input['address'];
    $teacher->mobile = $input['mobile'];
    $teacher->save();
    
    $user = User::find($teacher->user_id);
    $user->firstname= $input['firstname'];
    $user->surname = $input['surname'];
    $user->email = $input['email']; 
    $user->address = $input['address'];
    $user->mobile = $input['mobile'];
    $user->save();

    return response()->json(['Profesor actualizado' => $teacher->toArray()], $this->successStatus);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $teacher->delete();
        return response()->json(['Profesor' => $teacher->toArray()], $this->successStatus);
    }

    public function studentsWithCompletedTasks($teacher_id)
{
    // Obtener los estudiantes que corresponden al profesor
    $students = DB::table('students')
                ->where('cicle_id', '=', $teacher_id)
                ->get();

    // Iterar sobre los estudiantes para agregar el campo de tareas completadas
    foreach ($students as $student) {
        $completed_tasks = DB::table('tasks')
                            ->join('task_assignments', 'tasks.task_id', '=', 'task_assignments.task_id')
                            ->where('task_assignments.student_id', '=', $student->id)
                            ->whereNotNull('tasks.completion_date')
                            ->count();
        $student->completed_tasks = $completed_tasks;
    }

    return response()->json(['students' => $students], $this->successStatus);
}   

}
