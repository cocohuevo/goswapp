<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';
    protected $primaryKey='id';
    public $timestamps=true;

    protected $fillable = [
        'firstname','surname', 'email', 'password','type','address','mobile','cicle_id',
    ];
    
      public function cicle()
    {
        return $this->belongsTo(Cicle::class);
    }
    
}