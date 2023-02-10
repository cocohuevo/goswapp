<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';
    protected $primaryKey='id';
    public $timestamps=true;

    protected $fillable = [
        'firstname','surname', 'email', 'password','address','mobile','ciclo_id',
    ];
    
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function cicle()
    {
        return $this->belongsTo(Cicle::class);
    }
    
}