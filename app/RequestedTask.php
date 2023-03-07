<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestedTask extends Model
{
    protected $fillable = ['cicle_id', 'task_id', 'student_id', 'assignment'];

    public function cicle()
    {
        return $this->belongsTo(Cicle::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}