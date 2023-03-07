<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskAssignment extends Model
{

    protected $fillable = [
        'student_id', 'student_name', 'cicle_student', 'teacher_id', 'task_id', 'assigned_at','due_date','completed_at','feedback',
    ];

    public function student()
{
    return $this->belongsTo(Student::class);
}

public function task()
{
    return $this->belongsTo(Task::class);
}

public function teacher()
{
    return $this->belongsTo(Teacher::class);
}
}
