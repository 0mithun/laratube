<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Video;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Video $video)
    {
        return $video->comments()->paginate(10);
    }
    public function replies(Comment $comment)
    {
        return $comment->replies()->paginate(10);
    }
}
