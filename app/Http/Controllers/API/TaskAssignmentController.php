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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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


}
