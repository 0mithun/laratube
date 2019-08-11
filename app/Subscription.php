<?php

namespace App;

use App\BaseModel;

class Subscription extends BaseModel
{
    protected $fillable = [
        'user_id', 'channel_id'
    ];

    
}
