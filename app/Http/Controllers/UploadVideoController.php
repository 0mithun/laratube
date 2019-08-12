<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;
use App\Jobs\Videos\ConvertForStreaming;

class UploadVideoController extends Controller
{

    public function index(Channel $channel){
        return view('channels.upload', compact('channel'));
    }

    public function store(Channel $channel){
        $video = $channel->videos()->create([
            'title'     =>  request('title'),
            'path'      =>  request()->video->store("channels/{$channel->id}")
        ]);

        $this->dispatch(new ConvertForStreaming($video));

        return $video;
    }
}
