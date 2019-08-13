<?php

namespace App;

use App\BaseModel;

class Comment extends BaseModel
{
    protected $fillable = [
        'user_id', 'video_id', 'body', 'comment_id'
    ];

    protected $with = ['user', 'votes'];

    protected $appends = ['replies_count'];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'comment_id')->whereNotNull('comment_id');
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }


    public function getRepliesCountAttribute()
    {
        return $this->replies->count();
    }
}
