<?php

namespace App;

use App\User;
use App\BaseModel;


class Channel extends BaseModel
{
    protected $fillable = [
        'name','description','image'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
