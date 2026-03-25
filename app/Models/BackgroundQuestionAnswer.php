<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackgroundQuestionAnswer extends Model
{
    protected $table = 'background_question_answers';
    protected $guarded = [];

    public function question()
    {
        return $this->belongsTo(BackGroundQuestion::class, 'back_ground_question_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
