<?php

namespace App;

use App\BaseModel;

class Video extends BaseModel
{
    protected $fillable = [
        'channel_id','title','description','path'
    ];
}
