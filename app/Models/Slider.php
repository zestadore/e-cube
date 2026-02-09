<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'sliders';
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
