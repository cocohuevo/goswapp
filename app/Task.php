<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    protected $primaryKey='id';
    public $timestamps=true;

    protected $fillable =[
        'num_boscoins','description','date_request','date_completian','type','user_id','is_published','profile_id','deleted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function cicle()
    {
        return $this->belongsTo(Cicle::class);
    }

}
