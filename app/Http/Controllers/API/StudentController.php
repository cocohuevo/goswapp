<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Cicle;
use App\User;
use Validator;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();

	// Obtener la información de la tabla de ciclos
        $cicles = Cicle::all()->pluck('name', 'id');

        // Agregar el campo cicleName a cada alumno
        $students = $students->map(function ($student) use ($cicles) {
            $cicleName = $cicles->get($student->cicle_id, 'Desconocido');
            $student->cicleName = $cicleName;
            return $student;
        });	

        return response()->json(['Estudiantes' => $students->toArray()], $this->successStatus);
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
        'type' => 'student',
    ]);
    // Crear el estudiante con el mismo ID del usuario
    $student = new Student([
        'firstname' => $input['firstname'],
        'surname' => $input['surname'],
        'email' => $input['email'],
        'password' => bcrypt($input['password']),
        'mobile' => $input['mobile'],
        'type' => 'student',
        'address' => $input['address'],
        'cicle_id' => $input['cicle_id'],
    ]);
    $user->student()->save($student);
    // Devolver la respuesta con los datos del estudiante recién creado
    return response()->json(['Estudiante' => $student->toArray()], $this->successStatus);
}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::find($id);
        if (is_null($student)) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        return response()->json(['Estudiante' => $student->toArray()], $this->successStatus);
        
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
    
    $student = Student::where('user_id', $id)->first();
if (is_null($student)) {
    return response()->json(['error' => 'Estudiante no encontrado'], 404);
}

$student->firstname = $input['firstname'];
$student->surname = $input['surname'];
$student->email = $input['email']; 
$student->address = $input['address'];
$student->mobile = $input['mobile'];
$student->save();

$user = User::find($student->user_id);
$user->firstname = $input['firstname'];
$user->surname = $input['surname'];
$user->email = $input['email'];
$user->address = $input['address'];
$user->mobile = $input['mobile'];
$user->save();

return response()->json(['Estudiante actualizado' => $student->toArray()], $this->successStatus);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student->delete();
        return response()->json(['Estudiante' => $student->toArray()], $this->successStatus);
    }

}
