<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
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
        $input['password'] = bcrypt($input['password']);
        $input['type'] = 'student';
        $student = Student::create($input);
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
            'password' => 'required',
            'type' => 'required',
            'boscoins'=>'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);       
        }
        $student->firstname= $input['firstname'];
        $student->surname = $input['surname'];
        $student->email = $input['email'];
        $student->password = $input['password'];   
        $student->address = $input['address'];
        $student->boscoins= $input['boscoins'];
        $student->mobile = $input['mobile'];
        $student->type = $input['type'];
        $student['password'] = bcrypt($student['password']);
        $student->save();

        return response()->json(['Usuario' => $student->toArray()], $this->successStatus);
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
