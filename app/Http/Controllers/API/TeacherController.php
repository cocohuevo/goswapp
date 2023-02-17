<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Teacher;
use Validator;
use Illuminate\Support\Facades\Auth;
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
            'type' => 'required',
            'cicle_id' => 'required',

        ]);
        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);       
        }
        $input['password'] = bcrypt($input['password']);
        $teacher = Teacher::create($input);
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
            'password' => 'required',
            'type' => 'required',
            'boscoins'=>'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);       
        }
        $teacher->firstname= $input['firstname'];
        $teacher->surname = $input['surname'];
        $teacher->email = $input['email'];
        $teacher->password = $input['password'];   
        $teacher->address = $input['address'];
        $teacher->boscoins= $input['boscoins'];
        $teacher->mobile = $input['mobile'];
        $teacher->type = $input['type'];
        $teacher['password'] = bcrypt($teacher['password']);
        $teacher->save();

        return response()->json(['Usuario' => $teacher->toArray()], $this->successStatus);
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
}
