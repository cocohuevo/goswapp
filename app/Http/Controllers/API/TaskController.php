<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Task;
use App\Cicle;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $input = $request->all();
    $validator = Validator::make($input, [
        'title' => 'required',
        'description' => 'required',
        'user_id' => 'required',
        'imagen' => 'nullable',
        'num_boscoins' => 'nullable|integer',
        'cicle_id' => 'nullable|integer',
	    'comment' => 'nullable',
        'client_address' => 'required',
        'client_phone' => 'required',
        'client_rating' => 'nullable|numeric',
	    'completion_date' => 'nullable|date',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 401);
    }

    $task = new Task;
    $task->title = $input['title'];
    $task->description = $input['description'];
    $task->num_boscoins = $input['num_boscoins']?? 0;
    $task->user_id = $input['user_id'];
    $task->cicle_id = $input['cicle_id']?? null;
    $task->completion_date = $input['completion_date']?? null;
    $task->comment = $input['comment']?? null;
    $task->client_address = $input['client_address']?? null;
    $task->client_phone = $input['client_phone']?? null;
    $task->client_rating = $input['client_rating']?? null;

    // Guardar la imagen si se ha enviado
    if ($request->hasFile('imagen')) {
        $imagen = $request->file('imagen');
        $nombre_imagen = time() . '.' . $imagen->getClientOriginalExtension();
        $ruta_imagen = $imagen->storeAs('public/images/', $nombre_imagen);
        $task->imagen = 'images/' . $nombre_imagen; // Almacenar la ruta relativa a la imagen
    }

    $task->save();

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
            'title' => 'required',
            'num_boscoins'=>'required',
            'description'=>'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);       
        }
        $task->num_boscoins= $input['num_boscoins'];
        $task->description = $input['description'];
        $task->user_id= $input['user_id'];
        $task->cicle_id = $input['cicle_id'];
        $task->grade= $input['grade'];
        $task->title = $input['title'];
        $task->imagen= $input['imagen'];
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
    public function tasksByCicle($cicleNumber)
{
    $tasks = Task::where('cicle_id', $cicleNumber)->get()->toArray();
    return [
        "Tareas del ciclo" => $tasks
    ];
} public function assignCicleToTask($taskId, $cicleId)
{
    $task = Task::findOrFail($taskId);
    $cicle = Cicle::findOrFail($cicleId);
    $task->cicle()->associate($cicle);
    $task->save();
    return response()->json([
        'message' => 'Ciclo asignado a la tarea correctamente',
        'task' => $task
    ]);
}

public function rateTask($taskId, Request $request)
{
    $task = Task::findOrFail($taskId);
    $task->grade = $request->input('grade');
    $task->grade = number_format((double)$task->grade, 2, '.', '');
    $task->save();
    return response()->json([
        'message' => 'Tarea valorada correctamente',
        'task' => [
            'id' => $task->id,
            'name' => $task->name,
            'description' => $task->description,
            'grade' => floatval($task->grade),
            'created_at' => $task->created_at,
            'updated_at' => $task->updated_at
        ]
    ]);
}


}