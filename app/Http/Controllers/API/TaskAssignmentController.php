<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TaskAssignment;
use App\Task;

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
        $taskAssignment = TaskAssignments::find($id);
        if (is_null($taskAssignment)) {
            return response()->json(['error' => $validator->errors()], 401);
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

    public function assignTaskToStudent($userId, $taskId)
{
    if (!auth()->check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }else{
        $cicleId=Task::find($taskId)->cicleId;
    $assignment = new TaskAssignment;
    $assignment->student_id = $userId;
    $assignment->task_id = $taskId;
    $assignment->teacher_id = auth()->user()->id;
    $assignment->assigned_at = now();
    $assignment->save();

    return response()->json(['message' => 'Tarea asignada al alumno']);
    }
    
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

}
