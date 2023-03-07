<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    protected $primaryKey='id';
    public $timestamps=true;

    protected $fillable =[
        'num_boscoins','description','cicle_id','user_id','grade','title','imagen','completion_date','comment','client_address','client_phone','client_rating',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cicle()
    {
        return $this->belongsTo(Cicle::class);
    }

    public function requestedTasks()
    {
        return $this->hasMany(RequestedTask::class);
    }

}