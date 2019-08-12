<?php

namespace App;

use App\BaseModel;

class Vote extends BaseModel
{
    protected $fillable = [
        'type', 'votable_type', 'votable_id', 'user_id'
    ];

    public function votable()
    {
        return $this->morphTo();
    }
}
