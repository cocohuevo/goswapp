<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Task;
use App\Profile;
use Validator;


class TaskController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
        return response()->json(['Tareas' => $tasks->toArray()], $this->successStatus);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'num_boscoins'=>'required',
            'description'=>'required',
            'date_request'=>'required',
            'date_completian'=>'required',
            'type'=>'required',
            'user_id'=>'required',
            'profile_id'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);       
        }
        $task = Task::create($input);
        return response()->json(['Tarea' => $task->toArray()], $this->successStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        if (is_null($task)) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        return response()->json(['Tarea' => $task->toArray()], $this->successStatus);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'num_boscoins'=>'required',
            'description'=>'required',
            'date_request'=>'required',
            'date_completian'=>'required',
            'type'=>'required',
            'user_id'=>'required',
            'profile_id'=>'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);       
        }
        $task->num_boscoins= $input['num_boscoins'];
        $task->description = $input['description'];
        $task->date_request = $input['date_request'];
        $task->date_completian = $input['date_completian'];
        $task->type = $input['type'];   
        $task->user_id = $input['user_id'];
        $task->profile_id = $input['profile_id'];

        $task->save();

        return response()->json(['Tarea' => $task->toArray()], $this->successStatus);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['Tarea' => $task->toArray()], $this->successStatus);
    }
    public function getTasks($id)
{
    $task = Task::where('profile_id', $id)->first();
    if (!$task) {
        return response()->json(['message' => 'No se encontró la tarea con el id especificado.'], 404);
    }

    $tasks = Task::where('profile_id', $id)->get();
    if ($tasks->isEmpty()) {
        return response()->json(['message' => 'Este perfil no tiene tareas asociadas.'], 200);
    }

    return response()->json(['tasks' => $tasks], 200);
}
}