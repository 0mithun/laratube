<?php

namespace App;

use App\BaseModel;

class Video extends BaseModel
{
    protected $fillable = [
        'channel_id', 'title', 'description', 'path'
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function editable()
    {
        return auth()->check() && $this->channel->user_id === auth()->user()->id;
    }


    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('comment_id');
    }
}
