<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cicle extends Model
{
    protected $table = 'cicles';
    protected $primaryKey='id';
    public $timestamps=true;

    protected $fillable =[
        'name', 'description','profile_id',
    ];
    public function users()
    {
        return $this->hasMany(Task::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
    
}
