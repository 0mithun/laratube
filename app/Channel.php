<?php

namespace App;

use App\Video;

use App\BaseModel;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Channel extends BaseModel implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = [
        'name','description','image'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100);
    }

    public function editable(){
        if(!auth()->check()){
          return false;  
        }
        return $this->user_id === auth()->user()->id;
    }

    public function image(){

        if($this->media->first()){
            return $this->media->first()->getFullUrl('thumb');
        }
    }

    public function subscriptions(){
        return $this->hasMany(Subscription::class);
    }

    public function videos(){
        return $this->hasMany(Video::class);
    }
}
