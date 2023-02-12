<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cicle extends Model
{
    protected $table = 'cicles';
    protected $primaryKey='id';
    public $timestamps=true;

    protected $fillable =[
        'name', 'description',
    ];
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    
}
