<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_methods';
    protected $guarded = [];
    protected $appends=['qr_code'];

    public function getQrCodeAttribute()
    {
        if($this->attributes['image']!=null){
            return url('/') .'/uploads/payments/'.$this->attributes['image'];
        }else{
            return null;
        }
    }
}
