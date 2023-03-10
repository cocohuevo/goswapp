<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $primaryKey='id';
    public $timestamps=true;

    protected $fillable = [
        'firstname','surname', 'email', 'password','boscoins','type','address','mobile','cicle_id',
    ];

    public function assignments()
{
    return $this->hasMany(TaskAssignment::class);
}
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function cicle()
    {
        return $this->belongsTo(Cicle::class);
    }
	
public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}