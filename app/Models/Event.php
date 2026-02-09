<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $guarded = [];
    protected $appends=['image_path'];

    public function getImagePathAttribute(){
        if($this->attributes['image']!=null){
            return url('/') .'/uploads/sliders/'.$this->attributes['image'];
        }else{
            return null;
        }
    }
}
