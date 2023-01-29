<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $primaryKey='id';

    public $timestamps=true;

    protected $fillable =[
        'name',
    ];
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
