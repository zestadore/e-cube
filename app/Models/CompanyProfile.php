<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    protected $table = 'company_profiles';
    protected $guarded = [];
    protected $appends=['image_path'];

    public function getImagePathAttribute(){
        if($this->attributes['company_logo']!=null){
            return url('/') .'/uploads/logos/'.$this->attributes['company_logo'];
        }else{
            return null;
        }
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id', 'id');
    }
}
